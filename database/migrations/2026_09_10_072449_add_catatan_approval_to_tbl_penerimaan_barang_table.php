<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_penerimaan_barang', function (Blueprint $table) {
            $table->text('catatan_approval')
                ->nullable()
                ->after('approve_direktur_at');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_penerimaan_barang', function (Blueprint $table) {
            $table->dropColumn('catatan_approval');
        });
    }
};