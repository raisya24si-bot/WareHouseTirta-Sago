<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSupplier extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_master_supplier';

    protected $primaryKey = 'id_master_supplier';

    protected $fillable = [
        'kd_master_supplier',
        'nm_master_supplier',
        'alamat_supplier',
        'kontak_supplier',
        'status_master_supplier',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    protected static function booted(): void
    {
        static::created(function (self $supplier) {
            $supplier->updateQuietly([
                'kd_master_supplier' => 'SUP-'
                    . str_pad(
                        (string) $supplier->id_master_supplier,
                        3,
                        '0',
                        STR_PAD_LEFT
                    ),
            ]);
        });
    }
}