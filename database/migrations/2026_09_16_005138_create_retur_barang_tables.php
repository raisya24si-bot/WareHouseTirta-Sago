<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        if (! Schema::hasTable('tbl_retur_barang')) {

            Schema::create('tbl_retur_barang', function (Blueprint $table) {

                $table->id('id_retur');

                $table->string('kd_retur', 30)->unique();

                $table->date('tgl_retur');

                $table->foreignId('fk_penerimaan_barang')
                    ->constrained('tbl_penerimaan_barang', 'id_penerimaan');

                $table->foreignId('fk_status_retur')
                    ->constrained('tbl_master_status_retur', 'id_status_retur');

                $table->text('catatan_retur')->nullable();

                $table->decimal('nilai_total_retur', 15, 2)->default(0);
                $table->decimal('nilai_terselamatkan', 15, 2)->default(0);

                // Diisi begitu status masuk PROSES_KIRIM_GANTI
                $table->string('no_resi_pengiriman', 50)->nullable();
                $table->string('nm_ekspedisi', 100)->nullable();
                $table->string('estimasi_hari', 20)->nullable();

                // Audit proses: siapa yang menerbitkan BAP & siapa yang menutup retur
                $table->unsignedBigInteger('submit_by')->nullable();
                $table->timestamp('submit_at')->nullable();

                $table->unsignedBigInteger('selesai_by')->nullable();
                $table->timestamp('selesai_at')->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_status_retur');
                $table->index('fk_penerimaan_barang');
            });
        }

        if (! Schema::hasTable('tbl_retur_barang_detail')) {

            Schema::create('tbl_retur_barang_detail', function (Blueprint $table) {

                $table->id('id_retur_detail');

                $table->foreignId('fk_retur')
                    ->constrained('tbl_retur_barang', 'id_retur')
                    ->cascadeOnDelete();

                $table->foreignId('fk_penerimaan_barang_detail')
                    ->constrained('tbl_penerimaan_barang_detail', 'id_penerimaan_barang_detail');

                $table->foreignId('fk_barang')
                    ->constrained('tbl_master_barang', 'id_master_barang');

                // Snapshot qty reject hasil QC inbound (dari qty_rusak GRN)
                $table->unsignedInteger('qty_reject_qc')->default(0);

                // Qty yang benar-benar diajukan retur (input stepper di form)
                $table->unsignedInteger('qty_diretur')->default(0);

                $table->decimal('harga_satuan', 15, 2)->default(0);
                $table->decimal('subtotal_retur', 15, 2)->default(0);

                $table->string('catatan_detail', 255)->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->unique(
                    ['fk_retur', 'fk_penerimaan_barang_detail'],
                    'uk_detail_retur_penerimaan'
                );
            });
        }

        if (! Schema::hasTable('tbl_retur_barang_detail_alasan')) {

            Schema::create('tbl_retur_barang_detail_alasan', function (Blueprint $table) {

                $table->id('id_retur_detail_alasan');

                $table->foreignId('fk_retur_detail')
                    ->constrained('tbl_retur_barang_detail', 'id_retur_detail')
                    ->cascadeOnDelete();

                $table->foreignId('fk_alasan_retur')
                    ->constrained('tbl_master_alasan_retur', 'id_alasan_retur');

                $table->timestamps();

                $table->unique(
                    ['fk_retur_detail', 'fk_alasan_retur'],
                    'uk_detail_alasan_retur'
                );
            });
        }


        if (! Schema::hasTable('tbl_retur_barang_foto')) {

            Schema::create('tbl_retur_barang_foto', function (Blueprint $table) {

                $table->id('id_retur_foto');

                $table->foreignId('fk_retur_detail')
                    ->constrained('tbl_retur_barang_detail', 'id_retur_detail')
                    ->cascadeOnDelete();

                $table->string('nama_file', 255)->nullable();
                $table->string('path_file', 200)->nullable();
                $table->string('mime_type', 100)->nullable();
                $table->unsignedBigInteger('ukuran_file')->nullable();

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
        Schema::dropIfExists('tbl_retur_barang_foto');
        Schema::dropIfExists('tbl_retur_barang_detail_alasan');
        Schema::dropIfExists('tbl_retur_barang_detail');
        Schema::dropIfExists('tbl_retur_barang');
    }
};