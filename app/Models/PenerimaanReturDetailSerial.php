<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanReturDetailSerial extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_retur_detail_serial';
    protected $primaryKey = 'id_penerimaan_retur_detail_serial';

    protected $fillable = [
        'fk_penerimaan_retur_detail',
        'no_seri',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function detail(): BelongsTo
    {
        return $this->belongsTo(PenerimaanReturDetail::class, 'fk_penerimaan_retur_detail', 'id_penerimaan_retur_detail');
    }
}