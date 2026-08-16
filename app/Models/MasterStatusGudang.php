<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusGudang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_status_gudang';

    protected $primaryKey = 'id_status_gudang';

    protected $fillable = [
        'kd_status_gudang',
        'nm_status_gudang',
        'desc_status_gudang',
    ];

    public function gudangs()
    {
        return $this->hasMany(
            MasterGudang::class,
            'fk_status_gudang',
            'id_status_gudang'
        );
    }
}