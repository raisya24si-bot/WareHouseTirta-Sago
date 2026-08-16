<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterGudang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_gudang';
    protected $primaryKey = 'id_gudang';

    protected $fillable = [
        'kd_gudang', 'nm_gudang', 'desc_gudang', 'kepala_gudang', 'alamat_gudang', 'fk_status_gudang',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function statusGudang(): BelongsTo
    {
        return $this->belongsTo(
            MasterStatusGudang::class,
            'fk_status_gudang',
            'id_status_gudang'
        );
    }

    public function raks(): HasMany
    {
        return $this->hasMany(MasterRak::class, 'fk_gudang', 'id_gudang');
    }
}
