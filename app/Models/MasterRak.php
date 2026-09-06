<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRak extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_rak';
    protected $primaryKey = 'id_rak';

    protected $fillable = [
        'kd_rak', 'fk_gudang', 'status_rak',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(MasterGudang::class, 'fk_gudang', 'id_gudang');
    }

    public function rows(): HasMany
    {
        return $this->hasMany(MasterRow::class, 'fk_rak', 'id_rak');
    }
}
