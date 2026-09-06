<?php

namespace App\Http\Controllers;

use App\Models\MasterRow;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrukturLokasiController extends Controller
{
    /**
     * Buat bin sampai TOTAL jumlahnya sesuai input (bukan menambah
     * sejumlah itu). Contoh: sudah ada 6 bin, isi 9 -> sistem cuma
     * buat 3 bin baru (nomor 07,08,09) supaya totalnya jadi 9.
     * Kode dibuat otomatis: {kd_row}.{urutan 2 digit}.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_row' => 'required|exists:tbl_master_row,id_row',
            'jumlah' => 'required|integer|min:1|max:300',
            'status_lokasi' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $row = MasterRow::findOrFail($validated['fk_row']);

        $existing = StrukturLokasi::withTrashed()
            ->where('fk_row', $row->id_row)
            ->count();

        $target = $validated['jumlah'];
        $toCreate = $target - $existing;

        if ($toCreate <= 0) {
            return back()->withErrors([
                'jumlah' => "Row ini sudah punya {$existing} bin. Masukkan angka lebih besar dari {$existing} untuk menambah bin baru.",
            ]);
        }

        DB::transaction(function () use ($toCreate, $existing, $row, $validated) {
            for ($i = 1; $i <= $toCreate; $i++) {
                $seq = $existing + $i;
                $binCode = str_pad((string) $seq, 2, '0', STR_PAD_LEFT);

                StrukturLokasi::create([
                    'kd_lokasi' => $row->kd_row . '.' . $binCode,
                    'fk_row' => $row->id_row,
                    'bin' => $binCode,
                    'status_lokasi' => $validated['status_lokasi'],
                ]);
            }
        });

        return back()->with('success', "{$toCreate} bin baru berhasil ditambahkan (total sekarang {$target} bin).");
    }

    /**
     * Kode, row, & nomor bin bersifat tetap setelah dibuat, jadi
     * yang bisa diubah di sini hanya status.
     */
    public function update(Request $request, StrukturLokasi $strukturLokasi)
    {
        $validated = $request->validate([
            'status_lokasi' => 'required|in:AKTIF,MAINTENANCE,TIDAK AKTIF',
        ]);

        $strukturLokasi->update($validated);

        return back()->with('success', 'Status struktur lokasi berhasil diperbarui.');
    }

    public function destroy(StrukturLokasi $strukturLokasi)
    {
        $adaBarang = StokLokasi::where('fk_lokasi', $strukturLokasi->id_lokasi)
            ->where('qty_stok', '>', 0)
            ->exists();

        if ($adaBarang) {
            return back()->withErrors([
                'lokasi' => 'Bin ' . $strukturLokasi->bin . ' tidak dapat dihapus karena masih ada barang di dalamnya.'
            ]);
        }

        $strukturLokasi->delete();

        return back()->with('success', 'Struktur lokasi berhasil dihapus.');
    }
}