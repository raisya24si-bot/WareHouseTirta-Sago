<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterKategoriGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasterKategoriGudangController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $query = MasterKategoriGudang::withCount('gudangs');

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(function ($q) use ($search) {
                $q->where('nm_kategori_gudang', 'like', "%{$search}%")
                    ->orWhere('kd_kategori_gudang', 'like', "%{$search}%");
            });
        }

        $kategoriList = $query->latest('id_kategori_gudang')
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        return view('master.kategori-gudang.index', compact('kategoriList', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateKategori($request);
        $validated['kd_kategori_gudang'] = $this->generateKode($validated['nm_kategori_gudang']);
        $validated['created_by'] = auth()->id() ?? 1;

        MasterKategoriGudang::create($validated);

        return back()->with('success', 'Jenis gudang berhasil ditambahkan.');
    }

    public function update(Request $request, MasterKategoriGudang $masterKategoriGudang)
    {
        $validated = $this->validateKategori($request, $masterKategoriGudang);
        $validated['updated_by'] = auth()->id() ?? 1;

        $masterKategoriGudang->update($validated);

        return back()->with('success', 'Jenis gudang berhasil diperbarui.');
    }

    public function destroy(MasterKategoriGudang $masterKategoriGudang)
    {
        if ($masterKategoriGudang->gudangs()->exists()) {
            return back()->with(
                'error',
                'Jenis gudang ini masih dipakai oleh salah satu gudang, jadi tidak bisa dinonaktifkan.'
            );
        }

        $masterKategoriGudang->update([
            'status_kategori_gudang' => 'TIDAK AKTIF',
            'deleted_by' => auth()->id() ?? 1,
        ]);

        return back()->with('success', 'Jenis gudang berhasil dinonaktifkan.');
    }

    private function validateKategori(Request $request, ?MasterKategoriGudang $kategori = null): array
    {
        return $request->validate([
            'nm_kategori_gudang' => [
                'required', 'string', 'max:50',
                Rule::unique('tbl_master_kategori_gudang', 'nm_kategori_gudang')
                    ->ignore($kategori?->id_kategori_gudang, 'id_kategori_gudang'),
            ],
            'desc_kategori_gudang' => ['nullable', 'string', 'max:255'],
            'status_kategori_gudang' => ['required', Rule::in(['AKTIF', 'TIDAK AKTIF'])],
        ]);
    }

    /**
     * Bikin kd_kategori_gudang otomatis dari nama, misal "Karantina" jadi
     * "KARANTINA". Kalau kodenya udah dipakai, tambahin angka di belakang.
     */
    private function generateKode(string $nama): string
    {
        $base = Str::of($nama)->upper()->replaceMatches('/[^A-Z0-9]+/', '_')->trim('_')->limit(20, '');
        $base = (string) $base ?: 'KATEGORI';

        $kode = $base;
        $suffix = 1;

        while (MasterKategoriGudang::where('kd_kategori_gudang', $kode)->exists()) {
            $suffix++;
            $kode = $base.'_'.$suffix;
        }

        return $kode;
    }
}