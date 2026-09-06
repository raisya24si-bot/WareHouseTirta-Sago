<?php

namespace Database\Seeders;

use App\Models\MasterSatuan;
use Illuminate\Database\Seeder;

class MasterSatuanSeeder extends Seeder
{
    public function run(): void
    {
        $satuans = [
            ['Unit', 'Satuan unit barang'],
            ['Pcs', 'Satuan per buah'],
            ['Roll', 'Satuan berbentuk gulungan'],
            ['Batang', 'Satuan berbentuk batang'],
            ['Meter', 'Satuan panjang meter'],
            ['Box', 'Satuan dalam bentuk box'],
        ];

        foreach ($satuans as [$nama, $desc]) {
            MasterSatuan::create([
                'nm_master_satuan' => $nama,
                'desc_master_satuan' => $desc,
                'status_master_satuan' => 'AKTIF',
            ]);
        }
    }
}
