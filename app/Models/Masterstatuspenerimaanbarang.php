<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterStatusPenerimaanBarang extends Model
{
    protected $table = 'tbl_master_status_penerimaan_barang';
    protected $primaryKey = 'id_status_penerimaan_barang';

    protected $fillable = [
        'kd_status_penerimaan_barang',
        'nm_status_penerimaan_barang',
        'urutan',
    ];

    public function penerimaanBarangs(): HasMany
    {
        return $this->hasMany(PenerimaanBarang::class, 'fk_status_penerimaan_barang', 'id_status_penerimaan_barang');
    }
}