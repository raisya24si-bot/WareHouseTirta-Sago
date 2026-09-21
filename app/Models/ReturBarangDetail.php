<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturBarangDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_retur_barang_detail';
    protected $primaryKey = 'id_retur_detail';

    protected $fillable = [
        'fk_retur', 'fk_penerimaan_barang_detail', 'fk_barang',
        'qty_reject_qc', 'qty_diretur',
        'harga_satuan', 'subtotal_retur',
        'catatan_detail',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'qty_reject_qc' => 'integer',
        'qty_diretur' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal_retur' => 'decimal:2',
    ];

    public function returBarang(): BelongsTo
    {
        return $this->belongsTo(ReturBarang::class, 'fk_retur', 'id_retur');
    }

    public function penerimaanBarangDetail(): BelongsTo
    {
        return $this->belongsTo(PenerimaanBarangDetail::class, 'fk_penerimaan_barang_detail', 'id_penerimaan_barang_detail');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    // Multi-select alasan kerusakan (chip di form)
    public function alasan(): BelongsToMany
    {
        return $this->belongsToMany(
            MasterAlasanRetur::class,
            'tbl_retur_barang_detail_alasan',
            'fk_retur_detail',
            'fk_alasan_retur'
        )->withTimestamps();
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(ReturBarangFoto::class, 'fk_retur_detail', 'id_retur_detail');
    }

    // Dipanggil sebelum save, biar subtotal selalu konsisten
    public function hitungSubtotal(): float
    {
        return (float) $this->qty_diretur * (float) $this->harga_satuan;
    }
}