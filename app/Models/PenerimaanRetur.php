<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanRetur extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_retur';
    protected $primaryKey = 'id_penerimaan_retur';

    protected $fillable = [
        'kd_penerimaan_retur',
        'fk_retur', 'no_sj_supplier',
        'fk_status_penerimaan_retur',
        'waktu_tiba_dock', 'dock_number',
        'catatan_verifikasi', 'is_consent_verifikasi',
        'submit_by', 'submit_at',
        'selesai_by', 'selesai_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'waktu_tiba_dock' => 'datetime',
        'is_consent_verifikasi' => 'boolean',
        'submit_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function returBarang(): BelongsTo
    {
        return $this->belongsTo(ReturBarang::class, 'fk_retur', 'id_retur');
    }

    public function statusPenerimaanRetur(): BelongsTo
    {
        return $this->belongsTo(MasterStatusPenerimaanRetur::class, 'fk_status_penerimaan_retur', 'id_status_penerimaan_retur');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenerimaanReturDetail::class, 'fk_penerimaan_retur', 'id_penerimaan_retur');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submit_by');
    }

    public function selesaiBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'selesai_by');
    }

    // Supplier & GRN asal ikut BAP Retur, nggak disimpan ulang di sini.
    public function getSupplierAttribute()
    {
        return $this->returBarang?->supplier;
    }

    public function getKodeStatusAttribute(): ?string
    {
        return $this->statusPenerimaanRetur?->kd_status_penerimaan_retur;
    }

    public function isDalamProses(): bool
    {
        return in_array($this->kode_status, MasterStatusPenerimaanRetur::GROUP_DALAM_PROSES, true);
    }

    public function isSelesai(): bool
    {
        return in_array($this->kode_status, MasterStatusPenerimaanRetur::GROUP_SELESAI, true);
    }

    public function totalQtyTiba(): int
    {
        return (int) $this->details->sum('qty_tiba');
    }
}