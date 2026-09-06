<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. MASTER KATEGORI GUDANG
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasTable('tbl_master_kategori_gudang')) {
            Schema::create('tbl_master_kategori_gudang', function (Blueprint $table) {
                $table->id('id_kategori_gudang');

                $table->string('kd_kategori_gudang', 20)
                    ->unique();

                $table->string('nm_kategori_gudang', 50)
                    ->unique();

                $table->text('desc_kategori_gudang')
                    ->nullable();

                $table->string('status_kategori_gudang', 20)
                    ->default('AKTIF');

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('status_kategori_gudang');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 2. DEFAULT KATEGORI GUDANG
        |--------------------------------------------------------------------------
        */

        $kategoriDefault = [
            [
                'kd_kategori_gudang' => 'STORAGE',
                'nm_kategori_gudang' => 'Storage',
                'desc_kategori_gudang' => 'Gudang utama untuk penyimpanan barang.',
                'status_kategori_gudang' => 'AKTIF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_kategori_gudang' => 'TRANSIT',
                'nm_kategori_gudang' => 'Transit',
                'desc_kategori_gudang' => 'Gudang untuk barang yang sedang dalam proses perpindahan.',
                'status_kategori_gudang' => 'AKTIF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kd_kategori_gudang' => 'REJECTED',
                'nm_kategori_gudang' => 'Rejected',
                'desc_kategori_gudang' => 'Gudang untuk barang rusak atau ditolak.',
                'status_kategori_gudang' => 'AKTIF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kategoriDefault as $kategori) {
            DB::table('tbl_master_kategori_gudang')
                ->updateOrInsert(
                    [
                        'kd_kategori_gudang' => $kategori['kd_kategori_gudang'],
                    ],
                    $kategori
                );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. TAMBAHKAN KATEGORI KE GUDANG
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasColumn('tbl_master_gudang', 'fk_kategori_gudang')) {
            Schema::table('tbl_master_gudang', function (Blueprint $table) {
                $table->unsignedBigInteger('fk_kategori_gudang')
                    ->nullable()
                    ->after('fk_status_gudang');

                $table->index('fk_kategori_gudang');

                $table->foreign('fk_kategori_gudang')
                    ->references('id_kategori_gudang')
                    ->on('tbl_master_kategori_gudang')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 4. TAMBAHKAN STOK RUSAK PADA STOK LOKASI
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasColumn('tbl_stok_lokasi', 'qty_rusak')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->unsignedInteger('qty_rusak')
                    ->default(0)
                    ->after('qty_stok');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 5. TAMBAHKAN STOK BAIK DAN RUSAK PADA DETAIL OPNAME
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasColumn('tbl_opname_detail', 'stok_baik')) {
            Schema::table('tbl_opname_detail', function (Blueprint $table) {
                $table->unsignedInteger('stok_baik')
                    ->nullable()
                    ->after('stok_aktual');

                $table->unsignedInteger('stok_rusak')
                    ->default(0)
                    ->after('stok_baik');
            });
        }
    }

    public function down(): void
    {
        /*
        | Jangan hapus kategori gudang kalau masih dipakai gudang.
        */

        if (Schema::hasColumn('tbl_opname_detail', 'stok_rusak')) {
            Schema::table('tbl_opname_detail', function (Blueprint $table) {
                $table->dropColumn('stok_rusak');
            });
        }

        if (Schema::hasColumn('tbl_opname_detail', 'stok_baik')) {
            Schema::table('tbl_opname_detail', function (Blueprint $table) {
                $table->dropColumn('stok_baik');
            });
        }

        if (Schema::hasColumn('tbl_stok_lokasi', 'qty_rusak')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->dropColumn('qty_rusak');
            });
        }

        if (Schema::hasColumn('tbl_master_gudang', 'fk_kategori_gudang')) {
            Schema::table('tbl_master_gudang', function (Blueprint $table) {
                $table->dropForeign(['fk_kategori_gudang']);
                $table->dropColumn('fk_kategori_gudang');
            });
        }

        Schema::dropIfExists('tbl_master_kategori_gudang');
    }
};