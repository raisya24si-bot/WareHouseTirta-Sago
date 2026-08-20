<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Opname extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tbl_opname';
    protected $primaryKey = 'id_opname';

    protected $fillable = [
        'kd_opname', 'fk_gudang', 'tgl_mulai', 'tgl_selesai',
        'status_opname', 'catatan',
        'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'fk_gudang' => 'integer',
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'created_by' => 'integer', 'updated_by' => 'integer', 'deleted_by' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $opname) {
            if (empty($opname->kd_opname)) {
                $year = now()->year;
                $count = self::withTrashed()->whereYear('created_at', $year)->count();
                $opname->kd_opname = 'OPN-' . $year . '-' . str_pad((string) ($count + 1), 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(MasterGudang::class, 'fk_gudang', 'id_gudang');
    }

    public function lokasis(): BelongsToMany
    {
        return $this->belongsToMany(
            StrukturLokasi::class,
            'tbl_opname_lokasi',
            'fk_opname',
            'fk_lokasi',
            'id_opname',
            'id_lokasi'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(OpnameDetail::class, 'fk_opname', 'id_opname');
    }

    /**
     * Persentase progress opname: berapa % baris detail yang
     * sudah diisi stok aktualnya.
     */
    public function getProgressAttribute(): int
    {
        $total = $this->details_count ?? $this->details()->count();

        if ($total === 0) {
            return 0;
        }

        $counted = $this->details_counted_count ?? $this->details()->whereNotNull('stok_aktual')->count();

        return (int) round(($counted / $total) * 100);
    }

    public function getHasSelisihAttribute(): bool
    {
        return ($this->details_selisih_count ?? $this->details()->where('status_item', 'SELISIH')->count()) > 0;
    }
}
