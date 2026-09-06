<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKategoriGudang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_kategori_gudang';

    protected $primaryKey = 'id_kategori_gudang';

    protected $fillable = [
        'kd_kategori_gudang',
        'nm_kategori_gudang',
        'desc_kategori_gudang',
        'status_kategori_gudang',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function gudangs(): HasMany
    {
        return $this->hasMany(
            MasterGudang::class,
            'fk_kategori_gudang',
            'id_kategori_gudang'
        );
    }
}