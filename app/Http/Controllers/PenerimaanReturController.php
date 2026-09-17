<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterStatusPenerimaanRetur;
use App\Models\MasterStatusRetur;
use App\Models\MasterSupplier;
use App\Models\PenerimaanRetur;
use App\Models\PenerimaanReturDetail;
use App\Models\PenerimaanReturDetailSerial;
use App\Models\ReturBarang;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanReturController extends Controller
{
    use HasPerPage;

    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);

        $penerimaans = $query
            ->latest('id_penerimaan_retur')
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        $tabCounts = [
            'all' => PenerimaanRetur::count(),
            'proses' => $this->countByStatusGroup(MasterStatusPenerimaanRetur::GROUP_DALAM_PROSES),
            'selesai' => $this->countByStatusGroup(MasterStatusPenerimaanRetur::GROUP_SELESAI),
        ];

        $summary = [
            'menunggu_kedatangan' => $this->countByStatus('MENUNGGU_KEDATANGAN'),
            'unit_dalam_perjalanan' => (int) ReturBarang::whereHas(
                'statusRetur',
                fn ($q) => $q->whereIn('kd_status_retur', MasterStatusRetur::GROUP_DALAM_PROSES)
            )->get()->sum(fn ($retur) => $retur->totalItemReject() - $this->totalSudahTerima($retur)),

            'proses_qc' => $this->countByStatus('PROSES_QC'),

            'selesai_bulan_ini' => PenerimaanRetur::whereHas(
                'statusPenerimaanRetur',
                fn ($q) => $q->where('kd_status_penerimaan_retur', 'SELESAI')
            )->whereMonth('selesai_at', now()->month)->whereYear('selesai_at', now()->year)->count(),

            'unit_kembali_stok_bulan_ini' => (int) PenerimaanReturDetail::whereHas(
                'penerimaanRetur',
                fn ($q) => $q->whereMonth('selesai_at', now()->month)->whereYear('selesai_at', now()->year)
            )->sum('qty_tiba'),
        ];

        $suppliers = MasterSupplier::query()
            ->where('status_master_supplier', 'AKTIF')
            ->orderBy('nm_master_supplier')
            ->get();

        // BAP Retur yang siap ditarik barang penggantinya: statusnya lagi
        // "Dalam Proses" (MENUNGGU_RESPON_VENDOR atau PROSES_KIRIM_GANTI)
        // dan masih ada sisa qty yang belum diterima. Nggak perlu nunggu
        // konfirmasi manual dulu -- begitu retur diterbitkan, sudah bisa
        // langsung ditarik ke sini.
        $returEligible = ReturBarang::query()
            ->whereHas('statusRetur', fn ($q) => $q->whereIn('kd_status_retur', MasterStatusRetur::GROUP_DALAM_PROSES))
            ->with(['penerimaanBarang.po.supplier', 'details.barang'])
            ->get()
            ->filter(fn ($retur) => $this->totalSudahTerima($retur) < $retur->totalItemReject())
            ->values();

        $bins = StrukturLokasi::query()
            ->where('status_lokasi', 'AKTIF')
            ->with('row.rak.gudang')
            ->get();

        return view('penerimaan-retur.index', [
            'penerimaans' => $penerimaans,
            'tabCounts' => $tabCounts,
            'summary' => $summary,
            'suppliers' => $suppliers,
            'returEligible' => $returEligible,
            'bins' => $bins,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX: ITEM KLAIM RETUR (buat isi step 2 modal secara dinamis)
    |--------------------------------------------------------------------------
    */

    public function itemsForRetur(ReturBarang $retur)
    {
        $items = $retur->details()
            ->with('barang')
            ->get()
            ->map(function ($detail) {

                $sudahTiba = (int) PenerimaanReturDetail::where('fk_retur_detail', $detail->id_retur_detail)->sum('qty_tiba');
                $sisa = (int) $detail->qty_diretur - $sudahTiba;

                return [
                    'fk_retur_detail' => $detail->id_retur_detail,
                    'fk_barang' => $detail->fk_barang,
                    'nama_barang' => $detail->barang?->nm_master_barang,
                    'qty_diklaim' => (int) $detail->qty_diretur,
                    'qty_sisa_klaim' => max($sisa, 0),
                ];
            })
            ->filter(fn ($item) => $item['qty_sisa_klaim'] > 0)
            ->values();

        return response()->json([
            'items' => $items,
            'supplier' => $retur->supplier?->nm_master_supplier,
            'kontak' => $retur->supplier?->kontak_supplier,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_retur' => ['required', 'exists:tbl_retur_barang,id_retur'],
            'no_sj_supplier' => ['required', 'string', 'max:50'],
            'waktu_tiba_dock' => ['nullable', 'date'],
            'dock_number' => ['nullable', 'string', 'max:50'],
            'catatan_verifikasi' => ['nullable', 'string'],
            'is_consent_verifikasi' => ['required', 'accepted'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.fk_retur_detail' => ['required', 'exists:tbl_retur_barang_detail,id_retur_detail'],
            'items.*.qty_tiba' => ['required', 'integer', 'min:1'],
            'items.*.fk_bin_tujuan' => ['required', 'exists:tbl_master_lokasi,id_lokasi'],
            'items.*.serials' => ['required', 'array', 'min:1'],
            'items.*.serials.*' => ['required', 'string', 'max:100', 'distinct'],
        ], [
            'is_consent_verifikasi.accepted' => 'Pernyataan berita acara wajib dicentang.',
            'items.*.serials.required' => 'Isi nomor seri untuk tiap unit yang datang.',
            'items.*.serials.*.distinct' => 'Ada nomor seri yang double di item yang sama.',
        ]);

        // Validasi tambahan: jumlah serial number harus PAS sama dengan qty_tiba
        foreach ($validated['items'] as $index => $item) {
            if (count($item['serials']) !== (int) $item['qty_tiba']) {
                return back()->withErrors([
                    "items.{$index}.serials" => 'Jumlah nomor seri harus sama dengan Qty Tiba.',
                ])->withInput();
            }
        }

        $userId = auth()->id() ?? 1;
        $isDraft = $request->input('mode') === 'draft';

        $penerimaan = DB::transaction(function () use ($validated, $userId, $isDraft) {

            $statusAwal = MasterStatusPenerimaanRetur::where(
                'kd_status_penerimaan_retur',
                $isDraft ? 'MENUNGGU_KEDATANGAN' : 'PROSES_QC'
            )->firstOrFail();

            $retur = ReturBarang::findOrFail($validated['fk_retur']);

            $this->tandaiSedangDiproses($retur, $userId);

            $penerimaan = PenerimaanRetur::create([
                'kd_penerimaan_retur' => $this->generateKodePenerimaanRetur(),
                'fk_retur' => $retur->id_retur,
                'no_sj_supplier' => $validated['no_sj_supplier'],
                'fk_status_penerimaan_retur' => $statusAwal->id_status_penerimaan_retur,
                'waktu_tiba_dock' => $validated['waktu_tiba_dock'] ?? now(),
                'dock_number' => $validated['dock_number'] ?? null,
                'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
                'is_consent_verifikasi' => (bool) ($validated['is_consent_verifikasi'] ?? false),
                'submit_by' => $userId,
                'submit_at' => now(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);

            foreach ($validated['items'] as $item) {

                $returDetail = \App\Models\ReturBarangDetail::findOrFail($item['fk_retur_detail']);

                $detail = PenerimaanReturDetail::create([
                    'fk_penerimaan_retur' => $penerimaan->id_penerimaan_retur,
                    'fk_retur_detail' => $returDetail->id_retur_detail,
                    'fk_barang' => $returDetail->fk_barang,
                    'qty_diklaim' => $returDetail->qty_diretur,
                    'qty_tiba' => $item['qty_tiba'],
                    'fk_bin_tujuan' => $item['fk_bin_tujuan'],
                    'is_masuk_stok' => false,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);

                foreach ($item['serials'] as $noSeri) {
                    PenerimaanReturDetailSerial::create([
                        'fk_penerimaan_retur_detail' => $detail->id_penerimaan_retur_detail,
                        'no_seri' => $noSeri,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]);
                }

                // Draf belum push stok -- baru dieksekusi begitu QC final disubmit.
                if (! $isDraft) {
                    $this->tambahStok($detail->fk_barang, $detail->fk_bin_tujuan, $detail->qty_tiba, $userId);
                    $detail->update(['is_masuk_stok' => true]);
                }
            }

            if (! $isDraft) {
                $this->tutupReturJikaSudahLunas($retur, $userId);
            }

            return $penerimaan;
        });

        return redirect()
            ->route('penerimaan-retur.show', $penerimaan)
            ->with('success', $isDraft
                ? 'Draf penerimaan '.$penerimaan->kd_penerimaan_retur.' berhasil disimpan.'
                : 'Penerimaan '.$penerimaan->kd_penerimaan_retur.' berhasil diverifikasi dan masuk ke bin stok aktif.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(PenerimaanRetur $penerimaanRetur)
    {
        $penerimaanRetur->load([
            'statusPenerimaanRetur',
            'returBarang.penerimaanBarang.po.supplier',
            'details.barang',
            'details.binTujuan.row.rak.gudang',
            'details.serials',
            'submittedBy',
        ]);

        return view('penerimaan-retur.show', ['penerimaan' => $penerimaanRetur]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function filteredQuery(Request $request)
    {
        $query = PenerimaanRetur::query()
            ->with([
                'statusPenerimaanRetur',
                'returBarang.penerimaanBarang.po.supplier',
                'details',
            ]);

        if ($request->filled('search')) {

            $search = trim($request->string('search')->toString());

            $query->where(function ($q) use ($search) {

                $q->where('kd_penerimaan_retur', 'like', "%{$search}%")
                    ->orWhere('no_sj_supplier', 'like', "%{$search}%")
                    ->orWhereHas('returBarang', fn ($rq) => $rq
                        ->where('kd_retur', 'like', "%{$search}%")
                        ->orWhereHas('penerimaanBarang', fn ($gq) => $gq->where('kd_penerimaan', 'like', "%{$search}%"))
                        ->orWhereHas('penerimaanBarang.po.supplier', fn ($sq) => $sq->where('nm_master_supplier', 'like', "%{$search}%")));
            });
        }

        $status = $request->string('status')->toString();

        if ($status === 'proses') {
            $query->whereHas('statusPenerimaanRetur', fn ($q) => $q->whereIn(
                'kd_status_penerimaan_retur',
                MasterStatusPenerimaanRetur::GROUP_DALAM_PROSES
            ));
        } elseif ($status === 'selesai') {
            $query->whereHas('statusPenerimaanRetur', fn ($q) => $q->whereIn(
                'kd_status_penerimaan_retur',
                MasterStatusPenerimaanRetur::GROUP_SELESAI
            ));
        }

        if ($request->filled('supplier')) {
            $query->whereHas(
                'returBarang.penerimaanBarang.po',
                fn ($q) => $q->where('fk_supplier', $request->integer('supplier'))
            );
        }

        if ($request->filled('month')) {
            $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$request->string('month')->toString()]);
        }

        return $query;
    }

    private function generateKodePenerimaanRetur(): string
    {
        $year = now()->format('Y');
        $prefix = 'RCV-RET-'.$year.'-';

        $numbers = PenerimaanRetur::withTrashed()
            ->where('kd_penerimaan_retur', 'like', $prefix.'%')
            ->pluck('kd_penerimaan_retur');

        $maxNumber = 0;

        foreach ($numbers as $kode) {
            if (preg_match('/^'.preg_quote($prefix, '/').'(\d+)$/', $kode, $matches)) {
                $maxNumber = max($maxNumber, (int) $matches[1]);
            }
        }

        return $prefix.str_pad((string) ($maxNumber + 1), 3, '0', STR_PAD_LEFT);
    }

    private function countByStatus(string $kode): int
    {
        return PenerimaanRetur::whereHas(
            'statusPenerimaanRetur',
            fn ($q) => $q->where('kd_status_penerimaan_retur', $kode)
        )->count();
    }

    private function countByStatusGroup(array $kodes): int
    {
        return PenerimaanRetur::whereHas(
            'statusPenerimaanRetur',
            fn ($q) => $q->whereIn('kd_status_penerimaan_retur', $kodes)
        )->count();
    }

    // Total qty yang udah pernah diterima (lewat penerimaan retur manapun)
    // buat semua item di satu dokumen retur.
    private function totalSudahTerima(ReturBarang $retur): int
    {
        return (int) PenerimaanReturDetail::whereIn(
            'fk_retur_detail',
            $retur->details->pluck('id_retur_detail')
        )->sum('qty_tiba');
    }

    // Begitu ada dokumen penerimaan retur pertama yang dibuat buat retur
    // ini (draf ataupun final), retur otomatis naik jadi PROSES_KIRIM_GANTI
    // -- ini yang jadi penanda "vendor udah kirim / lagi diproses" buat
    // monitoring, tanpa perlu langkah konfirmasi manual terpisah.
    private function tandaiSedangDiproses(ReturBarang $retur, int $userId): void
    {
        if ($retur->kode_status !== 'MENUNGGU_RESPON_VENDOR') {
            return;
        }

        $statusProses = MasterStatusRetur::where('kd_status_retur', 'PROSES_KIRIM_GANTI')->first();

        if (! $statusProses) {
            return;
        }

        $retur->update([
            'fk_status_retur' => $statusProses->id_status_retur,
            'updated_by' => $userId,
        ]);
    }

    // Begitu qty yang sudah diterima >= qty yang diklaim di seluruh item
    // retur ini, retur otomatis ditutup jadi SELESAI.
    private function tutupReturJikaSudahLunas(ReturBarang $retur, int $userId): void
    {
        $retur->refresh();

        if ($this->totalSudahTerima($retur) < $retur->totalItemReject()) {
            return;
        }

        $statusSelesai = \App\Models\MasterStatusRetur::where('kd_status_retur', 'SELESAI')->first();

        if (! $statusSelesai) {
            return;
        }

        $retur->update([
            'fk_status_retur' => $statusSelesai->id_status_retur,
            'nilai_terselamatkan' => $retur->nilai_total_retur,
            'selesai_by' => $userId,
            'selesai_at' => now(),
            'updated_by' => $userId,
        ]);
    }

    /**
     * Upsert qty_stok pada bin tujuan + naikkan stok_saat_ini di Master
     * Barang, sama persis polanya seperti tambahStok() di
     * ApprovalPenerimaanController.
     */
    private function tambahStok(int $fkBarang, int $fkLokasi, int $qty, int $userId): void
    {
        $stok = StokLokasi::query()
            ->where('fk_barang', $fkBarang)
            ->where('fk_lokasi', $fkLokasi)
            ->first();

        if ($stok) {
            $stok->update([
                'qty_stok' => $stok->qty_stok + $qty,
                'updated_by' => $userId,
            ]);
        } else {
            StokLokasi::create([
                'fk_barang' => $fkBarang,
                'fk_lokasi' => $fkLokasi,
                'qty_stok' => $qty,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }

        $barang = \App\Models\MasterBarang::find($fkBarang);

        if ($barang) {
            $barang->stok_saat_ini = (int) $barang->stok_saat_ini + $qty;
            $barang->updated_by = $userId;
            $barang->save();
        }
    }
}