<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tbl_po')) {

            Schema::create('tbl_po', function (Blueprint $table) {

                $table->id('id_po');

                $table->string('kd_po', 30)->unique();

                $table->foreignId('fk_supplier')
                    ->nullable()
                    ->constrained('tbl_master_supplier', 'id_master_supplier')
                    ->nullOnDelete();

                $table->string('desc_po', 100)->nullable();

                $table->foreignId('fk_status_po')
                    ->constrained('tbl_master_status_po', 'id_status_po');

                $table->unsignedBigInteger('submit_by')->nullable();
                $table->timestamp('submit_at')->nullable();

                $table->unsignedBigInteger('approve_kasubag_by')->nullable();
                $table->timestamp('approve_kasubag_at')->nullable();

                $table->unsignedBigInteger('approve_kabag_by')->nullable();
                $table->timestamp('apporve_kabag_at')->nullable();

                $table->unsignedBigInteger('approve_direktur_by')->nullable();
                $table->timestamp('approve_direktur_at')->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_status_po');
            });
        }

        if (! Schema::hasTable('tbl_po_detail')) {

            Schema::create('tbl_po_detail', function (Blueprint $table) {

                $table->id('id_po_detail');

                $table->foreignId('fk_po')
                    ->constrained('tbl_po', 'id_po')
                    ->cascadeOnDelete();

                $table->foreignId('fk_barang')
                    ->constrained('tbl_master_barang', 'id_master_barang');

                /*
                | Snapshot stok & minimum stok PAS barang ini diminta --
                | bukan angka live. Jadi kalau stok gudang berubah
                | belakangan, riwayat permintaan yang lama tetap
                | mencerminkan kondisi waktu itu diajukan.
                */
                $table->integer('qty_stok_at_request');
                $table->integer('qty_min_stok_at_request');

                $table->unsignedInteger('qty_request');

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->unique(['fk_po', 'fk_barang']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_po_detail');
        Schema::dropIfExists('tbl_po');
    }
};