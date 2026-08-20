<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $this->call([
            MasterKategoriSeeder::class,
            MasterSatuanSeeder::class,
            MasterSupplierSeeder::class,
            MasterBarangSeeder::class,
            MasterStatusGudangSeeder::class,
            //Tambahan cara Membuat Seeder melalui factory
            MasterGudangSeeder::class,
            OpnameSeeder::class
            
        ]);
      
        
    }
}
