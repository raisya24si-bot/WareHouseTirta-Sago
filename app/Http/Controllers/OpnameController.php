<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterBarang;
use App\Models\MasterGudang;
use App\Models\MasterRow;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpnameController extends Controller
{
    use HasPerPage;

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);

        $search = trim(
            $request->string('search')->toString()
        );

        $query = Opname::with('gudang')
            ->withCount([
                'details',

                'details as details_counted_count' => function ($q) {
                    $q->whereNotNull('stok_aktual');
                },

                'details as details_selisih_count' => function ($q) {
                    $q->where('status_item', 'SELISIH');
                },
            ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {

                $q->where(
                    'kd_opname',
                    'like',
                    "%{$search}%"
                );

                $q->orWhereHas('gudang', function ($gudang) use ($search) {

                    $gudang->where(
                        'nm_gudang',
                        'like',
                        "%{$search}%"
                    );
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status_opname',
                $request->string('status')->toString()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER ISSUE / SELISIH
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('issue')) {
            $query->whereHas(
                'details',
                function ($q) {
                    $q->where(
                        'status_item',
                        'SELISIH'
                    );
                }
            );
        }

        $opnames = $query
            ->latest('id_opname')
            ->paginate(
                $this->resolvePerPage(
                    $request,
                    $query
                )
            )
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

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
                    function ($q) {
                        $q->where(
                            'status_item',
                            'SELISIH'
                        );
                    }
                )
                ->count(),

            'completed_this_month' => Opname::where(
                'status_opname',
                'COMPLETED'
            )
                ->whereMonth(
                    'tgl_selesai',
                    now()->month
                )
                ->whereYear(
                    'tgl_selesai',
                    now()->year
                )
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | DATA FORM
        |--------------------------------------------------------------------------
        */

        $gudangs = MasterGudang::orderBy(
            'nm_gudang'
        )->get();

        $lokasis = StrukturLokasi::with(
            'row.rak.gudang'
        )
            ->where(
                'status_lokasi',
                'AKTIF'
            )
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


    /*
    |--------------------------------------------------------------------------
    | CREATE OPNAME
    |--------------------------------------------------------------------------
    |
    | CREATE hanya membuat:
    |
    | tbl_opname
    | tbl_opname_lokasi
    | tbl_opname_detail
    |
    | TIDAK mengubah tbl_stok_lokasi.
    |
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

        /*
        |--------------------------------------------------------------------------
        | Pastikan BIN memang milik gudang yang dipilih
        |--------------------------------------------------------------------------
        */

        $validLokasiIds = StrukturLokasi::query()
            ->whereIn(
                'id_lokasi',
                $validated['lokasi_ids']
            )
            ->whereHas(
                'row.rak.gudang',
                function ($q) use ($validated) {
                    $q->where(
                        'id_gudang',
                        $validated['fk_gudang']
                    );
                }
            )
            ->pluck('id_lokasi')
            ->toArray();

        if (
            count($validLokasiIds)
            !== count($validated['lokasi_ids'])
        ) {
            return back()
                ->withErrors([
                    'lokasi_ids' =>
                        'Ada BIN yang tidak termasuk dalam gudang yang dipilih.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        $opname = DB::transaction(
            function () use (
                $validated
            ) {

                $userId =
                    auth()->id() ?? 1;

                /*
                |--------------------------------------------------------------------------
                | HEADER OPNAME
                |--------------------------------------------------------------------------
                */

                $opname = Opname::create([

                    'fk_gudang' =>
                        $validated['fk_gudang'],

                    'tgl_mulai' =>
                        now()->toDateString(),

                    'status_opname' =>
                        'ONGOING',

                    'created_by' =>
                        $userId,
                ]);

                /*
                |--------------------------------------------------------------------------
                | BIN YANG DIPILIH
                |--------------------------------------------------------------------------
                */

                $opname->lokasis()->attach(
                    $validated['lokasi_ids']
                );

                /*
                |--------------------------------------------------------------------------
                | SNAPSHOT STOK
                |--------------------------------------------------------------------------
                |
                | Hanya mengambil stok resmi.
                |
                | Stok rusak dari opname BELUM masuk sini.
                |
                */

                $stokItems = StokLokasi::query()
                    ->whereIn(
                        'fk_lokasi',
                        $validated['lokasi_ids']
                    )
                    ->where(
                        'qty_stok',
                        '>',
                        0
                    )
                    ->get();

                foreach (
                    $stokItems as $stok
                ) {

                    OpnameDetail::create([

                        'fk_opname' =>
                            $opname->id_opname,

                        'fk_lokasi' =>
                            $stok->fk_lokasi,

                        'fk_barang' =>
                            $stok->fk_barang,

                        /*
                        | Snapshot stok saat opname dibuat.
                        */
                        'stok_sistem' =>
                            $stok->qty_stok,

                        /*
                        | Belum dihitung.
                        */
                        'stok_aktual' =>
                            null,

                        /*
                        | Belum ada barang rusak.
                        */
                        'stok_rusak' =>
                            0,

                        'selisih' =>
                            null,

                        'status_item' =>
                            'BELUM DIHITUNG',

                        'created_by' =>
                            $userId,
                    ]);
                }

                return $opname;
            }
        );

        return redirect()
            ->route(
                'opname.show',
                $opname
            )
            ->with(
                'success',
                'Opname ' .
                $opname->kd_opname .
                ' berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        Opname $opname
    ) {
        $id_opname = $opname->id_opname;
        $opname->load('gudang');

        $perPage =
            $this->perPageOption(
                $request
            );

        $search = trim(
            $request->string('search')->toString()
        );

        $query = OpnameDetail::with([
            'barang',
            'lokasi',
        ])
            ->where(
                'fk_opname',
                $opname->id_opname
            );

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'barang',
                    function ($b) use ($search) {

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
                    }
                )
                    ->orWhereHas(
                        'lokasi',
                        function ($l) use ($search) {

                            $l->where(
                                'bin',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER BIN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bin')) {

            $query->where(
                'fk_lokasi',
                $request->integer('bin')
            );
        }

        $details = $query
            ->orderBy('fk_lokasi')
            ->paginate(
                $this->resolvePerPage(
                    $request,
                    $query
                )
            )
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | SEMUA BIN DALAM OPNAME
        |--------------------------------------------------------------------------
        */

        $bins = $opname
            ->lokasis()
            ->orderBy('bin')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DETEKSI BIN KOSONG
        |--------------------------------------------------------------------------
        */

        $binIdsWithDetails =
            OpnameDetail::where(
                'fk_opname',
                $opname->id_opname
            )
                ->pluck('fk_lokasi')
                ->unique();

        $emptyBins = $bins
            ->whereNotIn(
                'id_lokasi',
                $binIdsWithDetails
            )
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

        /*
        |--------------------------------------------------------------------------
        | SEMUA BARANG AKTIF
        |--------------------------------------------------------------------------
        */

        $allBarangs = MasterBarang::where(
            'status_master_barang',
            'AKTIF'
        )
            ->orderBy('nm_master_barang')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ROW YANG BISA DIPAKAI UNTUK BIKIN BIN BARU
        |--------------------------------------------------------------------------
        |
        | Cuma row yang ada di GUDANG yang sama dengan opname ini.
        | Bin baru bakal dibuat di salah satu row ini.
        |--------------------------------------------------------------------------
        */

        $rows = MasterRow::whereHas(
            'rak',
            function ($q) use ($opname) {

                $q->where(
                    'fk_gudang',
                    $opname->fk_gudang
                );
            }
        )
            ->where(
                'status_row',
                'AKTIF'
            )
            ->with('rak')
            ->orderBy('kd_row')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SELECTED BIN
        |--------------------------------------------------------------------------
        */

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
                        ->whereNotNull(
                            'stok_aktual'
                        )
                        ->exists();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROGRESS
        |--------------------------------------------------------------------------
        */

        $totalItems =
            $opname
                ->details()
                ->count();

        $countedItems =
            $opname
                ->details()
                ->whereNotNull(
                    'stok_aktual'
                )
                ->count();

        $selisihItems =
            $opname
                ->details()
                ->where(
                    'status_item',
                    'SELISIH'
                )
                ->count();

        $progress =
            $totalItems > 0
                ? (int) round(
                    (
                        $countedItems
                        / $totalItems
                    ) * 100
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
                'selectedBinCanDelete',
                'rows'
            )
        );
    }



    public function update(
        Request $request,
        Opname $opname
    ) {
        if (
            $opname->status_opname !== 'ONGOING'
        ) {

            return back()
                ->withErrors([
                    'opname' =>
                        'Opname yang sudah selesai tidak dapat diubah lagi.',
                ]);
        }

        $validated = $request->validate([

            'detail' => [
                'required',
                'array',
            ],

            'detail.*.actual' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'detail.*.rusak' => [
                'nullable',
                'integer',
                'min:0',
            ],

            /*
            | Kita support juga input "baik"
            | kalau Blade nanti menampilkan field Baik.
            */
            'detail.*.baik' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        DB::transaction(
            function () use (
                $validated,
                $opname
            ) {

                $userId =
                    auth()->id() ?? 1;

                foreach (
                    $validated['detail']
                    as $detailId => $values
                ) {

                    $detail =
                        OpnameDetail::where(
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

                    /*
                    |--------------------------------------------------------------------------
                    | INPUT
                    |--------------------------------------------------------------------------
                    */

                    $actual =
                        $values['actual']
                        ?? null;

                    $rusak =
                        (int) (
                            $values['rusak']
                            ?? 0
                        );

                    $baikInput =
                        $values['baik']
                        ?? null;

                    /*
                    |--------------------------------------------------------------------------
                    | BELUM DIHITUNG
                    |--------------------------------------------------------------------------
                    */

                    if ($actual === null) {

                        $detail->stok_aktual =
                            null;

                        $detail->stok_rusak =
                            0;

                        $detail->selisih =
                            null;

                        $detail->status_item =
                            'BELUM DIHITUNG';

                        $detail->updated_by =
                            $userId;

                        $detail->save();

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | RUSAK TIDAK BOLEH > ACTUAL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $rusak > (int) $actual
                    ) {

                        throw ValidationException::withMessages([
                            "detail.{$detailId}.rusak" =>
                                'Qty rusak tidak boleh lebih besar dari Actual Qty.',
                        ]);
                    }

            

                    $baik =
                        (int) $actual
                        - $rusak;


                    if (
                        $baikInput !== null
                        &&
                        (int) $baikInput !== $baik
                    ) {

                        throw ValidationException::withMessages([
                            "detail.{$detailId}.baik" =>
                                'Qty Baik harus sama dengan Actual Qty dikurangi Qty Rusak.',
                        ]);
                    }


                    $detail->stok_aktual =
                        (int) $actual;

                    $detail->stok_rusak =
                        $rusak;

                    
                    $detail->selisih =
                        (int) $actual
                        -
                        (int) $detail->stok_sistem;

                   
                    $detail->status_item =
                        $detail->selisih === 0
                            ? 'SESUAI'
                            : 'SELISIH';

                    $detail->updated_by =
                        $userId;

                    $detail->save();
                }
            }
        );

        return back()->with(
            'success',
            'Progress berhasil disimpan. Stok resmi belum berubah.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT OPNAME
    |--------------------------------------------------------------------------
    |
    | HANYA METHOD INI YANG BOLEH MENGUBAH tbl_stok_lokasi.
    |
    */
   public function submitAdjustment(Opname $opname)
{

// return $opname->all();
    if ($opname->status_opname !== 'ONGOING') {
        return back()->withErrors([
            'submit' =>
                'Opname ini sudah selesai dan tidak dapat disubmit lagi.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL BIN OPNAME
    |--------------------------------------------------------------------------
    */

    $bins = $opname
        ->lokasis()
        ->orderBy('bin')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | VALIDASI 1
    | Tidak boleh ada BIN kosong.
    |--------------------------------------------------------------------------
    */

    $binIdsWithDetails = OpnameDetail::where(
        'fk_opname',
        $opname->id_opname
    )
        ->pluck('fk_lokasi')
        ->unique();

    $emptyBins = $bins->whereNotIn(
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
                'Masih ada BIN kosong: ' .
                $binNames .
                '. Isi barang atau hapus BIN tersebut dari opname.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL DETAIL OPNAME
    |--------------------------------------------------------------------------
    */

    $allDetails = OpnameDetail::with([
        'barang',
        'lokasi.row.rak.gudang.kategoriGudang',
    ])
        ->where(
            'fk_opname',
            $opname->id_opname
        )
        ->get();

    if ($allDetails->isEmpty()) {
        return back()->withErrors([
            'submit' =>
                'Belum ada barang yang tercatat dalam opname.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI 2
    | Semua barang harus sudah dihitung.
    |--------------------------------------------------------------------------
    */

    $unCounted = $allDetails->whereNull('stok_aktual');

    if ($unCounted->isNotEmpty()) {
        return back()->withErrors([
            'submit' =>
                'Submit tidak dapat dilakukan. ' .
                'Masih ada ' .
                $unCounted->count() .
                ' barang yang belum diisi Actual Qty.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI 3
    |
    | Actual = Baik + Rusak
    |
    | Contoh:
    |
    | Sistem = 5
    | Actual = 5
    | Rusak  = 2
    | Baik   = 3
    |
    | 3 + 2 = 5
    |--------------------------------------------------------------------------
    */

    foreach ($allDetails as $detail) {

        $system = (int) $detail->stok_sistem;

        $actual = (int) $detail->stok_aktual;

        $rusak = max(
            0,
            (int) ($detail->stok_rusak ?? 0)
        );

        /*
        |--------------------------------------------------------------------------
        | RUSAK TIDAK BOLEH > ACTUAL
        |--------------------------------------------------------------------------
        */

        if ($rusak > $actual) {
            return back()->withErrors([
                'submit' =>
                    'Barang ' .
                    ($detail->barang?->nm_master_barang ?? '-') .
                    ' tidak valid. ' .
                    'Qty rusak tidak boleh lebih besar dari Actual Qty.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG BARANG BAIK
        |--------------------------------------------------------------------------
        */

        $baik = $actual - $rusak;

        if (($baik + $rusak) !== $actual) {
            return back()->withErrors([
                'submit' =>
                    'Barang ' .
                    ($detail->barang?->nm_master_barang ?? '-') .
                    ' tidak valid. ' .
                    'Qty Baik + Qty Rusak harus sama dengan Actual Qty. ' .
                    'Actual: ' . $actual .
                    ', Baik: ' . $baik .
                    ', Rusak: ' . $rusak . '.',
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CARI BIN REJECTED
    |--------------------------------------------------------------------------
    */

    $rejectedLocation = StrukturLokasi::query()
        ->where(
            'status_lokasi',
            'AKTIF'
        )
        ->whereHas(
            'row.rak.gudang.kategoriGudang',
            function ($query) {
                $query->whereRaw(
                    'UPPER(nm_kategori_gudang) = ?',
                    ['REJECTED']
                );
            }
        )
        ->with(
            'row.rak.gudang.kategoriGudang'
        )
        ->orderBy('id_lokasi')
        ->first();

    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH ADA BARANG RUSAK
    |--------------------------------------------------------------------------
    */

    $adaBarangRusak = $allDetails->contains(
        function ($detail) {
            return (int) (
                $detail->stok_rusak ?? 0
            ) > 0;
        }
    );

    /*
    |--------------------------------------------------------------------------
    | ADA RUSAK TAPI BIN REJECTED BELUM ADA
    |--------------------------------------------------------------------------
    */

    if ($adaBarangRusak && ! $rejectedLocation) {
        return back()->withErrors([
            'submit' =>
                'Submit tidak dapat dilakukan karena belum ada BIN aktif ' .
                'pada gudang kategori REJECTED. ' .
                'Buat gudang kategori REJECTED beserta BIN-nya terlebih dahulu.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEMUA VALIDASI LOLOS
    |
    | BARU SEKARANG STOK RESMI DIUBAH.
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use (
        $allDetails,
        $opname,
        $rejectedLocation
    ){
        $id_lokasi = collect($allDetails)->select('fk_lokasi')->pluck('fk_lokasi')->toArray();

        $hapus_stok_by_bin = StokLokasi::whereIn('fk_lokasi',$id_lokasi)->delete();
        $userId = auth()->id() ?? 1;
        foreach ($allDetails as $detail) {

            $actual = (int) $detail->stok_aktual;

            $rusak = max(
                0,
                (int) ($detail->stok_rusak ?? 0)
            );

            /*
            |--------------------------------------------------------------------------
            | BARANG BAIK
            |--------------------------------------------------------------------------
            */

            $baik = $actual - $rusak;

            /*
            |--------------------------------------------------------------------------
            | 1. UPDATE STOK LOKASI ASAL
            |--------------------------------------------------------------------------
            |
            | Barang baik tetap berada di BIN asal.
            |
            */

            $stokAsal = StokLokasi::where(
                    'fk_barang',
                    $detail->fk_barang
                )
                ->where(
                    'fk_lokasi',
                    $detail->fk_lokasi
                )
                ->first();

            if (! $stokAsal) {

                $stokAsal = new StokLokasi();

                $stokAsal->fk_barang =
                    $detail->fk_barang;

                $stokAsal->fk_lokasi =
                    $detail->fk_lokasi;

                $stokAsal->created_by =
                    $userId;

                $stokAsal->qty_rusak =
                    0;
            }

            /*
            | Barang baik.
            */

            $stokAsal->qty_stok =
                $baik;

            /*
            | Barang rusak pada BIN asal
            | tidak lagi ditaruh sebagai stok aktif
            | karena dipindahkan ke REJECTED.
            */

            $stokAsal->qty_rusak =
                0;

            $stokAsal->updated_by =
                $userId;

            $stokAsal->save();

            /*
            |--------------------------------------------------------------------------
            | 2. BARANG RUSAK → BIN REJECTED
            |--------------------------------------------------------------------------
            */

            if (
                $rusak > 0 &&
                $rejectedLocation
            ) {

                $stokRejected = StokLokasi::where(
                        'fk_barang',
                        $detail->fk_barang
                    )
                    ->where(
                        'fk_lokasi',
                        $rejectedLocation->id_lokasi
                    )
                    ->first();

                /*
                | Belum ada record → CREATE
                */

                if (! $stokRejected) {

                    $stokRejected = new StokLokasi();

                    $stokRejected->fk_barang =
                        $detail->fk_barang;

                    $stokRejected->fk_lokasi =
                        $rejectedLocation->id_lokasi;

                    $stokRejected->qty_stok =
                        0;

                    $stokRejected->qty_rusak =
                        0;

                    $stokRejected->created_by =
                        $userId;
                }

                /*
                |--------------------------------------------------------------------------
                | TAMBAHKAN BARANG RUSAK
                |--------------------------------------------------------------------------
                |
                | INI BAGIAN YANG TADI KURANG.
                |
                */

                $stokRejected->qty_rusak =
                    (int) $stokRejected->qty_rusak
                    +
                    $rusak;

                $stokRejected->updated_by =
                    $userId;

                $stokRejected->save();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. SELESAIKAN OPNAME
        |--------------------------------------------------------------------------
        */

        $opname->update([
            'status_opname' =>
                'COMPLETED',

            'tgl_selesai' =>
                now()->toDateString(),

            'updated_by' =>
                $userId,
        ]);
    });

    return back()->with(
        'success',
        'Stock Opname berhasil disubmit. ' .
        'Stok barang baik dan barang rusak berhasil diperbarui.'
    );
}
    public function addItem(
        Request $request,
        Opname $opname
    ) {

        if (
            $opname->status_opname !== 'ONGOING'
        ) {

            return back()
                ->withErrors([
                    'item' =>
                        'Opname yang sudah selesai tidak dapat ditambahkan barang.',
                ]);
        }

        $validated = $request->validate([

            'new_bin' => [
                'nullable',
                'boolean',
            ],

            'fk_lokasi' => [
                'required_if:new_bin,1',
                'nullable',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'fk_row' => [
                'required_if:new_bin,1',
                'nullable',
                'exists:tbl_master_row,id_row',
            ],

            'fk_barang' => [
                'required',
                'exists:tbl_master_barang,id_master_barang',
            ],
        ]);

        $isNewBin = $request->boolean('new_bin');

        if ($isNewBin) {

            /*
            |--------------------------------------------------------------------------
            | BIN BARU
            |--------------------------------------------------------------------------
            |
            | User pilih ROW, sistem yang bikinin BIN-nya otomatis
            | (nomor urut 2 digit, sama kayak logic di
            | StrukturLokasiController::store()), lalu langsung
            | disambungkan ke sesi opname ini (tbl_opname_lokasi).
            |--------------------------------------------------------------------------
            */

            $row = MasterRow::findOrFail(
                $validated['fk_row']
            );

            /*
            | ROW harus ada di gudang yang sama dengan opname ini.
            */

            $rowGudangId =
                $row->rak?->fk_gudang;

            if ((int) $rowGudangId !== (int) $opname->fk_gudang) {

                return back()
                    ->withErrors([
                        'fk_row' =>
                            'Row tersebut bukan bagian dari gudang opname ini.',
                    ]);
            }

            $lokasi = DB::transaction(
                function () use ($row) {

                    $existing =
                        StrukturLokasi::where(
                                'fk_row',
                                $row->id_row
                            )
                            ->count();

                    $seq = $existing + 1;

                    $binCode = str_pad(
                        (string) $seq,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );

                    return StrukturLokasi::create([

                        'kd_lokasi' =>
                            $row->kd_row . '.' . $binCode,

                        'fk_row' =>
                            $row->id_row,

                        'bin' =>
                            $binCode,

                        'status_lokasi' =>
                            'AKTIF',

                        'created_by' =>
                            auth()->id() ?? 1,
                    ]);
                }
            );

            /*
            | Sambungkan bin baru ini ke sesi opname (kalau belum).
            */

            $opname->lokasis()->syncWithoutDetaching([
                $lokasi->id_lokasi,
            ]);

            $validated['fk_lokasi'] = $lokasi->id_lokasi;

        } else {

            /*
            |--------------------------------------------------------------------------
            | BIN HARUS TERMASUK OPNAME
            |--------------------------------------------------------------------------
            */

            $isBinValid =
                $opname
                    ->lokasis()
                    ->where(
                        'tbl_master_lokasi.id_lokasi',
                        $validated['fk_lokasi']
                    )
                    ->exists();

            if (! $isBinValid) {

                return back()
                    ->withErrors([
                        'fk_lokasi' =>
                            'Bin tersebut tidak termasuk dalam sesi opname ini.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BARANG TIDAK BOLEH DUPLIKAT
        |--------------------------------------------------------------------------
        */

        $alreadyExists =
            OpnameDetail::where(
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

            return back()
                ->withErrors([
                    'fk_barang' =>
                        'Barang ini sudah tercatat di bin tersebut untuk opname ini.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL SNAPSHOT STOK
        |--------------------------------------------------------------------------
        */

        $stokLokasi =
            StokLokasi::where(
                'fk_lokasi',
                $validated['fk_lokasi']
            )
                ->where(
                    'fk_barang',
                    $validated['fk_barang']
                )
                ->first();

        $stokSistem =
            $stokLokasi
                ? $stokLokasi->qty_stok
                : 0;

        /*
        |--------------------------------------------------------------------------
        | CREATE DETAIL
        |--------------------------------------------------------------------------
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

            'stok_aktual' =>
                null,

            'stok_rusak' =>
                0,

            'selisih' =>
                null,

            'status_item' =>
                'BELUM DIHITUNG',

            'created_by' =>
                auth()->id() ?? 1,
        ]);

        return back()
            ->with(
                'success',
                'Barang berhasil ditambahkan ke opname. Stok resmi belum diubah.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ITEM
    |--------------------------------------------------------------------------
    */

    public function updateItem(
        Request $request,
        Opname $opname,
        OpnameDetail $item
    ) {

        if (
            $opname->status_opname !== 'ONGOING'
        ) {

            return back()
                ->withErrors([
                    'item' =>
                        'Opname yang sudah selesai tidak dapat diedit.',
                ]);
        }

        abort_unless(
            $item->fk_opname ===
            $opname->id_opname,
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

        /*
        | Jangan mengubah stok resmi.
        */

        $item->save();

        return back()
            ->with(
                'success',
                'Barang berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE ITEM
    |--------------------------------------------------------------------------
    */

    public function deleteItem(
        Opname $opname,
        OpnameDetail $item
    ) {

        if (
            $opname->status_opname !== 'ONGOING'
        ) {

            return back()
                ->withErrors([
                    'item' =>
                        'Opname yang sudah selesai tidak dapat diubah.',
                ]);
        }

        abort_unless(
            $item->fk_opname ===
            $opname->id_opname,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | BARANG YANG SUDAH DIHITUNG TIDAK BOLEH DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (
            $item->stok_aktual !== null
        ) {

            return back()
                ->withErrors([
                    'item' =>
                        'Barang yang sudah dihitung tidak dapat dihapus dari opname.',
                ]);
        }

        $item->delete();

        return back()
            ->with(
                'success',
                'Barang berhasil dihapus dari opname.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE BIN
    |--------------------------------------------------------------------------
    */

    public function deleteBin(
        Opname $opname,
        StrukturLokasi $lokasi
    ) {

        if (
            $opname->status_opname !== 'ONGOING'
        ) {

            return back()
                ->withErrors([
                    'bin' =>
                        'Opname yang sudah selesai tidak dapat diubah.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BIN HARUS TERMASUK OPNAME
        |--------------------------------------------------------------------------
        */

        $isBinValid =
            $opname
                ->lokasis()
                ->where(
                    'tbl_master_lokasi.id_lokasi',
                    $lokasi->id_lokasi
                )
                ->exists();

        if (! $isBinValid) {

            return back()
                ->withErrors([
                    'bin' =>
                        'Bin tersebut tidak termasuk dalam sesi opname ini.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH ADA BARANG YANG DIHITUNG
        |--------------------------------------------------------------------------
        */

        $adaYangSudahDihitung =
            OpnameDetail::where(
                'fk_opname',
                $opname->id_opname
            )
                ->where(
                    'fk_lokasi',
                    $lokasi->id_lokasi
                )
                ->whereNotNull(
                    'stok_aktual'
                )
                ->exists();

        if (
            $adaYangSudahDihitung
        ) {

            return back()
                ->withErrors([
                    'bin' =>
                        'Bin ' .
                        $lokasi->bin .
                        ' masih ada barang yang sudah dihitung, tidak bisa dihapus dari opname.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE DETAIL + DETACH BIN
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
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
                    ->detach(
                        $lokasi->id_lokasi
                    );
            }
        );

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


    /*
    |--------------------------------------------------------------------------
    | DELETE OPNAME
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Opname $opname
    ) {

        if (
            $opname->status_opname === 'COMPLETED'
        ) {

            return back()
                ->withErrors([
                    'opname' =>
                        'Opname yang sudah selesai tidak dapat dihapus.',
                ]);
        }

        $opname->delete();

        return redirect()
            ->route(
                'opname.index'
            )
            ->with(
                'success',
                'Opname berhasil dihapus.'
            );
    }
}

