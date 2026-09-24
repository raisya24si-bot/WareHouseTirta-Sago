<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BpbDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_bpb_gudang_detail';
    protected $primaryKey = 'id_bpb_detail';

    protected $fillable = [
        'fk_bpb', 'fk_barang', 'fk_bin',
        'qty_request', 'qty_available', 'catatan',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'fk_bpb' => 'integer',
        'fk_barang' => 'integer',
        'fk_bin' => 'integer',
        'qty_request' => 'integer',
        'qty_available' => 'integer',
    ];

    public function bpb(): BelongsTo
    {
        return $this->belongsTo(Bpb::class, 'fk_bpb', 'id_bpb');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    public function bin(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_bin', 'id_lokasi');
    }

    public function isStokAman(): bool
    {
        return $this->qty_available >= $this->qty_request;
    }
}