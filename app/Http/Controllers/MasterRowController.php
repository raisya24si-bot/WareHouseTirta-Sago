<?php

namespace App\Http\Controllers;

use App\Models\MasterRak;
use App\Models\MasterRow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterRowController extends Controller
{
    /**
     * Buat row sampai TOTAL jumlahnya sesuai input (bukan menambah
     * sejumlah itu). Contoh: sudah ada 6 row, isi 9 -> sistem cuma
     * buat 3 row baru (nomor 7,8,9) supaya totalnya jadi 9.
     * Kode dibuat otomatis: {kd_rak}.{urutan 2 digit}.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_rak' => 'required|exists:tbl_master_rak,id_rak',
            'jumlah' => 'required|integer|min:1|max:200',
            'status_row' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $rak = MasterRak::findOrFail($validated['fk_rak']);

        $existing = MasterRow::withTrashed()
            ->where('fk_rak', $rak->id_rak)
            ->count();

        $target = $validated['jumlah'];
        $toCreate = $target - $existing;

        if ($toCreate <= 0) {
            return back()->withErrors([
                'jumlah' => "Rak ini sudah punya {$existing} row. Masukkan angka lebih besar dari {$existing} untuk menambah row baru.",
            ]);
        }

        DB::transaction(function () use ($toCreate, $existing, $rak, $validated) {
            for ($i = 1; $i <= $toCreate; $i++) {
                $seq = $existing + $i;

                MasterRow::create([
                    'kd_row' => $rak->kd_rak . '.' . str_pad((string) $seq, 2, '0', STR_PAD_LEFT),
                    'fk_rak' => $rak->id_rak,
                    'status_row' => $validated['status_row'],
                ]);
            }
        });

        return back()->with('success', "{$toCreate} row baru berhasil ditambahkan (total sekarang {$target} row).");
    }

    /**
     * Kode & rak bersifat tetap setelah dibuat, jadi yang bisa
     * diubah di sini hanya status.
     */
    public function update(Request $request, MasterRow $masterRow)
    {
        $validated = $request->validate([
            'status_row' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $masterRow->update($validated);

        return back()->with('success', 'Status row berhasil diperbarui.');
    }

    public function destroy(MasterRow $masterRow)
    {
        if ($masterRow->lokasis()->exists()) {
            return back()->withErrors([
                'row' => 'Row tidak dapat dihapus karena masih memiliki struktur lokasi/bin.'
            ]);
        }

        $masterRow->delete();

        return back()->with('success', 'Row berhasil dihapus.');
    }
}