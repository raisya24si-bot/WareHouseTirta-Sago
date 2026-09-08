<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_barang';
    protected $primaryKey = 'id_penerimaan';

    protected $fillable = [
        'kd_penerimaan', 'tgl_penerimaan_barang', 'fk_po',
        'no_sjinv_supplier', 'desc_penerimaan_barang', 'fk_status_penerimaan_barang',
        'submit_by', 'submit_at',
        'approve_kasubag_by', 'approve_kasubag_at',
        'approve_kabag_by', 'approve_kabag_at',
        'approve_direktur_by', 'approve_direktur_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'tgl_penerimaan_barang' => 'date',
        'submit_at' => 'datetime',
        'approve_kasubag_at' => 'datetime',
        'approve_kabag_at' => 'datetime',
        'approve_direktur_at' => 'datetime',
    ];

    public const LEVELS = [
        'kasubag' => [
            'order' => 1,
            'label' => 'Kasubag',
            'status' => 'PENDING_KASUBAG',
            'next_status' => 'PENDING_KABAG',
            'by_field' => 'approve_kasubag_by',
            'at_field' => 'approve_kasubag_at',
        ],
        'kabag' => [
            'order' => 2,
            'label' => 'Kabag',
            'status' => 'PENDING_KABAG',
            'next_status' => 'PENDING_DIREKTUR',
            'by_field' => 'approve_kabag_by',
            'at_field' => 'approve_kabag_at',
        ],
        'direktur' => [
            'order' => 3,
            'label' => 'Direktur',
            'status' => 'PENDING_DIREKTUR',
            'next_status' => 'APPROVED',
            'by_field' => 'approve_direktur_by',
            'at_field' => 'approve_direktur_at',
        ],
    ];


    public function statusPenerimaan(): BelongsTo
    {
        return $this->belongsTo(MasterStatusPenerimaanBarang::class, 'fk_status_penerimaan_barang', 'id_status_penerimaan_barang');
    }

    public function po(): BelongsTo
    {
        return $this->belongsTo(Po::class, 'fk_po', 'id_po');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenerimaanBarangDetail::class, 'fk_penerimaan_barang', 'id_penerimaan');
    }

    public function buktiDukungs(): HasMany
    {
        return $this->hasMany(PenerimaanBarangBuktiDukung::class, 'fk_penerimaan_barang', 'id_penerimaan');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submit_by');
    }

    public function kasubagBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_kasubag_by');
    }

    public function kabagBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_kabag_by');
    }

    public function direkturBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_direktur_by');
    }

    public function getKodeStatusAttribute(): ?string
    {
        return $this->statusPenerimaan?->kd_status_penerimaan_barang;
    }


    public function canBeEdited(): bool
    {
        return in_array($this->kode_status, ['DRAFT', 'REJECTED'], true);
    }

    public function isRejected(): bool
    {
        return $this->kode_status === 'REJECTED';
    }

    public function isApproved(): bool
    {
        return $this->kode_status === 'APPROVED';
    }

    public function isPendingAt(string $level): bool
    {
        return isset(self::LEVELS[$level])
            && $this->kode_status === self::LEVELS[$level]['status'];
    }

    public function hasPassedLevel(string $level): bool
    {
        if (! isset(self::LEVELS[$level])) {
            return false;
        }

        return ! is_null($this->{self::LEVELS[$level]['at_field']});
    }

    public function currentLevelOrder(): ?int
    {
        foreach (self::LEVELS as $config) {

            if ($config['status'] === $this->kode_status) {
                return $config['order'];
            }
        }

        return null;
    }


    public function totalSku(): int
    {
        return $this->details->count();
    }

    public function totalQtyRequest(): int
    {
        return (int) $this->details->sum('qty_request');
    }
}