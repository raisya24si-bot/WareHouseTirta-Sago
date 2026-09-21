<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_master_status_retur')) {
            return;
        }

        Schema::create('tbl_master_status_retur', function (Blueprint $table) {

            $table->id('id_status_retur');

            $table->string('kd_status_retur', 30);

            $table->unique(
                'kd_status_retur',
                'uk_status_retur_kd'
            );

            $table->string('nm_status_retur', 50);

            $table->unsignedTinyInteger('urutan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_master_status_retur');
    }
};