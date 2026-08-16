<?php

namespace Database\Seeders;

use App\Models\MasterKategori;
use Illuminate\Database\Seeder;

class MasterKategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Pipa', 'Fitting', 'Alat', 'Meteran', 'Aksesoris'] as $nama) {
            MasterKategori::create([
                'nm_master_kategori' => $nama,
                'desc_master_kategori' => $nama,
                'status_master_kategori' => 'AKTIF',
            ]);
        }
    }
}
