<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpnameDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_opname_detail';
    protected $primaryKey = 'id_opname_detail';

    protected $fillable = [
        'fk_opname', 'fk_lokasi', 'fk_barang',
        'stok_sistem', 'stok_aktual', 'selisih',
        'status_item', 'keterangan',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'fk_opname' => 'integer',
        'fk_lokasi' => 'integer',
        'fk_barang' => 'integer',
        'stok_sistem' => 'integer',
        'stok_aktual' => 'integer',
        'selisih' => 'integer',
    ];

    public function opname(): BelongsTo
    {
        return $this->belongsTo(Opname::class, 'fk_opname', 'id_opname');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(StrukturLokasi::class, 'fk_lokasi', 'id_lokasi');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MasterBarang::class, 'fk_barang', 'id_master_barang');
    }

    /**
     * Hitung ulang selisih & status_item berdasarkan stok_sistem
     * vs stok_aktual yang baru diisi user.
     */
    public function recalculate(): void
    {
        if ($this->stok_aktual === null) {
            $this->selisih = null;
            $this->status_item = 'BELUM DIHITUNG';
            return;
        }

        $this->selisih = $this->stok_aktual - $this->stok_sistem;
        $this->status_item = $this->selisih === 0 ? 'SESUAI' : 'SELISIH';
    }
}
