<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterAlasanRetur extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_alasan_retur';
    protected $primaryKey = 'id_alasan_retur';

    protected $fillable = [
        'kd_alasan_retur',
        'nm_alasan_retur',
        'status_alasan_retur',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function detailReturs(): BelongsToMany
    {
        return $this->belongsToMany(
            ReturBarangDetail::class,
            'tbl_retur_barang_detail_alasan',
            'fk_alasan_retur',
            'fk_retur_detail'
        )->withTimestamps();
    }

    public function scopeAktif($query)
    {
        return $query->where('status_alasan_retur', 'AKTIF');
    }
}