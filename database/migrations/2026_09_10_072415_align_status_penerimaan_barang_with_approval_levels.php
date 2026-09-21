<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            ['kd_status_penerimaan_barang' => 'DRAFT', 'nm_status_penerimaan_barang' => 'Draft', 'urutan' => 1],
            ['kd_status_penerimaan_barang' => 'PENDING_KASUBAG', 'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Kasubag', 'urutan' => 2],
            ['kd_status_penerimaan_barang' => 'PENDING_KABAG', 'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Kabag', 'urutan' => 3],
            ['kd_status_penerimaan_barang' => 'PENDING_DIREKTUR', 'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Direktur', 'urutan' => 4],
            ['kd_status_penerimaan_barang' => 'APPROVED', 'nm_status_penerimaan_barang' => 'Approved', 'urutan' => 5],
            ['kd_status_penerimaan_barang' => 'REJECTED', 'nm_status_penerimaan_barang' => 'Rejected', 'urutan' => 6],
        ];

        
        $rename = [
            'SUBMITTED' => 'PENDING_DIREKTUR',
            'APPROVED_KASUBAG' => 'PENDING_KABAG',
            'APPROVED_KABAG' => 'PENDING_DIREKTUR',
            'APPROVED_DIREKTUR' => 'APPROVED',
        ];

        foreach ($rename as $old => $new) {

            $oldRow = DB::table('tbl_master_status_penerimaan_barang')
                ->where('kd_status_penerimaan_barang', $old)
                ->first();

            $newRow = DB::table('tbl_master_status_penerimaan_barang')
                ->where('kd_status_penerimaan_barang', $new)
                ->first();

            if ($oldRow && ! $newRow) {
                // Kode lama masih dipakai & kode baru belum ada -> ganti nama saja.
                DB::table('tbl_master_status_penerimaan_barang')
                    ->where('id_status_penerimaan_barang', $oldRow->id_status_penerimaan_barang)
                    ->update(['kd_status_penerimaan_barang' => $new]);
            } elseif ($oldRow && $newRow) {
                // Keduanya ada -> pindahkan referensi transaksi ke kode baru, hapus yang lama.
                DB::table('tbl_penerimaan_barang')
                    ->where('fk_status_penerimaan_barang', $oldRow->id_status_penerimaan_barang)
                    ->update(['fk_status_penerimaan_barang' => $newRow->id_status_penerimaan_barang]);

                DB::table('tbl_master_status_penerimaan_barang')
                    ->where('id_status_penerimaan_barang', $oldRow->id_status_penerimaan_barang)
                    ->delete();
            }
        }

        foreach ($rows as $row) {

            DB::table('tbl_master_status_penerimaan_barang')->updateOrInsert(
                ['kd_status_penerimaan_barang' => $row['kd_status_penerimaan_barang']],
                [
                    'nm_status_penerimaan_barang' => $row['nm_status_penerimaan_barang'],
                    'urutan' => $row['urutan'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        // Tidak ada rollback otomatis — perubahan ini menyatukan data status lama & baru.
    }
};