<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // MASTER STATUS BPB
        // (DRAFT, MENUNGGU_APPROVAL, DIPROSES_GUDANG, SIAP_AMBIL, SELESAI)
        // =====================================================
        if (! Schema::hasTable('tbl_master_status_bpb')) {

            Schema::create('tbl_master_status_bpb', function (Blueprint $table) {

                $table->id('id_status_bpb');

                $table->string('kd_status_bpb', 30)->unique();
                $table->string('nm_status_bpb', 50);
                $table->unsignedTinyInteger('urutan')->nullable();

                $table->timestamps();
            });
        }


        // =====================================================
        // MASTER TINGKAT URGENSI BPB
        // (NORMAL, TINGGI, DARURAT)
        // =====================================================
        if (! Schema::hasTable('tbl_master_urgensi_bpb')) {

            Schema::create('tbl_master_urgensi_bpb', function (Blueprint $table) {

                $table->id('id_urgensi_bpb');

                $table->string('kd_urgensi_bpb', 30)->unique();
                $table->string('nm_urgensi_bpb', 50);
                $table->unsignedTinyInteger('urutan')->nullable();

                $table->timestamps();
            });
        }


        // =====================================================
        // HEADER BPB (BON PERMINTAAN BARANG)
        // =====================================================
        if (! Schema::hasTable('tbl_bpb_gudang')) {

            Schema::create('tbl_bpb_gudang', function (Blueprint $table) {

                $table->id('id_bpb');

                // Kode dibuat otomatis oleh sistem, contoh: BPB/2026/09/1
                $table->string('kd_bpb', 30)->unique();

                $table->date('tgl_bpb');

                // Judul / keterangan pekerjaan singkat
                $table->string('desc_bpb', 191)->nullable();

                $table->foreignId('fk_status_bpb')
                    ->constrained('tbl_master_status_bpb', 'id_status_bpb');

                $table->foreignId('fk_tingkat_urgensi')
                    ->constrained('tbl_master_urgensi_bpb', 'id_urgensi_bpb');

                $table->foreignId('fk_gudang_pengambilan')
                    ->constrained('tbl_master_gudang', 'id_gudang');

                /*
                | Referensi SPK belum punya tabel/relasi tersendiri di modul ini.
                | Untuk sementara disimpan sebagai teks bebas: nomor SPK aktif,
                | atau keterangan darurat kalau SPK belum terbit (status_spk = DARURAT).
                */
                $table->string('status_spk', 20)->default('ADA');
                $table->string('no_spk', 100)->nullable();

                $table->unsignedBigInteger('submit_by')->nullable();
                $table->timestamp('submit_at')->nullable();

                $table->unsignedBigInteger('approve_kasubag_by')->nullable();
                $table->timestamp('approve_kasubag_at')->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_status_bpb');
                $table->index('fk_tingkat_urgensi');
                $table->index('fk_gudang_pengambilan');
            });
        }


        // =====================================================
        // DETAIL ITEM BPB
        // =====================================================
        if (! Schema::hasTable('tbl_bpb_gudang_detail')) {

            Schema::create('tbl_bpb_gudang_detail', function (Blueprint $table) {

                $table->id('id_bpb_detail');

                $table->foreignId('fk_bpb')
                    ->constrained('tbl_bpb_gudang', 'id_bpb')
                    ->cascadeOnDelete();

                $table->foreignId('fk_barang')
                    ->constrained('tbl_master_barang', 'id_master_barang');

                // Bin/lokasi rak tujuan pengambilan, opsional (diisi tim gudang saat picking)
                $table->foreignId('fk_bin')
                    ->nullable()
                    ->constrained('tbl_master_lokasi', 'id_lokasi')
                    ->nullOnDelete();

                $table->unsignedInteger('qty_request');

                /*
                | Snapshot stok yang tersedia PAS barang ini ditambahkan ke BPB --
                | sama seperti pola qty_stok_at_request di tbl_po_detail.
                */
                $table->integer('qty_available');

                $table->string('catatan', 191)->nullable();

                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index('fk_bpb');
                $table->index('fk_barang');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_bpb_gudang_detail');
        Schema::dropIfExists('tbl_bpb_gudang');
        Schema::dropIfExists('tbl_master_urgensi_bpb');
        Schema::dropIfExists('tbl_master_status_bpb');
    }
};