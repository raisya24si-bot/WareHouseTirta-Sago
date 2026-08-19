<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokLokasi extends Model
{
    protected $table = 'tbl_stok_lokasi';

    protected $primaryKey = 'id_stok_lokasi';

    protected $fillable = [
        'fk_barang',
        'fk_lokasi',
        'qty_stok',
        'qty_rusak',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fk_barang' => 'integer',
        'fk_lokasi' => 'integer',
        'qty_stok' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(
            MasterBarang::class,
            'fk_barang',
            'id_master_barang'
        );
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(
            StrukturLokasi::class,
            'fk_lokasi',
            'id_lokasi'
        );
    }
}