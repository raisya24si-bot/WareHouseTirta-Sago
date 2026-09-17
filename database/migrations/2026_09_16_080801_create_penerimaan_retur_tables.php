<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        if (! Schema::hasTable('tbl_penerimaan_retur')) {

            Schema::create('tbl_penerimaan_retur', function (Blueprint $table) {

                $table->id('id_penerimaan_retur');

                $table->string('kd_penerimaan_retur', 30)->unique();

                $table->foreignId('fk_retur')
                    ->constrained('tbl_retur_barang', 'id_retur');

                $table->string('no_sj_supplier', 50)->nullable();

                $table->foreignId('fk_status_penerimaan_retur')
                    ->constrained('tbl_master_status_penerimaan_retur', 'id_status_penerimaan_retur');

                $table->dateTime('waktu_tiba_dock')->nullable();
                $table->string('dock_number', 50)->nullable();

                $table->text('catatan_verifikasi')->nullable();
                $table->boolean('is_consent_verifikasi')->default(false);

                $table->unsignedBigInteger('submit_by')->nullable();
                $table->timestamp('submit_at')->nullable();

                $table->unsignedBigInteger('selesai_by')->nullable();
                $table->timestamp('selesai_at')->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_retur');
                $table->index('fk_status_penerimaan_retur');
            });
        }

        if (! Schema::hasTable('tbl_penerimaan_retur_detail')) {

            Schema::create('tbl_penerimaan_retur_detail', function (Blueprint $table) {

                $table->id('id_penerimaan_retur_detail');

                $table->foreignId('fk_penerimaan_retur')
                    ->constrained('tbl_penerimaan_retur', 'id_penerimaan_retur')
                    ->cascadeOnDelete();

                $table->foreignId('fk_retur_detail')
                    ->constrained('tbl_retur_barang_detail', 'id_retur_detail');

                $table->foreignId('fk_barang')
                    ->constrained('tbl_master_barang', 'id_master_barang');

                // Snapshot dari qty_diretur di retur asal
                $table->unsignedInteger('qty_diklaim')->default(0);

                // Qty fisik yang benar-benar datang (bisa parsial)
                $table->unsignedInteger('qty_tiba')->default(0);

                $table->foreignId('fk_bin_tujuan')
                    ->nullable()
                    ->constrained('tbl_master_lokasi', 'id_lokasi');

                // Flag sudah di-push ke tbl_stok_lokasi apa belum
                $table->boolean('is_masuk_stok')->default(false);

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
        }


        if (! Schema::hasTable('tbl_penerimaan_retur_detail_serial')) {

            Schema::create('tbl_penerimaan_retur_detail_serial', function (Blueprint $table) {

                $table->id('id_penerimaan_retur_detail_serial');

                $table->foreignId('fk_penerimaan_retur_detail')
                    ->constrained(
                        'tbl_penerimaan_retur_detail',
                        'id_penerimaan_retur_detail',
                        'fk_pnrm_retur_detail_serial'
                    )
                    ->cascadeOnDelete();

                $table->string('no_seri', 100);

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->unique(
                    ['fk_penerimaan_retur_detail', 'no_seri'],
                    'uk_serial_per_item'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_penerimaan_retur_detail_serial');
        Schema::dropIfExists('tbl_penerimaan_retur_detail');
        Schema::dropIfExists('tbl_penerimaan_retur');
    }
};