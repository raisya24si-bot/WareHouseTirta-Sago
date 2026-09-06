<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_notifikasi')) {
            return;
        }

        Schema::create('tbl_notifikasi', function (Blueprint $table) {

            $table->id('id_notifikasi');

            $table->string('tipe', 30);

            $table->string('judul');
            $table->text('pesan');

            $table->foreignId('fk_barang')
                ->nullable()
                ->constrained('tbl_master_barang', 'id_master_barang')
                ->nullOnDelete();

            $table->foreignId('fk_opname')
                ->nullable()
                ->constrained('tbl_opname', 'id_opname')
                ->nullOnDelete();

            $table->json('data')->nullable();

            $table->timestamp('dibaca_at')->nullable();

            $table->timestamps();

            $table->index(['tipe', 'created_at']);
            $table->index('dibaca_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_notifikasi');
    }
};