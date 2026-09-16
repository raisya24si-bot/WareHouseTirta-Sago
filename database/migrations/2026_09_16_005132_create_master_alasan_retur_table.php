<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_master_alasan_retur')) {
            return;
        }

        Schema::create('tbl_master_alasan_retur', function (Blueprint $table) {

            $table->id('id_alasan_retur');

            $table->string('kd_alasan_retur', 30)
                ->nullable()
                ->unique();

            $table->string('nm_alasan_retur', 100)
                ->unique();

            $table->string('status_alasan_retur', 20)
                ->default('AKTIF');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status_alasan_retur');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_master_alasan_retur');
    }
};