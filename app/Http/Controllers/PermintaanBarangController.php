<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermintaanBarangController extends Controller
{

    protected function dummyData(): array
    {
        return [
            'BPB-2023-1110' => [
                'kode' => 'BPB-2023-1110',
                'judul' => 'Perbaikan Pipa Transmisi HDPE 300mm Kebocoran Jl. Sudirman KM 4',
                'prioritas' => 'Sangat Mendesak',
                'prioritas_kode' => 'darurat',
                'tanggal' => '24 Okt 2023',
                'waktu' => '08:42 WIB (Hari ini)',
                'waktu_registrasi' => '25 Okt 2023, 09:30 WIB',
                'spk_status' => 'belum_ada',
                'spk_label' => 'Belum Ada SPK (Darurat)',
                'spk_kode' => 'SPK-TEMP-EMERGENCY-09',
                'spk_pekerjaan' => 'Pipa Bocor Jl. Gatot S...',
                'gudang_tujuan' => 'GU-1 (Gudang Induk Distribusi)',
                'status' => 'draft',
                'status_label' => 'Draf Permintaan',
                'pegawai_pemohon' => 'Budi Pratama',
                'subbagian_pemohon' => 'Subbag Pemeliharaan Distribusi',
                'total_jenis_barang' => 3,
                'total_kuantitas' => 16,
                'kesiapan_stok' => 100,
                'target_penyerahan' => 'Hari Ini',
                'target_penyerahan_ket' => 'Prioritas Kebocoran',
                'lampiran_foto' => 1,
                'items' => [
                    [
                        'kode' => 'BRG-PVC-004',
                        'nama' => 'Pipa PVC SNI 4 Inch RRJ S-12.5',
                        'kategori' => 'Pipa Distribusi',
                        'spesifikasi' => 'Tekanan PN-10, Panjang 6 Meter',
                        'satuan' => 'Batang',
                        'jumlah_diminta' => 10,
                        'catatan' => 'Untuk titik sambungan pipa primer patah di Jl. Gatot Subroto',
                        'stok_tersedia' => '142 Btg',
                        'stok_status' => 'aman',
                    ],
                    [
                        'kode' => 'BRG-VLV-012',
                        'nama' => 'Gate Valve Flange 4 Inch Cast Iron PN16',
                        'kategori' => 'Valve & Kontrol',
                        'spesifikasi' => 'Non-Rising Stem, Standard Flange JIS/DIN',
                        'satuan' => 'Unit',
                        'jumlah_diminta' => 2,
                        'catatan' => 'Penggantian gate valve lama yang macet dan rembes',
                        'stok_tersedia' => '8 Unit',
                        'stok_status' => 'aman',
                    ],
                    [
                        'kode' => 'BRG-FIT-088',
                        'nama' => 'Gibault Joint 4 Inch',
                        'kategori' => 'Aksesoris Fitting',
                        'spesifikasi' => 'Rubber Ring EPDM, Baut Galvanis',
                        'satuan' => 'Pcs',
                        'jumlah_diminta' => 4,
                        'catatan' => 'Kopling sambung segmen perbaikan pipa PVC eksisting',
                        'stok_tersedia' => '15 Pcs',
                        'stok_status' => 'aman',
                    ],
                ],
            ],
            'BPB-2023-1108' => [
                'kode' => 'BPB-2023-1108',
                'judul' => 'Stok Penggantian Gate Valve Zona Distribusi Barat',
                'prioritas' => 'Normal',
                'prioritas_kode' => 'normal',
                'tanggal' => '23 Okt 2023',
                'waktu' => '16:15 WIB',
                'spk_status' => 'ada',
                'spk_label' => 'Sudah Ada SPK',
                'spk_kode' => 'SPK-DIST-2023-104',
                'gudang_tujuan' => 'GU-2 (Distribusi Selatan)',
                'status' => 'draft',
                'status_label' => 'Draf Permintaan',
                'pegawai_pemohon' => 'Budi Pratama',
                'subbagian_pemohon' => 'Subbag Pemeliharaan Distribusi',
                'total_jenis_barang' => 5,
                'total_kuantitas' => 22,
                'kesiapan_stok' => 100,
                'items' => [],
            ],
            'BPB-2023-1104' => [
                'kode' => 'BPB-2023-1104',
                'judul' => 'Interkoneksi Pipa PVC 150mm Jalur Perumahan Telaga Asri',
                'prioritas' => 'Tinggi',
                'prioritas_kode' => 'tinggi',
                'tanggal' => '22 Okt 2023',
                'waktu' => '11:20 WIB',
                'spk_status' => 'ada',
                'spk_label' => 'Sudah Ada SPK',
                'spk_kode' => 'SPK-DIST-2023-098',
                'gudang_tujuan' => 'GU-1 (Gudang Induk)',
                'status' => 'menunggu_approval',
                'status_label' => 'Menunggu Approval Kasubag',
                'pegawai_pemohon' => 'Budi Pratama',
                'subbagian_pemohon' => 'Subbag Pemeliharaan Distribusi',
                'total_jenis_barang' => 8,
                'total_kuantitas' => 41,
                'kesiapan_stok' => 90,
                'items' => [],
            ],
            'BPB-2023-1092' => [
                'kode' => 'BPB-2023-1092',
                'judul' => 'Pemeliharaan Berkala Gauge Adaptor dan Meter Air Sub-Zona 4',
                'prioritas' => 'Normal',
                'prioritas_kode' => 'normal',
                'tanggal' => '20 Okt 2023',
                'waktu' => '09:00 WIB',
                'spk_status' => 'ada',
                'spk_label' => 'Sudah Ada SPK',
                'spk_kode' => 'SPK-DIST-2023-092',
                'gudang_tujuan' => 'GU-1 (Gudang Induk)',
                'status' => 'diproses_gudang',
                'status_label' => 'Sedang Disiapkan Gudang',
                'pegawai_pemohon' => 'Budi Pratama',
                'subbagian_pemohon' => 'Subbag Pemeliharaan Distribusi',
                'total_jenis_barang' => 4,
                'total_kuantitas' => 12,
                'kesiapan_stok' => 100,
                'items' => [],
            ],
            'BPB-2023-1077' => [
                'kode' => 'BPB-2023-1077',
                'judul' => 'Penggantian Stop Kran & Pemasangan Clamp Saddle Sambungan Rumah',
                'prioritas' => 'Tinggi',
                'prioritas_kode' => 'tinggi',
                'tanggal' => '19 Okt 2023',
                'waktu' => '14:20 WIB',
                'spk_status' => 'ada',
                'spk_label' => 'Sudah Ada SPK',
                'spk_kode' => 'SPK-DIST-2023-087',
                'gudang_tujuan' => 'GU-1 (Gudang Induk) — Rak B-04',
                'status' => 'siap_ambil',
                'status_label' => 'Siap Ambil di Gudang',
                'pegawai_pemohon' => 'Budi Pratama',
                'subbagian_pemohon' => 'Subbag Pemeliharaan Distribusi',
                'total_jenis_barang' => 3,
                'total_kuantitas' => 9,
                'kesiapan_stok' => 100,
                'items' => [],
            ],
        ];
    }

    public function index(Request $request)
    {
        $permintaan = collect($this->dummyData())->values();

        $stats = [
            'total' => 14,
            'draft' => 3,
            'menunggu_approval' => 4,
            'diproses_gudang' => 5,
            'siap_ambil' => 2,
        ];

        return view('permintaan-barang.index', [
            'permintaan' => $permintaan,
            'stats' => $stats,
        ]);
    }

    public function show(string $kode)
    {
        $data = $this->dummyData();

        $defaults = [
            'waktu_registrasi' => null,
            'spk_pekerjaan' => null,
            'target_penyerahan' => null,
            'target_penyerahan_ket' => null,
            'lampiran_foto' => 0,
            'items' => [],
        ];

        $bpb = array_merge($defaults, $data[$kode] ?? $data['BPB-2023-1110']);

        return view('permintaan-barang.show', [
            'bpb' => (object) $bpb,
        ]);
    }
}