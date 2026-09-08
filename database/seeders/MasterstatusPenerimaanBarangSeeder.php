<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPenerimaanBarangSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['kd_status_penerimaan_barang' => 'DRAFT', 'nm_status_penerimaan_barang' => 'Draft', 'urutan' => 1],
            ['kd_status_penerimaan_barang' => 'PENDING_KASUBAG', 'nm_status_penerimaan_barang' => 'Menunggu Verifikasi Kasubag', 'urutan' => 2],
            ['kd_status_penerimaan_barang' => 'PENDING_KABAG', 'nm_status_penerimaan_barang' => 'Menunggu Verifikasi Kabag', 'urutan' => 3],
            ['kd_status_penerimaan_barang' => 'PENDING_DIREKTUR', 'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Direktur', 'urutan' => 4],
            ['kd_status_penerimaan_barang' => 'APPROVED', 'nm_status_penerimaan_barang' => 'Disetujui / Selesai', 'urutan' => 5],
            ['kd_status_penerimaan_barang' => 'REJECTED', 'nm_status_penerimaan_barang' => 'Ditolak', 'urutan' => 6],
        ];

        foreach ($statuses as $status) {

            DB::table('tbl_master_status_penerimaan_barang')->updateOrInsert(
                ['kd_status_penerimaan_barang' => $status['kd_status_penerimaan_barang']],
                [
                    'nm_status_penerimaan_barang' => $status['nm_status_penerimaan_barang'],
                    'urutan' => $status['urutan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}