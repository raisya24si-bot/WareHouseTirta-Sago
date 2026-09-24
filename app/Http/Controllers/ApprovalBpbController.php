<?php

namespace App\Http\Controllers;

use App\Models\Bpb;
use App\Models\MasterStatusBpb;
use Illuminate\Http\Request;

class ApprovalBpbController extends Controller
{
    public function index(Request $request)
    {
        $statusTabMap = [
            'menunggu' => 'MENUNGGU_APPROVAL',
            'draft' => 'DRAFT',
            'diproses' => 'DIPROSES_GUDANG',
            'ditolak' => 'DITOLAK',
        ];

        $tabAktif = $request->get('status', 'menunggu');
        if (! array_key_exists($tabAktif, $statusTabMap)) {
            $tabAktif = 'menunggu';
        }
        $kodeStatus = $statusTabMap[$tabAktif];

        $query = Bpb::with(['status', 'urgensi', 'gudang', 'createdBy', 'approveKasubagBy', 'details'])
            ->whereHas('status', fn ($q) => $q->where('kd_status_bpb', $kodeStatus));

        if ($kodeStatus === 'MENUNGGU_APPROVAL') {
            $query->oldest('submit_at');
        } elseif ($kodeStatus === 'DRAFT') {
            $query->latest('updated_at');
        } else {
            $query->latest('approve_kasubag_at');
        }

        if ($request->filled('gudang')) {
            $query->where('fk_gudang_pengambilan', $request->gudang);
        }

        $antrean = $query->paginate(10)->withQueryString();

        $stats = [];
        foreach ($statusTabMap as $tab => $kode) {
            $stats[$tab] = Bpb::whereHas('status', fn ($q) => $q->where('kd_status_bpb', $kode))->count();
        }


        $stats['total_approval'] = $stats['menunggu'] + $stats['diproses'] + $stats['ditolak'];

        $gudangList = \App\Models\MasterGudang::orderBy('nm_gudang')->get();

        return view('permintaan-barang.approval-kasubag', [
            'antrean' => $antrean,
            'stats' => $stats,
            'tabAktif' => $tabAktif,
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