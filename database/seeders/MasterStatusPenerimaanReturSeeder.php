<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPenerimaanReturSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['kd_status_penerimaan_retur' => 'MENUNGGU_KEDATANGAN', 'nm_status_penerimaan_retur' => 'Menunggu Penerimaan / Kedatangan', 'urutan' => 1],
            ['kd_status_penerimaan_retur' => 'PROSES_QC', 'nm_status_penerimaan_retur' => 'Dalam Proses QC & Verifikasi', 'urutan' => 2],
            ['kd_status_penerimaan_retur' => 'SELESAI', 'nm_status_penerimaan_retur' => 'Selesai Masuk Stok', 'urutan' => 3],
        ];

        foreach ($rows as $row) {
            DB::table('tbl_master_status_penerimaan_retur')->updateOrInsert(
                ['kd_status_penerimaan_retur' => $row['kd_status_penerimaan_retur']],
                [
                    'nm_status_penerimaan_retur' => $row['nm_status_penerimaan_retur'],
                    'urutan' => $row['urutan'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}