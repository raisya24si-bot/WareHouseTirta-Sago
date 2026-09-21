<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPenerimaanBarangSeeder extends Seeder
{
    public function run(): void
    {
        // Kode status ini HARUS sinkron dengan App\Models\PenerimaanBarang::LEVELS.
        DB::table('tbl_master_status_penerimaan_barang')->insert([
            [
                'kd_status_penerimaan_barang' => 'DRAFT',
                'nm_status_penerimaan_barang' => 'Draft',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'PENDING_KASUBAG',
                'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Kasubag',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'PENDING_KABAG',
                'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Kabag',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'PENDING_DIREKTUR',
                'nm_status_penerimaan_barang' => 'Menunggu Persetujuan Direktur',
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'APPROVED',
                'nm_status_penerimaan_barang' => 'Approved',
                'urutan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'REJECTED',
                'nm_status_penerimaan_barang' => 'Rejected',
                'urutan' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}