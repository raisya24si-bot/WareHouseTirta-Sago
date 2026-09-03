<?php

namespace App\Http\Controllers;

use App\Models\MasterKategori;
use App\Http\Controllers\Concerns\HasPerPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterKategoriController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $query = MasterKategori::withCount('masterBarangs');

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(fn ($q) => $q
                ->where('kd_master_kategori', 'like', "%{$search}%")
                ->orWhere('nm_master_kategori', 'like', "%{$search}%"));
        }

        $categories = $query->latest('id_master_kategori')->paginate($this->resolvePerPage($request, $query))->withQueryString();
        return view('master.kategori.index', compact('categories', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateKategori($request);
        $validated['created_by'] = auth()->id() ?? 1;
        MasterKategori::create($validated);
        return back()->with('success', 'Kategori berhasil ditambahkan. Kode dibuat otomatis.');
    }

    public function update(Request $request, MasterKategori $masterKategori)
    {
        $validated = $this->validateKategori($request, $masterKategori);
        $validated['updated_by'] = auth()->id() ?? 1;
        $masterKategori->update($validated);
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(MasterKategori $masterKategori)
    {
        $masterKategori->update(['status_master_kategori' => 'TIDAK AKTIF', 'deleted_by' => auth()->id() ?? 1]);
        $masterKategori->delete();
        return back()->with('success', 'Kategori berhasil dinonaktifkan.');
    }

    private function validateKategori(Request $request, ?MasterKategori $kategori = null): array
    {
        return $request->validate([
            'nm_master_kategori' => ['required', 'string', 'max:100', Rule::unique('tbl_master_kategori', 'nm_master_kategori')->ignore($kategori?->id_master_kategori, 'id_master_kategori')],
            'desc_master_kategori' => ['nullable', 'string'],
            'status_master_kategori' => ['required', Rule::in(['AKTIF', 'TIDAK AKTIF'])],
        ]);
    }

}
