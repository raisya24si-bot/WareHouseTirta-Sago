<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanReturDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_retur_detail';
    protected $primaryKey = 'id_penerimaan_retur_detail';

    protected $fillable = [
        'fk_penerimaan_retur', 'fk_retur_detail', 'fk_barang',
        'qty_diklaim', 'qty_tiba',
        'fk_bin_tujuan', 'is_masuk_stok',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'qty_diklaim' => 'integer',
        'qty_tiba' => 'integer',
        'is_masuk_stok' => 'boolean',
    ];

    public function penerimaanRetur(): BelongsTo
    {
        return $this->belongsTo(PenerimaanRetur::class, 'fk_penerimaan_retur', 'id_penerimaan_retur');
    }

    public function returDetail(): BelongsTo
    {
        return $this->belongsTo(ReturBarangDetail::class, 'fk_retur_detail', 'id_retur_detail');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    public function binTujuan(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_bin_tujuan', 'id_lokasi');
    }

    public function serials(): HasMany
    {
        return $this->hasMany(PenerimaanReturDetailSerial::class, 'fk_penerimaan_retur_detail', 'id_penerimaan_retur_detail');
    }

    // Dipakai validasi: jumlah serial yang diinput harus pas sama qty_tiba
    public function isJumlahSerialValid(): bool
    {
        return $this->serials()->count() === (int) $this->qty_tiba;
    }
}