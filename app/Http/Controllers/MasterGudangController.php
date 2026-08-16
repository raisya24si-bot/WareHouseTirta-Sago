<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
use App\Models\MasterRak;
use App\Models\MasterRow;
use App\Models\MasterStatusGudang;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterGudangController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $tab = $request->string('tab', 'gudang')->toString();
        $tab = in_array($tab, ['gudang', 'rak', 'row', 'lokasi'], true) ? $tab : 'gudang';

        $perPage = $this->perPageOption($request);

        $search = trim($request->string('search')->toString());

        $statuses = MasterStatusGudang::orderBy('nm_status_gudang')->get();
        $allGudangs = MasterGudang::orderBy('nm_gudang')->get();
        $allRaks = MasterRak::with('gudang')->orderBy('kd_rak')->get();
        $allRows = MasterRow::with('rak.gudang')->orderBy('kd_row')->get();

        $gudangs = collect();
        $raks = collect();
        $rows = collect();
        $lokasis = collect();

        if ($tab === 'gudang') {
            $query = MasterGudang::with('statusGudang');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('kd_gudang', 'like', "%{$search}%")
                        ->orWhere('nm_gudang', 'like', "%{$search}%")
                        ->orWhere('kepala_gudang', 'like', "%{$search}%")
                        ->orWhere('alamat_gudang', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('fk_status_gudang', $request->integer('status'));
            }

            $gudangs = $query
                ->latest('id_gudang')
                ->paginate($this->resolvePerPage($request, $query), ['*'], 'gudang_page')
                ->withQueryString();
        }

        if ($tab === 'rak') {
            $query = MasterRak::with('gudang');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('kd_rak', 'like', "%{$search}%")
                        ->orWhereHas('gudang', function ($gudang) use ($search) {
                            $gudang->where('kd_gudang', 'like', "%{$search}%")
                                ->orWhere('nm_gudang', 'like', "%{$search}%");
                        });
                });
            }

            if ($request->filled('status')) {
                $query->where('status_rak', $request->string('status')->toString());
            }

            $raks = $query
                ->latest('id_rak')
                ->paginate($this->resolvePerPage($request, $query), ['*'], 'rak_page')
                ->withQueryString();
        }

        if ($tab === 'row') {
            $query = MasterRow::with('rak.gudang');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('kd_row', 'like', "%{$search}%")
                        ->orWhereHas('rak', function ($rak) use ($search) {
                            $rak->where('kd_rak', 'like', "%{$search}%");
                        });
                });
            }

            if ($request->filled('status')) {
                $query->where('status_row', $request->string('status')->toString());
            }

            $rows = $query
                ->latest('id_row')
                ->paginate($this->resolvePerPage($request, $query), ['*'], 'row_page')
                ->withQueryString();
        }

        if ($tab === 'lokasi') {
            $query = StrukturLokasi::with('row.rak.gudang');

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('kd_lokasi', 'like', "%{$search}%")
                        ->orWhere('bin', 'like', "%{$search}%")
                        ->orWhereHas('row', function ($row) use ($search) {
                            $row->where('kd_row', 'like', "%{$search}%")
                                ->orWhereHas('rak', function ($rak) use ($search) {
                                    $rak->where('kd_rak', 'like', "%{$search}%");
                                });
                        });
                });
            }

            if ($request->filled('status')) {
                $query->where('status_lokasi', $request->string('status')->toString());
            }

            $lokasis = $query
                ->latest('id_lokasi')
                ->paginate($this->resolvePerPage($request, $query), ['*'], 'lokasi_page')
                ->withQueryString();
        }

        return view('master.gudang.index', compact(
            'tab',
            'perPage',
            'statuses',
            'allGudangs',
            'allRaks',
            'allRows',
            'gudangs',
            'raks',
            'rows',
            'lokasis'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nm_gudang' => ['required', 'string', 'max:50', Rule::unique('tbl_master_gudang', 'nm_gudang')],
            'kepala_gudang' => ['nullable', 'string', 'max:100'],
            'alamat_gudang' => ['nullable', 'string', 'max:500'],
            'fk_status_gudang' => ['required', 'exists:tbl_master_status_gudang,id_status_gudang'],
        ]);

        $next = ((int) MasterGudang::withTrashed()->max('id_gudang')) + 1;

        MasterGudang::create([
            'kd_gudang' => 'GU' . $next,
            'nm_gudang' => $validated['nm_gudang'],
            'kepala_gudang' => $validated['kepala_gudang'] ?? null,
            'alamat_gudang' => $validated['alamat_gudang'] ?? null,
            'desc_gudang' => $validated['alamat_gudang'] ?? null,
            'fk_status_gudang' => $validated['fk_status_gudang'],
        ]);

        return back()->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, MasterGudang $masterGudang)
    {
        $validated = $request->validate([
            'nm_gudang' => ['required', 'string', 'max:50', Rule::unique('tbl_master_gudang', 'nm_gudang')->ignore($masterGudang->id_gudang, 'id_gudang')],
            'kepala_gudang' => ['nullable', 'string', 'max:100'],
            'alamat_gudang' => ['nullable', 'string', 'max:500'],
            'fk_status_gudang' => ['required', 'exists:tbl_master_status_gudang,id_status_gudang'],
        ]);

        $masterGudang->update([
            'nm_gudang' => $validated['nm_gudang'],
            'kepala_gudang' => $validated['kepala_gudang'] ?? null,
            'alamat_gudang' => $validated['alamat_gudang'] ?? null,
            'desc_gudang' => $validated['alamat_gudang'] ?? null,
            'fk_status_gudang' => $validated['fk_status_gudang'],
        ]);

        return back()->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(MasterGudang $masterGudang)
    {
        if ($masterGudang->raks()->exists()) {
            return back()->withErrors([
                'gudang' => 'Gudang tidak dapat dihapus karena masih memiliki data rak.',
            ]);
        }

        $masterGudang->delete();

        return back()->with('success', 'Gudang berhasil dihapus.');
    }
}
