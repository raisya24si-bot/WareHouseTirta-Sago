<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_master_gudang', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_master_gudang', 'kepala_gudang')) {
                $table->string('kepala_gudang', 100)->nullable()->after('nm_gudang');
            }
            if (!Schema::hasColumn('tbl_master_gudang', 'alamat_gudang')) {
                $table->text('alamat_gudang')->nullable()->after('kepala_gudang');
            }
        });
    }
    public function down(): void
    {
        Schema::table('tbl_master_gudang', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_master_gudang', 'alamat_gudang')) $table->dropColumn('alamat_gudang');
            if (Schema::hasColumn('tbl_master_gudang', 'kepala_gudang')) $table->dropColumn('kepala_gudang');
        });
    }
};
