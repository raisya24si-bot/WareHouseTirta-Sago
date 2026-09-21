<?php

namespace App\Console\Commands;

use App\Models\MasterBarang;
use App\Models\StokLokasi;
use Illuminate\Console\Command;

/**
 * Perintah sekali jalan untuk memperbaiki data lama.
 *
 * Perbaikan di controller hanya berlaku untuk transaksi BARU. Angka
 * stok_saat_ini yang terlanjur melenceng sejak sebelumnya tidak akan
 * ikut terkoreksi sampai barangnya tersentuh transaksi lagi.
 *
 * Jalankan:  php artisan stok:sync
 * Cek dulu tanpa mengubah apa pun:  php artisan stok:sync --dry-run
 */
class SyncStokSaatIni extends Command
{
    protected $signature = 'stok:sync {--dry-run : Tampilkan selisih saja, tanpa menyimpan perubahan}';

    protected $description = 'Samakan stok_saat_ini di Master Barang dengan total qty_stok di tbl_stok_lokasi';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->warn('MODE DRY-RUN: tidak ada data yang diubah.');
        }

        // Total stok fisik per barang, langsung dari sumber sebenarnya.
        $totalPerBarang = StokLokasi::query()
            ->whereNull('deleted_at')
            ->selectRaw('fk_barang, SUM(qty_stok) as total')
            ->groupBy('fk_barang')
            ->pluck('total', 'fk_barang');

        $jumlahDiperbaiki = 0;
        $barisSelisih = [];

        MasterBarang::query()
            ->orderBy('id_master_barang')
            ->chunk(200, function ($daftarBarang) use ($totalPerBarang, $dryRun, &$jumlahDiperbaiki, &$barisSelisih) {

                foreach ($daftarBarang as $barang) {

                    $stokTercatat = (int) $barang->stok_saat_ini;
                    $stokFisik = (int) ($totalPerBarang[$barang->id_master_barang] ?? 0);

                    if ($stokTercatat === $stokFisik) {
                        continue;
                    }

                    $barisSelisih[] = [
                        $barang->kd_master_barang,
                        $barang->nm_master_barang,
                        $stokTercatat,
                        $stokFisik,
                        $stokFisik - $stokTercatat,
                    ];

                    if (! $dryRun) {
                        $barang->syncStokSaatIni();
                    }

                    $jumlahDiperbaiki++;
                }
            });

        if ($jumlahDiperbaiki === 0) {
            $this->info('Semua stok sudah sinkron. Tidak ada yang perlu diperbaiki.');

            return self::SUCCESS;
        }

        $this->table(
            ['Kode', 'Nama Barang', 'Tercatat', 'Fisik (bin)', 'Selisih'],
            $barisSelisih
        );

        $this->info(
            $dryRun
                ? "Ditemukan {$jumlahDiperbaiki} barang dengan stok tidak sinkron (belum diubah)."
                : "Selesai. {$jumlahDiperbaiki} barang berhasil disinkronkan."
        );

        return self::SUCCESS;
    }
}