<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_master_kategori', function (Blueprint $table) {
            $table->id('id_master_kategori');

            $table->string('kd_master_kategori', 20)
                ->nullable()
                ->unique();

            $table->string('nm_master_kategori', 100)
                ->unique();

            $table->text('desc_master_kategori')
                ->nullable();

            $table->string('status_master_kategori', 20)
                ->default('AKTIF');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status_master_kategori');
        });


        Schema::create('tbl_master_satuan', function (Blueprint $table) {
            $table->id('id_master_satuan');

            $table->string('kd_master_satuan', 20)
                ->nullable()
                ->unique();

            $table->string('nm_master_satuan', 50)
                ->unique();

            $table->text('desc_master_satuan')
                ->nullable();

            $table->string('status_master_satuan', 20)
                ->default('AKTIF');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status_master_satuan');
        });


        Schema::create('tbl_master_supplier', function (Blueprint $table) {
            $table->id('id_master_supplier');

            $table->string('kd_master_supplier', 20)
                ->nullable()
                ->unique();

            $table->string('nm_master_supplier', 100)
                ->unique();

            $table->text('alamat_supplier')
                ->nullable();

            $table->string('kontak_supplier', 13)
                ->nullable();

            $table->string('status_master_supplier', 20)
                ->default('AKTIF');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status_master_supplier');
        });


        Schema::create('tbl_master_status_gudang', function (Blueprint $table) {
            $table->id('id_status_gudang');

            $table->string('kd_status_gudang', 20)
                ->unique();

            $table->string('nm_status_gudang', 50)
                ->unique();

            $table->text('desc_status_gudang')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('nm_status_gudang');
        });


        // =====================================================
        // MASTER GUDANG
        // =====================================================

        Schema::create('tbl_master_gudang', function (Blueprint $table) {
            $table->id('id_gudang');

            // Kode dibuat otomatis oleh aplikasi
            // Contoh: GU1, GU2, GU3
            $table->string('kd_gudang', 20)
                ->unique();

            $table->string('nm_gudang', 50);

            $table->string('desc_gudang', 100)
                ->nullable();

            // Relasi status gudang
            $table->unsignedBigInteger('fk_status_gudang');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('fk_status_gudang');
            $table->index('nm_gudang');

            // Foreign Key
            $table->foreign('fk_status_gudang')
                ->references('id_status_gudang')
                ->on('tbl_master_status_gudang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });


Schema::create('tbl_master_rak', function (Blueprint $table) {
    $table->id('id_rak');

    // Kode otomatis hierarkis: {kd_gudang}.{urutan 2 digit}
    // Contoh: GU1.01, GU1.02
    $table->string('kd_rak', 30)
        ->unique();

    // Relasi ke gudang
    $table->unsignedBigInteger('fk_gudang');

    // Status
    $table->string('status_rak', 20)
        ->default('AKTIF');

    // Audit
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->unsignedBigInteger('deleted_by')->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->foreign('fk_gudang')
        ->references('id_gudang')
        ->on('tbl_master_gudang')
        ->cascadeOnUpdate()
        ->restrictOnDelete();

    $table->index('fk_gudang');
    $table->index('status_rak');
});


Schema::create('tbl_master_row', function (Blueprint $table) {
    $table->id('id_row');

    // Kode otomatis hierarkis: {kd_rak}.{urutan 2 digit}
    // Contoh: GU1.01.01, GU1.01.02
    $table->string('kd_row', 30)
        ->unique();

    // Relasi ke rak
    $table->unsignedBigInteger('fk_rak');

    // Status
    $table->string('status_row', 20)
        ->default('AKTIF');

    // Audit
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->unsignedBigInteger('deleted_by')->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->foreign('fk_rak')
        ->references('id_rak')
        ->on('tbl_master_rak')
        ->cascadeOnUpdate()
        ->restrictOnDelete();

    $table->index('fk_rak');
    $table->index('status_row');
});


Schema::create('tbl_master_lokasi', function (Blueprint $table) {
    $table->id('id_lokasi');

    // Kode otomatis hierarkis: {kd_row}.{urutan bin 2 digit}
    // Contoh: GU1.01.01.01, GU1.01.01.02
    $table->string('kd_lokasi', 30)
        ->unique();

    // Relasi ke row
    $table->unsignedBigInteger('fk_row');

    // Nomor urut bin (2 digit, otomatis: 01, 02, 03, ...)
    $table->string('bin', 30);

    // Status
    $table->string('status_lokasi', 20)
        ->default('AKTIF');

    // Audit
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->unsignedBigInteger('deleted_by')->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->foreign('fk_row')
        ->references('id_row')
        ->on('tbl_master_row')
        ->cascadeOnUpdate()
        ->restrictOnDelete();

    $table->index('fk_row');
    $table->index('bin');
    $table->index('status_lokasi');

    $table->unique([
        'fk_row',
        'bin'
    ]);
});

        Schema::create('tbl_master_barang', function (Blueprint $table) {
            $table->id('id_master_barang');

            // Kode dibuat otomatis oleh aplikasi
            $table->string('kd_master_barang', 50)
                ->nullable()
                ->unique();

            $table->string('nm_master_barang', 100);

            $table->text('desc_master_barang')
                ->nullable();

            // Relasi
            $table->unsignedBigInteger('fk_kategori');
            $table->unsignedBigInteger('fk_satuan');

            // Stok
            $table->unsignedInteger('minimum_stok')
                ->default(0);

            $table->unsignedInteger('stok_saat_ini')
                ->default(0);

            // Status stok otomatis
            $table->string('stok_status', 20)
                ->default('HABIS');

            // Status barang
            $table->string('status_master_barang', 20)
                ->default('AKTIF');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Kategori
            $table->foreign('fk_kategori')
                ->references('id_master_kategori')
                ->on('tbl_master_kategori')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Foreign Key Satuan
            $table->foreign('fk_satuan')
                ->references('id_master_satuan')
                ->on('tbl_master_satuan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Index
            $table->index('fk_kategori');
            $table->index('fk_satuan');
            $table->index('stok_status');
            $table->index('status_master_barang');
        });
    }


    public function down(): void
{
    // =====================================================
    // HAPUS TABEL DENGAN FOREIGN KEY TERLEBIH DAHULU
    // =====================================================

    Schema::dropIfExists('tbl_master_barang');

    // Lokasi bergantung pada Row
    Schema::dropIfExists('tbl_master_lokasi');

    // Row bergantung pada Rak
    Schema::dropIfExists('tbl_master_row');

    // Rak bergantung pada Gudang
    Schema::dropIfExists('tbl_master_rak');

    // Gudang bergantung pada Status Gudang
    Schema::dropIfExists('tbl_master_gudang');

    Schema::dropIfExists('tbl_master_supplier');

    Schema::dropIfExists('tbl_master_satuan');

    Schema::dropIfExists('tbl_master_kategori');

    Schema::dropIfExists('tbl_master_status_gudang');
}
};