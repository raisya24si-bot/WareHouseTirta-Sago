<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterBarang;
use App\Models\MasterKategori;
use App\Models\MasterSatuan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterBarangController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $query = MasterBarang::with(['kategori', 'satuan']);

        if ($request->filled('fk_kategori')) {
            $query->where('fk_kategori', $request->integer('fk_kategori'));
        }

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(fn ($q) => $q
                ->where('kd_master_barang', 'like', "%{$search}%")
                ->orWhere('nm_master_barang', 'like', "%{$search}%"));
        }

        $barangs = $query->latest('id_master_barang')->paginate($this->resolvePerPage($request, $query))->withQueryString();
        $categories = MasterKategori::where('status_master_kategori', 'AKTIF')->orderBy('nm_master_kategori')->get();
        $satuans = MasterSatuan::where('status_master_satuan', 'AKTIF')->orderBy('nm_master_satuan')->get();

        return view('master.barang.index', compact('barangs', 'categories', 'satuans', 'perPage')) ;
    }

    public function store(Request $request)
    {
        $validated = $this->validateBarang($request);
        $validated['created_by'] = auth()->id() ?? 1;
        $validated['status_master_barang'] = $validated['status_master_barang'] ?? 'AKTIF';

        // Kode dan status stok dibuat otomatis oleh model.
        MasterBarang::create($validated);

        return back()->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, MasterBarang $masterBarang)
    {
        $validated = $this->validateBarang($request, $masterBarang);
        $validated['updated_by'] = auth()->id() ?? 1;

        // Kode barang tidak boleh diubah manual; status stok juga otomatis.
        $masterBarang->update($validated);

        return back()->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(MasterBarang $masterBarang)
    {
        $masterBarang->update([
            'status_master_barang' => 'TIDAK AKTIF',
            'deleted_by' => auth()->id() ?? 1,
        ]);
        $masterBarang->delete();

        return back()->with('success', 'Barang berhasil dinonaktifkan.');
    }

    private function validateBarang(Request $request, ?MasterBarang $barang = null): array
    {
        return $request->validate([
            'nm_master_barang' => ['required', 'string', 'max:100'],
            'desc_master_barang' => ['nullable', 'string'],
            'fk_kategori' => ['required', 'exists:tbl_master_kategori,id_master_kategori'],
            'fk_satuan' => ['required', 'exists:tbl_master_satuan,id_master_satuan'],
            'minimum_stok' => ['required', 'integer', 'min:0'],
            'stok_saat_ini' => ['required', 'integer', 'min:0'],
            'status_master_barang' => ['nullable', Rule::in(['AKTIF', 'TIDAK AKTIF'])],
        ]);
    }

    private function perPage(Request $request): int
    {
        $value = $request->integer('per_page', 10);
        return in_array($value, [10, 25, 35, 50], true) ? $value : 10;
    }
}
