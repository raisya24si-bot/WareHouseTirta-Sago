<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturLokasi extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_lokasi';

    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'kd_lokasi',
        'fk_row',
        'bin',
        'status_lokasi',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function row()
    {
        return $this->belongsTo(
            MasterRow::class,
            'fk_row',
            'id_row'
        );
    }

    public function stokLokasis()
    {
        return $this->hasMany(
            StokLokasi::class,
            'fk_lokasi',
            'id_lokasi'
        );
    }
}