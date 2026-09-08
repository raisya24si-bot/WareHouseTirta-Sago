<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
use App\Models\MasterStatusPenerimaanBarang;
use App\Models\Po;
use App\Models\PenerimaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        $tabCounts = [
            'all' => PenerimaanBarang::count(),
            'draft' => $this->countByStatus('DRAFT'),
            'menunggu' => PenerimaanBarang::whereHas(
                'statusPenerimaan',
                fn ($q) => $q->whereIn('kd_status_penerimaan_barang', [
                    'PENDING_KASUBAG',
                    'PENDING_KABAG',
                    'PENDING_DIREKTUR',
                ])
            )->count(),
            'alokasi' => PenerimaanBarang::whereHas(
                'details',
                fn ($q) => $q->whereNotNull('fk_lokasi_barang')
            )
                ->whereHas(
                    'statusPenerimaan',
                    fn ($q) => $q->whereNotIn('kd_status_penerimaan_barang', [
                        'DRAFT',
                        'APPROVED',
                        'REJECTED',
                    ])
                )
                ->count(),
            'selesai' => $this->countByStatus('APPROVED'),
            'rejected' => $this->countByStatus('REJECTED'),
        ];

        $qtyTotals = DB::table('tbl_penerimaan_barang_detail')
            ->whereNull('deleted_at')
            ->selectRaw('SUM(qty_baik) as total_baik, SUM(qty_rusak) as total_rusak')
            ->first();

        $totalBaik = (int) ($qtyTotals->total_baik ?? 0);
        $totalRusak = (int) ($qtyTotals->total_rusak ?? 0);
        $totalDiperiksa = $totalBaik + $totalRusak;

        $avgVerifikasiMinutes = (int) round(
            DB::table('tbl_penerimaan_barang')
                ->whereNull('deleted_at')
                ->whereNotNull('submit_at')
                ->whereNotNull('approve_kasubag_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, submit_at, approve_kasubag_at)) as avg_minutes')
                ->value('avg_minutes') ?? 0
        );

        $summary = [
            'menunggu_verifikasi' => $tabCounts['menunggu'],
            'dalam_alokasi' => $tabCounts['alokasi'],
            'selesai' => $tabCounts['selesai'],
            'total_barang' => (int) PenerimaanBarang::query()
                ->with('details:id_penerimaan_barang_detail,fk_penerimaan_barang,qty_request')
                ->get()
                ->sum(fn ($penerimaan) => $penerimaan->details->sum('qty_request')),
            'item_sesuai' => $totalBaik,
            'item_discrepancy' => $totalRusak,
            'accuracy_percentage' => $totalDiperiksa > 0
                ? round(($totalBaik / $totalDiperiksa) * 100, 1)
                : 0.0,
            'discrepancy_percentage' => $totalDiperiksa > 0
                ? round(($totalRusak / $totalDiperiksa) * 100, 1)
                : 0.0,
            'avg_verifikasi_minutes' => $avgVerifikasiMinutes,
        ];

        $statusOptions = [
            ['value' => 'menunggu', 'label' => 'Menunggu Verifikasi'],
            ['value' => 'alokasi', 'label' => 'Dalam Alokasi'],
            ['value' => 'APPROVED', 'label' => 'Disetujui / Selesai'],
            ['value' => 'DRAFT', 'label' => 'Draft'],
            ['value' => 'REJECTED', 'label' => 'Ditolak'],
        ];

        $gudangs = MasterGudang::query()
            ->orderBy('nm_gudang')
            ->get(['id_gudang', 'kd_gudang', 'nm_gudang']);

        $poTerbuka = Po::query()
            ->with([
                'supplier',
                'details.barang.satuan',
                'statusPo',
            ])
            ->whereHas('statusPo', fn ($q) => $q->where('kd_status_po', 'APPROVED'))
            ->get()
            ->filter(fn (Po $po) => $po->canBeReceived())
            ->values();

        return view('penerimaan.index', compact(
            'penerimaans',
            'perPage',
            'statusOptions',
            'tabCounts',
            'summary',
            'poTerbuka',
            'gudangs'
        ));
    }

    public function export(Request $request)
    {
        $this->validateDateRange($request);

        $rows = $this->filteredQuery($request)
            ->latest('id_penerimaan')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Penerimaan Barang');

        $headers = [
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
        ];

        $sheet->fromArray($headers, null, 'A1');

        $rowNumber = 2;

        foreach ($rows as $penerimaan) {
            $details = $penerimaan->details;

            $units = $details
                ->map(fn ($detail) => $detail->barang?->satuan?->nm_master_satuan)
                ->filter()
                ->unique()
                ->values();

            $gudangNames = $details
                ->map(fn ($detail) => $detail->lokasi?->row?->rak?->gudang?->nm_gudang)
                ->filter()
                ->unique()
                ->values();

            $sheet->fromArray([
                $penerimaan->kd_penerimaan,
                $penerimaan->tgl_penerimaan_barang?->format('d/m/Y') ?? '-',
                $penerimaan->po?->kd_po ?? '-',
                $penerimaan->no_sjinv_supplier ?: '-',
                $penerimaan->po?->supplier?->nm_master_supplier ?? '-',
                $details->count(),
                (int) $details->sum('qty_request'),
                $units->count() === 1
                    ? $units->first()
                    : ($units->isEmpty() ? 'Unit' : 'Beragam Satuan'),
                $gudangNames->count() === 1
                    ? $gudangNames->first()
                    : ($gudangNames->isEmpty() ? '-' : 'Beragam Gudang'),
                $penerimaan->statusPenerimaan?->nm_status_penerimaan_barang
                    ?? $penerimaan->kode_status
                    ?? '-',
            ], null, 'A' . $rowNumber);

            $rowNumber++;
        }

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:J' . max($rowNumber - 1, 1));

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = 'penerimaan-barang-' . now()->format('Ymd-His') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function laporanAkurasiPdf(Request $request)
    {
        $this->validateDateRange($request);

        $qtyTotals = DB::table('tbl_penerimaan_barang_detail')
            ->whereNull('deleted_at')
            ->selectRaw('SUM(qty_baik) as total_baik, SUM(qty_rusak) as total_rusak')
            ->first();

        $totalBaik = (int) ($qtyTotals->total_baik ?? 0);
        $totalRusak = (int) ($qtyTotals->total_rusak ?? 0);
        $totalDiperiksa = $totalBaik + $totalRusak;

        $avgVerifikasiMinutes = (int) round(
            DB::table('tbl_penerimaan_barang')
                ->whereNull('deleted_at')
                ->whereNotNull('submit_at')
                ->whereNotNull('approve_kasubag_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, submit_at, approve_kasubag_at)) as avg_minutes')
                ->value('avg_minutes') ?? 0
        );

        $summary = [
            'item_sesuai' => $totalBaik,
            'item_discrepancy' => $totalRusak,
            'accuracy_percentage' => $totalDiperiksa > 0
                ? round(($totalBaik / $totalDiperiksa) * 100, 1)
                : 0.0,
            'discrepancy_percentage' => $totalDiperiksa > 0
                ? round(($totalRusak / $totalDiperiksa) * 100, 1)
                : 0.0,
            'avg_verifikasi_minutes' => $avgVerifikasiMinutes,
        ];

        $rows = $this->filteredQuery($request)->latest('id_penerimaan')->get();

        $supplierBreakdown = $rows
            ->groupBy(fn ($penerimaan) => $penerimaan->po?->supplier?->nm_master_supplier ?? 'Tanpa Supplier')
            ->map(function ($group) {
                $details = $group->flatMap->details;

                $baik = (int) $details->sum('qty_baik');
                $rusak = (int) $details->sum('qty_rusak');
                $diperiksa = $baik + $rusak;

                return [
                    'jumlah_dokumen' => $group->count(),
                    'qty_baik' => $baik,
                    'qty_rusak' => $rusak,
                    'akurasi' => $diperiksa > 0 ? round(($baik / $diperiksa) * 100, 1) : 0.0,
                ];
            })
            ->sortByDesc('qty_baik');

        $pdf = Pdf::loadView('penerimaan.pdf.akurasi', [
            'summary' => $summary,
            'rows' => $rows,
            'supplierBreakdown' => $supplierBreakdown,
            'generatedAt' => now(),
            'filters' => $request->only(['search', 'status', 'date_from', 'date_to', 'gudang']),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-akurasi-penerimaan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_po' => ['required', 'integer', 'exists:tbl_po,id_po'],
            'no_sjinv_supplier' => ['nullable', 'string', 'max:50'],
            'tgl_penerimaan_barang' => ['required', 'date'],
            'desc_penerimaan_barang' => ['nullable', 'string', 'max:100'],
        ]);

        $po = Po::query()
            ->with(['statusPo', 'details'])
            ->findOrFail($validated['fk_po']);

        if (! $po->canBeReceived()) {
            return back()
                ->withErrors([
                    'fk_po' => 'Purchase Order tersebut belum dapat digunakan untuk penerimaan barang.',
                ])
                ->withInput();
        }

        $statusDraft = MasterStatusPenerimaanBarang::query()
            ->where('kd_status_penerimaan_barang', 'DRAFT')
            ->firstOrFail();

        $penerimaan = DB::transaction(function () use ($validated, $po, $statusDraft) {
            $userId = auth()->id() ?? 1;

            $penerimaan = PenerimaanBarang::create([
                'kd_penerimaan' => $this->generateKodePenerimaan(),
                'tgl_penerimaan_barang' => $validated['tgl_penerimaan_barang'],
                'fk_po' => $po->id_po,
                'no_sjinv_supplier' => $validated['no_sjinv_supplier'] ?? null,
                'desc_penerimaan_barang' => $validated['desc_penerimaan_barang'] ?? null,
                'fk_status_penerimaan_barang' => $statusDraft->id_status_penerimaan_barang,
                'created_by' => $userId,
            ]);

            foreach ($po->details as $poDetail) {
                $penerimaan->details()->create([
                    'fk_barang' => $poDetail->fk_barang,
                    'qty_request' => $poDetail->qty_request,
                    'qty_baik' => 0,
                    'qty_rusak' => 0,
                    'created_by' => $userId,
                ]);
            }

            return $penerimaan;
        });

        return redirect()
            ->route('penerimaan.verifikasi', $penerimaan)
            ->with('success', 'Penerimaan barang berhasil dibuat sebagai draft.');
    }

    public function verifikasi(PenerimaanBarang $penerimaan)
    {
        $penerimaan->load([
            'statusPenerimaan',
            'po.supplier',
            'po.details.barang',
            'details.barang',
            'details.lokasi',
            'buktiDukungs',
        ]);

        return view('penerimaan.verifikasi', compact('penerimaan'));
    }

    public function saveDraft(Request $request, PenerimaanBarang $penerimaan)
    {
        if (! $penerimaan->canBeEdited()) {
            return back()->withErrors([
                'penerimaan' => 'Penerimaan ini tidak dapat diubah karena statusnya sudah diproses.',
            ]);
        }

        $validated = $request->validate([
            'no_sjinv_supplier' => ['nullable', 'string', 'max:50'],
            'tgl_penerimaan_barang' => ['required', 'date'],
            'desc_penerimaan_barang' => ['nullable', 'string', 'max:100'],
        ]);

        $penerimaan->update([
            'no_sjinv_supplier' => $validated['no_sjinv_supplier'] ?? null,
            'tgl_penerimaan_barang' => $validated['tgl_penerimaan_barang'],
            'desc_penerimaan_barang' => $validated['desc_penerimaan_barang'] ?? null,
            'updated_by' => auth()->id() ?? 1,
        ]);

        return back()->with('success', 'Draft penerimaan berhasil disimpan.');
    }

    public function submit(Request $request, PenerimaanBarang $penerimaan)
    {
        $penerimaan->load(['statusPenerimaan', 'details']);

        if (! $penerimaan->canBeEdited()) {
            return back()->withErrors([
                'submit' => 'Penerimaan ini sudah diproses dan tidak dapat disubmit kembali.',
            ]);
        }

        if ($penerimaan->details->isEmpty()) {
            return back()->withErrors([
                'submit' => 'Detail barang penerimaan belum tersedia.',
            ]);
        }

        foreach ($penerimaan->details as $detail) {
            $qtyRequest = (int) $detail->qty_request;
            $qtyBaik = (int) $detail->qty_baik;
            $qtyRusak = (int) $detail->qty_rusak;

            if (($qtyBaik + $qtyRusak) > $qtyRequest) {
                return back()->withErrors([
                    'submit' => 'Total qty baik + qty rusak tidak boleh melebihi qty request.',
                ]);
            }
        }

        $nextStatus = MasterStatusPenerimaanBarang::query()
            ->where('kd_status_penerimaan_barang', 'PENDING_KASUBAG')
            ->firstOrFail();

        $penerimaan->update([
            'fk_status_penerimaan_barang' => $nextStatus->id_status_penerimaan_barang,
            'submit_by' => auth()->id() ?? 1,
            'submit_at' => now(),
            'updated_by' => auth()->id() ?? 1,
        ]);

        return redirect()
            ->route('penerimaan.index')
            ->with('success', 'Penerimaan berhasil disubmit dan menunggu verifikasi Kasubag.');
    }

    private function filteredQuery(Request $request)
    {
        $query = PenerimaanBarang::query()->with([
            'statusPenerimaan',
            'po.supplier',
            'details.barang.satuan',
            'details.lokasi.row.rak.gudang',
            'submittedBy',
        ]);

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());

            $query->where(function ($q) use ($search) {
                $q->where('kd_penerimaan', 'like', "%{$search}%")
                    ->orWhere('no_sjinv_supplier', 'like', "%{$search}%")
                    ->orWhere('desc_penerimaan_barang', 'like', "%{$search}%")
                    ->orWhereHas('po', function ($poQuery) use ($search) {
                        $poQuery->where('kd_po', 'like', "%{$search}%")
                            ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                                $supplierQuery->where('nm_master_supplier', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $status = $request->string('status')->toString();

        if ($status === 'menunggu') {
            $query->whereHas('statusPenerimaan', fn ($q) => $q->whereIn(
                'kd_status_penerimaan_barang',
                ['PENDING_KASUBAG', 'PENDING_KABAG', 'PENDING_DIREKTUR']
            ));
        } elseif ($status === 'alokasi') {
            $query->whereHas('details', fn ($q) => $q->whereNotNull('fk_lokasi_barang'))
                ->whereHas('statusPenerimaan', fn ($q) => $q->whereNotIn(
                    'kd_status_penerimaan_barang',
                    ['DRAFT', 'APPROVED', 'REJECTED']
                ));
        } elseif ($status !== '') {
            $query->whereHas('statusPenerimaan', fn ($q) => $q->where(
                'kd_status_penerimaan_barang',
                $status
            ));
        }

        if ($request->filled('date_from')) {
            $query->whereDate(
                'tgl_penerimaan_barang',
                '>=',
                $request->string('date_from')->toString()
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'tgl_penerimaan_barang',
                '<=',
                $request->string('date_to')->toString()
            );
        }

        if ($request->filled('gudang')) {
            $query->whereHas(
                'details.lokasi.row.rak',
                fn ($q) => $q->where('fk_gudang', $request->integer('gudang'))
            );
        }

        return $query;
    }

    private function validateDateRange(Request $request): void
    {
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $from = $request->date('date_from');
            $to = $request->date('date_to');

            if ($from && $to && $from->gt($to)) {
                abort(422, 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            }
        }
    }

    private function generateKodePenerimaan(): string
    {
        $year = now()->format('Y');
        $prefix = 'GRN-' . $year . '-';

        $numbers = PenerimaanBarang::withTrashed()
            ->where('kd_penerimaan', 'like', $prefix . '%')
            ->pluck('kd_penerimaan');

        $maxNumber = 0;

        foreach ($numbers as $kode) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $kode, $matches)) {
                $maxNumber = max($maxNumber, (int) $matches[1]);
            }
        }

        return $prefix . str_pad((string) ($maxNumber + 1), 4, '0', STR_PAD_LEFT);
    }

    private function countByStatus(string $kode): int
    {
        return PenerimaanBarang::query()
            ->whereHas('statusPenerimaan', fn ($q) => $q->where(
                'kd_status_penerimaan_barang',
                $kode
            ))
            ->count();
    }
}