<?php

namespace Database\Seeders;

use App\Models\MasterBarang;
use App\Models\MasterKategori;
use App\Models\MasterSatuan;
use Illuminate\Database\Seeder;

class MasterBarangSeeder extends Seeder
{
    public function run(): void
    {
        $pipa = MasterKategori::where('nm_master_kategori', 'Pipa')->firstOrFail();
        $fitting = MasterKategori::where('nm_master_kategori', 'Fitting')->firstOrFail();
        $alat = MasterKategori::where('nm_master_kategori', 'Alat')->firstOrFail();
        $meteran = MasterKategori::where('nm_master_kategori', 'Meteran')->firstOrFail();

        $pcs = MasterSatuan::where('nm_master_satuan', 'Pcs')->firstOrFail();
        $btg = MasterSatuan::where('nm_master_satuan', 'Batang')->firstOrFail();
        $unit = MasterSatuan::where('nm_master_satuan', 'Unit')->firstOrFail();

        $barangs = [
            ['Pipa PVC 1/2', 'Pipa PVC ukuran 1/2 inch', 10, 50, $pipa->id_master_kategori, $btg->id_master_satuan],
            ['Pipa PVC 3/4', 'Pipa PVC ukuran 3/4 inch', 10, 45, $pipa->id_master_kategori, $btg->id_master_satuan],
            ['Elbow PVC', 'Elbow PVC', 5, 30, $fitting->id_master_kategori, $pcs->id_master_satuan],
            ['Tee PVC', 'Tee PVC', 5, 25, $fitting->id_master_kategori, $pcs->id_master_satuan],
            ['Kunci Inggris', 'Kunci inggris untuk pekerjaan teknis', 2, 15, $alat->id_master_kategori, $unit->id_master_satuan],
            ['Tang Kombinasi', 'Tang kombinasi', 2, 12, $alat->id_master_kategori, $unit->id_master_satuan],
            ['Meter Air', 'Meter air', 3, 20, $meteran->id_master_kategori, $unit->id_master_satuan],
            ['Meteran Digital', 'Meteran digital', 2, 10, $meteran->id_master_kategori, $unit->id_master_satuan],
            ['Pipa PVC 1', 'Pipa PVC ukuran 1 inch', 10, 40, $pipa->id_master_kategori, $btg->id_master_satuan],
            ['Socket PVC', 'Socket PVC', 5, 35, $fitting->id_master_kategori, $pcs->id_master_satuan],
            ['Palu Besi', 'Palu besi', 2, 8, $alat->id_master_kategori, $unit->id_master_satuan],
            ['Barang Kosong', 'Contoh barang dengan stok habis', 2, 0, $alat->id_master_kategori, $unit->id_master_satuan],
        ];

        foreach ($barangs as [$nama, $desc, $minimum, $stok, $kategori, $satuan]) {
            MasterBarang::create([
                'nm_master_barang' => $nama,
                'desc_master_barang' => $desc,
                'minimum_stok' => $minimum,
                'stok_saat_ini' => $stok,
                'status_master_barang' => 'AKTIF',
                'fk_kategori' => $kategori,
                'fk_satuan' => $satuan,
            ]);
        }
    }
}
