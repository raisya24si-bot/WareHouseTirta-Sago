<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_master_status_penerimaan_barang')) {
            return;
        }

        Schema::create('tbl_master_status_penerimaan_barang', function (Blueprint $table) {

            $table->id('id_status_penerimaan_barang');

            $table->string('kd_status_penerimaan_barang', 30)->unique();
            $table->string('nm_status_penerimaan_barang', 50);
            $table->unsignedTinyInteger('urutan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_master_status_penerimaan_barang');
    }
};