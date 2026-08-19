<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterBarang;
use App\Models\MasterGudang;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ManajemenStokController extends Controller
{
    use HasPerPage;

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);

        $search = trim(
            $request->string('search')->toString()
        );

        /*
        |--------------------------------------------------------------------------
        | BARANG
        |--------------------------------------------------------------------------
        |
        | Semua master barang harus tetap muncul.
        |
        | Barang yang belum punya tbl_stok_lokasi juga tetap tampil
        | karena sumber utamanya adalah tbl_master_barang.
        |
        */

        $query = MasterBarang::query()
            ->with([
                'stokLokasis.lokasi.row.rak.gudang',
            ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'kd_master_barang',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'nm_master_barang',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'stokLokasis.lokasi',
                        function ($lokasi) use ($search) {

                            $lokasi->where(
                                'bin',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                    ->orWhereHas(
                        'stokLokasis.lokasi.row',
                        function ($row) use ($search) {

                            $row->where(
                                'kd_row',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                    ->orWhereHas(
                        'stokLokasis.lokasi.row.rak',
                        function ($rak) use ($search) {

                            $rak->where(
                                'kd_rak',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                    ->orWhereHas(
                        'stokLokasis.lokasi.row.rak.gudang',
                        function ($gudang) use ($search) {

                            $gudang
                                ->where(
                                    'kd_gudang',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'nm_gudang',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER GUDANG
        |--------------------------------------------------------------------------
        */

        if ($request->filled('gudang')) {

            $gudangId = $request->integer('gudang');

            $query->whereHas(
                'stokLokasis.lokasi.row.rak.gudang',
                function ($q) use ($gudangId) {

                    $q->where(
                        'id_gudang',
                        $gudangId
                    );
                }
            );
        }


        $barangs = $query
            ->orderBy('nm_master_barang')
            ->paginate(
                $this->resolvePerPage(
                    $request,
                    $query
                )
            )
            ->withQueryString();

        $gudangs = MasterGudang::query()
            ->orderBy('nm_gudang')
            ->get();


        $lokasis = StrukturLokasi::query()
            ->with([
                'row.rak.gudang',
            ])
            ->where(
                'status_lokasi',
                'AKTIF'
            )
            ->orderBy('bin')
            ->get();

        return view(
            'manajemen-stok.index',
            compact(
                'barangs',
                'gudangs',
                'lokasis',
                'perPage'
            )
        );
    }


    public function show(
        MasterBarang $masterBarang
    ) {
        $masterBarang->load([
            'kategori',
            'satuan',
            'stokLokasis.lokasi.row.rak.gudang',
        ]);

        return view(
            'manajemen-stok.show',
            compact('masterBarang')
        );
    }


    public function update(
        Request $request,
        StokLokasi $stokLokasi
    ) {
        $validated = $request->validate([

            'fk_lokasi' => [
                'required',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'qty_stok' => [
                'required',
                'integer',
                'min:0',
            ],

        ]);


        $duplicate = StokLokasi::query()
            ->where(
                'fk_barang',
                $stokLokasi->fk_barang
            )
            ->where(
                'fk_lokasi',
                $validated['fk_lokasi']
            )
            ->where(
                'id_stok_lokasi',
                '!=',
                $stokLokasi->id_stok_lokasi
            )
            ->exists();

        if ($duplicate) {

            return back()
                ->withErrors([
                    'fk_lokasi' =>
                        'Barang ini sudah berada pada BIN tersebut.',
                ])
                ->withInput();
        }

        $stokLokasi->update([
            'fk_lokasi' =>
                $validated['fk_lokasi'],

            'qty_stok' =>
                $validated['qty_stok'],

            'updated_by' =>
                auth()->id() ?? 1,
        ]);

        return back()->with(
            'success',
            'Data stok barang berhasil diperbarui.'
        );
    }


    public function addBin(
        Request $request
    ) {
        $validated = $request->validate([

            'fk_barang' => [
                'required',
                'exists:tbl_master_barang,id_master_barang',
            ],

            'fk_lokasi' => [
                'required',
                'exists:tbl_master_lokasi,id_lokasi',
            ],

            'qty_stok' => [
                'required',
                'integer',
                'min:0',
            ],

        ]);


        $exists = StokLokasi::query()
            ->where(
                'fk_barang',
                $validated['fk_barang']
            )
            ->where(
                'fk_lokasi',
                $validated['fk_lokasi']
            )
            ->exists();

        if ($exists) {

            return back()
                ->withErrors([
                    'fk_lokasi' =>
                        'Barang ini sudah terdaftar pada BIN tersebut.',
                ])
                ->withInput();
        }

        StokLokasi::create([

            'fk_barang' =>
                $validated['fk_barang'],

            'fk_lokasi' =>
                $validated['fk_lokasi'],

            'qty_stok' =>
                $validated['qty_stok'],

            'created_by' =>
                auth()->id() ?? 1,

        ]);

        return back()->with(
            'success',
            'BIN berhasil ditambahkan ke barang.'
        );
    }


    public function destroy(
        StokLokasi $stokLokasi
    ) {
        $stokLokasi->update([
            'deleted_by' =>
                auth()->id() ?? 1,
        ]);

        $stokLokasi->delete();

        return back()->with(
            'success',
            'Barang berhasil dilepas dari BIN tersebut.'
        );
    }
}