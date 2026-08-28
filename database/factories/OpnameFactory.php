<?php
namespace database\Factories;

use App\Models\Opname;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpnameFactory extends Factory
{
    protected $model = Opname::class;

    
    protected static $counter = 1;

    public function definition(): array
    {
        // 1. Generate tanggal mulai acak
        $tglMulai = fake()->dateTimeBetween('-1 month', 'now');
        $tglMulaiStr = $tglMulai->format('Y-m-d');

        // 2. Generate format kode: OP-YYYY-MM-DD-NomorUrut
        $kdOpname = 'OP-' . $tglMulaiStr . '-' . self::$counter++;

        $tglSelesai = fake()->dateTimeBetween($tglMulai, $tglMulai->format('Y-m-d') . ' +3 days');

        return [
            'kd_opname'     => $kdOpname,
            'fk_gudang' => \App\Models\MasterGudang::factory(), 
            'tgl_mulai'     => $tglMulaiStr,
            'tgl_selesai'   => fake()->randomElement([null, $tglSelesai->format('Y-m-d')]), 
            'status_opname' => fake()->randomElement(['Draft', 'Proses', 'Selesai']),
            'catatan'       => fake()->optional()->sentence(),
            'created_by'    => fake()->numberBetween(1, 10),
            'updated_by'    => null,
            'deleted_by'    => null,
        ];
    }
}
