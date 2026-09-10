<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterStatusPenerimaanBarang;
use App\Models\PenerimaanBarang;
use App\Models\StokLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalDirekturController extends Controller
{
    use HasPerPage;

    /**
     * Antrian GRN yang menunggu keputusan akhir Direktur.
     */
    public function index(Request $request)
    {
        $query = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', 'PENDING_DIREKTUR')
            )
            ->with([
                'po.supplier',
                'details.barang.satuan',
                'submittedBy',
            ])
            ->orderBy('submit_at');

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

        $totalMenunggu = $this->countByStatus('PENDING_DIREKTUR');

        $totalDisetujuiBulanIni = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', 'APPROVED')
            )
            ->whereMonth('approve_direktur_at', now()->month)
            ->whereYear('approve_direktur_at', now()->year)
            ->count();

        $totalDitolakBulanIni = PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', 'REJECTED')
            )
            ->whereMonth('approve_direktur_at', now()->month)
            ->whereYear('approve_direktur_at', now()->year)
            ->count();

        $nilaiMenunggu = 0;

        foreach ($penerimaans as $penerimaan) {
            foreach ($penerimaan->details as $detail) {
                $nilaiMenunggu += ((int) $detail->qty_baik) * ((float) ($detail->harga_satuan ?? 0));
            }
        }

        return view('approval.direktur.index', compact(
            'penerimaans',
            'perPage',
            'totalMenunggu',
            'totalDisetujuiBulanIni',
            'totalDitolakBulanIni',
            'nilaiMenunggu'
        ));
    }


    /**
     * Setujui GRN: kunci dokumen & dorong stok ke tbl_stok_lokasi.
     */
    public function approve(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {

        $penerimaan->load(['statusPenerimaan', 'details']);

        if (! $penerimaan->isPendingAt('direktur')) {

            $message = 'Dokumen ini tidak lagi menunggu approval Direktur.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['approve' => $message]);
        }

        // Validasi: semua qty baik & qty rusak wajib sudah punya bin sebelum
        // disetujui — sesuai catatan "Wajib ditentukan sebelum approval".
        foreach ($penerimaan->details as $detail) {

            if ((int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang) {

                $message = 'Masih ada item baik yang belum memiliki lokasi bin. Tidak dapat disetujui.';

                if ($request->wantsJson()) {
                    return response()->json(['message' => $message], 422);
                }

                return back()->withErrors(['approve' => $message]);
            }

            if ((int) $detail->qty_rusak > 0 && ! $detail->fk_lokasi_karantina) {

                $message = 'Masih ada item rusak yang belum memiliki bin karantina. Tidak dapat disetujui.';

                if ($request->wantsJson()) {
                    return response()->json(['message' => $message], 422);
                }

                return back()->withErrors(['approve' => $message]);
            }
        }

        $nextStatus = MasterStatusPenerimaanBarang::query()
            ->where('kd_status_penerimaan_barang', 'APPROVED')
            ->firstOrFail();

        DB::transaction(function () use ($penerimaan, $nextStatus, $request) {

            $userId = auth()->id() ?? 1;

            foreach ($penerimaan->details as $detail) {

                if ((int) $detail->qty_baik > 0 && $detail->fk_lokasi_barang) {

                    $this->tambahStok(
                        $detail->fk_barang,
                        $detail->fk_lokasi_barang,
                        (int) $detail->qty_baik,
                        $userId
                    );
                }

                if ((int) $detail->qty_rusak > 0 && $detail->fk_lokasi_karantina) {

                    $this->tambahStok(
                        $detail->fk_barang,
                        $detail->fk_lokasi_karantina,
                        (int) $detail->qty_rusak,
                        $userId
                    );
                }
            }

            $penerimaan->update([
                'fk_status_penerimaan_barang' => $nextStatus->id_status_penerimaan_barang,
                'approve_direktur_by' => $userId,
                'approve_direktur_at' => now(),
                'catatan_approval' => $request->input('catatan_approval'),
                'updated_by' => $userId,
            ]);
        });

        $message = 'Penerimaan berhasil disetujui. Stok gudang telah diperbarui.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('penerimaan.index')
            ->with('success', $message);
    }


    /**
     * Tolak GRN: kembalikan ke Draft supaya petugas gudang bisa memperbaiki.
     */
    public function reject(
        Request $request,
        PenerimaanBarang $penerimaan
    ) {

        $penerimaan->load(['statusPenerimaan']);

        if (! $penerimaan->isPendingAt('direktur')) {

            $message = 'Dokumen ini tidak lagi menunggu approval Direktur.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return back()->withErrors(['reject' => $message]);
        }

        $validated = $request->validate([
            'catatan_approval' => ['required', 'string', 'max:1000'],
        ], [
            'catatan_approval.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $rejectedStatus = MasterStatusPenerimaanBarang::query()
            ->where('kd_status_penerimaan_barang', 'REJECTED')
            ->firstOrFail();

        $userId = auth()->id() ?? 1;

        $penerimaan->update([
            'fk_status_penerimaan_barang' => $rejectedStatus->id_status_penerimaan_barang,
            'approve_direktur_by' => $userId,
            'approve_direktur_at' => now(),
            'catatan_approval' => $validated['catatan_approval'],
            'updated_by' => $userId,
        ]);

        $message = 'Penerimaan ditolak dan dikembalikan ke draft untuk diperbaiki.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('penerimaan.index')
            ->with('success', $message);
    }


    /**
     * Upsert qty stok pada satu bin (dipakai untuk barang baik maupun
     * barang rusak yang disimpan di bin karantina).
     */
    private function tambahStok(
        int $fkBarang,
        int $fkLokasi,
        int $qty,
        int $userId
    ): void {

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
    }


    private function countByStatus(string $kode): int
    {
        return PenerimaanBarang::query()
            ->whereHas(
                'statusPenerimaan',
                fn ($q) => $q->where('kd_status_penerimaan_barang', $kode)
            )
            ->count();
    }
}