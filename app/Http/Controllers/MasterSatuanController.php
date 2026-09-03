<?php

namespace App\Http\Controllers;

use App\Models\MasterSatuan;
use App\Http\Controllers\Concerns\HasPerPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterSatuanController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $query = MasterSatuan::withCount('masterBarangs');

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(fn ($q) => $q
                ->where('kd_master_satuan', 'like', "%{$search}%")
                ->orWhere('nm_master_satuan', 'like', "%{$search}%"));
        }

        $satuans = $query->latest('id_master_satuan')->paginate($this->resolvePerPage($request, $query))->withQueryString();
        return view('master.satuan.index', compact('satuans', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateSatuan($request);
        $validated['created_by'] = auth()->id() ?? 1;
        MasterSatuan::create($validated);
        return back()->with('success', 'Satuan berhasil ditambahkan. Kode dibuat otomatis.');
    }

    public function update(Request $request, MasterSatuan $masterSatuan)
    {
        $validated = $this->validateSatuan($request, $masterSatuan);
        $validated['updated_by'] = auth()->id() ?? 1;
        $masterSatuan->update($validated);
        return back()->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(MasterSatuan $masterSatuan)
    {
        $masterSatuan->update(['status_master_satuan' => 'TIDAK AKTIF', 'deleted_by' => auth()->id() ?? 1]);
        $masterSatuan->delete();
        return back()->with('success', 'Satuan berhasil dinonaktifkan.');
    }

    private function validateSatuan(Request $request, ?MasterSatuan $satuan = null): array
    {
        return $request->validate([
            'nm_master_satuan' => ['required', 'string', 'max:50', Rule::unique('tbl_master_satuan', 'nm_master_satuan')->ignore($satuan?->id_master_satuan, 'id_master_satuan')],
            'desc_master_satuan' => ['nullable', 'string'],
            'status_master_satuan' => ['required', Rule::in(['AKTIF', 'TIDAK AKTIF'])],
        ]);
    }

}
