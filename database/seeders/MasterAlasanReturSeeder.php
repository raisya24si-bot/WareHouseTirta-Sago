<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterAlasanReturSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            'Pecah (Kaca Dial Retak)',
            'Segel Metrologi Patah / Rusak',
            'Sumbing / Rompal',
            'Cacat Drat / Flange Retak',
            'Dial Buram / Kemasukan Air',
            'Bocor saat Pre-Test Hidrostatik',
            'Korosi / Karat',
            'Aksesoris Kurang / Hilang',
        ];

        foreach ($rows as $nama) {
            DB::table('tbl_master_alasan_retur')->updateOrInsert(
                ['nm_alasan_retur' => $nama],
                [
                    'status_alasan_retur' => 'AKTIF',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}