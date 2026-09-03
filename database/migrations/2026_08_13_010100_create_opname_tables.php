<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // OPNAME (header)
        // =====================================================
        Schema::create('tbl_opname', function (Blueprint $table) {
            $table->id('id_opname');

            $table->string('kd_opname', 30)->unique();
            $table->unsignedBigInteger('fk_gudang');

            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();

            $table->string('status_opname', 20)->default('ONGOING'); // ONGOING | COMPLETED
            $table->text('catatan')->nullable();

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
            $table->index('status_opname');
        });

        // =====================================================
        // OPNAME LOKASI (pivot) — bin/lokasi mana saja yang
        // dipilih ketika opname dibuat (step "Select Bins")
        // =====================================================
        Schema::create('tbl_opname_lokasi', function (Blueprint $table) {
            $table->id('id_opname_lokasi');

            $table->unsignedBigInteger('fk_opname');
            $table->unsignedBigInteger('fk_lokasi');

            $table->timestamps();

            $table->foreign('fk_opname')
                ->references('id_opname')
                ->on('tbl_opname')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('fk_lokasi')
                ->references('id_lokasi')
                ->on('tbl_master_lokasi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['fk_opname', 'fk_lokasi']);
        });

        // =====================================================
        // OPNAME DETAIL — baris per barang per bin (ini yang
        // muncul di halaman "Actual Stok")
        // =====================================================
        Schema::create('tbl_opname_detail', function (Blueprint $table) {
            $table->id('id_opname_detail');

            $table->unsignedBigInteger('fk_opname');
            $table->unsignedBigInteger('fk_lokasi');
            $table->unsignedBigInteger('fk_barang');

            $table->integer('stok_sistem')->default(0); // snapshot qty saat opname dibuat
            $table->integer('stok_aktual')->nullable();  // diisi user saat hitung fisik
            $table->integer('selisih')->nullable();       // stok_aktual - stok_sistem

            $table->string('status_item', 20)->default('BELUM DIHITUNG'); // BELUM DIHITUNG | SESUAI | SELISIH
            $table->text('keterangan')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fk_opname')
                ->references('id_opname')
                ->on('tbl_opname')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('fk_lokasi')
                ->references('id_lokasi')
                ->on('tbl_master_lokasi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('fk_barang')
                ->references('id_master_barang')
                ->on('tbl_master_barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['fk_opname', 'fk_lokasi', 'fk_barang'], 'opname_detail_unique');
            $table->index('fk_opname');
            $table->index('status_item');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_opname_detail');
        Schema::dropIfExists('tbl_opname_lokasi');
        Schema::dropIfExists('tbl_opname');
    }
};
