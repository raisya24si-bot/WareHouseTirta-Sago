<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRow extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_row';

    protected $primaryKey = 'id_row';

    protected $fillable = [
        'kd_row',
        'fk_rak',
        'status_row',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function rak()
    {
        return $this->belongsTo(
            MasterRak::class,
            'fk_rak',
            'id_rak'
        );
    }

    public function lokasis()
    {
        return $this->hasMany(
            StrukturLokasi::class,
            'fk_row',
            'id_row'
        );
    }
}