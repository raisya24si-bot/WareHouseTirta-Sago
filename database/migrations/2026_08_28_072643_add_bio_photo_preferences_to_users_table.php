<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (! Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'photo_url')) {
                $table->string('photo_url')->nullable()->after('bio');
            }

            /*
            |--------------------------------------------------------------------------
            | PREFERENCES
            |--------------------------------------------------------------------------
            |
            | JSON kecil buat preferensi non-kritikal (misal toggle
            | notifikasi di halaman Pengaturan). Sengaja bukan tabel
            | terpisah karena isinya cuma preferensi tampilan/notifikasi,
            | bukan data transaksional.
            |--------------------------------------------------------------------------
            */

            if (! Schema::hasColumn('users', 'preferences')) {
                $table->json('preferences')->nullable()->after('photo_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'bio')) {
                $table->dropColumn('bio');
            }

            if (Schema::hasColumn('users', 'photo_url')) {
                $table->dropColumn('photo_url');
            }

            if (Schema::hasColumn('users', 'preferences')) {
                $table->dropColumn('preferences');
            }
        });
    }
};