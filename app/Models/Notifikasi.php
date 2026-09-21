<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Notifikasi extends Model
{
    protected $table = 'tbl_notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'tipe', 'judul', 'pesan', 'fk_barang', 'fk_opname', 'data', 'dibaca_at',
    ];

    protected $casts = [
        'data' => 'array',
        'dibaca_at' => 'datetime',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    public function opname(): BelongsTo
    {
        return $this->belongsTo(Opname::class, 'fk_opname', 'id_opname');
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('dibaca_at');
    }

    public function isRead(): bool
    {
        return $this->dibaca_at !== null;
    }

    /*
    |--------------------------------------------------------------------------
    | TAMPILAN (icon, warna, link tujuan) PER TIPE
    |--------------------------------------------------------------------------
    */

    public function getIconAttribute(): string
    {
        return match ($this->tipe) {
            'STOK_HABIS' => 'production_quantity_limits',
            'OPNAME_SELISIH' => 'warning',
            'BARANG_MASUK' => 'move_to_inbox',
            default => 'notifications',
        };
    }

    public function getColorAttribute(): string
    {
        return match ($this->tipe) {
            'STOK_HABIS' => 'red',
            'OPNAME_SELISIH' => 'amber',
            'BARANG_MASUK' => 'green',
            default => 'primary',
        };
    }

    public function getUrlAttribute(): string
    {
        if ($this->fk_opname && $this->opname) {
            return route('opname.show', $this->fk_opname);
        }

        if ($this->fk_barang && $this->barang) {
            return route('manajemen-stok.show', $this->fk_barang);
        }

        return route('notifikasi.index');
    }
}
