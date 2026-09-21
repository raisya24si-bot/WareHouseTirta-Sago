<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | REJECT INFO
    |--------------------------------------------------------------------------
    |
    | Dipakai waktu PO ditolak di salah satu tingkat approval (Kasubag /
    | Kabag / Direktur). Kolom ini menyimpan siapa yang menolak, kapan,
    | catatan/alasan revisinya, dan tingkat berapa yang menolak --
    | supaya waktu PO dibalikin ke petugas untuk direvisi, riwayat
    | penolakannya tetap kelihatan (di halaman edit maupun index).
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::table('tbl_po', function (Blueprint $table) {

            if (! Schema::hasColumn('tbl_po', 'reject_by')) {
                $table->unsignedBigInteger('reject_by')->nullable()->after('approve_direktur_at');
            }

            if (! Schema::hasColumn('tbl_po', 'reject_at')) {
                $table->timestamp('reject_at')->nullable()->after('reject_by');
            }

            if (! Schema::hasColumn('tbl_po', 'reject_level')) {
                $table->string('reject_level', 20)->nullable()->after('reject_at');
            }

            if (! Schema::hasColumn('tbl_po', 'reject_note')) {
                $table->text('reject_note')->nullable()->after('reject_level');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_po', function (Blueprint $table) {

            $table->dropColumn([
                'reject_by',
                'reject_at',
                'reject_level',
                'reject_note',
            ]);
        });
    }
};
