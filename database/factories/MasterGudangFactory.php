<?php

namespace Database\Factories;

use App\Models\MasterGudang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MasterGudang>
 */
class MasterGudangFactory extends Factory
{
    protected $model = MasterGudang::class;

    // Variabel statis untuk menghitung nomor urut kode gudang
    protected static $counter = 1;

    public function definition(): array
    {
        // Menghasilkan format: GU1, GU2, GU3, dst.
        $kdGudang = 'GU' . self::$counter++;

        return [
            'kd_gudang'   => $kdGudang,
            'nm_gudang' => 'Gudang ' . fake()->city(), // Contoh: Gudang Jakarta
            'alamat_gudang'      => fake()->address(),
            'kepala_gudang' =>fake()->name(),
            'fk_status_gudang' => 1
            // Tambahkan kolom lain di sini sesuai struktur tabel gudang Anda
        ];
    }
}
