<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,

            MasterKategoriSeeder::class,
            MasterSatuanSeeder::class,
            MasterSupplierSeeder::class,
            MasterBarangSeeder::class,
            MasterStatusGudangSeeder::class,
            MasterStatusPoSeeder::class,

            // Tambahan cara membuat Seeder melalui factory
            MasterGudangSeeder::class,
            OpnameSeeder::class,
        ]);
    }
}