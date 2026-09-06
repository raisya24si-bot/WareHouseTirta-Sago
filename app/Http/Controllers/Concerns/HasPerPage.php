<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

/**
 * Helper seragam untuk fitur "Tampilkan X data" di semua halaman
 * list (Master Barang, Kategori, Satuan, Supplier, Gudang/Rak/Row/
 * Lokasi, Opname, dst). Pilihan yang didukung: 10, 20, 30, 50, Semua.
 */
trait HasPerPage
{
    /**
     * Nilai mentah per_page dari query string, sudah divalidasi.
     * Dipakai untuk ditampilkan balik di dropdown "Tampilkan".
     */
    protected function perPageOption(Request $request): string
    {
        $raw = $request->string('per_page', '10')->toString();

        return in_array($raw, ['10', '20', '30', '50', 'all'], true) ? $raw : '10';
    }

    /**
     * Angka limit yang benar-benar dipakai untuk ->paginate().
     * Kalau opsinya "all", hitung total baris dari $query (setelah
     * filter/search diterapkan) supaya semua data tampil di 1 halaman.
     */
    protected function resolvePerPage(Request $request, $query = null): int
    {
        $option = $this->perPageOption($request);

        if ($option === 'all') {
            if ($query) {
                return max((int) (clone $query)->count(), 1);
            }

            return 1000000;
        }

        return (int) $option;
    }
}
