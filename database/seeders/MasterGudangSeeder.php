<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterGudangSeeder extends Seeder
{
    public function run(): void
    {
        $statusAktif = DB::table('tbl_master_status_gudang')
            ->where('kd_status_gudang', 'AKTIF')
            ->value('id_status_gudang');

        $storage = DB::table('tbl_master_kategori_gudang')
            ->where('kd_kategori_gudang', 'STORAGE')
            ->value('id_kategori_gudang');

        $transit = DB::table('tbl_master_kategori_gudang')
            ->where('kd_kategori_gudang', 'TRANSIT')
            ->value('id_kategori_gudang');

        $rejected = DB::table('tbl_master_kategori_gudang')
            ->where('kd_kategori_gudang', 'REJECTED')
            ->value('id_kategori_gudang');

        if (!$statusAktif || !$storage || !$transit || !$rejected) {
            throw new \RuntimeException(
                'Status gudang atau kategori gudang belum tersedia.'
            );
        }

        $gudangs = [
            [
                'kd_gudang' => 'GU1',
                'nm_gudang' => 'Gudang Utama',
                'desc_gudang' => 'Gudang utama penyimpanan barang.',
                'fk_kategori_gudang' => $storage,
            ],
            [
                'kd_gudang' => 'GU2',
                'nm_gudang' => 'Gudang Transit',
                'desc_gudang' => 'Gudang untuk barang transit.',
                'fk_kategori_gudang' => $transit,
            ],
            [
                'kd_gudang' => 'GU3',
                'nm_gudang' => 'Gudang Rejected',
                'desc_gudang' => 'Gudang barang rusak atau ditolak.',
                'fk_kategori_gudang' => $rejected,
            ],
        ];

        foreach ($gudangs as $gudang) {
            DB::table('tbl_master_gudang')->updateOrInsert(
                [
                    'kd_gudang' => $gudang['kd_gudang'],
                ],
                [
                    'nm_gudang' => $gudang['nm_gudang'],
                    'desc_gudang' => $gudang['desc_gudang'],
                    'fk_status_gudang' => $statusAktif,
                    'fk_kategori_gudang' => $gudang['fk_kategori_gudang'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}