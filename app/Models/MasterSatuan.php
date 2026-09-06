<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSatuan extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_satuan';
    protected $primaryKey = 'id_master_satuan';

    protected $fillable = [
        'kd_master_satuan', 'nm_master_satuan', 'desc_master_satuan',
        'status_master_satuan', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'created_by' => 'integer', 'updated_by' => 'integer', 'deleted_by' => 'integer',
        'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (self $satuan) {
            $satuan->updateQuietly([
                'kd_master_satuan' => 'SAT-' . str_pad((string) $satuan->id_master_satuan, 3, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function masterBarangs(): HasMany
    {
        return $this->hasMany(MasterBarang::class, 'fk_satuan', 'id_master_satuan');
    }
}
