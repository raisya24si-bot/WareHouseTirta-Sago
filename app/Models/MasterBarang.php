<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_barang';
    protected $primaryKey = 'id_master_barang';

    protected $fillable = [
        'kd_master_barang', 'nm_master_barang', 'desc_master_barang',
        'minimum_stok', 'stok_saat_ini', 'stok_status', 'status_master_barang',
        'fk_kategori', 'fk_satuan', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'minimum_stok' => 'integer', 'stok_saat_ini' => 'integer',
        'fk_kategori' => 'integer', 'fk_satuan' => 'integer',
        'created_by' => 'integer', 'updated_by' => 'integer', 'deleted_by' => 'integer',
        'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $barang) {
            $barang->stok_status = self::calculateStockStatus((int) $barang->stok_saat_ini, (int) $barang->minimum_stok);
        });

        static::updating(function (self $barang) {
            if ($barang->isDirty(['stok_saat_ini', 'minimum_stok'])) {
                $barang->stok_status = self::calculateStockStatus((int) $barang->stok_saat_ini, (int) $barang->minimum_stok);
            }
        });

        static::created(function (self $barang) {
            $barang->updateQuietly([
                'kd_master_barang' => 'BRG-' . str_pad((string) $barang->id_master_barang, 3, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public static function calculateStockStatus(int $stok, int $minimum): string
    {
        if ($stok <= 0) return 'HABIS';
        if ($stok <= $minimum) return 'MENIPIS';
        return 'NORMAL';
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MasterKategori::class, 'fk_kategori', 'id_master_kategori');
    }

    public function category(): BelongsTo
    {
        return $this->kategori();
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(MasterSatuan::class, 'fk_satuan', 'id_master_satuan');
    }

    /**
     * Sebaran stok barang ini per bin/lokasi (banyak lokasi
     * sekaligus). Sumber data untuk modul Stock Opname.
     */
    public function stokLokasis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StokLokasi::class, 'fk_barang', 'id_master_barang');
    }
}
