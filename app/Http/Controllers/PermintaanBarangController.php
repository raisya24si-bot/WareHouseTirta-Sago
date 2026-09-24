<?php

namespace App\Http\Controllers;

use App\Models\Bpb;
use App\Models\BpbDetail;
use App\Models\MasterBarang;
use App\Models\MasterGudang;
use App\Models\MasterKategori;
use App\Models\MasterStatusBpb;
use App\Models\MasterUrgensiBpb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanBarangController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Bpb::with(['status', 'urgensi', 'gudang', 'details'])
            ->latest('id_bpb');

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('kd_status_bpb', strtoupper($request->status));
            });
        }

        if ($request->filled('prioritas')) {
            $query->whereHas('urgensi', function ($q) use ($request) {
                $q->where('kd_urgensi_bpb', strtoupper($request->prioritas));
            });
        }

        if ($request->filled('gudang')) {
            $query->where('fk_gudang_pengambilan', $request->gudang);
        }

        $permintaan = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Bpb::count(),
            'draft' => $this->countByStatus('DRAFT'),
            'menunggu_approval' => $this->countByStatus('MENUNGGU_APPROVAL'),
            'diproses_gudang' => $this->countByStatus('DIPROSES_GUDANG'),
            'siap_ambil' => $this->countByStatus('SIAP_AMBIL'),
        ];

        $gudangList = MasterGudang::orderBy('nm_gudang')->get();
        $urgensiList = MasterUrgensiBpb::orderBy('urutan')->get();

        return view('permintaan-barang.index', [
            'permintaan' => $permintaan,
            'stats' => $stats,
            'gudangList' => $gudangList,
            'urgensiList' => $urgensiList,
        ]);
    }

    private function countByStatus(string $kode): int
    {
        return Bpb::whereHas('status', fn ($q) => $q->where('kd_status_bpb', $kode))->count();
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(string $kode)
    {
        $bpb = Bpb::with([
            'status', 'urgensi', 'gudang', 'createdBy', 'submittedBy',
            'details.barang.kategori', 'details.barang.satuan', 'details.bin',
        ])->where('kd_bpb', $kode)->firstOrFail();

        $kategoriList = MasterKategori::orderBy('nm_master_kategori')->get();

        $katalogMaterial = MasterBarang::with(['kategori', 'satuan'])
            ->where('status_master_barang', 'AKTIF')
            ->orderBy('nm_master_barang')
            ->get();

        return view('permintaan-barang.show', [
            'bpb' => $bpb,
            'kategoriList' => $kategoriList,
            'katalogMaterial' => $katalogMaterial,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT HEADER BPB (Langkah 1)
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_bpb' => ['nullable', 'date'],
            'desc_bpb' => ['nullable', 'string', 'max:191'],
            'fk_gudang_pengambilan' => ['required', 'exists:tbl_master_gudang,id_gudang'],
            'fk_tingkat_urgensi' => ['required', 'exists:tbl_master_urgensi_bpb,id_urgensi_bpb'],
            'status_spk' => ['required', 'in:ADA,DARURAT'],
            'no_spk' => ['nullable', 'string', 'max:100'],
        ]);

        $bpb = DB::transaction(function () use ($validated) {

            $userId = auth()->id();

            $statusDraftId = MasterStatusBpb::where('kd_status_bpb', 'DRAFT')->value('id_status_bpb');

            return Bpb::create([
                'kd_bpb' => $this->generateKodeBpb(),
                'tgl_bpb' => $validated['tgl_bpb'] ?? now()->toDateString(),
                'desc_bpb' => $validated['desc_bpb'] ?? null,
                'fk_status_bpb' => $statusDraftId,
                'fk_tingkat_urgensi' => $validated['fk_tingkat_urgensi'],
                'fk_gudang_pengambilan' => $validated['fk_gudang_pengambilan'],
                'status_spk' => $validated['status_spk'],
                'no_spk' => $validated['no_spk'] ?? null,
                'created_by' => $userId,
            ]);
        });

        return redirect()
            ->route('permintaan-barang.show', $bpb->kd_bpb)
            ->with('success', 'Header BPB ' . $bpb->kd_bpb . ' berhasil dibuat. Silakan tambahkan rincian barang.');
    }

    private function generateKodeBpb(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');

        $prefix = "BPB/{$year}/{$month}/";

        $numbers = Bpb::withTrashed()
            ->where('kd_bpb', 'like', $prefix . '%')
            ->pluck('kd_bpb');

        $maxNumber = 0;

        foreach ($numbers as $kdBpb) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $kdBpb, $matches)) {
                $maxNumber = max($maxNumber, (int) $matches[1]);
            }
        }

        return $prefix . ($maxNumber + 1);
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH ITEM BARANG (Langkah 2)
    |--------------------------------------------------------------------------
    */

    public function storeItem(Request $request, string $kode)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (! $bpb->isEditable()) {
            return back()->withErrors(['item' => 'Item hanya bisa ditambahkan selama BPB berstatus Draft atau Ditolak.']);
        }

        $validated = $request->validate([
            'fk_barang' => ['required', 'exists:tbl_master_barang,id_master_barang'],
            'qty_request' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string', 'max:191'],
        ]);

        $barang = MasterBarang::findOrFail($validated['fk_barang']);

        // Kalau barang yang sama sudah ada di daftar BPB ini, jumlahnya
        // digabung (ditambah) ke baris yang sudah ada saja, tidak bikin
        // baris duplikat. Baris baru cuma dibuat kalau barangnya memang
        // belum ada di daftar.
        $itemSudahAda = BpbDetail::where('fk_bpb', $bpb->id_bpb)
            ->where('fk_barang', $barang->id_master_barang)
            ->first();

        if ($itemSudahAda) {
            $itemSudahAda->update([
                'qty_request' => $itemSudahAda->qty_request + $validated['qty_request'],
                'qty_available' => $barang->stok_saat_ini,
                'catatan' => $validated['catatan'] ?? $itemSudahAda->catatan,
                'updated_by' => auth()->id(),
            ]);

            return redirect()
                ->route('permintaan-barang.show', $bpb->kd_bpb)
                ->with('success', $barang->nm_master_barang . ' sudah ada di daftar, jumlahnya digabung jadi ' . $itemSudahAda->qty_request . '.');
        }

        BpbDetail::create([
            'fk_bpb' => $bpb->id_bpb,
            'fk_barang' => $barang->id_master_barang,
            'qty_request' => $validated['qty_request'],
            'qty_available' => $barang->stok_saat_ini,
            'catatan' => $validated['catatan'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('permintaan-barang.show', $bpb->kd_bpb)
            ->with('success', $barang->nm_master_barang . ' ditambahkan ke BPB.');
    }

    public function destroyItem(string $kode, BpbDetail $item)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (! $bpb->isEditable() || (int) $item->fk_bpb !== (int) $bpb->id_bpb) {
            return back()->withErrors(['item' => 'Item tidak dapat dihapus.']);
        }

        $item->update(['deleted_by' => auth()->id()]);
        $item->delete();

        return back()->with('success', 'Item dihapus dari BPB.');
    }

    public function updateItem(Request $request, string $kode, BpbDetail $item)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (! $bpb->isEditable() || (int) $item->fk_bpb !== (int) $bpb->id_bpb) {
            return back()->withErrors(['item' => 'Item hanya bisa diedit selama BPB berstatus Draft atau Ditolak.']);
        }

        $validated = $request->validate([
            'qty_request' => ['required', 'integer', 'min:1'],
            'catatan' => ['nullable', 'string', 'max:191'],
        ]);

        $item->update([
            'qty_request' => $validated['qty_request'],
            'catatan' => $validated['catatan'] ?? null,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Item BPB berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | AJUKAN KE KASUBAG
    |--------------------------------------------------------------------------
    */

    public function submit(string $kode)
    {
        $bpb = Bpb::with(['status', 'details'])->where('kd_bpb', $kode)->firstOrFail();

        if (! $bpb->isEditable()) {
            return back()->withErrors(['submit' => 'BPB ini sudah diajukan sebelumnya.']);
        }

        if ($bpb->details->isEmpty()) {
            return back()->withErrors(['submit' => 'Tambahkan minimal 1 item barang sebelum mengajukan BPB.']);
        }

        $sebelumnyaDitolak = $bpb->status->kd_status_bpb === 'DITOLAK';

        $statusMenungguId = MasterStatusBpb::where('kd_status_bpb', 'MENUNGGU_APPROVAL')->value('id_status_bpb');

        $bpb->update([
            'fk_status_bpb' => $statusMenungguId,
            'submit_by' => auth()->id(),
            'submit_at' => now(),
            'updated_by' => auth()->id(),
        ]);

        $pesan = $sebelumnyaDitolak
            ? 'BPB ' . $bpb->kd_bpb . ' berhasil diajukan ulang ke Kasubag.'
            : 'BPB ' . $bpb->kd_bpb . ' berhasil diajukan ke Kasubag.';

        return redirect()
            ->route('permintaan-barang.index')
            ->with('success', $pesan);
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS DRAFT
    |--------------------------------------------------------------------------
    */

    public function destroy(string $kode)
    {
        $bpb = Bpb::with('status')->where('kd_bpb', $kode)->firstOrFail();

        if (! $bpb->isEditable()) {
            return back()->withErrors(['delete' => 'Hanya dokumen berstatus Draft atau Ditolak yang bisa dihapus.']);
        }

        $bpb->update(['deleted_by' => auth()->id()]);
        $bpb->delete();

        return redirect()
            ->route('permintaan-barang.index')
            ->with('success', 'BPB ' . $bpb->kd_bpb . ' dihapus.');
    }
}