<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPoSeeder extends Seeder
{
    /*
    |--------------------------------------------------------------------------
    | URUTAN ID STATUS PO
    |--------------------------------------------------------------------------
    |
    | Sengaja di-insert dalam urutan ini (bukan urutan alur/workflow-nya)
    | supaya id_status_po yang ke-generate persis 1-6 seperti berikut:
    |   1 = APPROVED
    |   2 = REJECTED
    |   3 = DRAFT
    |   4 = PENDING_KASUBAG (menunggu Kasubag)
    |   5 = PENDING_KABAG   (menunggu Kabag)
    |   6 = PENDING_DIREKTUR (menunggu Direktur)
    |
    | CATATAN: karena ini pakai updateOrInsert (upsert), urutan id di atas
    | cuma kejamin kalau tabelnya masih kosong (fresh migrate + seed).
    | Kalau di-run ulang di database yang sudah ada isinya, id lama tetap
    | dipakai (upsert cuma update kolom lain, bukan reorder id).
    |--------------------------------------------------------------------------
    */

    public function run(): void
    {
        $statuses = [
            ['kd_status_po' => 'APPROVED', 'nm_status_po' => 'Approved', 'urutan' => 1],
            ['kd_status_po' => 'REJECTED', 'nm_status_po' => 'Rejected', 'urutan' => 2],
            ['kd_status_po' => 'DRAFT', 'nm_status_po' => 'Draft', 'urutan' => 3],
            ['kd_status_po' => 'PENDING_KASUBAG', 'nm_status_po' => 'Menunggu Persetujuan Kasubag', 'urutan' => 4],
            ['kd_status_po' => 'PENDING_KABAG', 'nm_status_po' => 'Menunggu Persetujuan Kabag', 'urutan' => 5],
            ['kd_status_po' => 'PENDING_DIREKTUR', 'nm_status_po' => 'Menunggu Persetujuan Direktur', 'urutan' => 6],
        ];

        foreach ($statuses as $status) {

            DB::table('tbl_master_status_po')->updateOrInsert(
                ['kd_status_po' => $status['kd_status_po']],
                [
                    'nm_status_po' => $status['nm_status_po'],
                    'urutan' => $status['urutan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
