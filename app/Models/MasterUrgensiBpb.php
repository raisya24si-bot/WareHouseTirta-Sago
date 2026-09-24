<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUrgensiBpb extends Model
{
    protected $table = 'tbl_master_urgensi_bpb';
    protected $primaryKey = 'id_urgensi_bpb';

    public $timestamps = true;

    protected $fillable = [
        'kd_urgensi_bpb', 'nm_urgensi_bpb', 'urutan',
    ];
}