<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Po extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_po';
    protected $primaryKey = 'id_po';

    protected $fillable = [
        'kd_po', 'fk_supplier', 'desc_po', 'fk_status_po',
        'submit_by', 'submit_at',
        'approve_kasubag_by', 'approve_kasubag_at',
        'approve_kabag_by', 'apporve_kabag_at',
        'approve_direktur_by', 'approve_direktur_at',
        'reject_by', 'reject_at', 'reject_level', 'reject_note',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'submit_at' => 'datetime',
        'approve_kasubag_at' => 'datetime',
        'apporve_kabag_at' => 'datetime',
        'approve_direktur_at' => 'datetime',
        'reject_at' => 'datetime',
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
            'at_field' => 'apporve_kabag_at',
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


    public function statusPo(): BelongsTo
    {
        return $this->belongsTo(MasterStatusPo::class, 'fk_status_po', 'id_status_po');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(MasterSupplier::class, 'fk_supplier', 'id_master_supplier');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PoDetail::class, 'fk_po', 'id_po');
    }

    public function penerimaanBarangs(): HasMany
    {
        return $this->hasMany(PenerimaanBarang::class, 'fk_po', 'id_po');
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

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reject_by');
    }

    public function getKodeStatusAttribute(): ?string
    {
        return $this->statusPo?->kd_status_po;
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

    public function canBeReceived(): bool
    {
        if (! $this->isApproved()) {
            return false;
        }

        return ! $this->penerimaanBarangs()
            ->whereHas('statusPenerimaan', function ($query) {

                $query->where('kd_status_penerimaan_barang', '!=', 'REJECTED');
            })
            ->exists();
    }
}