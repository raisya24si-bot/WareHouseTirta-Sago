<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\MasterGudang;
use App\Models\Opname;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([
                'barang' => [],
                'opname' => [],
                'gudang' => [],
            ]);
        }

        $barang = MasterBarang::query()
            ->where(function ($query) use ($q) {
                $query->where('kd_master_barang', 'like', "%{$q}%")
                    ->orWhere('nm_master_barang', 'like', "%{$q}%");
            })
            ->orderBy('nm_master_barang')
            ->limit(5)
            ->get(['id_master_barang', 'kd_master_barang', 'nm_master_barang', 'stok_saat_ini']);

        $opname = Opname::query()
            ->where('kd_opname', 'like', "%{$q}%")
            ->latest('id_opname')
            ->limit(5)
            ->get(['id_opname', 'kd_opname', 'status_opname']);

        $gudang = MasterGudang::query()
            ->where('nm_gudang', 'like', "%{$q}%")
            ->orderBy('nm_gudang')
            ->limit(5)
            ->get(['id_gudang', 'nm_gudang']);

        return response()->json([

            'barang' => $barang->map(fn ($b) => [
                'label' => $b->nm_master_barang,
                'sub' => $b->kd_master_barang . ' • Stok: ' . $b->stok_saat_ini,
                'url' => route('manajemen-stok.show', $b->id_master_barang),
            ]),

            'opname' => $opname->map(fn ($o) => [
                'label' => $o->kd_opname,
                'sub' => 'Stock Opname • ' . $o->status_opname,
                'url' => route('opname.show', $o->id_opname),
            ]),

            'gudang' => $gudang->map(fn ($g) => [
                'label' => $g->nm_gudang,
                'sub' => 'Gudang',
                'url' => route('master-gudang.index', ['tab' => 'gudang', 'search' => $g->nm_gudang]),
            ]),

        ]);
    }
}