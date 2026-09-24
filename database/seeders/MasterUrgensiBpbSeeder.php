<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterUrgensiBpbSeeder extends Seeder
{
    public function run(): void
    {
        $urgensi = [
            ['kd_urgensi_bpb' => 'NORMAL', 'nm_urgensi_bpb' => 'Normal', 'urutan' => 1],
            ['kd_urgensi_bpb' => 'TINGGI', 'nm_urgensi_bpb' => 'Tinggi', 'urutan' => 2],
            ['kd_urgensi_bpb' => 'DARURAT', 'nm_urgensi_bpb' => 'Sangat Mendesak', 'urutan' => 3],
        ];

        foreach ($urgensi as $item) {

            DB::table('tbl_master_urgensi_bpb')->updateOrInsert(
                ['kd_urgensi_bpb' => $item['kd_urgensi_bpb']],
                [
                    'nm_urgensi_bpb' => $item['nm_urgensi_bpb'],
                    'urutan' => $item['urutan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}