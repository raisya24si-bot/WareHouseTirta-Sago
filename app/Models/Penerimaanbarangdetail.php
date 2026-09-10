<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanBarangDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_barang_detail';
    protected $primaryKey = 'id_penerimaan_barang_detail';

    protected $fillable = [
        'fk_penerimaan_barang', 'fk_barang', 'fk_lokasi_barang', 'fk_lokasi_karantina',
        'qty_request', 'qty_baik', 'qty_rusak', 'harga_satuan',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'qty_request' => 'integer',
        'qty_baik' => 'integer',
        'qty_rusak' => 'integer',
        'harga_satuan' => 'integer',
    ];

    public function penerimaanBarang(): BelongsTo
    {
        return $this->belongsTo(PenerimaanBarang::class, 'fk_penerimaan_barang', 'id_penerimaan');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_lokasi_barang', 'id_lokasi');
    }

    public function lokasiKarantina(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_lokasi_karantina', 'id_lokasi');
    }

    public function getSelisihAttribute(): int
    {
        return (int) $this->qty_request - ((int) $this->qty_baik + (int) $this->qty_rusak);
    }
}