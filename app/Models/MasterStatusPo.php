<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterStatusPo extends Model
{
    protected $table = 'tbl_master_status_po';
    protected $primaryKey = 'id_status_po';

    protected $fillable = ['kd_status_po', 'nm_status_po', 'urutan'];

    public function pos(): HasMany
    {
        return $this->hasMany(Po::class, 'fk_status_po', 'id_status_po');
    }
}