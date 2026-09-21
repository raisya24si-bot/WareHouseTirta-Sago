<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('tbl_penerimaan_barang', function (Blueprint $table) {

            if (! Schema::hasColumn('tbl_penerimaan_barang', 'reject_by')) {
                $table->unsignedBigInteger('reject_by')->nullable()->after('approve_direktur_at');
            }

            if (! Schema::hasColumn('tbl_penerimaan_barang', 'reject_at')) {
                $table->timestamp('reject_at')->nullable()->after('reject_by');
            }

            if (! Schema::hasColumn('tbl_penerimaan_barang', 'reject_level')) {
                $table->string('reject_level', 20)->nullable()->after('reject_at');
            }

            if (! Schema::hasColumn('tbl_penerimaan_barang', 'reject_note')) {
                $table->text('reject_note')->nullable()->after('reject_level');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_penerimaan_barang', function (Blueprint $table) {

            $table->dropColumn([
                'reject_by',
                'reject_at',
                'reject_level',
                'reject_note',
            ]);
        });
    }
};
