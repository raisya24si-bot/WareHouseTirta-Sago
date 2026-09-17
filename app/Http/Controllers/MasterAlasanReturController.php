<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterAlasanRetur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterAlasanReturController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $query = MasterAlasanRetur::withCount('detailReturs');

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where('nm_alasan_retur', 'like', "%{$search}%");
        }

        $alasanList = $query->latest('id_alasan_retur')
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        return view('master.alasan-retur.index', compact('alasanList', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAlasan($request);
        $validated['created_by'] = auth()->id() ?? 1;

        MasterAlasanRetur::create($validated);

        return back()->with('success', 'Kategori alasan kerusakan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterAlasanRetur $masterAlasanRetur)
    {
        $validated = $this->validateAlasan($request, $masterAlasanRetur);
        $validated['updated_by'] = auth()->id() ?? 1;

        $masterAlasanRetur->update($validated);

        return back()->with('success', 'Kategori alasan kerusakan berhasil diperbarui.');
    }

    public function destroy(MasterAlasanRetur $masterAlasanRetur)
    {
        $masterAlasanRetur->update([
            'status_alasan_retur' => 'TIDAK AKTIF',
            'deleted_by' => auth()->id() ?? 1,
        ]);

        $masterAlasanRetur->delete();

        return back()->with('success', 'Kategori alasan kerusakan berhasil dinonaktifkan.');
    }

    private function validateAlasan(Request $request, ?MasterAlasanRetur $alasan = null): array
    {
        return $request->validate([
            'nm_alasan_retur' => [
                'required', 'string', 'max:100',
                Rule::unique('tbl_master_alasan_retur', 'nm_alasan_retur')
                    ->ignore($alasan?->id_alasan_retur, 'id_alasan_retur'),
            ],
            'status_alasan_retur' => ['required', Rule::in(['AKTIF', 'TIDAK AKTIF'])],
        ]);
    }
}