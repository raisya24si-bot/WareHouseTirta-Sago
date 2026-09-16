<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterAlasanRetur;
use App\Models\MasterStatusRetur;
use App\Models\MasterSupplier;
use App\Models\PenerimaanBarang;
use App\Models\ReturBarang;
use App\Models\ReturBarangDetail;
use App\Models\ReturBarangFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturBarangController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);

        $query = $this->filteredQuery($request);

        $returs = $query
            ->latest('id_retur')
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        $tabCounts = [
            'all' => ReturBarang::count(),
            'proses' => $this->countByStatusGroup(MasterStatusRetur::GROUP_DALAM_PROSES),
            'selesai' => $this->countByStatusGroup(MasterStatusRetur::GROUP_SELESAI),
        ];

        $summary = [
            'total_dokumen' => $tabCounts['all'],
            'total_unit' => (int) ReturBarangDetail::whereHas(
                'returBarang',
                fn ($q) => $q->whereNull('deleted_at')
            )->sum('qty_diretur'),

            'menunggu_vendor' => $this->countByStatus('MENUNGGU_RESPON_VENDOR'),
            'proses_kirim_ganti' => $this->countByStatus('PROSES_KIRIM_GANTI'),

            'selesai' => $tabCounts['selesai'],
            'nilai_terselamatkan' => (float) ReturBarang::whereHas(
                'statusRetur',
                fn ($q) => $q->where('kd_status_retur', 'SELESAI')
            )->sum('nilai_terselamatkan'),
        ];

        $suppliers = MasterSupplier::query()
            ->where('status_master_supplier', 'AKTIF')
            ->orderBy('nm_master_supplier')
            ->get();

        // Data buat modal "+ Buat Retur Baru" yang nempel di halaman ini
        // (ikut template: bukan halaman terpisah, tapi overlay modal).
        $grns = PenerimaanBarang::query()
            ->whereHas('statusPenerimaan', fn ($q) => $q->where('kd_status_penerimaan_barang', 'APPROVED'))
            ->whereHas('details', fn ($q) => $q->where('qty_rusak', '>', 0))
            ->with('po.supplier')
            ->latest('id_penerimaan')
            ->get();

        $alasanList = MasterAlasanRetur::aktif()->orderBy('nm_alasan_retur')->get();

        return view('retur.index', [
            'returs' => $returs,
            'tabCounts' => $tabCounts,
            'summary' => $summary,
            'suppliers' => $suppliers,
            'perPage' => $perPage,
            'grns' => $grns,
            'alasanList' => $alasanList,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT REKAP BAP (CSV)
    |--------------------------------------------------------------------------
    */

    public function export(Request $request)
    {
        $rows = $this->filteredQuery($request)
            ->latest('id_retur')
            ->get();

        $filename = 'rekap-bap-retur-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($rows) {

            $handle = fopen('php://output', 'w');

            // UTF-8 BOM biar kebuka rapi di Excel.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No. Retur',
                'Tanggal Retur',
                'No. GRN',
                'No. PO',
                'Supplier',
                'Total SKU',
                'Total Unit Reject',
                'Nilai Total Retur',
                'Nilai Terselamatkan',
                'Status',
                'No. Resi Pengiriman',
                'Ekspedisi',
                'Catatan Retur',
            ]);

            foreach ($rows as $retur) {
                fputcsv($handle, [
                    $retur->kd_retur,
                    optional($retur->tgl_retur)->format('Y-m-d'),
                    $retur->penerimaanBarang?->kd_penerimaan ?? '-',
                    $retur->penerimaanBarang?->po?->kd_po ?? '-',
                    $retur->supplier?->nm_master_supplier ?? '-',
                    $retur->details->count(),
                    (int) $retur->details->sum('qty_diretur'),
                    (float) $retur->nilai_total_retur,
                    (float) $retur->nilai_terselamatkan,
                    $retur->statusRetur?->nm_status_retur ?? '-',
                    $retur->no_resi_pengiriman ?: '-',
                    $retur->nm_ekspedisi ?: '-',
                    $retur->catatan_retur ?: '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX: ITEM REJECT PER GRN (buat isi modal secara dinamis)
    |--------------------------------------------------------------------------
    */

    public function itemsForGrn(PenerimaanBarang $grn)
    {
        $items = $grn->details()
            ->with('barang')
            ->where('qty_rusak', '>', 0)
            ->get()
            ->map(function ($detail) {

                $sudahDiretur = (int) ReturBarangDetail::where(
                    'fk_penerimaan_barang_detail',
                    $detail->id_penerimaan_barang_detail
                )->sum('qty_diretur');

                $sisa = (int) $detail->qty_rusak - $sudahDiretur;

                return [
                    'id_penerimaan_barang_detail' => $detail->id_penerimaan_barang_detail,
                    'fk_barang' => $detail->fk_barang,
                    'nama_barang' => $detail->barang?->nm_master_barang,
                    'qty_rusak' => (int) $detail->qty_rusak,
                    'qty_sisa_retur' => max($sisa, 0),
                    'harga_satuan' => (float) $detail->harga_satuan,
                ];
            })
            ->filter(fn ($item) => $item['qty_sisa_retur'] > 0)
            ->values();

        return response()->json(['items' => $items]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fk_penerimaan_barang' => ['required', 'exists:tbl_penerimaan_barang,id_penerimaan'],
            'catatan_retur' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.fk_penerimaan_barang_detail' => ['required', 'exists:tbl_penerimaan_barang_detail,id_penerimaan_barang_detail'],
            'items.*.qty_diretur' => ['required', 'integer', 'min:1'],
            'items.*.catatan_detail' => ['nullable', 'string', 'max:255'],
            'items.*.alasan_ids' => ['required', 'array', 'min:1'],
            'items.*.alasan_ids.*' => ['exists:tbl_master_alasan_retur,id_alasan_retur'],
            'items.*.fotos' => ['nullable', 'array'],
            'items.*.fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'items.required' => 'Minimal pilih 1 item barang yang mau diretur.',
            'items.*.qty_diretur.min' => 'Qty retur minimal 1.',
            'items.*.alasan_ids.required' => 'Pilih minimal 1 alasan kerusakan untuk tiap item.',
            'items.*.fotos.*.image' => 'File bukti harus berupa gambar.',
            'items.*.fotos.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
        ]);

        $userId = auth()->id() ?? 1;

        // Tombol "Simpan Draf" vs "Terbitkan & Kirim BAP Retur" di modal.
        $isDraft = $request->input('mode') === 'draft';

        $retur = DB::transaction(function () use ($validated, $userId, $isDraft) {

            $statusAwal = MasterStatusRetur::where(
                'kd_status_retur',
                $isDraft ? 'DRAFT' : 'MENUNGGU_RESPON_VENDOR'
            )->firstOrFail();

            $retur = ReturBarang::create([
                'kd_retur' => $this->generateKodeRetur(),
                'tgl_retur' => now()->toDateString(),
                'fk_penerimaan_barang' => $validated['fk_penerimaan_barang'],
                'fk_status_retur' => $statusAwal->id_status_retur,
                'catatan_retur' => $validated['catatan_retur'] ?? null,
                'nilai_total_retur' => 0,
                'submit_by' => $isDraft ? null : $userId,
                'submit_at' => $isDraft ? null : now(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);

            $nilaiTotal = 0;

            foreach ($validated['items'] as $index => $item) {

                $detailSumber = \App\Models\PenerimaanBarangDetail::findOrFail(
                    $item['fk_penerimaan_barang_detail']
                );

                $subtotal = $item['qty_diretur'] * (float) $detailSumber->harga_satuan;
                $nilaiTotal += $subtotal;

                $detail = ReturBarangDetail::create([
                    'fk_retur' => $retur->id_retur,
                    'fk_penerimaan_barang_detail' => $detailSumber->id_penerimaan_barang_detail,
                    'fk_barang' => $detailSumber->fk_barang,
                    'qty_reject_qc' => $detailSumber->qty_rusak,
                    'qty_diretur' => $item['qty_diretur'],
                    'harga_satuan' => $detailSumber->harga_satuan,
                    'subtotal_retur' => $subtotal,
                    'catatan_detail' => $item['catatan_detail'] ?? null,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);

                $detail->alasan()->sync($item['alasan_ids']);

                // Foto bukti kerusakan untuk item ini
                $fotos = request()->file("items.{$index}.fotos", []);

                foreach ($fotos as $file) {

                    $path = $file->store('retur-bukti', 'public');

                    ReturBarangFoto::create([
                        'fk_retur_detail' => $detail->id_retur_detail,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'ukuran_file' => $file->getSize(),
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]);
                }
            }

            $retur->update(['nilai_total_retur' => $nilaiTotal]);

            return $retur;
        });

        return redirect()
            ->route('retur.show', $retur)
            ->with('success', $isDraft
                ? 'Draf retur '.$retur->kd_retur.' berhasil disimpan.'
                : 'Dokumen retur '.$retur->kd_retur.' berhasil diterbitkan dan menunggu respon vendor.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(ReturBarang $retur)
    {
        $retur->load([
            'statusRetur',
            'penerimaanBarang.po.supplier',
            'details.barang',
            'details.alasan',
            'details.fotos',
            'submittedBy',
        ]);

        return view('retur.show', ['retur' => $retur]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT / UPDATE (khusus status DRAFT)
    |--------------------------------------------------------------------------
    |
    | GRN sumbernya dikunci -- gak bisa diganti lewat sini, cuma qty,
    | catatan, alasan kerusakan per item, dan foto bukti yang bisa
    | diubah. Item bisa dihapus (uncheck), tapi nggak bisa nambah item
    | baru dari GRN lain di sini -- itu tetap lewat form "Buat Retur
    | Baru" yang terpisah.
    */

    public function edit(ReturBarang $retur)
    {
        abort_unless($retur->canBeEdited(), 403, 'Dokumen retur ini sudah terkirim ke vendor dan tidak bisa diedit lagi.');

        $retur->load([
            'statusRetur',
            'penerimaanBarang.po.supplier',
            'details.barang',
            'details.alasan',
            'details.fotos',
        ]);

        $alasanList = MasterAlasanRetur::aktif()->orderBy('nm_alasan_retur')->get();

        return view('retur.edit', [
            'retur' => $retur,
            'alasanList' => $alasanList,
        ]);
    }

    public function update(Request $request, ReturBarang $retur)
    {
        abort_unless($retur->canBeEdited(), 403, 'Dokumen retur ini sudah terkirim ke vendor dan tidak bisa diedit lagi.');

        $validated = $request->validate([
            'catatan_retur' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.id_retur_detail' => [
                'required', 'integer', 'exists:tbl_retur_barang_detail,id_retur_detail',
            ],
            'items.*.qty_diretur' => ['required', 'integer', 'min:1'],
            'items.*.catatan_detail' => ['nullable', 'string', 'max:255'],
            'items.*.alasan_ids' => ['required', 'array', 'min:1'],
            'items.*.alasan_ids.*' => ['exists:tbl_master_alasan_retur,id_alasan_retur'],
            'items.*.fotos' => ['nullable', 'array'],
            'items.*.fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'items.required' => 'Minimal 1 item tersisa di dokumen retur ini.',
            'items.*.qty_diretur.min' => 'Qty retur minimal 1.',
            'items.*.alasan_ids.required' => 'Pilih minimal 1 alasan kerusakan untuk tiap item.',
        ]);

        $userId = auth()->id() ?? 1;
        $isDraft = $request->input('mode') === 'draft';

        DB::transaction(function () use ($retur, $validated, $userId, $isDraft) {

            $keptDetailIds = collect($validated['items'])->pluck('id_retur_detail')->all();

            // Item yang di-uncheck di form dianggap dikeluarkan dari
            // dokumen retur ini.
            $retur->details()
                ->whereNotIn('id_retur_detail', $keptDetailIds)
                ->get()
                ->each(fn (ReturBarangDetail $d) => $d->update(['deleted_by' => $userId]))
                ->each(fn (ReturBarangDetail $d) => $d->delete());

            $nilaiTotal = 0;

            foreach ($validated['items'] as $index => $item) {

                $detail = ReturBarangDetail::findOrFail($item['id_retur_detail']);

                abort_unless($detail->fk_retur === $retur->id_retur, 403);

                $subtotal = $item['qty_diretur'] * (float) $detail->harga_satuan;
                $nilaiTotal += $subtotal;

                $detail->update([
                    'qty_diretur' => $item['qty_diretur'],
                    'subtotal_retur' => $subtotal,
                    'catatan_detail' => $item['catatan_detail'] ?? null,
                    'updated_by' => $userId,
                ]);

                $detail->alasan()->sync($item['alasan_ids']);

                $fotos = request()->file("items.{$index}.fotos", []);

                foreach ($fotos as $file) {

                    $path = $file->store('retur-bukti', 'public');

                    ReturBarangFoto::create([
                        'fk_retur_detail' => $detail->id_retur_detail,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'ukuran_file' => $file->getSize(),
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]);
                }
            }

            $statusBaru = MasterStatusRetur::where(
                'kd_status_retur',
                $isDraft ? 'DRAFT' : 'MENUNGGU_RESPON_VENDOR'
            )->firstOrFail();

            $retur->update([
                'catatan_retur' => $validated['catatan_retur'] ?? null,
                'nilai_total_retur' => $nilaiTotal,
                'fk_status_retur' => $statusBaru->id_status_retur,
                'submit_by' => $isDraft ? null : ($retur->submit_by ?? $userId),
                'submit_at' => $isDraft ? null : ($retur->submit_at ?? now()),
                'updated_by' => $userId,
            ]);
        });

        return redirect()
            ->route('retur.show', $retur)
            ->with('success', $isDraft
                ? 'Draf retur '.$retur->kd_retur.' berhasil diperbarui.'
                : 'Dokumen retur '.$retur->kd_retur.' berhasil diterbitkan dan menunggu respon vendor.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS (khusus status DRAFT)
    |--------------------------------------------------------------------------
    */

    public function destroy(ReturBarang $retur)
    {
        abort_unless($retur->canBeDeleted(), 403, 'Dokumen retur yang sudah terkirim ke vendor tidak bisa dihapus.');

        $userId = auth()->id() ?? 1;

        DB::transaction(function () use ($retur, $userId) {

            $retur->details()->get()->each(function (ReturBarangDetail $detail) use ($userId) {
                $detail->update(['deleted_by' => $userId]);
                $detail->delete();
            });

            $retur->update(['deleted_by' => $userId]);
            $retur->delete();
        });

        return redirect()
            ->route('retur.index')
            ->with('success', 'Draf retur '.$retur->kd_retur.' berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK BAP (dokumen sudah resmi -- bukan DRAFT lagi)
    |--------------------------------------------------------------------------
    */

    public function cetakBap(ReturBarang $retur)
    {
        abort_unless($retur->canCetakBap(), 403, 'Draf retur belum diterbitkan, BAP belum bisa dicetak.');

        $retur->load([
            'statusRetur',
            'penerimaanBarang.po.supplier',
            'details.barang.satuan',
            'details.alasan',
            'submittedBy',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('retur.pdf.bap', ['retur' => $retur]);

        return $pdf->stream('BAP-Retur-'.$retur->kd_retur.'.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function filteredQuery(Request $request)
    {
        $query = ReturBarang::query()
            ->with([
                'statusRetur',
                'penerimaanBarang.po.supplier',
                'details',
            ]);

        if ($request->filled('search')) {

            $search = trim($request->string('search')->toString());

            $query->where(function ($q) use ($search) {

                $q->where('kd_retur', 'like', "%{$search}%")
                    ->orWhereHas('penerimaanBarang', fn ($grnQuery) => $grnQuery
                        ->where('kd_penerimaan', 'like', "%{$search}%")
                        ->orWhereHas('po.supplier', fn ($supplierQuery) => $supplierQuery
                            ->where('nm_master_supplier', 'like', "%{$search}%")));
            });
        }

        $status = $request->string('status')->toString();

        if ($status === 'proses') {
            $query->whereHas('statusRetur', fn ($q) => $q->whereIn(
                'kd_status_retur',
                MasterStatusRetur::GROUP_DALAM_PROSES
            ));
        } elseif ($status === 'selesai') {
            $query->whereHas('statusRetur', fn ($q) => $q->whereIn(
                'kd_status_retur',
                MasterStatusRetur::GROUP_SELESAI
            ));
        }

        if ($request->filled('supplier')) {
            $query->whereHas(
                'penerimaanBarang.po',
                fn ($q) => $q->where('fk_supplier', $request->integer('supplier'))
            );
        }

        if ($request->filled('month')) {
            // format input: YYYY-MM
            $query->whereRaw(
                "DATE_FORMAT(tgl_retur, '%Y-%m') = ?",
                [$request->string('month')->toString()]
            );
        }

        return $query;
    }

    private function generateKodeRetur(): string
    {
        $year = now()->format('Y');
        $prefix = 'RET-'.$year.'-';

        $numbers = ReturBarang::withTrashed()
            ->where('kd_retur', 'like', $prefix.'%')
            ->pluck('kd_retur');

        $maxNumber = 0;

        foreach ($numbers as $kode) {
            if (preg_match('/^'.preg_quote($prefix, '/').'(\d+)$/', $kode, $matches)) {
                $maxNumber = max($maxNumber, (int) $matches[1]);
            }
        }

        return $prefix.str_pad((string) ($maxNumber + 1), 3, '0', STR_PAD_LEFT);
    }

    private function countByStatus(string $kode): int
    {
        return ReturBarang::whereHas(
            'statusRetur',
            fn ($q) => $q->where('kd_status_retur', $kode)
        )->count();
    }

    private function countByStatusGroup(array $kodes): int
    {
        return ReturBarang::whereHas(
            'statusRetur',
            fn ($q) => $q->whereIn('kd_status_retur', $kodes)
        )->count();
    }
}