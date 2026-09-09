<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
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
            return back()
                ->withErrors([
                    'bukti_dukung' =>
                        'Penerimaan ini sudah diproses dan bukti pendukung tidak dapat diubah.',
                ]);
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

        foreach ($validated['bukti_dukung'] as $file) {

            $originalName = $file->getClientOriginalName();

            $path = $file->store(
                'penerimaan-bukti',
                'public'
            );

            PenerimaanBarangBuktiDukung::create([
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
        }

        $penerimaan->update([
            'updated_by' => $userId,
        ]);

        return back()->with(
            'success',
            'Bukti pendukung berhasil diupload.'
        );
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

            'buktiDukungs',
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


    public function saveDraft(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {


        if (! $penerimaan->canBeEdited()) {
            return back()
                ->withErrors([
                    'penerimaan' =>
                        'Penerimaan ini tidak dapat diubah karena statusnya sudah diproses.',
                ]);
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
        ]);


        $details =
            $penerimaan
                ->details()
                ->get();


        DB::transaction(
            function () use (
                $penerimaan,
                $validated,
                $details
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


                foreach (
                    $details as $detail
                ) {


                    $input =
                        $validated[
                            'details'
                        ][
                            $detail
                                ->id_penerimaan_barang_detail
                        ]
                        ?? null;

                    if (! $input) {
                        continue;
                    }

                    $qtyRequest =
                        (int) $detail
                            ->qty_request;

                    $qtyBaik =
                        (int) (
                            $input['qty_baik']
                            ?? 0
                        );

                    $qtyRusak =
                        (int) (
                            $input['qty_rusak']
                            ?? 0
                        );

                    if (
                        ($qtyBaik + $qtyRusak)
                        > $qtyRequest
                    ) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            "details.{$detail->id_penerimaan_barang_detail}.qty_baik" =>
                                'Qty baik + qty rusak tidak boleh melebihi qty request.',
                        ]);
                    }


                    $detail->update([
                        'qty_baik' =>
                            $qtyBaik,

                        'qty_rusak' =>
                            $qtyRusak,

                        'fk_lokasi_barang' =>
                            $input[
                                'fk_lokasi_barang'
                            ]
                            ?? null,

                        'updated_by' =>
                            $userId,
                    ]);
                }
            }
        );

        return back()
            ->with(
                'success',
                'Verifikasi penerimaan berhasil disimpan sebagai draft.'
            );
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


        foreach (
            $penerimaan->details
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

                return back()
                    ->withErrors([
                        'submit' =>
                            'Qty baik dan qty rusak tidak boleh bernilai negatif.',
                    ]);
            }


            if (
                ($qtyBaik + $qtyRusak)
                > $qtyRequest
            ) {

                return back()
                    ->withErrors([
                        'submit' =>
                            'Total qty baik + qty rusak tidak boleh melebihi qty request.',
                    ]);
            }
        }


        $nextStatus =
            MasterStatusPenerimaanBarang::query()
                ->where(
                    'kd_status_penerimaan_barang',
                    'PENDING_KASUBAG'
                )
                ->firstOrFail();


        DB::transaction(
            function () use (
                $penerimaan,
                $nextStatus
            ) {

                $userId =
                    auth()->id()
                    ?? 1;

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