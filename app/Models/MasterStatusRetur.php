<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterStatusRetur extends Model
{
    protected $table = 'tbl_master_status_retur';
    protected $primaryKey = 'id_status_retur';

    protected $fillable = [
        'kd_status_retur',
        'nm_status_retur',
        'urutan',
    ];


    public const GROUP_DALAM_PROSES = [
        'MENUNGGU_RESPON_VENDOR', 'PROSES_KIRIM_GANTI',
    ];

    public const GROUP_SELESAI = ['SELESAI'];

    public function returBarangs(): HasMany
    {
        return $this->hasMany(ReturBarang::class, 'fk_status_retur', 'id_status_retur');
    }
}