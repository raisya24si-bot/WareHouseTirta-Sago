<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
use App\Models\MasterRak;
use App\Models\MasterRow;
use App\Models\MasterStatusPenerimaanBarang;
use App\Models\Po;
use App\Models\PenerimaanBarang;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use App\Models\PenerimaanBarangBuktiDukung;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $this->validateDateRange($request);

        $perPage = $this->perPageOption($request);

        $query = $this->filteredQuery($request);

        $penerimaans = $query
            ->latest('id_penerimaan')
            ->paginate(
                $this->resolvePerPage($request, $query)
            )
            ->withQueryString();


        $tabCounts = [
            'all' => PenerimaanBarang::count(),

            'draft' => $this->countByStatus('DRAFT'),

            'menunggu' => PenerimaanBarang::whereHas(
                'statusPenerimaan',
                fn ($q) => $q->whereIn(
                    'kd_status_penerimaan_barang',
                    [
                        'PENDING_KASUBAG',
                        'PENDING_KABAG',
                        'PENDING_DIREKTUR',
                    ]
                )
            )->count(),

            'alokasi' => PenerimaanBarang::whereHas(
                'details',
                fn ($q) => $q->whereNotNull(
                    'fk_lokasi_barang'
                )
            )
                ->whereHas(
                    'statusPenerimaan',
                    fn ($q) => $q->whereNotIn(
                        'kd_status_penerimaan_barang',
                        [
                            'DRAFT',
                            'APPROVED',
                            'REJECTED',
                        ]
                    )
                )
                ->count(),

            'selesai' => $this->countByStatus('APPROVED'),

            'rejected' => $this->countByStatus('REJECTED'),
        ];


            $summary = [
    'menunggu_verifikasi' =>
        $tabCounts['menunggu'],

    'dalam_alokasi' =>
        $tabCounts['alokasi'],

    'selesai' =>
        $tabCounts['selesai'],

    'total_barang' =>
        (int) PenerimaanBarang::query()
            ->with(
                'details:id_penerimaan_barang_detail,fk_penerimaan_barang,qty_request'
            )
            ->get()
            ->sum(
                fn ($penerimaan) =>
                    $penerimaan->details->sum('qty_request')
            ),

    'accuracy_percentage' =>
        $tabCounts['all'] > 0
            ? round(
                ($tabCounts['selesai'] / $tabCounts['all']) * 100,
                1
            )
            : 0,

    'item_sesuai' =>
        (int) PenerimaanBarang::query()
            ->with(
                'details:id_penerimaan_barang_detail,fk_penerimaan_barang,qty_baik'
            )
            ->get()
            ->sum(
                fn ($penerimaan) =>
                    $penerimaan->details->sum('qty_baik')
            ),

    'item_discrepancy' =>
        (int) PenerimaanBarang::query()
            ->with(
                'details:id_penerimaan_barang_detail,fk_penerimaan_barang,qty_rusak'
            )
            ->get()
            ->sum(
                fn ($penerimaan) =>
                    $penerimaan->details->sum('qty_rusak')
            ),

    'discrepancy_percentage' => 0,

    'avg_verifikasi_minutes' => 0,
];


        $statusOptions = [
            [
                'value' => 'menunggu',
                'label' => 'Menunggu Verifikasi',
            ],
            [
                'value' => 'alokasi',
                'label' => 'Dalam Alokasi',
            ],
            [
                'value' => 'APPROVED',
                'label' => 'Disetujui / Selesai',
            ],
            [
                'value' => 'DRAFT',
                'label' => 'Draft',
            ],
            [
                'value' => 'REJECTED',
                'label' => 'Ditolak',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | GUDANG
        |--------------------------------------------------------------------------
        */

        $gudangs = MasterGudang::query()
            ->orderBy('nm_gudang')
            ->get([
                'id_gudang',
                'kd_gudang',
                'nm_gudang',
            ]);

        /*
        |--------------------------------------------------------------------------
        | PO YANG BISA DITERIMA
        |--------------------------------------------------------------------------
        */

        $poTerbuka = Po::query()
            ->with([
                'supplier',
                'details.barang.satuan',
                'statusPo',
            ])
            ->whereHas(
                'statusPo',
                fn ($q) =>
                    $q->where(
                        'kd_status_po',
                        'APPROVED'
                    )
            )
            ->get()
            ->filter(
                fn (Po $po) =>
                    $po->canBeReceived()
            )
            ->values();

        return view(
            'penerimaan.index',
            compact(
                'penerimaans',
                'perPage',
                'statusOptions',
                'tabCounts',
                'summary',
                'poTerbuka',
                'gudangs'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */

    public function export(Request $request)
    {
        $this->validateDateRange($request);

        $rows = $this->filteredQuery($request)
            ->latest('id_penerimaan')
            ->get();

        $filename =
            'penerimaan-barang-' .
            now()->format('Ymd-His') .
            '.csv';

        return response()->streamDownload(
            function () use ($rows) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                */

                fwrite(
                    $handle,
                    "\xEF\xBB\xBF"
                );

                fputcsv(
                    $handle,
                    [
                        'No. Penerimaan',
                        'Tanggal Masuk',
                        'No. PO',
                        'No. Invoice / SJ',
                        'Supplier',
                        'Total SKU',
                        'Total Qty',
                        'Satuan',
                        'Gudang',
                        'Status',
                    ]
                );

                foreach ($rows as $penerimaan) {

                    $details =
                        $penerimaan->details;

                    $units = $details
                        ->map(
                            fn ($detail) =>
                                $detail
                                    ->barang
                                    ?->satuan
                                    ?->nm_master_satuan
                        )
                        ->filter()
                        ->unique()
                        ->values();

                    $gudangNames = $details
                        ->map(
                            fn ($detail) =>
                                $detail
                                    ->lokasi
                                    ?->row
                                    ?->rak
                                    ?->gudang
                                    ?->nm_gudang
                        )
                        ->filter()
                        ->unique()
                        ->values();

                    fputcsv(
                        $handle,
                        [
                            $penerimaan->kd_penerimaan,

                            $penerimaan
                                ->tgl_penerimaan_barang
                                ?->format('Y-m-d'),

                            $penerimaan
                                ->po
                                ?->kd_po
                                ?? '-',

                            $penerimaan
                                ->no_sjinv_supplier
                                ?: '-',

                            $penerimaan
                                ->po
                                ?->supplier
                                ?->nm_master_supplier
                                ?? '-',

                            $details->count(),

                            (int) $details
                                ->sum('qty_request'),

                            $units->count() === 1
                                ? $units->first()
                                : (
                                    $units->isEmpty()
                                        ? 'Unit'
                                        : 'Beragam Satuan'
                                ),

                            $gudangNames->count() === 1
                                ? $gudangNames->first()
                                : (
                                    $gudangNames->isEmpty()
                                        ? '-'
                                        : 'Beragam Gudang'
                                ),

                            $penerimaan
                                ->statusPenerimaan
                                ?->nm_status_penerimaan_barang
                                ??
                                $penerimaan->kode_status
                                ??
                                '-',
                        ]
                    );
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }

    public function store(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDASI INPUT
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'fk_po' => [
            'required',
            'integer',
            'exists:tbl_po,id_po',
        ],

        'no_sjinv_supplier' => [
            'nullable',
            'string',
            'max:50',
        ],

        'tgl_penerimaan_barang' => [
            'required',
            'date',
        ],

        'desc_penerimaan_barang' => [
            'nullable',
            'string',
            'max:100',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | AMBIL PURCHASE ORDER
    |--------------------------------------------------------------------------
    */

    $po = Po::query()
        ->with([
            'statusPo',
            'details',
        ])
        ->findOrFail(
            $validated['fk_po']
        );


    /*
    |--------------------------------------------------------------------------
    | CEK STATUS PURCHASE ORDER
    |--------------------------------------------------------------------------
    */

    if (! $po->canBeReceived()) {

        return back()
            ->withErrors([
                'fk_po' =>
                    'Purchase Order tersebut belum dapat digunakan untuk penerimaan barang.',
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL STATUS DRAFT
    |--------------------------------------------------------------------------
    */

    $statusDraft =
        MasterStatusPenerimaanBarang::query()
            ->where(
                'kd_status_penerimaan_barang',
                'DRAFT'
            )
            ->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | BUAT PENERIMAAN BARANG
    |--------------------------------------------------------------------------
    */

    $penerimaan =
        DB::transaction(
            function () use (
                $validated,
                $po,
                $statusDraft
            ) {

                $userId =
                    auth()->id()
                    ?? 1;


                /*
                |--------------------------------------------------------------------------
                | BUAT HEADER PENERIMAAN
                |--------------------------------------------------------------------------
                */

                $penerimaan =
                    PenerimaanBarang::create([
                        'kd_penerimaan' =>
                            $this
                                ->generateKodePenerimaan(),

                        'tgl_penerimaan_barang' =>
                            $validated[
                                'tgl_penerimaan_barang'
                            ],

                        'fk_po' =>
                            $po->id_po,

                        'no_sjinv_supplier' =>
                            $validated[
                                'no_sjinv_supplier'
                            ]
                            ?? null,

                        'desc_penerimaan_barang' =>
                            $validated[
                                'desc_penerimaan_barang'
                            ]
                            ?? null,

                        'fk_status_penerimaan_barang' =>
                            $statusDraft
                                ->id_status_penerimaan_barang,

                        'created_by' =>
                            $userId,
                    ]);


                /*
                |--------------------------------------------------------------------------
                | COPY DETAIL PO
                |--------------------------------------------------------------------------
                */

                foreach (
                    $po->details
                    as $poDetail
                ) {

                    $penerimaan
                        ->details()
                        ->create([
                            'fk_barang' =>
                                $poDetail
                                    ->fk_barang,

                            'qty_request' =>
                                $poDetail
                                    ->qty_request,

                            'qty_baik' =>
                                0,

                            'qty_rusak' =>
                                0,

                            'created_by' =>
                                $userId,
                        ]);
                }


                return $penerimaan;
            }
        );


    /*
    |--------------------------------------------------------------------------
    | REDIRECT KE HALAMAN VERIFIKASI
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'penerimaan.verifikasi',
            [
                'penerimaan' =>
                    $penerimaan->id_penerimaan,
            ]
        )
        ->with(
            'success',
            'Penerimaan barang berhasil dibuat sebagai draft.'
        );
}

    public function uploadBuktiDukung(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {
        if (! $penerimaan->canBeEdited()) {

            $message = 'Penerimaan ini sudah diproses dan bukti pendukung tidak dapat diubah.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['bukti_dukung' => $message]);
        }

        $validated = $request->validate([
            'bukti_dukung' => [
                'required',
                'array',
                'min:1',
            ],

            'bukti_dukung.*' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'bukti_dukung.required' =>
                'Silakan pilih minimal satu gambar.',

            'bukti_dukung.*.image' =>
                'File bukti pendukung harus berupa gambar.',

            'bukti_dukung.*.mimes' =>
                'Format gambar yang diperbolehkan: JPG, JPEG, PNG, atau WEBP.',

            'bukti_dukung.*.max' =>
                'Ukuran setiap gambar maksimal 5 MB.',
        ]);

        $userId = auth()->id() ?? 1;

        $created = [];

        foreach ($validated['bukti_dukung'] as $file) {

            $originalName = $file->getClientOriginalName();

            $path = $file->store(
                'penerimaan-bukti',
                'public'
            );

            $bukti = PenerimaanBarangBuktiDukung::create([
                'fk_penerimaan_barang' =>
                    $penerimaan->id_penerimaan,

                'nama_file' =>
                    $originalName,

                'path_file' =>
                    $path,

                'mime_type' =>
                    $file->getClientMimeType(),

                'ukuran_file' =>
                    $file->getSize(),

                'created_by' =>
                    $userId,

                'updated_by' =>
                    $userId,
            ]);

            $created[] = [
                'id' => $bukti->id_penerimaan_barang_bukti_dukung ?? $bukti->id,
                'nama_file' => $bukti->nama_file,
                'url' => Storage::disk('public')->url($bukti->path_file),
            ];
        }

        $penerimaan->update([
            'updated_by' => $userId,
        ]);

        $message = 'Bukti pendukung berhasil diupload.';

        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
                'files' => $created,
                'total' => $penerimaan->buktiDukungs()->count(),
            ]);
        }

        return back()->with('success', $message);
    }


    public function verifikasi(
        PenerimaanBarang $penerimaan
    ) {

        $penerimaan->load([
            'statusPenerimaan',

            'po.supplier',

            'po.details.barang.satuan',

            'details.barang.satuan',

            'details.lokasi.row.rak.gudang',

            'details.lokasiKarantina.row.rak.gudang',

            'buktiDukungs.creator',
        ]);


        $lokasis = StrukturLokasi::query()
            ->with([
                'row.rak.gudang',
            ])
            ->where(
                'status_lokasi',
                'AKTIF'
            )
            ->orderBy(
                'id_lokasi'
            )
            ->get();

        return view(
            'penerimaan.verifikasi',
            [
                'penerimaan' =>
                    $penerimaan,

                'lokasis' =>
                    $lokasis,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOKASI PICKER (Gudang > Rak > Row > Bin) — cascading, real dari DB.
    |
    | Okupansi dihitung dari data stok fisik (tbl_stok_lokasi) yang benar-benar
    | ada, bukan angka statis: sebuah bin dianggap "terisi" bila punya baris
    | stok dengan qty_stok > 0.
    |--------------------------------------------------------------------------
    */

    /**
     * Base query join lokasi > row > rak, dengan info stok per bin.
     */
    private function lokasiBinStatsQuery()
    {
        return DB::table('tbl_master_lokasi as l')
            ->join('tbl_master_row as r', 'r.id_row', '=', 'l.fk_row')
            ->join('tbl_master_rak as rak', 'rak.id_rak', '=', 'r.fk_rak')
            ->leftJoin('tbl_stok_lokasi as sl', function ($join) {
                $join->on('sl.fk_lokasi', '=', 'l.id_lokasi')
                    ->where('sl.qty_stok', '>', 0);
            })
            ->whereNull('l.deleted_at')
            ->whereNull('r.deleted_at')
            ->whereNull('rak.deleted_at')
            ->where('l.status_lokasi', 'AKTIF')
            ->where('r.status_row', 'AKTIF')
            ->where('rak.status_rak', 'AKTIF');
    }

    private function occupancyPercent(int $total, int $terisi): int
    {
        return $total > 0
            ? (int) round($terisi / $total * 100)
            : 0;
    }

    /**
     * Level 1: daftar gudang + okupansi bin keseluruhan gudang.
     */
    public function lokasiGudangOptions()
    {
        $stats = $this->lokasiBinStatsQuery()
            ->select(
                'rak.fk_gudang',
                DB::raw('COUNT(DISTINCT l.id_lokasi) as total_bin'),
                DB::raw('COUNT(DISTINCT CASE WHEN sl.id_stok_lokasi IS NOT NULL THEN l.id_lokasi END) as bin_terisi')
            )
            ->groupBy('rak.fk_gudang')
            ->get()
            ->keyBy('fk_gudang');

        $gudangs = MasterGudang::query()
            ->orderBy('nm_gudang')
            ->get(['id_gudang', 'kd_gudang', 'nm_gudang']);

        $data = $gudangs->map(function ($gudang) use ($stats) {

            $stat = $stats->get($gudang->id_gudang);
            $total = (int) ($stat->total_bin ?? 0);
            $terisi = (int) ($stat->bin_terisi ?? 0);

            return [
                'id' => $gudang->id_gudang,
                'kode' => $gudang->kd_gudang,
                'label' => $gudang->nm_gudang,
                'total_bin' => $total,
                'bin_terisi' => $terisi,
                'bin_kosong' => max(0, $total - $terisi),
                'occupancy_percent' => $this->occupancyPercent($total, $terisi),
            ];
        })->values();

        return response()->json($data);
    }

    /**
     * Level 2: daftar rak dalam satu gudang + okupansi per rak.
     */
    public function lokasiRakOptions(Request $request)
    {
        $validated = $request->validate([
            'gudang_id' => ['required', 'integer', 'exists:tbl_master_gudang,id_gudang'],
        ]);

        $stats = $this->lokasiBinStatsQuery()
            ->where('rak.fk_gudang', $validated['gudang_id'])
            ->select(
                'rak.id_rak',
                DB::raw('COUNT(DISTINCT l.id_lokasi) as total_bin'),
                DB::raw('COUNT(DISTINCT CASE WHEN sl.id_stok_lokasi IS NOT NULL THEN l.id_lokasi END) as bin_terisi')
            )
            ->groupBy('rak.id_rak')
            ->get()
            ->keyBy('id_rak');

        $raks = MasterRak::query()
            ->where('fk_gudang', $validated['gudang_id'])
            ->where('status_rak', 'AKTIF')
            ->orderBy('kd_rak')
            ->get(['id_rak', 'kd_rak']);

        $data = $raks->map(function ($rak) use ($stats) {

            $stat = $stats->get($rak->id_rak);
            $total = (int) ($stat->total_bin ?? 0);
            $terisi = (int) ($stat->bin_terisi ?? 0);

            return [
                'id' => $rak->id_rak,
                'label' => $rak->kd_rak,
                'total_bin' => $total,
                'bin_terisi' => $terisi,
                'bin_kosong' => max(0, $total - $terisi),
                'occupancy_percent' => $this->occupancyPercent($total, $terisi),
            ];
        })->values();

        return response()->json($data);
    }

    /**
     * Level 3: daftar row/tingkat dalam satu rak + jumlah bin.
     */
    public function lokasiRowOptions(Request $request)
    {
        $validated = $request->validate([
            'rak_id' => ['required', 'integer', 'exists:tbl_master_rak,id_rak'],
        ]);

        $stats = $this->lokasiBinStatsQuery()
            ->where('rak.id_rak', $validated['rak_id'])
            ->select(
                'r.id_row',
                DB::raw('COUNT(DISTINCT l.id_lokasi) as total_bin'),
                DB::raw('COUNT(DISTINCT CASE WHEN sl.id_stok_lokasi IS NOT NULL THEN l.id_lokasi END) as bin_terisi')
            )
            ->groupBy('r.id_row')
            ->get()
            ->keyBy('id_row');

        $rows = MasterRow::query()
            ->where('fk_rak', $validated['rak_id'])
            ->where('status_row', 'AKTIF')
            ->orderBy('kd_row')
            ->get(['id_row', 'kd_row']);

        $data = $rows->map(function ($row) use ($stats) {

            $stat = $stats->get($row->id_row);
            $total = (int) ($stat->total_bin ?? 0);
            $terisi = (int) ($stat->bin_terisi ?? 0);

            return [
                'id' => $row->id_row,
                'label' => $row->kd_row,
                'total_bin' => $total,
                'bin_terisi' => $terisi,
                'bin_kosong' => max(0, $total - $terisi),
                'occupancy_percent' => $this->occupancyPercent($total, $terisi),
            ];
        })->values();

        return response()->json($data);
    }

    /**
     * Level 4: daftar bin dalam satu row, dengan status terisi/kosong.
     */
    public function lokasiBinOptions(Request $request)
    {
        $validated = $request->validate([
            'row_id' => ['required', 'integer', 'exists:tbl_master_row,id_row'],
        ]);

        $bins = StrukturLokasi::query()
            ->where('fk_row', $validated['row_id'])
            ->where('status_lokasi', 'AKTIF')
            ->orderBy('bin')
            ->get(['id_lokasi', 'kd_lokasi', 'bin']);

        $binIds = $bins->pluck('id_lokasi');

        $terisiMap = DB::table('tbl_stok_lokasi')
            ->join('tbl_master_barang', 'tbl_master_barang.id_master_barang', '=', 'tbl_stok_lokasi.fk_barang')
            ->whereIn('tbl_stok_lokasi.fk_lokasi', $binIds)
            ->where('tbl_stok_lokasi.qty_stok', '>', 0)
            ->select(
                'tbl_stok_lokasi.fk_lokasi',
                'tbl_master_barang.nm_master_barang',
                'tbl_stok_lokasi.qty_stok'
            )
            ->get()
            ->groupBy('fk_lokasi');

        $data = $bins->map(function ($bin) use ($terisiMap) {

            $isiBin = $terisiMap->get($bin->id_lokasi);

            return [
                'id' => $bin->id_lokasi,
                'label' => $bin->kd_lokasi ?: $bin->bin,
                'bin' => $bin->bin,
                'terisi' => (bool) $isiBin,
                'isi' => $isiBin
                    ? $isiBin->map(fn ($stok) => [
                        'nama_barang' => $stok->nm_master_barang,
                        'qty' => (int) $stok->qty_stok,
                    ])->values()
                    : [],
            ];
        })->values();

        return response()->json($data);
    }


    /**
     * Terapkan input qty/harga/lokasi per detail (dipakai bareng oleh
     * saveDraft() dan submit(), supaya submit juga menyimpan perubahan
     * yang baru diketik user meskipun belum sempat klik "Simpan Draf").
     */
    private function applyDetailInputs(
        PenerimaanBarang $penerimaan,
        array $detailsInput,
        int $userId
    ): void {

        if (empty($detailsInput)) {
            return;
        }

        $details = $penerimaan->details()->get();

        foreach ($details as $detail) {

            $input = $detailsInput[$detail->id_penerimaan_barang_detail] ?? null;

            if (! $input) {
                continue;
            }

            $qtyRequest = (int) $detail->qty_request;
            $qtyBaik = (int) ($input['qty_baik'] ?? $detail->qty_baik);
            $qtyRusak = (int) ($input['qty_rusak'] ?? $detail->qty_rusak);

            if (($qtyBaik + $qtyRusak) > $qtyRequest) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "details.{$detail->id_penerimaan_barang_detail}.qty_baik" =>
                        'Qty baik + qty rusak tidak boleh melebihi qty request.',
                ]);
            }

            $detail->update([
                'qty_baik' => $qtyBaik,
                'qty_rusak' => $qtyRusak,

                'fk_lokasi_barang' =>
                    $input['fk_lokasi_barang'] ?? $detail->fk_lokasi_barang,

                'fk_lokasi_karantina' =>
                    $input['fk_lokasi_karantina'] ?? $detail->fk_lokasi_karantina,

                'harga_satuan' =>
                    isset($input['harga_satuan'])
                        ? (int) $input['harga_satuan']
                        : $detail->harga_satuan,

                'updated_by' => $userId,
            ]);
        }
    }


    public function saveDraft(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {


        if (! $penerimaan->canBeEdited()) {

            $message = 'Penerimaan ini tidak dapat diubah karena statusnya sudah diproses.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['penerimaan' => $message]);
        }


        $validated = $request->validate([
            'no_sjinv_supplier' => [
                'nullable',
                'string',
                'max:50',
            ],

            'tgl_penerimaan_barang' => [
                'required',
                'date',
            ],

            'desc_penerimaan_barang' => [
                'nullable',
                'string',
                'max:100',
            ],

            'details' => [
                'required',
                'array',
                'min:1',
            ],

            'details.*.qty_baik' => [
                'required',
                'integer',
                'min:0',
            ],

            'details.*.qty_rusak' => [
                'required',
                'integer',
                'min:0',
            ],

            'details.*.fk_lokasi_barang' => [
                'nullable',
                'integer',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'details.*.fk_lokasi_karantina' => [
                'nullable',
                'integer',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'details.*.harga_satuan' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        DB::transaction(
            function () use (
                $penerimaan,
                $validated
            ) {

                $userId =
                    auth()->id()
                    ?? 1;

                $penerimaan->update([
                    'no_sjinv_supplier' =>
                        $validated[
                            'no_sjinv_supplier'
                        ]
                        ?? null,

                    'tgl_penerimaan_barang' =>
                        $validated[
                            'tgl_penerimaan_barang'
                        ],

                    'desc_penerimaan_barang' =>
                        $validated[
                            'desc_penerimaan_barang'
                        ]
                        ?? null,

                    'updated_by' =>
                        $userId,
                ]);

                $this->applyDetailInputs(
                    $penerimaan,
                    $validated['details'] ?? [],
                    $userId
                );
            }
        );

        $message = 'Verifikasi penerimaan berhasil disimpan sebagai draft.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('success', $message);
    }


    public function submit(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {

        $penerimaan->load([
            'statusPenerimaan',
            'details',
        ]);


        if (! $penerimaan->canBeEdited()) {
            return back()
                ->withErrors([
                    'submit' =>
                        'Penerimaan ini sudah diproses dan tidak dapat disubmit kembali.',
                ]);
        }


        if (
            $penerimaan
                ->details
                ->isEmpty()
        ) {

            return back()
                ->withErrors([
                    'submit' =>
                        'Detail barang penerimaan belum tersedia.',
                ]);
        }


        // Validasi input details[] yang dikirim bareng submit — ini
        // memastikan perubahan qty/harga/lokasi yang baru diketik user
        // (belum sempat "Simpan Draf") tetap ikut tersimpan saat submit.
        $validated = $request->validate([
            'no_sjinv_supplier' => [
                'nullable', 'string', 'max:50',
            ],
            'tgl_penerimaan_barang' => [
                'nullable', 'date',
            ],
            'desc_penerimaan_barang' => [
                'nullable', 'string', 'max:100',
            ],
            'details.*.qty_baik' => [
                'nullable', 'integer', 'min:0',
            ],
            'details.*.qty_rusak' => [
                'nullable', 'integer', 'min:0',
            ],
            'details.*.fk_lokasi_barang' => [
                'nullable', 'integer', 'exists:tbl_master_lokasi,id_lokasi',
            ],
            'details.*.fk_lokasi_karantina' => [
                'nullable', 'integer', 'exists:tbl_master_lokasi,id_lokasi',
            ],
            'details.*.harga_satuan' => [
                'nullable', 'integer', 'min:0',
            ],
        ]);


        // Catatan: idealnya alur ini lewat Kasubag -> Kabag dulu sebelum
        // Direktur (lihat PenerimaanBarang::LEVELS). Karena halaman approval
        // Kasubag & Kabag belum dibuat, submit langsung mengarah ke antrian
        // Direktur supaya alur tetap jalan. Kalau nanti halaman Kasubag/Kabag
        // dibuat, cukup ganti baris di bawah ini ke 'PENDING_KASUBAG'.
        $nextStatus =
            MasterStatusPenerimaanBarang::query()
                ->where(
                    'kd_status_penerimaan_barang',
                    'PENDING_DIREKTUR'
                )
                ->firstOrFail();


        DB::transaction(
            function () use (
                $penerimaan,
                $nextStatus,
                $validated
            ) {

                $userId =
                    auth()->id()
                    ?? 1;

                // Simpan dulu perubahan header + detail (kalau ada dikirim),
                // baru validasi konsistensi qty pakai nilai yang paling baru.
                $penerimaan->update([
                    'no_sjinv_supplier' => $validated['no_sjinv_supplier'] ?? $penerimaan->no_sjinv_supplier,
                    'tgl_penerimaan_barang' => $validated['tgl_penerimaan_barang'] ?? $penerimaan->tgl_penerimaan_barang,
                    'desc_penerimaan_barang' => $validated['desc_penerimaan_barang'] ?? $penerimaan->desc_penerimaan_barang,
                ]);

                $this->applyDetailInputs(
                    $penerimaan,
                    $validated['details'] ?? [],
                    $userId
                );

                foreach (
                    $penerimaan->details()->get()
                    as $detail
                ) {

                    $qtyRequest =
                        (int) $detail
                            ->qty_request;

                    $qtyBaik =
                        (int) $detail
                            ->qty_baik;

                    $qtyRusak =
                        (int) $detail
                            ->qty_rusak;


                    if (
                        $qtyBaik < 0
                        ||
                        $qtyRusak < 0
                    ) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'submit' =>
                                'Qty baik dan qty rusak tidak boleh bernilai negatif.',
                        ]);
                    }


                    if (
                        ($qtyBaik + $qtyRusak)
                        > $qtyRequest
                    ) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'submit' =>
                                'Total qty baik + qty rusak tidak boleh melebihi qty request.',
                        ]);
                    }
                }

                $penerimaan->update([
                    'fk_status_penerimaan_barang' =>
                        $nextStatus
                            ->id_status_penerimaan_barang,

                    'submit_by' =>
                        $userId,

                    'submit_at' =>
                        now(),

                    'updated_by' =>
                        $userId,
                ]);
            }
        );


        return redirect()
            ->route(
                'penerimaan.index'
            )
            ->with(
                'success',
                'Penerimaan berhasil disubmit dan menunggu verifikasi Kasubag.'
            );
    }


    private function filteredQuery(
        Request $request
    ) {

        $query =
            PenerimaanBarang::query()
                ->with([
                    'statusPenerimaan',
                    'po.supplier',
                    'details.barang.satuan',
                    'details.lokasi.row.rak.gudang',
                    'submittedBy',
                ]);


        if (
            $request->filled('search')
        ) {

            $search =
                trim(
                    $request
                        ->string('search')
                        ->toString()
                );

            $query->where(
                function ($q) use (
                    $search
                ) {

                    $q->where(
                        'kd_penerimaan',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'no_sjinv_supplier',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'desc_penerimaan_barang',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'po',
                            function ($poQuery) use (
                                $search
                            ) {

                                $poQuery
                                    ->where(
                                        'kd_po',
                                        'like',
                                        "%{$search}%"
                                    )

                                    ->orWhereHas(
                                        'supplier',
                                        function (
                                            $supplierQuery
                                        ) use (
                                            $search
                                        ) {

                                            $supplierQuery
                                                ->where(
                                                    'nm_master_supplier',
                                                    'like',
                                                    "%{$search}%"
                                                );
                                        }
                                    );
                            }
                        );
                }
            );
        }


        $status =
            $request
                ->string('status')
                ->toString();

        if (
            $status === 'menunggu'
        ) {

            $query->whereHas(
                'statusPenerimaan',
                fn ($q) =>
                    $q->whereIn(
                        'kd_status_penerimaan_barang',
                        [
                            'PENDING_KASUBAG',
                            'PENDING_KABAG',
                            'PENDING_DIREKTUR',
                        ]
                    )
            );

        } elseif (
            $status === 'alokasi'
        ) {

            $query
                ->whereHas(
                    'details',
                    fn ($q) =>
                        $q->whereNotNull(
                            'fk_lokasi_barang'
                        )
                )
                ->whereHas(
                    'statusPenerimaan',
                    fn ($q) =>
                        $q->whereNotIn(
                            'kd_status_penerimaan_barang',
                            [
                                'DRAFT',
                                'APPROVED',
                                'REJECTED',
                            ]
                        )
                );

        } elseif (
            $status !== ''
        ) {

            $query->whereHas(
                'statusPenerimaan',
                fn ($q) =>
                    $q->where(
                        'kd_status_penerimaan_barang',
                        $status
                    )
            );
        }

        if (
            $request->filled('date_from')
        ) {

            $query->whereDate(
                'tgl_penerimaan_barang',
                '>=',
                $request
                    ->string('date_from')
                    ->toString()
            );
        }


        if (
            $request->filled('date_to')
        ) {

            $query->whereDate(
                'tgl_penerimaan_barang',
                '<=',
                $request
                    ->string('date_to')
                    ->toString()
            );
        }

        if (
            $request->filled('gudang')
        ) {

            $query->whereHas(
                'details.lokasi.row.rak',
                fn ($q) =>
                    $q->where(
                        'fk_gudang',
                        $request->integer(
                            'gudang'
                        )
                    )
            );
        }

        return $query;
    }


    private function validateDateRange(
        Request $request
    ): void {

        if (
            $request->filled('date_from')
            &&
            $request->filled('date_to')
        ) {

            $from =
                $request->date(
                    'date_from'
                );

            $to =
                $request->date(
                    'date_to'
                );

            if (
                $from
                &&
                $to
                &&
                $from->gt($to)
            ) {

                abort(
                    422,
                    'Tanggal awal tidak boleh lebih besar dari tanggal akhir.'
                );
            }
        }
    }

    private function generateKodePenerimaan(): string
    {
        $year =
            now()->format('Y');

        $prefix =
            'GRN-' .
            $year .
            '-';

        $numbers =
            PenerimaanBarang::withTrashed()
                ->where(
                    'kd_penerimaan',
                    'like',
                    $prefix . '%'
                )
                ->pluck(
                    'kd_penerimaan'
                );

        $maxNumber = 0;

        foreach (
            $numbers as $kode
        ) {

            if (
                preg_match(
                    '/^' .
                    preg_quote(
                        $prefix,
                        '/'
                    ) .
                    '(\d+)$/',
                    $kode,
                    $matches
                )
            ) {

                $maxNumber =
                    max(
                        $maxNumber,
                        (int) $matches[1]
                    );
            }
        }

        return $prefix .
            str_pad(
                (string) (
                    $maxNumber + 1
                ),
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    private function countByStatus(
        string $kode
    ): int {

        return PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) =>
                    $q->where(
                        'kd_status_penerimaan_barang',
                        $kode
                    )
            )
            ->count();
    }
}