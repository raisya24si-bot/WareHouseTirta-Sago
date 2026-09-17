<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_master_status_penerimaan_retur')) {
            return;
        }

        Schema::create('tbl_master_status_penerimaan_retur', function (Blueprint $table) {

            $table->id('id_status_penerimaan_retur');

            $table->string('kd_status_penerimaan_retur', 30);
            $table->unique('kd_status_penerimaan_retur', 'status_penerimaan_retur_kd_unique');

            $table->string('nm_status_penerimaan_retur', 50);

            // 1 = Menunggu Kedatangan, 2 = Proses QC, 3 = Selesai
            $table->unsignedTinyInteger('urutan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_master_status_penerimaan_retur');
    }
};