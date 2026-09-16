<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturBarangFoto extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_retur_barang_foto';
    protected $primaryKey = 'id_retur_foto';

    protected $fillable = [
        'fk_retur_detail',
        'nama_file', 'path_file', 'mime_type', 'ukuran_file',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'fk_retur_detail' => 'integer',
        'ukuran_file' => 'integer',
    ];

    public function detail(): BelongsTo
    {
        return $this->belongsTo(ReturBarangDetail::class, 'fk_retur_detail', 'id_retur_detail');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // URL publik buat ditampilkan di <img>, sesuaikan disk storage kamu
    public function getUrlAttribute(): ?string
    {
        return $this->path_file ? asset('storage/'.$this->path_file) : null;
    }
}