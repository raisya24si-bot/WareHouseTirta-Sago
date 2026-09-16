<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_retur_barang';
    protected $primaryKey = 'id_retur';

    protected $fillable = [
        'kd_retur', 'tgl_retur',
        'fk_penerimaan_barang', 'fk_status_retur',
        'catatan_retur',
        'nilai_total_retur', 'nilai_terselamatkan',
        'no_resi_pengiriman', 'nm_ekspedisi', 'estimasi_hari',
        'submit_by', 'submit_at',
        'selesai_by', 'selesai_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'tgl_retur' => 'date',
        'nilai_total_retur' => 'decimal:2',
        'nilai_terselamatkan' => 'decimal:2',
        'submit_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function penerimaanBarang(): BelongsTo
    {
        return $this->belongsTo(PenerimaanBarang::class, 'fk_penerimaan_barang', 'id_penerimaan');
    }

    public function statusRetur(): BelongsTo
    {
        return $this->belongsTo(MasterStatusRetur::class, 'fk_status_retur', 'id_status_retur');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ReturBarangDetail::class, 'fk_retur', 'id_retur');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submit_by');
    }

    public function selesaiBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'selesai_by');
    }

    // Supplier ikut GRN -> PO, nggak disimpan ulang di tabel ini.
    public function getSupplierAttribute()
    {
        return $this->penerimaanBarang?->po?->supplier;
    }

    public function getKodeStatusAttribute(): ?string
    {
        return $this->statusRetur?->kd_status_retur;
    }

    public function isDalamProses(): bool
    {
        return in_array($this->kode_status, MasterStatusRetur::GROUP_DALAM_PROSES, true);
    }

    public function isSelesai(): bool
    {
        return in_array($this->kode_status, MasterStatusRetur::GROUP_SELESAI, true);
    }

    public function totalItemReject(): int
    {
        return (int) $this->details->sum('qty_diretur');
    }
}