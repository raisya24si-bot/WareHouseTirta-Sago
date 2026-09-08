<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (! Schema::hasTable('tbl_penerimaan_barang')) {

            Schema::create('tbl_penerimaan_barang', function (Blueprint $table) {

                $table->id('id_penerimaan');

                $table->string('kd_penerimaan', 30)->unique();

                $table->date('tgl_penerimaan_barang');

                $table->foreignId('fk_po')
                    ->constrained('tbl_po', 'id_po');

                $table->string('no_sjinv_supplier', 50)->nullable();

                $table->string('desc_penerimaan_barang', 100)->nullable();

                $table->foreignId('fk_status_penerimaan_barang')
                    ->constrained('tbl_master_status_penerimaan_barang', 'id_status_penerimaan_barang');

                $table->unsignedBigInteger('submit_by')->nullable();
                $table->timestamp('submit_at')->nullable();

                $table->unsignedBigInteger('approve_kasubag_by')->nullable();
                $table->timestamp('approve_kasubag_at')->nullable();

                $table->unsignedBigInteger('approve_kabag_by')->nullable();
                $table->timestamp('approve_kabag_at')->nullable();

                $table->unsignedBigInteger('approve_direktur_by')->nullable();
                $table->timestamp('approve_direktur_at')->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_status_penerimaan_barang');
                $table->index('fk_po');
            });
        }

        if (! Schema::hasTable('tbl_penerimaan_barang_detail')) {

            Schema::create('tbl_penerimaan_barang_detail', function (Blueprint $table) {

                $table->id('id_penerimaan_barang_detail');

                $table->foreignId('fk_penerimaan_barang')
                    ->constrained('tbl_penerimaan_barang', 'id_penerimaan')
                    ->cascadeOnDelete();

                $table->foreignId('fk_barang')
                    ->constrained('tbl_master_barang', 'id_master_barang');


                $table->foreignId('fk_lokasi_barang')
                    ->nullable()
                    ->constrained('tbl_master_lokasi', 'id_lokasi')
                    ->nullOnDelete();

                $table->unsignedInteger('qty_request');
                $table->unsignedInteger('qty_baik')->default(0);
                $table->unsignedInteger('qty_rusak')->default(0);

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->unique(
                    ['fk_penerimaan_barang', 'fk_barang'],
                    'uk_detail_penerimaan_barang'
                );
            });
        }

        if (! Schema::hasTable('tbl_penerimaan_barang_bukti_dukung')) {

            Schema::create('tbl_penerimaan_barang_bukti_dukung', function (Blueprint $table) {

                $table->id('id_penerimaan_barang_bukti_dukung');

                $table->foreignId('fk_penerimaan_barang')
                    ->constrained('tbl_penerimaan_barang', 'id_penerimaan')
                    ->cascadeOnDelete();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_penerimaan_barang_bukti_dukung');
        Schema::dropIfExists('tbl_penerimaan_barang_detail');
        Schema::dropIfExists('tbl_penerimaan_barang');
    }
};