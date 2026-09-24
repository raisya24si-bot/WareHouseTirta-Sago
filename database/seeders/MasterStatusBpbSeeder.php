<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusBpbSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['kd_status_bpb' => 'DRAFT', 'nm_status_bpb' => 'Draf Permintaan', 'urutan' => 1],
            ['kd_status_bpb' => 'MENUNGGU_APPROVAL', 'nm_status_bpb' => 'Menunggu Approval Kasubag', 'urutan' => 2],
            ['kd_status_bpb' => 'DIPROSES_GUDANG', 'nm_status_bpb' => 'Sedang Disiapkan Gudang', 'urutan' => 3],
            ['kd_status_bpb' => 'SIAP_AMBIL', 'nm_status_bpb' => 'Siap Ambil di Gudang', 'urutan' => 4],
            ['kd_status_bpb' => 'SELESAI', 'nm_status_bpb' => 'Selesai Diambil', 'urutan' => 5],
            ['kd_status_bpb' => 'DITOLAK', 'nm_status_bpb' => 'Ditolak', 'urutan' => 6],
        ];

        foreach ($statuses as $status) {

            DB::table('tbl_master_status_bpb')->updateOrInsert(
                ['kd_status_bpb' => $status['kd_status_bpb']],
                [
                    'nm_status_bpb' => $status['nm_status_bpb'],
                    'urutan' => $status['urutan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}