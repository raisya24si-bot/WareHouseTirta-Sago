<?php

namespace App\Http\Controllers;

use App\Models\MasterGudang;
use App\Models\MasterRak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterRakController extends Controller
{
    /**
     * Buat rak sampai TOTAL jumlahnya sesuai input (bukan menambah
     * sejumlah itu). Contoh: sudah ada 6 rak, isi 9 -> sistem cuma
     * buat 3 rak baru (nomor 7,8,9) supaya totalnya jadi 9.
     * Kode dibuat otomatis: {kd_gudang}.{urutan 2 digit}.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_gudang' => 'required|exists:tbl_master_gudang,id_gudang',
            'jumlah' => 'required|integer|min:1|max:200',
            'status_rak' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $gudang = MasterGudang::findOrFail($validated['fk_gudang']);

        $existing = MasterRak::withTrashed()
            ->where('fk_gudang', $gudang->id_gudang)
            ->count();

        $target = $validated['jumlah'];
        $toCreate = $target - $existing;

        if ($toCreate <= 0) {
            return back()->withErrors([
                'jumlah' => "Gudang ini sudah punya {$existing} rak. Masukkan angka lebih besar dari {$existing} untuk menambah rak baru.",
            ]);
        }

        DB::transaction(function () use ($toCreate, $existing, $validated, $gudang) {
            for ($i = 1; $i <= $toCreate; $i++) {
                $seq = $existing + $i;

                MasterRak::create([
                    'kd_rak' => $gudang->kd_gudang . '.' . str_pad((string) $seq, 2, '0', STR_PAD_LEFT),
                    'fk_gudang' => $gudang->id_gudang,
                    'status_rak' => $validated['status_rak'],
                ]);
            }
        });

        return back()->with('success', "{$toCreate} rak baru berhasil ditambahkan (total sekarang {$target} rak).");
    }

    /**
     * Kode & gudang bersifat tetap setelah dibuat (mengikuti struktur
     * hierarki), jadi yang bisa diubah di sini hanya status.
     */
    public function update(Request $request, MasterRak $masterRak)
    {
        $validated = $request->validate([
            'status_rak' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $masterRak->update($validated);

        return back()->with('success', 'Status rak berhasil diperbarui.');
    }

    public function destroy(MasterRak $masterRak)
    {
        if ($masterRak->rows()->exists()) {
            return back()->withErrors([
                'rak' => 'Rak tidak dapat dihapus karena masih memiliki data row.'
            ]);
        }

        $masterRak->delete();

        return back()->with('success', 'Rak berhasil dihapus.');
    }
}