<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterStatusPenerimaanRetur extends Model
{
    protected $table = 'tbl_master_status_penerimaan_retur';
    protected $primaryKey = 'id_status_penerimaan_retur';

    protected $fillable = [
        'kd_status_penerimaan_retur',
        'nm_status_penerimaan_retur',
        'urutan',
    ];

    public const GROUP_DALAM_PROSES = ['MENUNGGU_KEDATANGAN', 'PROSES_QC'];
    public const GROUP_SELESAI = ['SELESAI'];

    public function penerimaanReturs(): HasMany
    {
        return $this->hasMany(PenerimaanRetur::class, 'fk_status_penerimaan_retur', 'id_status_penerimaan_retur');
    }
}