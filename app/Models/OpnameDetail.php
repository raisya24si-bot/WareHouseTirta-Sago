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
        'fk_opname',
        'fk_lokasi',
        'fk_barang',

        'stok_sistem',
        'stok_aktual',
        'stok_rusak',
        'selisih',

        'status_item',
        'keterangan',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fk_opname' => 'integer',
        'fk_lokasi' => 'integer',
        'fk_barang' => 'integer',

        'stok_sistem' => 'integer',
        'stok_aktual' => 'integer',
        'stok_rusak' => 'integer',
        'selisih' => 'integer',

        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function opname(): BelongsTo
    {
        return $this->belongsTo(
            Opname::class,
            'fk_opname',
            'id_opname'
        );
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(
            StrukturLokasi::class,
            'fk_lokasi',
            'id_lokasi'
        );
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(
            MasterBarang::class,
            'fk_barang',
            'id_master_barang'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | JUMLAH BARANG BAIK
    |--------------------------------------------------------------------------
    |
    | Actual = total barang fisik yang ditemukan
    |
    | Baik = Actual - Rusak
    |
    | Contoh:
    |
    | Sistem = 5
    | Actual = 5
    | Rusak  = 2
    |
    | Baik = 5 - 2 = 3
    |
    */

    public function getStokBaikAttribute(): ?int
    {
        if ($this->stok_aktual === null) {
            return null;
        }

        return max(
            0,
            (int) $this->stok_aktual
            -
            (int) ($this->stok_rusak ?? 0)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG SELISIH
    |--------------------------------------------------------------------------
    |
    | Selisih membandingkan TOTAL FISIK dengan STOK SISTEM.
    |
    | Actual = 5
    | Sistem = 5
    |
    | Selisih = 0
    |
    */

    public function recalculate(): void
    {
        /*
        | Belum dihitung
        */

        if ($this->stok_aktual === null) {

            $this->selisih = null;

            $this->status_item =
                'BELUM DIHITUNG';

            return;
        }

        $actual =
            (int) $this->stok_aktual;

        $rusak =
            (int) ($this->stok_rusak ?? 0);


        if ($rusak > $actual) {

            $this->selisih = null;

            $this->status_item =
                'SELISIH';

            return;
        }


        $this->selisih =
            $actual
            -
            (int) $this->stok_sistem;


        $this->status_item =
            $this->selisih === 0
                ? 'SESUAI'
                : 'SELISIH';
    }


    public function setActual(
        int $actual,
        int $rusak = 0
    ): void {

        $this->stok_aktual =
            $actual;

        $this->stok_rusak =
            $rusak;

        $this->recalculate();
    }
}