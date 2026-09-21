<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusReturSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['kd_status_retur' => 'DRAFT', 'nm_status_retur' => 'Draft', 'urutan' => 1],
            ['kd_status_retur' => 'MENUNGGU_RESPON_VENDOR', 'nm_status_retur' => 'Menunggu Respon Vendor', 'urutan' => 2],
            ['kd_status_retur' => 'PROSES_KIRIM_GANTI', 'nm_status_retur' => 'Sedang Proses Kirim / Ganti', 'urutan' => 3],
            ['kd_status_retur' => 'SELESAI', 'nm_status_retur' => 'Selesai', 'urutan' => 4],
        ];

        foreach ($rows as $row) {
            DB::table('tbl_master_status_retur')->updateOrInsert(
                ['kd_status_retur' => $row['kd_status_retur']],
                [
                    'nm_status_retur' => $row['nm_status_retur'],
                    'urutan' => $row['urutan'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}