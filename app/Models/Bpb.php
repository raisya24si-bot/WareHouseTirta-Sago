<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bpb extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_bpb_gudang';
    protected $primaryKey = 'id_bpb';

    protected $fillable = [
        'kd_bpb', 'tgl_bpb', 'desc_bpb',
        'fk_status_bpb', 'fk_tingkat_urgensi', 'fk_gudang_pengambilan',
        'status_spk', 'no_spk',
        'submit_by', 'submit_at',
        'approve_kasubag_by', 'approve_kasubag_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'tgl_bpb' => 'date',
        'submit_at' => 'datetime',
        'approve_kasubag_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function status(): BelongsTo
    {
        return $this->belongsTo(MasterStatusBpb::class, 'fk_status_bpb', 'id_status_bpb');
    }

    public function urgensi(): BelongsTo
    {
        return $this->belongsTo(MasterUrgensiBpb::class, 'fk_tingkat_urgensi', 'id_urgensi_bpb');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(MasterGudang::class, 'fk_gudang_pengambilan', 'id_gudang');
    }

    public function details(): HasMany
    {
        return $this->hasMany(BpbDetail::class, 'fk_bpb', 'id_bpb');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submit_by');
    }

    public function approveKasubagBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_kasubag_by');
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR BANTUAN UNTUK VIEW
    |--------------------------------------------------------------------------
    */

    public function getTotalJenisBarangAttribute(): int
    {
        return $this->details->count();
    }

    public function getTotalKuantitasAttribute(): int
    {
        return (int) $this->details->sum('qty_request');
    }

    public function getKesiapanStokAttribute(): int
    {
        if ($this->details->isEmpty()) {
            return 100;
        }

        $siap = $this->details->filter(
            fn (BpbDetail $item) => $item->qty_available >= $item->qty_request
        )->count();

        return (int) round(($siap / $this->details->count()) * 100);
    }

    public function isDraft(): bool
    {
        return $this->status?->kd_status_bpb === 'DRAFT';
    }

    public function isEditable(): bool
    {
        return in_array($this->status?->kd_status_bpb, ['DRAFT', 'DITOLAK'], true);
    }
}