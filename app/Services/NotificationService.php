<?php

namespace App\Services;

use App\Models\MasterBarang;
use App\Models\Notifikasi;
use App\Models\Opname;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;

class NotificationService
{
    
    public static function cekStokHabis(MasterBarang $barang): void
    {
        $totalStok = (int) StokLokasi::where('fk_barang', $barang->id_master_barang)->sum('qty_stok');

        if ($totalStok > 0) {
            return;
        }

        $sudahAda = Notifikasi::unread()
            ->where('tipe', 'STOK_HABIS')
            ->where('fk_barang', $barang->id_master_barang)
            ->exists();

        if ($sudahAda) {
            return;
        }

        Notifikasi::create([
            'tipe' => 'STOK_HABIS',
            'judul' => 'Stok Habis: ' . $barang->nm_master_barang,
            'pesan' =>
                'Stok barang "' . $barang->nm_master_barang . '" (' . $barang->kd_master_barang . ') ' .
                'sudah habis di semua BIN pada ' . now()->translatedFormat('d F Y, H:i') . '.',
            'fk_barang' => $barang->id_master_barang,
            'data' => [
                'kd_barang' => $barang->kd_master_barang,
                'tanggal_kejadian' => now()->toDateTimeString(),
            ],
        ]);
    }


    public static function barangMasuk(MasterBarang $barang, StrukturLokasi $lokasi, int $qty): void
    {
        if ($qty <= 0) {
            return;
        }

        Notifikasi::create([
            'tipe' => 'BARANG_MASUK',
            'judul' => 'Barang Masuk: ' . $barang->nm_master_barang,
            'pesan' =>
                '+' . number_format($qty) . ' ' . ($barang->satuan?->nm_master_satuan ?? 'unit') . ' ' .
                '"' . $barang->nm_master_barang . '" (' . $barang->kd_master_barang . ') ' .
                'masuk ke BIN ' . $lokasi->bin . ' pada ' . now()->translatedFormat('d F Y, H:i') . '.',
            'fk_barang' => $barang->id_master_barang,
            'data' => [
                'kd_barang' => $barang->kd_master_barang,
                'bin' => $lokasi->bin,
                'qty' => $qty,
                'tanggal_kejadian' => now()->toDateTimeString(),
            ],
        ]);
    }


    public static function opnameSelisih(Opname $opname, int $jumlahSelisih): void
    {
        if ($jumlahSelisih <= 0) {
            return;
        }

        Notifikasi::create([
            'tipe' => 'OPNAME_SELISIH',
            'judul' => 'Selisih Stock Opname: ' . $opname->kd_opname,
            'pesan' =>
                'Ditemukan ' . $jumlahSelisih . ' barang dengan selisih stok pada opname ' .
                $opname->kd_opname . ' (' . ($opname->gudang?->nm_gudang ?? '-') . '), ' .
                'diselesaikan pada ' . now()->translatedFormat('d F Y, H:i') . '.',
            'fk_opname' => $opname->id_opname,
            'data' => [
                'kd_opname' => $opname->kd_opname,
                'jumlah_selisih' => $jumlahSelisih,
                'tanggal_kejadian' => now()->toDateTimeString(),
            ],
        ]);
    }
}