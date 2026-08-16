<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterGudang;
use App\Models\Opname;
use App\Models\OpnameDetail;
use App\Models\StokLokasi;
use App\Models\StrukturLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OpnameController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);
        $search = trim((string) $request->string('search'));

        $query = Opname::with('gudang')
            ->withCount([
                'details',
                'details as details_counted_count' => fn ($q) => $q->whereNotNull('stok_aktual'),
                'details as details_selisih_count' => fn ($q) => $q->where('status_item', 'SELISIH'),
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kd_opname', 'like', "%{$search}%")
                    ->orWhereHas('gudang', function ($g) use ($search) {
                        $g->where('nm_gudang', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_opname', $request->string('status')->toString());
        }

        if ($request->boolean('issue')) {
            $query->whereHas('details', fn ($q) => $q->where('status_item', 'SELISIH'));
        }

        $opnames = $query->latest('id_opname')->paginate($this->resolvePerPage($request, $query))->withQueryString();

        // Kartu ringkasan di atas (sesuai referensi "Stock Opname by Location")
        $summary = [
            'ongoing' => Opname::where('status_opname', 'ONGOING')->count(),
            'discrepancies' => Opname::where('status_opname', 'ONGOING')
                ->whereHas('details', fn ($q) => $q->where('status_item', 'SELISIH'))
                ->count(),
            'completed_this_month' => Opname::where('status_opname', 'COMPLETED')
                ->whereMonth('tgl_selesai', now()->month)
                ->whereYear('tgl_selesai', now()->year)
                ->count(),
        ];

        $gudangs = MasterGudang::orderBy('nm_gudang')->get();

        // Semua bin AKTIF beserta rantai rak/row/gudang-nya, dipakai
        // modal "Create New Stock Opname" untuk filter & search di client-side.
        $lokasis = StrukturLokasi::with('row.rak.gudang')
            ->where('status_lokasi', 'AKTIF')
            ->orderBy('bin')
            ->get();

        return view('opname.index', compact('opnames', 'summary', 'gudangs', 'lokasis', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_gudang' => ['required', 'exists:tbl_master_gudang,id_gudang'],
            'lokasi_ids' => ['required', 'array', 'min:1'],
            'lokasi_ids.*' => ['integer', 'exists:tbl_master_lokasi,id_lokasi'],
        ]);

        $opname = DB::transaction(function () use ($validated) {
            $opname = Opname::create([
                'fk_gudang' => $validated['fk_gudang'],
                'tgl_mulai' => now()->toDateString(),
                'status_opname' => 'ONGOING',
                'created_by' => auth()->id() ?? 1,
            ]);

            $opname->lokasis()->attach($validated['lokasi_ids']);

            // Generate baris detail otomatis dari stok yang sudah
            // tercatat (tbl_stok_lokasi) pada tiap bin terpilih.
            $stokItems = StokLokasi::with('barang')
                ->whereIn('fk_lokasi', $validated['lokasi_ids'])
                ->where('qty_stok', '>', 0)
                ->get();

            foreach ($stokItems as $stok) {
                OpnameDetail::create([
                    'fk_opname' => $opname->id_opname,
                    'fk_lokasi' => $stok->fk_lokasi,
                    'fk_barang' => $stok->fk_barang,
                    'stok_sistem' => $stok->qty_stok,
                    'status_item' => 'BELUM DIHITUNG',
                    'created_by' => auth()->id() ?? 1,
                ]);
            }

            return $opname;
        });

        return redirect()
            ->route('opname.show', $opname)
            ->with('success', 'Opname ' . $opname->kd_opname . ' berhasil dibuat. Silakan mulai hitung fisik.');
    }

    public function show(Request $request, Opname $opname)
    {
        $opname->load('gudang');

        $perPage = $this->perPageOption($request);
        $search = trim((string) $request->string('search'));

        $query = OpnameDetail::with(['barang', 'lokasi'])
            ->where('fk_opname', $opname->id_opname);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($b) use ($search) {
                    $b->where('kd_master_barang', 'like', "%{$search}%")
                        ->orWhere('nm_master_barang', 'like', "%{$search}%");
                })->orWhereHas('lokasi', function ($l) use ($search) {
                    $l->where('bin', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('bin')) {
            $query->where('fk_lokasi', $request->integer('bin'));
        }

        $details = $query->orderBy('fk_lokasi')->paginate($this->resolvePerPage($request, $query))->withQueryString();

        $bins = $opname->lokasis()->orderBy('bin')->get();

        // Bin yang dipilih waktu create tapi belum ada barang tercatat
        // sama sekali (supaya tetap kelihatan di halaman & bisa diisi
        // lewat "+ Tambah Barang", bukan hilang begitu saja).
        $binIdsWithDetails = OpnameDetail::where('fk_opname', $opname->id_opname)
            ->pluck('fk_lokasi')
            ->unique();

        $emptyBins = $bins->whereNotIn('id_lokasi', $binIdsWithDetails)->values();

        if ($search !== '') {
            // Lagi nyari teks tertentu -> bin kosong gak relevan buat ditampilkan.
            $emptyBins = collect();
        } elseif ($request->filled('bin')) {
            $emptyBins = $emptyBins->where('id_lokasi', $request->integer('bin'))->values();
        }

        $allBarangs = \App\Models\MasterBarang::where('status_master_barang', 'AKTIF')
            ->orderBy('nm_master_barang')
            ->get();

        // Kalau lagi filter ke 1 bin spesifik, cek apakah bin itu boleh
        // dihapus dari opname (semua itemnya harus belum pernah dihitung).
        $selectedBin = null;
        $selectedBinCanDelete = false;
        if ($request->filled('bin')) {
            $selectedBin = $bins->firstWhere('id_lokasi', $request->integer('bin'));
            if ($selectedBin) {
                $selectedBinCanDelete = ! OpnameDetail::where('fk_opname', $opname->id_opname)
                    ->where('fk_lokasi', $selectedBin->id_lokasi)
                    ->whereNotNull('stok_aktual')
                    ->exists();
            }
        }

        $totalItems = $opname->details()->count();
        $countedItems = $opname->details()->whereNotNull('stok_aktual')->count();
        $selisihItems = $opname->details()->where('status_item', 'SELISIH')->count();
        $progress = $totalItems > 0 ? (int) round(($countedItems / $totalItems) * 100) : 0;

        return view('opname.show', compact(
            'opname', 'details', 'bins', 'emptyBins', 'perPage', 'allBarangs',
            'totalItems', 'countedItems', 'selisihItems', 'progress',
            'selectedBin', 'selectedBinCanDelete'
        ));
    }

    public function update(Request $request, Opname $opname)
    {
        $validated = $request->validate([
            'detail' => ['required', 'array'],
            'detail.*' => ['nullable', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $opname) {
            foreach ($validated['detail'] as $detailId => $stokAktual) {
                $detail = OpnameDetail::where('fk_opname', $opname->id_opname)
                    ->where('id_opname_detail', $detailId)
                    ->first();

                if (! $detail) {
                    continue;
                }

                $detail->stok_aktual = $stokAktual;
                $detail->updated_by = auth()->id() ?? 1;
                $detail->recalculate();
                $detail->save();
            }

            // Kalau semua baris sudah dihitung, tandai opname selesai.
            $total = $opname->details()->count();
            $counted = $opname->details()->whereNotNull('stok_aktual')->count();

            $opname->update([
                'status_opname' => ($total > 0 && $total === $counted) ? 'COMPLETED' : 'ONGOING',
                'tgl_selesai' => ($total > 0 && $total === $counted) ? now()->toDateString() : null,
                'updated_by' => auth()->id() ?? 1,
            ]);
        });

        return back()->with('success', 'Hasil hitung fisik berhasil disimpan.');
    }

    public function destroy(Opname $opname)
    {
        $opname->delete();

        return redirect()->route('opname.index')->with('success', 'Opname berhasil dihapus.');
    }

    /**
     * Tambah barang baru ke sebuah bin langsung dari halaman Opname
     * (dipakai saat bin kosong / barang belum tercatat di lokasi itu).
     * Ini juga yang jadi sumber data tbl_stok_lokasi untuk opname berikutnya.
     */
    public function addItem(Request $request, Opname $opname)
    {
        $validated = $request->validate([
            'fk_lokasi' => ['required', 'exists:tbl_master_lokasi,id_lokasi'],
            'fk_barang' => ['required', 'exists:tbl_master_barang,id_master_barang'],
            'stok_sistem' => ['required', 'integer', 'min:0'],
        ]);

        // Bin harus termasuk yang dipilih di opname ini.
        $isBinValid = $opname->lokasis()->where('tbl_master_lokasi.id_lokasi', $validated['fk_lokasi'])->exists();
        if (! $isBinValid) {
            return back()->withErrors(['fk_lokasi' => 'Bin tersebut tidak termasuk dalam sesi opname ini.']);
        }

        $alreadyExists = OpnameDetail::where('fk_opname', $opname->id_opname)
            ->where('fk_lokasi', $validated['fk_lokasi'])
            ->where('fk_barang', $validated['fk_barang'])
            ->exists();

        if ($alreadyExists) {
            return back()->withErrors(['fk_barang' => 'Barang ini sudah tercatat di bin tersebut untuk opname ini.']);
        }

        DB::transaction(function () use ($validated) {
            // Catat/update juga sebagai master stok per lokasi, supaya
            // opname berikutnya otomatis mengenali barang ini di bin ini.
            StokLokasi::updateOrCreate(
                ['fk_lokasi' => $validated['fk_lokasi'], 'fk_barang' => $validated['fk_barang']],
                ['qty_stok' => $validated['stok_sistem'], 'updated_by' => auth()->id() ?? 1]
            );
        });

        OpnameDetail::create([
            'fk_opname' => $opname->id_opname,
            'fk_lokasi' => $validated['fk_lokasi'],
            'fk_barang' => $validated['fk_barang'],
            'stok_sistem' => $validated['stok_sistem'],
            'status_item' => 'BELUM DIHITUNG',
            'created_by' => auth()->id() ?? 1,
        ]);

        return back()->with('success', 'Barang berhasil ditambahkan ke opname.');
    }

    /**
     * Edit System Qty / keterangan sebuah item di opname. Boleh
     * dilakukan kapan saja (termasuk setelah opname COMPLETED),
     * dan kalau Actual Qty-nya sudah diisi, selisih & status
     * dihitung ulang otomatis mengikuti System Qty yang baru.
     */
    public function updateItem(Request $request, Opname $opname, OpnameDetail $item)
    {
        abort_unless($item->fk_opname === $opname->id_opname, 404);

        $validated = $request->validate([
            'stok_sistem' => ['required', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $item->stok_sistem = $validated['stok_sistem'];
        $item->keterangan = $validated['keterangan'] ?? null;
        $item->updated_by = auth()->id() ?? 1;
        $item->recalculate();
        $item->save();

        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Hapus 1 baris item dari opname. Hanya boleh kalau item itu
     * belum diisi Actual Qty (belum dihitung fisik), supaya hasil
     * hitung yang sudah ada gak pernah hilang.
     */
    public function deleteItem(Opname $opname, OpnameDetail $item)
    {
        abort_unless($item->fk_opname === $opname->id_opname, 404);

        if ($item->stok_aktual !== null) {
            return back()->withErrors([
                'item' => 'Barang ini sudah dihitung (ada Actual Qty), tidak bisa dihapus dari opname.',
            ]);
        }

        $item->delete();

        return back()->with('success', 'Barang berhasil dihapus dari opname.');
    }

    /**
     * Keluarkan 1 bin dari opname (beserta semua baris itemnya).
     * Hanya boleh kalau SEMUA item di bin itu belum dihitung fisik
     * (belum ada Actual Qty).
     */
    public function deleteBin(Opname $opname, StrukturLokasi $lokasi)
    {
        $isBinValid = $opname->lokasis()->where('tbl_master_lokasi.id_lokasi', $lokasi->id_lokasi)->exists();
        if (! $isBinValid) {
            return back()->withErrors(['bin' => 'Bin tersebut tidak termasuk dalam sesi opname ini.']);
        }

        $adaYangSudahDihitung = OpnameDetail::where('fk_opname', $opname->id_opname)
            ->where('fk_lokasi', $lokasi->id_lokasi)
            ->whereNotNull('stok_aktual')
            ->exists();

        if ($adaYangSudahDihitung) {
            return back()->withErrors([
                'bin' => 'Bin ' . $lokasi->bin . ' masih ada barang yang sudah dihitung, tidak bisa dihapus dari opname.',
            ]);
        }

        DB::transaction(function () use ($opname, $lokasi) {
            OpnameDetail::where('fk_opname', $opname->id_opname)
                ->where('fk_lokasi', $lokasi->id_lokasi)
                ->delete();

            $opname->lokasis()->detach($lokasi->id_lokasi);
        });

        return redirect()
            ->route('opname.show', $opname)
            ->with('success', 'Bin ' . $lokasi->bin . ' berhasil dikeluarkan dari opname.');
    }
}