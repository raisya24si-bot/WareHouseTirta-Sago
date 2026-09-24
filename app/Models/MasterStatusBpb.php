<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterStatusBpb extends Model
{
    protected $table = 'tbl_master_status_bpb';
    protected $primaryKey = 'id_status_bpb';

    public $timestamps = true;

    protected $fillable = [
        'kd_status_bpb', 'nm_status_bpb', 'urutan',
    ];
}