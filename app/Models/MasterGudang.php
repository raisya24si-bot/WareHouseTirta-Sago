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
        'kd_gudang',
        'nm_gudang',
        'desc_gudang',
        'kepala_gudang',
        'alamat_gudang',
        'fk_status_gudang',
        'fk_kategori_gudang',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fk_status_gudang' => 'integer',
        'fk_kategori_gudang' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function statusGudang(): BelongsTo
    {
        return $this->belongsTo(
            MasterStatusGudang::class,
            'fk_status_gudang',
            'id_status_gudang'
        );
    }

    public function kategoriGudang(): BelongsTo
    {
        return $this->belongsTo(
            MasterKategoriGudang::class,
            'fk_kategori_gudang',
            'id_kategori_gudang'
        );
    }

    public function raks(): HasMany
    {
        return $this->hasMany(
            MasterRak::class,
            'fk_gudang',
            'id_gudang'
        );
    }
}