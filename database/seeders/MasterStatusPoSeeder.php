<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPoSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['kd_status_po' => 'DRAFT', 'nm_status_po' => 'Draft', 'urutan' => 1],
            ['kd_status_po' => 'PENDING_KASUBAG', 'nm_status_po' => 'Menunggu Persetujuan Kasubag', 'urutan' => 2],
            ['kd_status_po' => 'PENDING_KABAG', 'nm_status_po' => 'Menunggu Persetujuan Kabag', 'urutan' => 3],
            ['kd_status_po' => 'PENDING_DIREKTUR', 'nm_status_po' => 'Menunggu Persetujuan Direktur', 'urutan' => 4],
            ['kd_status_po' => 'APPROVED', 'nm_status_po' => 'Approved', 'urutan' => 5],
            ['kd_status_po' => 'REJECTED', 'nm_status_po' => 'Rejected', 'urutan' => null],
        ];

        foreach ($statuses as $status) {

            DB::table('tbl_master_status_po')->updateOrInsert(
                ['kd_status_po' => $status['kd_status_po']],
                [
                    'nm_status_po' => $status['nm_status_po'],
                    'urutan' => $status['urutan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}