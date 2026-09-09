<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanBarangBuktiDukung extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_penerimaan_barang_bukti_dukung';

    protected $primaryKey =
        'id_penerimaan_barang_bukti_dukung';

    protected $fillable = [
        'fk_penerimaan_barang',

        'nama_file',
        'path_file',
        'mime_type',
        'ukuran_file',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fk_penerimaan_barang' => 'integer',
        'ukuran_file' => 'integer',

        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function penerimaanBarang(): BelongsTo
    {
        return $this->belongsTo(
            PenerimaanBarang::class,
            'fk_penerimaan_barang',
            'id_penerimaan'
        );
    }
}