<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPenerimaanBarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_master_status_penerimaan_barang')->insert([
            [
                'kd_status_penerimaan_barang' => 'DRAFT',
                'nm_status_penerimaan_barang' => 'Draft',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'SUBMITTED',
                'nm_status_penerimaan_barang' => 'Submitted',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'APPROVED_KASUBAG',
                'nm_status_penerimaan_barang' => 'Approved Kasubag',
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'APPROVED_KABAG',
                'nm_status_penerimaan_barang' => 'Approved Kabag',
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_status_penerimaan_barang' => 'APPROVED_DIREKTUR',
                'nm_status_penerimaan_barang' => 'Approved Direktur',
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