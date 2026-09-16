<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REFF NUMBER & REFF FROM PADA STOK LOKASI
        |--------------------------------------------------------------------------
        |
        | Dipakai supaya qty_rusak di satu bin REJECTED bisa dilacak asalnya
        | dari transaksi mana -- baik dari Stock Opname maupun dari
        | Penerimaan Barang PO -- tanpa perlu bikin bin terpisah satu-satu
        | per batch barang rusak.
        |
        | reff_from  = jenis sumbernya, mis. 'OPNAME' atau 'PENERIMAAN'.
        | reff_number = kode dokumen sumbernya, mis. kode opname atau
        |                kode GRN (kd_penerimaan).
        |--------------------------------------------------------------------------
        */

        if (! Schema::hasColumn('tbl_stok_lokasi', 'reff_number')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->string('reff_number', 50)
                    ->default('0')
                    ->after('qty_rusak');
            });
        }

        if (! Schema::hasColumn('tbl_stok_lokasi', 'reff_from')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->string('reff_from', 50)
                    ->nullable()
                    ->after('reff_number');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_stok_lokasi', 'reff_from')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->dropColumn('reff_from');
            });
        }

        if (Schema::hasColumn('tbl_stok_lokasi', 'reff_number')) {
            Schema::table('tbl_stok_lokasi', function (Blueprint $table) {
                $table->dropColumn('reff_number');
            });
        }
    }
};