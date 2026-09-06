<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKategoriGudangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kd_kategori_gudang' => 'STORAGE',
                'nm_kategori_gudang' => 'Storage',
                'desc_kategori_gudang' => 'Gudang utama untuk penyimpanan barang.',
                'status_kategori_gudang' => 'AKTIF',
            ],
            [
                'kd_kategori_gudang' => 'TRANSIT',
                'nm_kategori_gudang' => 'Transit',
                'desc_kategori_gudang' => 'Gudang untuk barang dalam proses perpindahan.',
                'status_kategori_gudang' => 'AKTIF',
            ],
            [
                'kd_kategori_gudang' => 'REJECTED',
                'nm_kategori_gudang' => 'Rejected',
                'desc_kategori_gudang' => 'Gudang untuk barang rusak atau ditolak.',
                'status_kategori_gudang' => 'AKTIF',
            ],
        ];

        foreach ($data as $item) {
            DB::table('tbl_master_kategori_gudang')->updateOrInsert(
                [
                    'kd_kategori_gudang' => $item['kd_kategori_gudang'],
                ],
                [
                    'nm_kategori_gudang' => $item['nm_kategori_gudang'],
                    'desc_kategori_gudang' => $item['desc_kategori_gudang'],
                    'status_kategori_gudang' => $item['status_kategori_gudang'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}