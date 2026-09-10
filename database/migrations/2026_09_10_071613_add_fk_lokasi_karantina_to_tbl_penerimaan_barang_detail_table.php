<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_penerimaan_barang_detail', function (Blueprint $table) {
            $table->foreignId('fk_lokasi_karantina')
                ->nullable()
                ->after('fk_lokasi_barang')
                ->constrained('tbl_master_lokasi', 'id_lokasi')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_penerimaan_barang_detail', function (Blueprint $table) {
            $table->dropForeign(['fk_lokasi_karantina']);
            $table->dropColumn('fk_lokasi_karantina');
        });
    }
};