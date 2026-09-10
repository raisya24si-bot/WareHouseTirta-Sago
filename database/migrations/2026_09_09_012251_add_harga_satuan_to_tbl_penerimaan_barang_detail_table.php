<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_penerimaan_barang_detail', function (Blueprint $table) {
            $table->integer('harga_satuan')
                ->nullable()
                ->after('qty_rusak');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_penerimaan_barang_detail', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
        });
    }
};