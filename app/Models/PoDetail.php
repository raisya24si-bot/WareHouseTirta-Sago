<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_po_detail';
    protected $primaryKey = 'id_po_detail';

    protected $fillable = [
        'fk_po', 'fk_barang',
        'qty_stok_at_request', 'qty_min_stok_at_request', 'qty_request',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'qty_stok_at_request' => 'integer',
        'qty_min_stok_at_request' => 'integer',
        'qty_request' => 'integer',
    ];

    public function po(): BelongsTo
    {
        return $this->belongsTo(Po::class, 'fk_po', 'id_po');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }
}