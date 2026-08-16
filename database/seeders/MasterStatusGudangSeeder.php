<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusGudangSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'kd_status_gudang' => 'AKTIF',
                'nm_status_gudang' => 'Aktif',
                'desc_status_gudang' => 'Gudang aktif dan dapat digunakan.',
            ],
            [
                'kd_status_gudang' => 'NONAKTIF',
                'nm_status_gudang' => 'Tidak Aktif',
                'desc_status_gudang' => 'Gudang tidak sedang digunakan.',
            ],
            [
                'kd_status_gudang' => 'MAINTENANCE',
                'nm_status_gudang' => 'Maintenance',
                'desc_status_gudang' => 'Gudang sedang dalam proses pemeliharaan.',
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('tbl_master_status_gudang')->updateOrInsert(
                [
                    'kd_status_gudang' => $status['kd_status_gudang'],
                ],
                [
                    'nm_status_gudang' => $status['nm_status_gudang'],
                    'desc_status_gudang' => $status['desc_status_gudang'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}