<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_master_status_po')) {
            return;
        }

        Schema::create('tbl_master_status_po', function (Blueprint $table) {

            $table->id('id_status_po');

            $table->string('kd_status_po', 30)->unique();
            $table->string('nm_status_po', 50);
            $table->unsignedTinyInteger('urutan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_master_status_po');
    }
};