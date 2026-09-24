<?php

namespace App\Http\Controllers;

use App\Models\Bpb;
use App\Models\MasterStatusBpb;
use Illuminate\Http\Request;

class ApprovalBpbController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ANTREAN APPROVAL KASUBAG
    |--------------------------------------------------------------------------
    |
    | Catatan: untuk sekarang alur approval BPB baru sampai level Kasubag
    | saja (belum ada tingkat Kabag / Direktur seperti approval PO).
    | Begitu BPB disetujui Kasubag, status langsung pindah ke
    | DIPROSES_GUDANG supaya tim gudang bisa mulai picking barang.
    |
    */

    public function index(Request $request)
    {
        $query = Bpb::with(['urgensi', 'gudang', 'createdBy', 'details'])
            ->whereHas('status', fn ($q) => $q->where('kd_status_bpb', 'MENUNGGU_APPROVAL'))
            ->oldest('submit_at');

        if ($request->filled('gudang')) {
            $query->where('fk_gudang_pengambilan', $request->gudang);
        }

        $antrean = $query->paginate(10)->withQueryString();

        $totalMenunggu = Bpb::whereHas('status', fn ($q) => $q->where('kd_status_bpb', 'MENUNGGU_APPROVAL'))->count();

        $gudangList = \App\Models\MasterGudang::orderBy('nm_gudang')->get();

        return view('permintaan-barang.approval-kasubag', [
            'antrean' => $antrean,
            'totalMenunggu' => $totalMenunggu,
            'gudangList' => $gudangList,
        ]);
    }

    public function approve(string $kode)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (($bpb->status->kd_status_bpb ?? null) !== 'MENUNGGU_APPROVAL') {
            return back()->withErrors(['approval' => 'BPB ini sudah tidak berada di antrean approval Kasubag.']);
        }

        $statusDiprosesId = MasterStatusBpb::where('kd_status_bpb', 'DIPROSES_GUDANG')->value('id_status_bpb');

        $bpb->update([
            'fk_status_bpb' => $statusDiprosesId,
            'approve_kasubag_by' => auth()->id(),
            'approve_kasubag_at' => now(),
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'BPB ' . $bpb->kd_bpb . ' disetujui Kasubag, diteruskan ke Gudang.');
    }

    public function reject(Request $request, string $kode)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (($bpb->status->kd_status_bpb ?? null) !== 'MENUNGGU_APPROVAL') {
            return back()->withErrors(['approval' => 'BPB ini sudah tidak berada di antrean approval Kasubag.']);
        }

        $validated = $request->validate([
            'alasan_tolak' => ['nullable', 'string', 'max:191'],
        ]);

        $statusDitolakId = MasterStatusBpb::where('kd_status_bpb', 'DITOLAK')->value('id_status_bpb');

       
        $bpb->update([
            'fk_status_bpb' => $statusDitolakId,
            'desc_bpb' => trim(($bpb->desc_bpb ? $bpb->desc_bpb . ' — ' : '') . 'Ditolak Kasubag: ' . ($validated['alasan_tolak'] ?? '-')),
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'BPB ' . $bpb->kd_bpb . ' ditolak.');
    }
}