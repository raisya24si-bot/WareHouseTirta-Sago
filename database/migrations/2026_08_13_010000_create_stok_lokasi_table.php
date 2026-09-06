<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // STOK LOKASI
        // Menyimpan qty barang per bin/lokasi (satu barang bisa
        // ada di banyak bin sekaligus). Ini sumber data untuk
        // modul Stock Opname.
        // =====================================================
        Schema::create('tbl_stok_lokasi', function (Blueprint $table) {
            $table->id('id_stok_lokasi');

            $table->unsignedBigInteger('fk_barang');
            $table->unsignedBigInteger('fk_lokasi');

            $table->unsignedInteger('qty_stok')->default(0);

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fk_barang')
                ->references('id_master_barang')
                ->on('tbl_master_barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('fk_lokasi')
                ->references('id_lokasi')
                ->on('tbl_master_lokasi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['fk_barang', 'fk_lokasi']);
            $table->index('fk_barang');
            $table->index('fk_lokasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_stok_lokasi');
    }
};
