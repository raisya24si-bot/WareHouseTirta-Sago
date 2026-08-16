<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokLokasi extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_stok_lokasi';
    protected $primaryKey = 'id_stok_lokasi';

    protected $fillable = [
        'fk_barang', 'fk_lokasi', 'qty_stok',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'qty_stok' => 'integer',
        'fk_barang' => 'integer',
        'fk_lokasi' => 'integer',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_lokasi', 'id_lokasi');
    }
}
