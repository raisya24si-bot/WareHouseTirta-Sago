<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKategori extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_kategori';
    protected $primaryKey = 'id_master_kategori';

    protected $fillable = [
        'kd_master_kategori', 'nm_master_kategori', 'desc_master_kategori',
        'status_master_kategori', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'created_by' => 'integer', 'updated_by' => 'integer', 'deleted_by' => 'integer',
        'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (self $kategori) {
            $kategori->updateQuietly([
                'kd_master_kategori' => 'KAT-' . str_pad((string) $kategori->id_master_kategori, 3, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function masterBarangs(): HasMany
    {
        return $this->hasMany(MasterBarang::class, 'fk_kategori', 'id_master_kategori');
    }
}
