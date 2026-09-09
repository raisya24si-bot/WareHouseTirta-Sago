<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'tbl_penerimaan_barang_bukti_dukung',
            function (Blueprint $table) {

                $table->string('nama_file', 255)
                    ->nullable()
                    ->after('fk_penerimaan_barang');

                $table->string('path_file', 500)
                    ->nullable()
                    ->after('nama_file');

                $table->string('mime_type', 100)
                    ->nullable()
                    ->after('path_file');

                $table->unsignedBigInteger('ukuran_file')
                    ->nullable()
                    ->after('mime_type');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'tbl_penerimaan_barang_bukti_dukung',
            function (Blueprint $table) {

                $table->dropColumn([
                    'nama_file',
                    'path_file',
                    'mime_type',
                    'ukuran_file',
                ]);
            }
        );
    }
};