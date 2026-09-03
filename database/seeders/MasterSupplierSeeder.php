<?php

namespace Database\Seeders;

use App\Models\MasterSupplier;
use Illuminate\Database\Seeder;

class MasterSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['PT Tirta Material', 'Jl. Industri No. 10', '081234567890'],
            ['CV Sumber Teknik', 'Jl. Raya Utama No. 21', '081298765432'],
            ['UD Maju Jaya', 'Jl. Perdagangan No. 5', '082112223333'],
        ];

        foreach ($suppliers as [$nama, $alamat, $kontak]) {
            MasterSupplier::create([
                'nm_master_supplier' => $nama,
                'alamat_supplier' => $alamat,
                'kontak_supplier' => $kontak,
                'status_master_supplier' => 'AKTIF',
            ]);
        }
    }
}
