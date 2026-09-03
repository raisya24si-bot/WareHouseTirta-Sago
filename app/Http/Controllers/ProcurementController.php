<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterBarang;
use App\Models\MasterStatusPo;
use App\Models\MasterSupplier;
use App\Models\Po;
use App\Models\PoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementController extends Controller
{
    use HasPerPage;

    private const CART_KEY = 'po_draft_cart';

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    private function cart(): array
    {
        return session(self::CART_KEY, [
            'fk_supplier' => null,
            'desc_po' => null,
            'items' => [],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STOCK
    |--------------------------------------------------------------------------
    */

    private function stokPerBarang(): \Illuminate\Support\Collection
    {
        return MasterBarang::query()
            ->where('status_master_barang', 'AKTIF')
            ->pluck(
                'stok_saat_ini',
                'id_master_barang'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE PO NUMBER
    |--------------------------------------------------------------------------
    */

    private function generatePoNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');

        $prefix = "PO-{$year}-{$month}-";

        $numbers = Po::withTrashed()
            ->where(
                'kd_po',
                'like',
                $prefix . '%'
            )
            ->pluck('kd_po');

        $maxNumber = 0;

        foreach ($numbers as $kdPo) {

            if (
                preg_match(
                    '/^' .
                    preg_quote($prefix, '/') .
                    '(\d+)$/',
                    $kdPo,
                    $matches
                )
            ) {

                $maxNumber = max(
                    $maxNumber,
                    (int) $matches[1]
                );
            }
        }

        return $prefix . ($maxNumber + 1);
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS ID
    |--------------------------------------------------------------------------
    */

    private function statusId(string $kode): int
    {
        return MasterStatusPo::where(
            'kd_status_po',
            $kode
        )->value('id_status_po');
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */

        $stokPerBarang = $this->stokPerBarang();

        $barangs = MasterBarang::where(
            'status_master_barang',
            'AKTIF'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | BARANG YANG SUDAH MASUK PO
        |--------------------------------------------------------------------------
        |
        | Ambil PO terbaru untuk setiap barang.
        |
        | PO dengan status REJECTED tidak dihitung sebagai PO aktif,
        | sehingga barang masih bisa dimasukkan ke PO baru.
        |
        */

        $poPerBarang = PoDetail::query()
            ->with([
                'po.statusPo',
            ])
            ->whereHas('po', function ($query) {

                $query->whereHas(
                    'statusPo',
                    function ($status) {

                        $status->where(
                            'kd_status_po',
                            '!=',
                            'REJECTED'
                        );
                    }
                );
            })
            ->latest('id_po_detail')
            ->get()
            ->groupBy('fk_barang')
            ->map(function ($details) {

                $detail = $details->first();

                return $detail->po?->kd_po;
            });


        /*
        |--------------------------------------------------------------------------
        | CRITICAL STOCK
        |--------------------------------------------------------------------------
        */

        $criticalItems = $barangs
            ->map(function (MasterBarang $barang) use ($stokPerBarang) {

                $current = (int) (
                    $stokPerBarang[
                        $barang->id_master_barang
                    ] ?? 0
                );

                $minimum = (int) $barang->minimum_stok;

                $status = MasterBarang::calculateStockStatus(
                    $current,
                    $minimum
                );

                return (object) [

                    'barang' => $barang,

                    'current_stock' => $current,

                    'minimum_stock' => $minimum,

                    'stock_status' => $status,

                    'recommended_order' => max(
                        0,
                        ($minimum * 2) - $current
                    ),
                ];
            })
            ->filter(
                fn ($row) =>
                    in_array(
                        $row->stock_status,
                        ['HABIS', 'MENIPIS'],
                        true
                    )
            )
            ->sortBy(
                fn ($row) => [
                    $row->stock_status === 'HABIS'
                        ? 0
                        : 1,

                    $row->current_stock,
                ]
            )
            ->values();


        $outOfStockCount = $criticalItems
            ->where(
                'current_stock',
                '<=',
                0
            )
            ->count();


        $lowStockCount = $criticalItems
            ->where(
                'current_stock',
                '>',
                0
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STATISTIC
        |--------------------------------------------------------------------------
        */

        $pendingPoCount = Po::whereHas(
            'statusPo',
            fn ($q) =>
                $q->where(
                    'kd_status_po',
                    '!=',
                    'APPROVED'
                )
        )->count();


        $expectedShipmentCount = Po::whereHas(
            'statusPo',
            fn ($q) =>
                $q->where(
                    'kd_status_po',
                    'APPROVED'
                )
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER LIST
        |--------------------------------------------------------------------------
        */

        $perPage = $this->perPageOption($request);

        $poQuery = Po::with([
            'supplier',
            'statusPo',
            'details',
        ])
            ->latest('id_po');


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $status = $request
                ->string('status')
                ->toString();

            $poQuery->whereHas(
                'statusPo',
                fn ($q) =>
                    $q->where(
                        'kd_status_po',
                        $status
                    )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request
                    ->string('search')
                    ->toString()
            );

            $poQuery->where(
                function ($q) use ($search) {

                    $q->where(
                        'kd_po',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'supplier',
                        fn ($s) =>
                            $s->where(
                                'nm_master_supplier',
                                'like',
                                "%{$search}%"
                            )
                    );
                }
            );
        }


        $purchaseOrders = $poQuery
            ->paginate(
                $this->resolvePerPage(
                    $request,
                    $poQuery
                )
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | CURRENT PO DRAFT
        |--------------------------------------------------------------------------
        */

        $cart = $this->cart();


        $cartSupplier = $cart['fk_supplier']
            ? MasterSupplier::find(
                $cart['fk_supplier']
            )
            : null;


        $cartItems = collect(
            $cart['items']
        )
            ->map(function ($qty, $barangId) {

                $barang = MasterBarang::find(
                    $barangId
                );

                return $barang
                    ? (object) [
                        'barang' => $barang,
                        'qty' => (int) $qty,
                    ]
                    : null;
            })
            ->filter()
            ->values();


        $suppliers = MasterSupplier::where(
            'status_master_supplier',
            'AKTIF'
        )
            ->orderBy(
                'nm_master_supplier'
            )
            ->get();


        return view(
            'procurement.index',
            compact(
                'criticalItems',
                'outOfStockCount',
                'lowStockCount',
                'pendingPoCount',
                'expectedShipmentCount',
                'purchaseOrders',
                'perPage',
                'cartSupplier',
                'cartItems',
                'suppliers',
                'cart',
                'poPerBarang'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD TO DRAFT
    |--------------------------------------------------------------------------
    */

    public function addToDraft(Request $request)
    {
        $validated = $request->validate([
            'fk_barang' => [
                'required',
                'exists:tbl_master_barang,id_master_barang',
            ],

            'qty' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        $cart = $this->cart();


        $cart['items'][
            $validated['fk_barang']
        ] =
            ($cart['items'][
                $validated['fk_barang']
            ] ?? 0)
            + $validated['qty'];


        session([
            self::CART_KEY => $cart,
        ]);


        return back()->with(
            'success',
            'Barang ditambahkan ke draft PO.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SET DRAFT SUPPLIER
    |--------------------------------------------------------------------------
    */

    public function setDraftSupplier(Request $request)
    {
        $validated = $request->validate([
            'fk_supplier' => [
                'nullable',
                'exists:tbl_master_supplier,id_master_supplier',
            ],

            'desc_po' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);


        $cart = $this->cart();


        $cart['fk_supplier'] =
            $validated['fk_supplier']
            ?? null;


        $cart['desc_po'] =
            $validated['desc_po']
            ?? $cart['desc_po']
            ?? null;


        session([
            self::CART_KEY => $cart,
        ]);


        return back()->with(
            'success',
            'Draft PO diperbarui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE DRAFT QTY
    |--------------------------------------------------------------------------
    */

    public function updateDraftQty(
        Request $request,
        MasterBarang $masterBarang
    ) {
        $validated = $request->validate([
            'qty' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        $cart = $this->cart();


        if (
            isset(
                $cart['items'][
                    $masterBarang->id_master_barang
                ]
            )
        ) {

            $cart['items'][
                $masterBarang->id_master_barang
            ] = $validated['qty'];


            session([
                self::CART_KEY => $cart,
            ]);
        }


        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE DRAFT ITEM
    |--------------------------------------------------------------------------
    */

    public function removeDraftItem(
        MasterBarang $masterBarang
    ) {
        $cart = $this->cart();


        unset(
            $cart['items'][
                $masterBarang->id_master_barang
            ]
        );


        session([
            self::CART_KEY => $cart,
        ]);


        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PURCHASE ORDER
    |--------------------------------------------------------------------------
    */

    public function createPurchaseOrder(
        Request $request
    ) {
        $cart = $this->cart();


        if (empty($cart['items'])) {

            return back()->withErrors([
                'draft' =>
                    'Belum ada barang di draft PO.',
            ]);
        }


        if (empty($cart['fk_supplier'])) {

            return back()->withErrors([
                'draft' =>
                    'Pilih supplier dulu sebelum membuat Purchase Order.',
            ]);
        }


        $stokPerBarang =
            $this->stokPerBarang();


        $po = DB::transaction(
            function () use (
                $cart,
                $stokPerBarang
            ) {

                $userId =
                    auth()->id();


                $kdPo =
                    $this->generatePoNumber();


                $po = Po::create([
                    'kd_po' =>
                        $kdPo,

                    'fk_supplier' =>
                        $cart['fk_supplier'],

                    'desc_po' =>
                        $cart['desc_po'] ?? null,

                    'fk_status_po' =>
                        $this->statusId('DRAFT'),

                    'created_by' =>
                        $userId,
                ]);


                foreach (
                    $cart['items']
                    as $barangId => $qty
                ) {

                    if (
                        (int) $qty <= 0
                    ) {
                        continue;
                    }


                    $barang =
                        MasterBarang::find(
                            $barangId
                        );


                    if (!$barang) {
                        continue;
                    }


                    PoDetail::create([
                        'fk_po' =>
                            $po->id_po,

                        'fk_barang' =>
                            $barangId,

                        'qty_stok_at_request' =>
                            (int) (
                                $stokPerBarang[
                                    $barangId
                                ] ?? 0
                            ),

                        'qty_min_stok_at_request' =>
                            (int) $barang->minimum_stok,

                        'qty_request' =>
                            $qty,

                        'created_by' =>
                            $userId,
                    ]);
                }


                return $po;
            }
        );


        session()->forget(
            self::CART_KEY
        );


        return redirect()
            ->route(
                'procurement.index'
            )
            ->with(
                'success',
                'Purchase Order ' .
                $po->kd_po .
                ' berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT PAGE
    |--------------------------------------------------------------------------
    */

    public function edit(Po $po)
    {
        abort_unless(
            $po->kode_status !== 'APPROVED',
            403,
            'PO yang sudah disetujui tidak dapat diedit.'
        );


        $po->load([
            'supplier',
            'statusPo',
            'details.barang',
        ]);


        $existingBarangIds =
            $po->details
                ->pluck('fk_barang')
                ->filter()
                ->map(
                    fn ($id) => (int) $id
                )
                ->values()
                ->all();


        $availableBarangs =
            MasterBarang::where(
                'status_master_barang',
                'AKTIF'
            )
            ->when(
                count($existingBarangIds) > 0,
                function ($query) use (
                    $existingBarangIds
                ) {

                    $query->whereNotIn(
                        'id_master_barang',
                        $existingBarangIds
                    );
                }
            )
            ->orderBy(
                'nm_master_barang'
            )
            ->get();


        return view(
            'procurement.edit',
            compact(
                'po',
                'availableBarangs'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE EDIT
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Po $po
    ) {
        abort_unless(
            $po->kode_status !== 'APPROVED',
            403,
            'Purchase Order yang sudah disetujui tidak dapat diedit.'
        );


        $validated = $request->validate([
            'qty' => [
                'required',
                'array',
            ],

            'qty.*' => [
                'required',
                'integer',
                'min:1',
            ],

            'desc_po' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);


        DB::transaction(
            function () use (
                $validated,
                $po
            ) {

                $userId =
                    auth()->id();


                foreach (
                    $validated['qty']
                    as $itemId => $qty
                ) {

                    PoDetail::where(
                        'fk_po',
                        $po->id_po
                    )
                    ->where(
                        'id_po_detail',
                        $itemId
                    )
                    ->update([
                        'qty_request' =>
                            (int) $qty,

                        'updated_by' =>
                            $userId,
                    ]);
                }


                $po->update([
                    'desc_po' =>
                        $validated['desc_po']
                        ?? null,

                    'updated_by' =>
                        $userId,
                ]);
            }
        );


        return redirect()
            ->route(
                'procurement.index'
            )
            ->with(
                'success',
                'Purchase Order ' .
                $po->kd_po .
                ' berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD ITEM TO EXISTING PO
    |--------------------------------------------------------------------------
    */

    public function addItem(
        Request $request,
        Po $po
    ) {
        abort_unless(
            $po->kode_status !== 'APPROVED',
            403,
            'PO yang sudah disetujui tidak dapat diedit.'
        );


        $validated = $request->validate([
            'fk_barang' => [
                'required',
                'exists:tbl_master_barang,id_master_barang',
            ],

            'qty' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        $exists = PoDetail::where(
            'fk_po',
            $po->id_po
        )
            ->where(
                'fk_barang',
                $validated['fk_barang']
            )
            ->exists();


        if ($exists) {

            return back()->withErrors([
                'fk_barang' =>
                    'Barang ini sudah ada di dalam PO.',
            ]);
        }


        $barang =
            MasterBarang::findOrFail(
                $validated['fk_barang']
            );


        $stokPerBarang =
            $this->stokPerBarang();


        PoDetail::create([
            'fk_po' =>
                $po->id_po,

            'fk_barang' =>
                $validated['fk_barang'],

            'qty_stok_at_request' =>
                (int) (
                    $stokPerBarang[
                        $validated['fk_barang']
                    ] ?? 0
                ),

            'qty_min_stok_at_request' =>
                (int) $barang->minimum_stok,

            'qty_request' =>
                (int) $validated['qty'],

            'created_by' =>
                auth()->id(),
        ]);


        return back()->with(
            'success',
            'Barang berhasil ditambahkan ke PO.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE ITEM
    |--------------------------------------------------------------------------
    */

    public function removeItem(
        Po $po,
        PoDetail $item
    ) {
        abort_unless(
            $po->kode_status !== 'APPROVED',
            403,
            'PO yang sudah disetujui tidak dapat diedit.'
        );


        abort_unless(
            $item->fk_po === $po->id_po,
            404
        );


        $item->delete();


        return back()->with(
            'success',
            'Barang berhasil dihapus dari PO.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE PO
    |--------------------------------------------------------------------------
    */

    public function destroy(Po $po)
    {
        $kdPo =
            $po->kd_po;


        $po->delete();


        return redirect()
            ->route(
                'procurement.index'
            )
            ->with(
                'success',
                'Purchase Order ' .
                $kdPo .
                ' berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE PAGE
    |--------------------------------------------------------------------------
    */

    public function approve(Po $po)
    {
        $po->load([
            'supplier',
            'statusPo',
            'details.barang',
        ]);


        return view(
            'procurement.approve',
            compact('po')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approveSubmit(
        Request $request,
        Po $po
    ) {
        abort_if(
            $po->kode_status === 'APPROVED',
            403,
            'Purchase Order ini sudah disetujui.'
        );


        if (
            $po->details()->count() === 0
        ) {

            return back()->withErrors([
                'approve' =>
                    'Purchase Order belum memiliki barang.',
            ]);
        }


        DB::transaction(
            function () use ($po) {

                $po->update([
                    'fk_status_po' =>
                        $this->statusId(
                            'APPROVED'
                        ),

                    'updated_by' =>
                        auth()->id(),

                    'approve_at' =>
                        now(),

                    'approved_by' =>
                        auth()->id(),
                ]);
            }
        );


        return redirect()
            ->route(
                'procurement.index'
            )
            ->with(
                'success',
                'Purchase Order ' .
                $po->kd_po .
                ' berhasil disetujui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        Po $po
    ) {
        abort_if(
            $po->kode_status === 'APPROVED',
            403,
            'PO ini sudah disetujui dan tidak dapat ditolak.'
        );


        $po->update([
            'fk_status_po' =>
                $this->statusId(
                    'REJECTED'
                ),

            'updated_by' =>
                auth()->id(),
        ]);


        return redirect()
            ->route(
                'procurement.index'
            )
            ->with(
                'success',
                'Purchase Order ' .
                $po->kd_po .
                ' ditolak.'
        );
    }
}