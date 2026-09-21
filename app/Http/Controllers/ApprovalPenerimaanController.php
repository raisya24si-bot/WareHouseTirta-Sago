<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterBarang;
use App\Models\MasterStatusPenerimaanBarang;
use App\Models\PenerimaanBarang;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalPenerimaanController extends Controller
{
    use HasPerPage;

    private function levelConfig(string $level): array
    {
        abort_unless(
            array_key_exists($level, PenerimaanBarang::LEVELS),
            404
        );

        return PenerimaanBarang::LEVELS[$level];
    }

    private function statusId(string $kode): int
    {
        return MasterStatusPenerimaanBarang::where(
            'kd_status_penerimaan_barang',
            $kode
        )->value('id_status_penerimaan_barang');
    }

    /**
     * Level terakhir dalam rantai approval -- di sinilah stok gudang
     * benar-benar didorong ke tbl_stok_lokasi.
     */
    private function isFinalLevel(string $level): bool
    {
        $config = $this->levelConfig($level);

        return $config['next_status'] === 'APPROVED';
    }

    private function rejectedLocation(): ?StrukturLokasi
    {
        return StrukturLokasi::query()
            ->where('status_lokasi', 'AKTIF')
            ->whereHas(
                'row.rak.gudang.kategoriGudang',
                fn ($q) => $q->whereRaw(
                    'UPPER(nm_kategori_gudang) = ?',
                    ['REJECTED']
                )
            )
            ->orderBy('id_lokasi')
            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX (ANTREAN PERSETUJUAN, per level, + tab riwayat)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, string $level)
    {
        $config = $this->levelConfig($level);

        $tab = $request->string('tab')->toString() ?: 'menunggu';

        $statusForTab = match ($tab) {
            'disetujui' => 'APPROVED',
            'ditolak' => 'REJECTED',
            default => $config['status'],
        };

        $query = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', $statusForTab)
            )
            ->when(
                $tab === 'ditolak',
                fn ($q) => $q->where('reject_level', strtoupper($level))
            )
            ->with([
                'po.supplier',
                'details.barang.satuan',
                'submittedBy',
                'kasubagBy',
                'kabagBy',
                'direkturBy',
                'rejectedBy',
            ])
            ->when(
                $tab === 'menunggu',
                fn ($q) => $q->orderBy('submit_at'),
                fn ($q) => $q->orderByDesc($config['at_field'])
            );

        if ($search = $request->string('search')->toString()) {

            $query->where(function ($q) use ($search) {

                $q->where('kd_penerimaan', 'like', "%{$search}%")
                    ->orWhereHas(
                        'po',
                        fn ($q2) => $q2->where('kd_po', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'po.supplier',
                        fn ($q2) => $q2->where('nm_master_supplier', 'like', "%{$search}%")
                    );
            });
        }

        $perPage = $this->perPageOption($request);

        $penerimaans = $query
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        $totalMenunggu = PenerimaanBarang::whereHas(
            'statusPenerimaan',
            fn ($q) => $q->where('kd_status_penerimaan_barang', $config['status'])
        )->count();

        $totalDisetujuiBulanIni = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', 'APPROVED')
            )
            ->whereMonth($config['at_field'], now()->month)
            ->whereYear($config['at_field'], now()->year)
            ->count();

        $totalDitolakBulanIni = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', 'REJECTED')
            )
            ->where('reject_level', strtoupper($level))
            ->whereMonth('reject_at', now()->month)
            ->whereYear('reject_at', now()->year)
            ->count();

        $nilaiMenunggu = 0;

        foreach ($penerimaans as $penerimaan) {
            foreach ($penerimaan->details as $detail) {
                $nilaiMenunggu += ((int) $detail->qty_baik) * ((float) ($detail->harga_satuan ?? 0));
            }
        }

        return view('approval.penerimaan.index', compact(
            'level',
            'config',
            'penerimaans',
            'perPage',
            'tab',
            'totalMenunggu',
            'totalDisetujuiBulanIni',
            'totalDitolakBulanIni',
            'nilaiMenunggu'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    |
    | Kasubag & Kabag cuma meneruskan ke level berikutnya. Stok gudang
    | baru benar-benar didorong ke tbl_stok_lokasi saat level TERAKHIR
    | (Direktur) menyetujui -- sama seperti perilaku lama, cuma sekarang
    | jadi tahap akhir dari rantai, bukan satu-satunya tahap.
    |
    */

    public function approve(Request $request, string $level, PenerimaanBarang $penerimaan)
    {
        $config = $this->levelConfig($level);

        $penerimaan->load(['statusPenerimaan', 'details']);

        if (! $penerimaan->isPendingAt($level)) {

            $message = 'Dokumen ini tidak lagi menunggu approval ' . $config['label'] . '.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['approve' => $message]);
        }

    
        if (
            config('app.enforce_approval_segregation')
            && $penerimaan->submit_by
            && $penerimaan->submit_by == (auth()->id() ?? 1)
        ) {

            $message = 'Anda adalah pengaju (petugas) penerimaan ini dan tidak berhak menyetujuinya sendiri.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 403);
            }

            return back()->withErrors(['approve' => $message]);
        }
     
        $validated = $request->validate([
            'details' => ['sometimes', 'array'],
            'details.*.fk_lokasi_barang' => [
                'nullable', 'integer', 'exists:tbl_master_lokasi,id_lokasi',
            ],
            'details.*.fk_lokasi_karantina' => [
                'nullable', 'integer', 'exists:tbl_master_lokasi,id_lokasi',
            ],
        ]);

        $approverUserId = auth()->id() ?? 1;

        if (! empty($validated['details'] ?? [])) {

            $this->applyLokasiInputs($penerimaan, $validated['details'], $approverUserId);

            $penerimaan->load('details');
        }


        $adaBarangRusak = false;

        foreach ($penerimaan->details as $detail) {

            if ((int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang) {

                $message = 'Masih ada item baik yang belum memiliki lokasi bin. Tidak dapat disetujui.';

                if ($request->wantsJson()) {
                    return response()->json(['message' => $message], 422);
                }

                return back()->withErrors(['approve' => $message]);
            }

            if ((int) $detail->qty_rusak > 0) {
                $adaBarangRusak = true;
            }
        }

        $rejectedLocation = $adaBarangRusak ? $this->rejectedLocation() : null;

        if ($adaBarangRusak && ! $rejectedLocation) {

            $message = 'Tidak dapat disetujui: ada barang rusak, tapi belum ada BIN aktif ' .
                'pada gudang kategori REJECTED. Buat gudang kategori REJECTED beserta BIN-nya terlebih dahulu.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['approve' => $message]);
        }

        $isFinal = $this->isFinalLevel($level);

        $nextStatus = $this->statusId($config['next_status']);

        DB::transaction(function () use ($penerimaan, $config, $nextStatus, $isFinal, $request, $rejectedLocation) {

            $userId = auth()->id() ?? 1;

            if ($isFinal) {

                foreach ($penerimaan->details as $detail) {

                    if ((int) $detail->qty_baik > 0 && $detail->fk_lokasi_barang) {

                        $this->tambahStok(
                            $detail->fk_barang,
                            $detail->fk_lokasi_barang,
                            (int) $detail->qty_baik,
                            $userId
                        );
                    }

                    if ((int) $detail->qty_rusak > 0 && $rejectedLocation) {

                        $this->tambahStokRusak(
                            $detail->fk_barang,
                            $rejectedLocation->id_lokasi,
                            (int) $detail->qty_rusak,
                            $penerimaan->kd_penerimaan,
                            $userId
                        );
                    }
                }
            }

            $penerimaan->update([
                $config['by_field'] => $userId,
                $config['at_field'] => now(),
                'fk_status_penerimaan_barang' => $nextStatus,
                'catatan_approval' => $request->input('catatan_approval'),
                'updated_by' => $userId,
            ]);
        });

        $message = $isFinal
            ? 'Penerimaan berhasil disetujui. Stok gudang telah diperbarui.'
            : 'Penerimaan disetujui di tingkat ' . $config['label'] . ', diteruskan ke tingkat berikutnya.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('penerimaan.approval.index', $level)
            ->with('success', $message);
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT (BALIK KE PETUGAS -> halaman Penerimaan Barang PO)
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, string $level, PenerimaanBarang $penerimaan)
    {
        $config = $this->levelConfig($level);

        $penerimaan->load(['statusPenerimaan']);

        if (! $penerimaan->isPendingAt($level)) {

            $message = 'Dokumen ini tidak lagi menunggu approval ' . $config['label'] . '.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['reject' => $message]);
        }

        // Sama seperti approve(): petugas pengaju tidak berhak menolak
        // (memutuskan) dokumennya sendiri. Dinonaktifkan dulu selama
        // tahap beta -- lihat catatan di approve() / config
        // app.enforce_approval_segregation.
        if (
            config('app.enforce_approval_segregation')
            && $penerimaan->submit_by
            && $penerimaan->submit_by == (auth()->id() ?? 1)
        ) {

            $message = 'Anda adalah pengaju (petugas) penerimaan ini dan tidak berhak memutuskan approvalnya sendiri.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 403);
            }

            return back()->withErrors(['reject' => $message]);
        }

        $validated = $request->validate([
            'catatan_approval' => ['required', 'string', 'max:1000'],
        ], [
            'catatan_approval.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $userId = auth()->id() ?? 1;

        $penerimaan->update([
            'fk_status_penerimaan_barang' => $this->statusId('REJECTED'),
            'reject_by' => $userId,
            'reject_at' => now(),
            'reject_level' => strtoupper($level),
            'reject_note' => $validated['catatan_approval'],
            'catatan_approval' => $validated['catatan_approval'],
            'updated_by' => $userId,
        ]);

        $message = 'Penerimaan ditolak di tingkat ' . $config['label'] . ' dan dikembalikan ke petugas untuk direvisi.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('penerimaan.approval.index', $level)
            ->with('success', $message);
    }


    private function applyLokasiInputs(PenerimaanBarang $penerimaan, array $detailsInput, int $userId): void
    {
        if (empty($detailsInput)) {
            return;
        }

        $details = $penerimaan->details()->get();

        foreach ($details as $detail) {

            $input = $detailsInput[$detail->id_penerimaan_barang_detail] ?? null;

            if (! $input) {
                continue;
            }

            $detail->update([
                'fk_lokasi_barang' => $input['fk_lokasi_barang'] ?? $detail->fk_lokasi_barang,
                'fk_lokasi_karantina' => $input['fk_lokasi_karantina'] ?? $detail->fk_lokasi_karantina,
                'updated_by' => $userId,
            ]);
        }
    }


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

        $this->tambahStokSaatIniMasterBarang($fkBarang, $qty, $userId);
    }


    private function tambahStokSaatIniMasterBarang(int $fkBarang, int $qty, int $userId): void
    {

        MasterBarang::syncStokSaatIniById($fkBarang, $userId);
    }

    private function tambahStokRusak(int $fkBarang, int $fkLokasi, int $qty, string $kdPenerimaan, int $userId): void
    {
        $stok = StokLokasi::query()
            ->where('fk_barang', $fkBarang)
            ->where('fk_lokasi', $fkLokasi)
            ->first();

        if (! $stok) {
            $stok = new StokLokasi([
                'fk_barang' => $fkBarang,
                'fk_lokasi' => $fkLokasi,
                'qty_stok' => 0,
                'qty_rusak' => 0,
            ]);
            $stok->created_by = $userId;
        }

        $stok->qty_rusak = (int) $stok->qty_rusak + $qty;
        $stok->reff_number = $kdPenerimaan;
        $stok->reff_from = 'PENERIMAAN';
        $stok->updated_by = $userId;
        $stok->save();
    }
}