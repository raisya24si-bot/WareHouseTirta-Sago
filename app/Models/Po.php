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
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'submit_at' => 'datetime',
        'approve_kasubag_at' => 'datetime',
        'apporve_kabag_at' => 'datetime',
        'approve_direktur_at' => 'datetime',
    ];


    public const PROGRESSION = [
        'DRAFT' => ['next' => 'PENDING_KASUBAG', 'by' => 'submit_by', 'at' => 'submit_at', 'label' => 'Submit'],
        'PENDING_KASUBAG' => ['next' => 'PENDING_KABAG', 'by' => 'approve_kasubag_by', 'at' => 'approve_kasubag_at', 'label' => 'Kasubag'],
        'PENDING_KABAG' => ['next' => 'PENDING_DIREKTUR', 'by' => 'approve_kabag_by', 'at' => 'apporve_kabag_at', 'label' => 'Kabag'],
        'PENDING_DIREKTUR' => ['next' => 'APPROVED', 'by' => 'approve_direktur_by', 'at' => 'approve_direktur_at', 'label' => 'Direktur'],
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
        return $this->statusPo?->kd_status_po;
    }

    public function canBeEdited(): bool
    {
        return $this->kode_status !== 'APPROVED';
    }


    public function nextProgression(): ?array
    {
        return self::PROGRESSION[$this->kode_status] ?? null;
    }

    public function isRejected(): bool
    {
        return $this->kode_status === 'REJECTED';
    }

    public function isApproved(): bool
    {
        return $this->kode_status === 'APPROVED';
    }
}