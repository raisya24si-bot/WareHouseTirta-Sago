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

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN (buat kartu statistik di atas tabel)
        |--------------------------------------------------------------------------
        */

        $summary = [
            'total' => MasterBarang::count(),
            'menipis' => MasterBarang::where('stok_status', 'MENIPIS')->count(),
            'habis' => MasterBarang::where('stok_status', 'HABIS')->count(),
            'kategori' => MasterKategori::where('status_master_kategori', 'AKTIF')->count(),
        ];

        return view('master.barang.index', compact('barangs', 'categories', 'satuans', 'perPage', 'summary'));
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


    /*
    |--------------------------------------------------------------------------
    | IMPORT CSV / EXCEL
    |--------------------------------------------------------------------------
    |
    | Minimal kolom yang dibaca: Kode Barang, Nama Barang, Kategori, Satuan.
    | Min. Stok & Stok Saat Ini opsional (default 0 kalau kosong).
    |
    | - Nama header di baris pertama fleksibel (lihat normalizeHeader()) --
    |   "Nama Barang", "nama_barang", "nm_master_barang" semua dikenali.
    | - Kategori & Satuan dicocokkan berdasarkan NAMA (case-insensitive)
    |   ke data master yang sudah ada. Kalau tidak ketemu, baris itu
    |   dilewati (tidak dibuatkan kategori/satuan baru secara diam-diam).
    | - Kode Barang itu sendiri SELALU di-generate otomatis oleh model
    |   (lihat MasterBarang::booted()) untuk barang baru. Kolom "Kode
    |   Barang" di file cuma dipakai untuk mencocokkan barang yang SUDAH
    |   ADA (supaya import ulang meng-update, bukan duplikat).
    |
    | CATATAN: hanya .csv yang didukung di server ini (parser native
    | PHP, tanpa dependency tambahan). .xlsx ditolak dengan pesan yang
    | jelas -- lihat pesan error di bawah untuk cara mengatasinya.
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx', 'max:5120'],
        ]);

        $file = $request->file('file');

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        if ($extension === 'xlsx') {

            return back()->withErrors([
                'file' =>
                    'File .xlsx belum didukung di server ini (belum ada library Excel yang ' .
                    'terpasang). Silakan buka file-nya, lalu "File > Save As / Download" pilih ' .
                    '"CSV (Comma delimited)", dan upload ulang file .csv-nya. Kalau memang butuh ' .
                    'upload .xlsx langsung, install dulu package-nya: ' .
                    'composer require phpoffice/phpspreadsheet',
            ]);
        }

        $path = $file->getRealPath();

        $handle = fopen($path, 'r');

        if ($handle === false) {

            return back()->withErrors([
                'file' => 'File tidak dapat dibaca.',
            ]);
        }

        /*
        | Lewati BOM UTF-8 kalau ada (umum dari file hasil export Excel).
        */

        $bom = fread($handle, 3);

        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $firstLine = fgets($handle);

        rewind($handle);

        if ($bom === "\xEF\xBB\xBF") {
            fread($handle, 3);
        }

        $delimiter = $this->detectDelimiter(
            (string) $firstLine
        );

        $header = fgetcsv($handle, 0, $delimiter);

        if (! $header) {

            fclose($handle);

            return back()->withErrors([
                'file' => 'File kosong atau format tidak dikenali.',
            ]);
        }

        $colMap = [];

        foreach ($header as $idx => $label) {

            $key = $this->normalizeHeaderKey(
                (string) $label
            );

            if ($key !== null) {
                $colMap[$idx] = $key;
            }
        }

        if (! in_array('nama', $colMap, true)) {

            fclose($handle);

            return back()->withErrors([
                'file' =>
                    'Kolom "Nama Barang" tidak ditemukan di file. ' .
                    'Pastikan baris pertama berisi header kolom.',
            ]);
        }

        $created = 0;
        $updated = 0;
        $skipped = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {

            $rowNum++;

            $isBlank = count(
                array_filter(
                    $row,
                    fn ($v) => trim((string) $v) !== ''
                )
            ) === 0;

            if ($isBlank) {
                continue;
            }

            $data = [];

            foreach ($colMap as $idx => $key) {
                $data[$key] = isset($row[$idx])
                    ? trim((string) $row[$idx])
                    : null;
            }

            $nama = $data['nama'] ?? null;

            if (! $nama) {
                $skipped[] = "Baris {$rowNum}: Nama Barang kosong, dilewati.";
                continue;
            }

            $kategoriNama = $data['kategori'] ?? null;

            $kategori = $kategoriNama
                ? MasterKategori::whereRaw(
                    'LOWER(nm_master_kategori) = ?',
                    [strtolower($kategoriNama)]
                )->first()
                : null;

            if (! $kategori) {
                $skipped[] =
                    "Baris {$rowNum}: Kategori " .
                    ($kategoriNama ? "'{$kategoriNama}'" : '(kosong)') .
                    ' tidak ditemukan di Master Kategori, dilewati.';
                continue;
            }

            $satuanNama = $data['satuan'] ?? null;

            $satuan = $satuanNama
                ? MasterSatuan::whereRaw(
                    'LOWER(nm_master_satuan) = ?',
                    [strtolower($satuanNama)]
                )->first()
                : null;

            if (! $satuan) {
                $skipped[] =
                    "Baris {$rowNum}: Satuan " .
                    ($satuanNama ? "'{$satuanNama}'" : '(kosong)') .
                    ' tidak ditemukan di Master Satuan, dilewati.';
                continue;
            }

            $kode = $data['kode'] ?? null;

            $existing = $kode
                ? MasterBarang::where(
                    'kd_master_barang',
                    $kode
                )->first()
                : null;

            $minStok = isset($data['min_stok']) && is_numeric($data['min_stok'])
                ? (int) $data['min_stok']
                : 0;

            $stokAwal = isset($data['stok']) && is_numeric($data['stok'])
                ? (int) $data['stok']
                : 0;

            $payload = [
                'nm_master_barang' => $nama,
                'fk_kategori' => $kategori->id_master_kategori,
                'fk_satuan' => $satuan->id_master_satuan,
                'minimum_stok' => $minStok,
                'stok_saat_ini' => $stokAwal,
                'status_master_barang' => 'AKTIF',
            ];

            if ($existing) {

                $payload['updated_by'] = auth()->id() ?? 1;

                $existing->update($payload);

                $updated++;

            } else {

                $payload['created_by'] = auth()->id() ?? 1;

                MasterBarang::create($payload);

                $created++;
            }
        }

        fclose($handle);

        $message =
            "Import selesai: {$created} barang baru ditambahkan" .
            ($updated > 0 ? ", {$updated} barang diperbarui" : '') .
            '.';

        if (! empty($skipped)) {

            $message .= ' ' . count($skipped) . ' baris dilewati.';

            return back()
                ->with('success', $message)
                ->with('import_errors', $skipped);
        }

        return back()->with('success', $message);
    }


    public function importTemplate()
    {
        $rows = [
            ['Kode Barang', 'Nama Barang', 'Kategori', 'Satuan', 'Min Stok', 'Stok Saat Ini'],
            ['', 'Contoh: Pipa PVC 4 Inch', 'Pipa', 'Batang', 10, 50],
            ['', 'Contoh: Semen Portland 50kg', 'Fitting', 'Pcs', 5, 20],
        ];

        return response()->streamDownload(
            function () use ($rows) {

                $out = fopen('php://output', 'w');

                /*
                | BOM UTF-8 supaya Excel membaca karakter dengan benar.
                */
                fwrite($out, "\xEF\xBB\xBF");

                foreach ($rows as $row) {
                    fputcsv($out, $row);
                }

                fclose($out);
            },
            'template-import-barang.csv',
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }


    private function detectDelimiter(string $firstLine): string
    {
        $commas = substr_count($firstLine, ',');

        $semicolons = substr_count($firstLine, ';');

        /*
        | Excel versi Bahasa Indonesia biasanya export CSV pakai ";"
        | karena "," dipakai sebagai desimal.
        */

        return $semicolons > $commas ? ';' : ',';
    }


    private function normalizeHeaderKey(string $label): ?string
    {
        $normalized = strtolower(trim($label));

        $normalized = preg_replace('/[^a-z0-9]+/', '_', $normalized);

        $normalized = trim((string) $normalized, '_');

        $aliases = [
            'kode' => 'kode',
            'kode_barang' => 'kode',
            'kd_master_barang' => 'kode',
            'kd_barang' => 'kode',
            'sku' => 'kode',

            'nama' => 'nama',
            'nama_barang' => 'nama',
            'nm_master_barang' => 'nama',
            'nm_barang' => 'nama',

            'kategori' => 'kategori',
            'nm_master_kategori' => 'kategori',

            'satuan' => 'satuan',
            'nm_master_satuan' => 'satuan',

            'min_stok' => 'min_stok',
            'minimum_stok' => 'min_stok',
            'stok_minimum' => 'min_stok',
            'min_stock' => 'min_stok',

            'stok' => 'stok',
            'stok_saat_ini' => 'stok',
            'qty' => 'stok',
            'quantity' => 'stok',
        ];

        return $aliases[$normalized] ?? null;
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