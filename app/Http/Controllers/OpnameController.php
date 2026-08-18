<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
use App\Models\MasterBarang;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpnameController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $search = trim((string) $request->string('search'));

        $query = Opname::with('gudang')
            ->withCount([
                'details',
                'details as details_counted_count' => fn ($q) =>
                    $q->whereNotNull('stok_aktual'),
                'details as details_selisih_count' => fn ($q) =>
                    $q->where('status_item', 'SELISIH'),
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kd_opname', 'like', "%{$search}%")
                    ->orWhereHas('gudang', function ($g) use ($search) {
                        $g->where('nm_gudang', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'status_opname',
                $request->string('status')->toString()
            );
        }

        if ($request->boolean('issue')) {
            $query->whereHas(
                'details',
                fn ($q) => $q->where('status_item', 'SELISIH')
            );
        }

        $opnames = $query
            ->latest('id_opname')
            ->paginate(
                $this->resolvePerPage($request, $query)
            )
            ->withQueryString();

        $summary = [
            'ongoing' => Opname::where(
                'status_opname',
                'ONGOING'
            )->count(),

            'discrepancies' => Opname::where(
                'status_opname',
                'ONGOING'
            )
                ->whereHas(
                    'details',
                    fn ($q) => $q->where('status_item', 'SELISIH')
                )
                ->count(),

            'completed_this_month' => Opname::where(
                'status_opname',
                'COMPLETED'
            )
                ->whereMonth('tgl_selesai', now()->month)
                ->whereYear('tgl_selesai', now()->year)
                ->count(),
        ];

        $gudangs = MasterGudang::orderBy('nm_gudang')->get();

        $lokasis = StrukturLokasi::with('row.rak.gudang')
            ->where('status_lokasi', 'AKTIF')
            ->orderBy('bin')
            ->get();

        return view(
            'opname.index',
            compact(
                'opnames',
                'summary',
                'gudangs',
                'lokasis',
                'perPage'
            )
        );
    }

    /**
     * Membuat sesi Stock Opname baru.
     *
     * Data barang diambil dari tbl_stok_lokasi sebagai
     * snapshot stok sistem.
     *
     * TIDAK mengubah tbl_stok_lokasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_gudang' => [
                'required',
                'exists:tbl_master_gudang,id_gudang',
            ],

            'lokasi_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'lokasi_ids.*' => [
                'integer',
                'exists:tbl_master_lokasi,id_lokasi',
            ],
        ]);

        $opname = DB::transaction(function () use ($validated) {
            $userId = auth()->id() ?? 1;

            $opname = Opname::create([
                'fk_gudang' => $validated['fk_gudang'],
                'tgl_mulai' => now()->toDateString(),
                'status_opname' => 'ONGOING',
                'created_by' => $userId,
            ]);

            $opname->lokasis()->attach($validated['lokasi_ids']);

            /*
             * Ambil stok resmi dari tbl_stok_lokasi.
             *
             * Hanya stok > 0 yang otomatis dibuat sebagai detail.
             * Bin yang tidak mempunyai stok akan tetap muncul
             * sebagai Empty Bin di halaman opname.
             */
            $stokItems = StokLokasi::with('barang')
                ->whereIn('fk_lokasi', $validated['lokasi_ids'])
                ->where('qty_stok', '>', 0)
                ->get();

            foreach ($stokItems as $stok) {
                OpnameDetail::create([
                    'fk_opname' => $opname->id_opname,
                    'fk_lokasi' => $stok->fk_lokasi,
                    'fk_barang' => $stok->fk_barang,
                    'stok_sistem' => $stok->qty_stok,
                    'status_item' => 'BELUM DIHITUNG',
                    'created_by' => $userId,
                ]);
            }

            return $opname;
        });

        return redirect()
            ->route('opname.show', $opname)
            ->with(
                'success',
                'Opname ' . $opname->kd_opname .
                ' berhasil dibuat. Silakan mulai hitung fisik.'
            );
    }

    public function show(Request $request, Opname $opname)
    {
        $opname->load('gudang');

        $perPage = $this->perPageOption($request);
        $search = trim((string) $request->string('search'));

        $query = OpnameDetail::with(['barang', 'lokasi'])
            ->where('fk_opname', $opname->id_opname);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($b) use ($search) {
                    $b->where(
                        'kd_master_barang',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'nm_master_barang',
                            'like',
                            "%{$search}%"
                        );
                })
                    ->orWhereHas('lokasi', function ($l) use ($search) {
                        $l->where(
                            'bin',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('bin')) {
            $query->where(
                'fk_lokasi',
                $request->integer('bin')
            );
        }

        $details = $query
            ->orderBy('fk_lokasi')
            ->paginate(
                $this->resolvePerPage($request, $query)
            )
            ->withQueryString();

        $bins = $opname
            ->lokasis()
            ->orderBy('bin')
            ->get();

        /*
         * Cari bin yang belum mempunyai detail.
         */
        $binIdsWithDetails = OpnameDetail::where(
            'fk_opname',
            $opname->id_opname
        )
            ->pluck('fk_lokasi')
            ->unique();

        $emptyBins = $bins
            ->whereNotIn('id_lokasi', $binIdsWithDetails)
            ->values();

        if ($search !== '') {
            $emptyBins = collect();
        } elseif ($request->filled('bin')) {
            $emptyBins = $emptyBins
                ->where(
                    'id_lokasi',
                    $request->integer('bin')
                )
                ->values();
        }

        $allBarangs = MasterBarang::where(
            'status_master_barang',
            'AKTIF'
        )
            ->orderBy('nm_master_barang')
            ->get();

        $selectedBin = null;
        $selectedBinCanDelete = false;

        if ($request->filled('bin')) {
            $selectedBin = $bins->firstWhere(
                'id_lokasi',
                $request->integer('bin')
            );

            if ($selectedBin) {
                $selectedBinCanDelete =
                    ! OpnameDetail::where(
                        'fk_opname',
                        $opname->id_opname
                    )
                        ->where(
                            'fk_lokasi',
                            $selectedBin->id_lokasi
                        )
                        ->whereNotNull('stok_aktual')
                        ->exists();
            }
        }

        $totalItems = $opname->details()->count();

        $countedItems = $opname
            ->details()
            ->whereNotNull('stok_aktual')
            ->count();

        $selisihItems = $opname
            ->details()
            ->where('status_item', 'SELISIH')
            ->count();

        $progress = $totalItems > 0
            ? (int) round(
                ($countedItems / $totalItems) * 100
            )
            : 0;

        return view(
            'opname.show',
            compact(
                'opname',
                'details',
                'bins',
                'emptyBins',
                'perPage',
                'allBarangs',
                'totalItems',
                'countedItems',
                'selisihItems',
                'progress',
                'selectedBin',
                'selectedBinCanDelete'
            )
        );
    }

    /**
     * SAVE PROGRESS
     *
     * HANYA menyimpan ke tbl_opname_detail.
     *
     * TIDAK menyentuh tbl_stok_lokasi.
     */
    public function update(Request $request, Opname $opname)
    {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'opname' =>
                    'Opname yang sudah selesai tidak dapat diubah lagi.',
            ]);
        }

        $validated = $request->validate([
            'detail' => [
                'required',
                'array',
            ],

            'detail.*' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        DB::transaction(function () use ($validated, $opname) {
            $userId = auth()->id() ?? 1;

            foreach (
                $validated['detail']
                as $detailId => $stokAktual
            ) {
                $detail = OpnameDetail::where(
                    'fk_opname',
                    $opname->id_opname
                )
                    ->where(
                        'id_opname_detail',
                        $detailId
                    )
                    ->first();

                if (! $detail) {
                    continue;
                }

                $detail->stok_aktual = $stokAktual;
                $detail->updated_by = $userId;

                $detail->recalculate();
                $detail->save();
            }
        });

        return back()->with(
            'success',
            'Progress hitung fisik berhasil disimpan.'
        );
    }

    /**
     * SUBMIT ADJUSTMENT
     *
     * Di sinilah stok resmi baru diubah.
     *
     * tbl_opname_detail
     *        ↓
     * validasi
     *        ↓
     * tbl_stok_lokasi
     *
     * Jika stok lokasi sudah ada:
     *     UPDATE
     *
     * Jika belum ada:
     *     CREATE
     */
    public function submitAdjustment(Opname $opname)
    {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'submit' =>
                    'Opname ini sudah selesai dan tidak dapat disubmit lagi.',
            ]);
        }

        $bins = $opname
            ->lokasis()
            ->get();

        /*
         * =====================================================
         * VALIDASI 1
         * Semua bin yang dipilih harus mempunyai minimal
         * satu detail barang.
         * =====================================================
         */
        $binIdsWithDetails = OpnameDetail::where(
            'fk_opname',
            $opname->id_opname
        )
            ->pluck('fk_lokasi')
            ->unique();

        $emptyBins = $bins
            ->whereNotIn(
                'id_lokasi',
                $binIdsWithDetails
            );

        if ($emptyBins->isNotEmpty()) {
            $binNames = $emptyBins
                ->pluck('bin')
                ->implode(', ');

            return back()->withErrors([
                'submit' =>
                    'Submit tidak dapat dilakukan. ' .
                    'Masih ada bin yang kosong: ' .
                    $binNames .
                    '. Silakan isi barang pada bin tersebut ' .
                    'atau hapus bin dari opname.',
            ]);
        }

        /*
         * =====================================================
         * VALIDASI 2
         * SEMUA detail harus mempunyai stok_aktual.
         * =====================================================
         */
        $allDetails = OpnameDetail::where(
            'fk_opname',
            $opname->id_opname
        )->get();

        if ($allDetails->isEmpty()) {
            return back()->withErrors([
                'submit' =>
                    'Belum ada barang yang tercatat dalam opname.',
            ]);
        }

        $unCounted = $allDetails
            ->whereNull('stok_aktual');

        if ($unCounted->isNotEmpty()) {
            return back()->withErrors([
                'submit' =>
                    'Submit tidak dapat dilakukan. ' .
                    'Masih ada ' .
                    $unCounted->count() .
                    ' barang yang belum diisi Actual Qty. ' .
                    'Silakan isi semua barang atau hapus item/bin ' .
                    'yang memang tidak diperlukan.',
            ]);
        }

        /*
         * =====================================================
         * SEMUA VALIDASI SUDAH LOLOS
         *
         * BARU SEKARANG UPDATE / CREATE tbl_stok_lokasi.
         * =====================================================
         */
        DB::transaction(function () use ($allDetails, $opname) {
            $userId = auth()->id() ?? 1;

            foreach ($allDetails as $detail) {
                /*
                 * Cari stok lokasi termasuk yang pernah
                 * di-soft-delete.
                 */
                $stokLokasi = StokLokasi::withTrashed()
                    ->where(
                        'fk_lokasi',
                        $detail->fk_lokasi
                    )
                    ->where(
                        'fk_barang',
                        $detail->fk_barang
                    )
                    ->first();

                /*
                 * Kalau belum ada:
                 * CREATE
                 */
                if (! $stokLokasi) {
                    $stokLokasi = new StokLokasi();

                    $stokLokasi->fk_lokasi =
                        $detail->fk_lokasi;

                    $stokLokasi->fk_barang =
                        $detail->fk_barang;

                    $stokLokasi->created_by = $userId;
                } else {
                    /*
                     * Kalau sebelumnya soft delete,
                     * aktifkan kembali.
                     */
                    if ($stokLokasi->trashed()) {
                        $stokLokasi->restore();
                    }
                }

                /*
                 * Hasil Actual Qty dari opname menjadi
                 * stok resmi.
                 */
                $stokLokasi->qty_stok =
                    $detail->stok_aktual;

                $stokLokasi->updated_by = $userId;

                $stokLokasi->save();
            }

            /*
             * Setelah semua stok berhasil disimpan,
             * baru tandai opname COMPLETED.
             */
            $opname->update([
                'status_opname' => 'COMPLETED',
                'tgl_selesai' => now()->toDateString(),
                'updated_by' => $userId,
            ]);
        });

        return back()->with(
            'success',
            'Adjustment berhasil disubmit. Stok lokasi berhasil diperbarui/dibuat dan opname telah selesai.'
        );
    }

    public function destroy(Opname $opname)
    {
        if ($opname->status_opname === 'COMPLETED') {
            return back()->withErrors([
                'opname' =>
                    'Opname yang sudah selesai tidak dapat dihapus.',
            ]);
        }

        $opname->delete();

        return redirect()
            ->route('opname.index')
            ->with(
                'success',
                'Opname berhasil dihapus.'
            );
    }

    /**
     * Tambah barang ke opname.
     *
     * PENTING:
     * Method ini TIDAK mengubah tbl_stok_lokasi.
     *
     * Kalau barang sudah ada di tbl_stok_lokasi,
     * stok_sistem diambil dari sana.
     *
     * Kalau belum ada,
     * stok_sistem = 0.
     */
    public function addItem(
        Request $request,
        Opname $opname
    ) {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'item' =>
                    'Opname yang sudah selesai tidak dapat ditambahkan barang.',
            ]);
        }

        $validated = $request->validate([
            'fk_lokasi' => [
                'required',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'fk_barang' => [
                'required',
                'exists:tbl_master_barang,id_master_barang',
            ],
        ]);

        /*
         * Pastikan bin termasuk dalam opname.
         */
        $isBinValid = $opname
            ->lokasis()
            ->where(
                'tbl_master_lokasi.id_lokasi',
                $validated['fk_lokasi']
            )
            ->exists();

        if (! $isBinValid) {
            return back()->withErrors([
                'fk_lokasi' =>
                    'Bin tersebut tidak termasuk dalam sesi opname ini.',
            ]);
        }

        /*
         * Cek apakah barang sudah ada di opname ini.
         */
        $alreadyExists = OpnameDetail::where(
            'fk_opname',
            $opname->id_opname
        )
            ->where(
                'fk_lokasi',
                $validated['fk_lokasi']
            )
            ->where(
                'fk_barang',
                $validated['fk_barang']
            )
            ->exists();

        if ($alreadyExists) {
            return back()->withErrors([
                'fk_barang' =>
                    'Barang ini sudah tercatat di bin tersebut untuk opname ini.',
            ]);
        }

        /*
         * Ambil System Qty dari STOK RESMI.
         *
         * Tidak ada:
         * StokLokasi::updateOrCreate()
         *
         * di sini.
         */
        $stokLokasi = StokLokasi::where(
            'fk_lokasi',
            $validated['fk_lokasi']
        )
            ->where(
                'fk_barang',
                $validated['fk_barang']
            )
            ->first();

        $stokSistem = $stokLokasi
            ? $stokLokasi->qty_stok
            : 0;

        /*
         * Hanya membuat data sementara di
         * tbl_opname_detail.
         */
        OpnameDetail::create([
            'fk_opname' =>
                $opname->id_opname,

            'fk_lokasi' =>
                $validated['fk_lokasi'],

            'fk_barang' =>
                $validated['fk_barang'],

            'stok_sistem' =>
                $stokSistem,

            'status_item' =>
                'BELUM DIHITUNG',

            'created_by' =>
                auth()->id() ?? 1,
        ]);

        return back()->with(
            'success',
            'Barang berhasil ditambahkan ke opname. Stok resmi belum diubah.'
        );
    }

    /**
     * Edit System Qty / keterangan.
     *
     * Tetap hanya mengubah tbl_opname_detail.
     * Stok resmi baru berubah saat Submit.
     */
    public function updateItem(
        Request $request,
        Opname $opname,
        OpnameDetail $item
    ) {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'item' =>
                    'Opname yang sudah selesai tidak dapat diedit.',
            ]);
        }

        abort_unless(
            $item->fk_opname === $opname->id_opname,
            404
        );

        $validated = $request->validate([
            'stok_sistem' => [
                'required',
                'integer',
                'min:0',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $item->stok_sistem =
            $validated['stok_sistem'];

        $item->keterangan =
            $validated['keterangan'] ?? null;

        $item->updated_by =
            auth()->id() ?? 1;

        $item->recalculate();
        $item->save();

        return back()->with(
            'success',
            'Barang berhasil diperbarui.'
        );
    }

    /**
     * Hapus item dari opname.
     *
     * Tidak menyentuh tbl_stok_lokasi.
     */
    public function deleteItem(
        Opname $opname,
        OpnameDetail $item
    ) {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'item' =>
                    'Opname yang sudah selesai tidak dapat diubah.',
            ]);
        }

        abort_unless(
            $item->fk_opname === $opname->id_opname,
            404
        );

        if ($item->stok_aktual !== null) {
            return back()->withErrors([
                'item' =>
                    'Barang ini sudah dihitung (ada Actual Qty), tidak bisa dihapus dari opname.',
            ]);
        }

        $item->delete();

        return back()->with(
            'success',
            'Barang berhasil dihapus dari opname.'
        );
    }

    /**
     * Keluarkan bin dari opname.
     *
     * Tidak menyentuh tbl_stok_lokasi.
     */
    public function deleteBin(
        Opname $opname,
        StrukturLokasi $lokasi
    ) {
        if ($opname->status_opname !== 'ONGOING') {
            return back()->withErrors([
                'bin' =>
                    'Opname yang sudah selesai tidak dapat diubah.',
            ]);
        }

        $isBinValid = $opname
            ->lokasis()
            ->where(
                'tbl_master_lokasi.id_lokasi',
                $lokasi->id_lokasi
            )
            ->exists();

        if (! $isBinValid) {
            return back()->withErrors([
                'bin' =>
                    'Bin tersebut tidak termasuk dalam sesi opname ini.',
            ]);
        }

        $adaYangSudahDihitung = OpnameDetail::where(
            'fk_opname',
            $opname->id_opname
        )
            ->where(
                'fk_lokasi',
                $lokasi->id_lokasi
            )
            ->whereNotNull('stok_aktual')
            ->exists();

        if ($adaYangSudahDihitung) {
            return back()->withErrors([
                'bin' =>
                    'Bin ' .
                    $lokasi->bin .
                    ' masih ada barang yang sudah dihitung, tidak bisa dihapus dari opname.',
            ]);
        }

        DB::transaction(function () use (
            $opname,
            $lokasi
        ) {
            OpnameDetail::where(
                'fk_opname',
                $opname->id_opname
            )
                ->where(
                    'fk_lokasi',
                    $lokasi->id_lokasi
                )
                ->delete();

            $opname
                ->lokasis()
                ->detach($lokasi->id_lokasi);
        });

        return redirect()
            ->route(
                'opname.show',
                $opname
            )
            ->with(
                'success',
                'Bin ' .
                $lokasi->bin .
                ' berhasil dikeluarkan dari opname.'
            );
    }
}