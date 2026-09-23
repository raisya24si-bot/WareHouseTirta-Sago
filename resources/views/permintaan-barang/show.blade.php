@extends('layouts.app')

@section('title', 'Detail Permintaan '.$bpb->kode.' - Warehouse Tirta Sago')
@section('breadcrumb', 'Detail Permintaan Barang')

@section('content')

@php
    $statusBadge = [
        'draft' => ['label' => 'Draf Permintaan', 'classes' => 'bg-surface-container-highest text-secondary'],
        'menunggu_approval' => ['label' => 'Menunggu Approval Kasubag', 'classes' => 'bg-amber-100 text-amber-800'],
        'diproses_gudang' => ['label' => 'Sedang Disiapkan Gudang', 'classes' => 'bg-blue-100 text-primary'],
        'siap_ambil' => ['label' => 'Siap Ambil di Gudang', 'classes' => 'bg-green-100 text-green-800'],
    ];
    $badge = $statusBadge[$bpb->status] ?? $statusBadge['draft'];

    $prioritasBadge = [
        'darurat' => 'bg-error text-on-error',
        'tinggi' => 'bg-primary-fixed text-on-primary-fixed',
        'normal' => 'bg-surface-container-high text-on-surface-variant',
    ];

    $prioritasLabel = [
        'darurat' => 'Sangat Mendesak / Darurat',
        'tinggi' => 'Prioritas Tinggi',
        'normal' => 'Normal',
    ];

    $isDraft = $bpb->status === 'draft';
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    {{-- ================= BREADCRUMB ================= --}}
    <nav class="flex items-center gap-stack-sm text-sidebar-nav text-on-surface-variant">
        <a href="{{ route('permintaan-barang.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">assignment</span>
            Permintaan Barang
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Detail Permintaan ({{ $bpb->kode }})</span>
    </nav>


    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">

        <div class="flex flex-wrap items-center gap-stack-sm">
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">{{ $bpb->kode }}</h1>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-label-bold {{ $badge['classes'] }}">
                <span class="w-2 h-2 rounded-full bg-current opacity-70"></span>
                {{ strtoupper($isDraft ? 'DRAFT (Belum Diajukan)' : $badge['label']) }}
            </span>

            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[12px] font-label-bold {{ $prioritasBadge[$bpb->prioritas_kode] ?? $prioritasBadge['normal'] }}">
                @if($bpb->prioritas_kode === 'darurat')
                    <span class="material-symbols-outlined text-[14px]">bolt</span>
                @endif
                {{ $prioritasLabel[$bpb->prioritas_kode] ?? $bpb->prioritas }}
            </span>
        </div>

        <div class="flex items-center gap-stack-sm">
            <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-bold text-body-sm transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Cetak Draf
            </button>
            <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.remove('hidden')" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-md shadow-primary/20 hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Barang
            </button>
        </div>

    </div>

    <p class="text-body-sm text-on-surface-variant -mt-2">{{ $bpb->judul }}</p>


    {{-- ================= INFO HEADER ================= --}}
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-container-padding py-stack-md border-b border-outline-variant">
            <div class="flex items-center gap-stack-sm">
                <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                <h2 class="font-label-bold text-on-surface">Informasi Header Permintaan (BPB)</h2>
            </div>

            @if($isDraft)
                <button type="button" class="inline-flex items-center gap-1.5 px-stack-md py-1.5 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high text-[13px] font-label-bold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">edit_note</span>
                    Edit Informasi Header
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-stack-md p-container-padding">

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Nomor BPB</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->kode }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Waktu Registrasi</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->waktu_registrasi ?? $bpb->tanggal.', '.$bpb->waktu }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Pegawai Pemohon</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->pegawai_pemohon }}</span>
                <span class="block text-[12px] text-on-surface-variant">{{ $bpb->subbagian_pemohon }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Gudang Tujuan</span>
                <span class="block font-label-bold text-primary mt-1">{{ $bpb->gudang_tujuan }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Rujukan SPK / Pekerjaan</span>
                @if($bpb->spk_status === 'belum_ada')
                    <span class="block font-label-bold text-tertiary mt-1">Belum Ada SPK (Sementara)</span>
                    <span class="block text-[12px] text-error">{{ $bpb->spk_pekerjaan ?? $bpb->spk_kode }}</span>
                @else
                    <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->spk_kode }}</span>
                    <span class="block text-[12px] text-on-surface-variant">Sudah Ada SPK</span>
                @endif
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Status Alur Dokumen</span>
                <span class="flex items-center gap-1 font-label-bold text-on-surface-variant mt-1">
                    <span class="material-symbols-outlined text-[16px]">sentiment_neutral</span>
                    {{ $isDraft ? 'Menunggu Pengajuan' : $badge['label'] }}
                </span>
            </div>

        </div>

    </div>


    {{-- ================= QUICK STATS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">

        <div class="flex items-center justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm">
            <div>
                <span class="block text-[12px] text-on-surface-variant">Total Jenis Barang</span>
                <span class="block text-2xl font-bold text-on-surface mt-1">{{ $bpb->total_jenis_barang }}</span>
            </div>
            <span class="p-2 rounded-lg bg-primary-fixed text-primary material-symbols-outlined">category</span>
        </div>

        <div class="flex items-center justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm">
            <div>
                <span class="block text-[12px] text-on-surface-variant">Total Kuantitas Fisik</span>
                <span class="block text-2xl font-bold text-on-surface mt-1">{{ $bpb->total_kuantitas }}</span>
            </div>
            <span class="p-2 rounded-lg bg-surface-container-high text-on-surface material-symbols-outlined">layers</span>
        </div>

        <div class="flex items-center justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm">
            <div>
                <span class="block text-[12px] text-on-surface-variant">Kesiapan Stok Gudang</span>
                <span class="block text-2xl font-bold text-green-700 mt-1">{{ $bpb->kesiapan_stok }}%</span>
            </div>
            <span class="p-2 rounded-lg bg-green-100 text-green-700 material-symbols-outlined">check_circle</span>
        </div>

        <div class="flex items-center justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm">
            <div>
                <span class="block text-[12px] text-on-surface-variant">Target Penyerahan</span>
                <span class="block text-xl font-bold {{ $bpb->prioritas_kode === 'darurat' ? 'text-error' : 'text-on-surface' }} mt-1">{{ $bpb->target_penyerahan ?? '-' }}</span>
                @if(!empty($bpb->target_penyerahan_ket))
                    <span class="block text-[11px] text-on-surface-variant">{{ $bpb->target_penyerahan_ket }}</span>
                @endif
            </div>
            <span class="p-2 rounded-lg bg-orange-100 text-orange-700 material-symbols-outlined">schedule</span>
        </div>

    </div>


    {{-- ================= DAFTAR MATERIAL ================= --}}
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-stack-sm px-container-padding py-stack-md border-b border-outline-variant">
            <div class="flex items-start gap-stack-sm">
                <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">inventory_2</span>
                <div>
                    <h2 class="font-label-bold text-on-surface">Daftar Material Diminta (Bill of Materials)</h2>
                    <p class="text-[12px] text-on-surface-variant">Verifikasi jumlah kebutuhan lapangan dan pastikan stok gudang mencukupi sebelum diajukan</p>
                </div>
            </div>

            @if($isDraft)
                <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-stack-md py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-sm hover:bg-primary-container transition-colors self-start sm:self-center">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Barang Material
                </button>
            @endif
        </div>

        <div class="overflow-x-auto custom-scrollbar">

            <table class="w-full min-w-[900px] text-left text-body-sm border-collapse">

                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-bold text-[12px] uppercase tracking-wider">
                        <th class="px-container-padding py-stack-md">No</th>
                        <th class="px-stack-md py-stack-md">Kode &amp; Nama Material</th>
                        <th class="px-stack-md py-stack-md">Kategori &amp; Spesifikasi</th>
                        <th class="px-stack-md py-stack-md">Satuan</th>
                        <th class="px-stack-md py-stack-md">Jumlah Diminta</th>
                        <th class="px-stack-md py-stack-md">Catatan Keperluan Lapangan</th>
                        <th class="px-stack-md py-stack-md">Ketersediaan Stok</th>
                        <th class="px-container-padding py-stack-md text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-outline-variant/60">

                    @forelse($bpb->items as $i => $item)

                        <tr class="hover:bg-surface-container-low/60 transition-colors">

                            <td class="px-container-padding py-stack-md text-on-surface-variant">{{ $i + 1 }}</td>

                            <td class="px-stack-md py-stack-md">
                                <span class="block font-label-bold text-primary">{{ $item['kode'] }}</span>
                                <span class="block font-label-bold text-on-surface">{{ $item['nama'] }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md">
                                <span class="inline-block px-2 py-0.5 rounded-md bg-surface-container-high text-[11px] text-on-surface-variant mb-1">{{ $item['kategori'] }}</span>
                                <span class="block text-[12px] text-on-surface-variant">{{ $item['spesifikasi'] }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">{{ $item['satuan'] }}</td>

                            <td class="px-stack-md py-stack-md font-label-bold text-on-surface">{{ $item['jumlah_diminta'] }}</td>

                            <td class="px-stack-md py-stack-md text-[13px] text-on-surface-variant max-w-[220px]">{{ $item['catatan'] }}</td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <span class="block font-label-bold text-on-surface">{{ $item['stok_tersedia'] }}</span>
                                @if($item['stok_status'] === 'aman')
                                    <span class="inline-flex items-center gap-1 text-[11px] text-green-700">
                                        <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                        Stok Aman &amp; Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] text-error">
                                        <span class="material-symbols-outlined text-[13px]">error</span>
                                        Stok Menipis
                                    </span>
                                @endif
                            </td>

                            <td class="px-container-padding py-stack-md text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1">
                                    <button type="button" class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <button type="button" class="p-1.5 rounded-lg text-error hover:bg-error-container transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-container-padding py-12 text-center text-on-surface-variant">
                                Belum ada rincian material untuk permintaan ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- ================= SOP VERIFIKASI ================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-stack-md p-container-padding rounded-xl bg-surface-container-lowest shadow-sm">

        <div class="flex items-start gap-stack-sm">
            <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">shield</span>
            <div>
                <p class="font-label-bold text-on-surface">SOP Verifikasi Pengambilan Barang Lapangan</p>
                <p class="text-[12px] text-on-surface-variant max-w-xl mt-0.5">
                    Barang yang diajukan langsung mengurangi reservasi kuota gudang GU-1 setelah diverifikasi Kasubag.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-stack-sm text-[13px] text-on-surface-variant self-start sm:self-center">
            <span>Lampiran Bukti Foto Kerusakan: <strong class="text-on-surface">{{ $bpb->lampiran_foto ?? 0 }} File Terunggah</strong></span>
            <button type="button" class="inline-flex items-center gap-1 text-primary font-label-bold hover:underline">
                <span class="material-symbols-outlined text-[16px]">attachment</span>
                Lihat Foto
            </button>
        </div>

    </div>


    {{-- ================= FOOTER ACTIONS ================= --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-stack-sm p-container-padding rounded-xl bg-surface-container-lowest shadow-sm sticky bottom-0">

        @if($isDraft)
            <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-error-container text-error font-label-bold text-body-sm hover:bg-error hover:text-on-error transition-colors">
                <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                Hapus Draft Permintaan Ini
            </button>
        @else
            <span></span>
        @endif

        <div class="flex items-center gap-stack-sm">
            <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container-high text-on-surface font-label-bold text-body-sm hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Draft
            </button>

            @if($isDraft)
                <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-md shadow-primary/20 hover:bg-primary-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
                    Ajukan / Submit Permintaan
                </button>
            @endif
        </div>

    </div>

</div>

@php
    $katalogMaterial = [
        [
            'kode' => 'BRG-FIT-045',
            'nama' => 'Klem Saddle 2 x 1/2 Inch',
            'kategori' => 'Aksesoris Sambungan Rumah',
            'spesifikasi' => 'Bahan Ductile Iron, Baut Anti Karat, Standard SNI',
            'satuan' => 'Pcs',
            'stok' => '64 Pcs',
            'stok_status' => 'aman',
            'stok_label' => 'Tersedia Aman',
        ],
        [
            'kode' => 'BRG-PIP-012',
            'nama' => 'Pipa PVC SNI S-12.5 RRJ 4"',
            'kategori' => 'Pipa Distribusi',
            'spesifikasi' => 'Panjang 6m, Tekanan 10 Bar',
            'satuan' => 'Btg',
            'stok' => '142 Btg',
            'stok_status' => 'aman',
            'stok_label' => 'Tersedia Aman',
        ],
        [
            'kode' => 'BRG-VLV-089',
            'nama' => 'Gate Valve Flange SNI 4"',
            'kategori' => 'Valve & Kontrol',
            'spesifikasi' => 'Cast Iron Body, PN 16',
            'satuan' => 'Unit',
            'stok' => '8 Unit',
            'stok_status' => 'terbatas',
            'stok_label' => 'Tersedia',
        ],
        [
            'kode' => 'BRG-FIT-088',
            'nama' => 'Gibault Joint 4 Inch',
            'kategori' => 'Aksesoris Fitting',
            'spesifikasi' => 'Rubber Ring EPDM, Baut Galvanis',
            'satuan' => 'Pcs',
            'stok' => '15 Pcs',
            'stok_status' => 'terbatas',
            'stok_label' => 'Tersedia',
        ],
    ];

    $kategoriList = collect($katalogMaterial)->pluck('kategori')->unique()->values();
@endphp

{{-- ================= MODAL: TAMBAH ITEM MATERIAL LAPANGAN (visual only) ================= --}}
<div id="modal-tambah-barang" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <div class="w-full max-w-xl bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div class="px-container-padding py-stack-md flex items-start justify-between shrink-0 border-b border-outline-variant">
            <div class="flex items-start gap-stack-sm">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary-fixed text-primary">
                    <span class="material-symbols-outlined text-[20px]">post_add</span>
                </div>
                <div>
                    <h2 class="text-body-lg font-label-bold text-on-surface">Tambah Item Material Lapangan</h2>
                    <span class="text-[12px] text-on-surface-variant">Pilih spesifikasi material pipa, valve, atau aksesoris distribusi</span>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.add('hidden')" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-container-padding flex flex-col gap-stack-md overflow-y-auto custom-scrollbar">

            <div class="flex items-center justify-between">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Pilih Material Lapangan *</label>
                <button type="button" class="inline-flex items-center gap-1 text-[12px] font-label-bold text-primary hover:underline">
                    <span class="material-symbols-outlined text-[15px]">menu_book</span>
                    Buka Katalog Material
                </button>
            </div>

            {{-- Filter kategori barang (TODO: sambungkan ke Master Kategori — masih visual/dummy) --}}
            <div class="flex flex-wrap items-center gap-1.5" id="filter-kategori-material">
                <button type="button" onclick="filterKatalogMaterial('semua', this)" class="kategori-chip active px-stack-sm py-1 rounded-full bg-primary text-on-primary text-[12px] font-label-bold transition-colors">
                    Semua Kategori
                </button>
                @foreach($kategoriList as $kategori)
                    <button type="button" onclick="filterKatalogMaterial('{{ $kategori }}', this)" class="kategori-chip px-stack-sm py-1 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high text-[12px] transition-colors">
                        {{ $kategori }}
                    </button>
                @endforeach
            </div>

            {{-- Search box --}}
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">search</span>
                <input type="text" id="search-material" placeholder="Cari kode atau nama material..." class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary border border-outline-variant">
            </div>

            {{-- Daftar material (radio list) --}}
            <div class="flex flex-col gap-1.5 max-h-64 overflow-y-auto custom-scrollbar" id="list-material">

                @foreach($katalogMaterial as $i => $mat)
                    <label
                        class="material-row flex items-center justify-between gap-stack-sm p-stack-md rounded-lg border-2 {{ $i === 0 ? 'border-primary bg-primary-fixed/20' : 'border-outline-variant bg-surface-container-lowest' }} cursor-pointer transition-colors"
                        data-kategori="{{ $mat['kategori'] }}"
                        data-kode="{{ $mat['kode'] }}"
                        data-nama="{{ $mat['nama'] }}"
                        data-spesifikasi="{{ $mat['spesifikasi'] }}"
                        data-kategori-label="{{ $mat['kategori'] }}"
                        data-satuan="{{ $mat['satuan'] }}"
                        data-stok="{{ $mat['stok'] }}"
                        data-stok-status="{{ $mat['stok_status'] }}"
                        data-stok-label="{{ $mat['stok_label'] }}"
                        onclick="pilihMaterial(this)"
                    >
                        <div class="flex items-center gap-stack-sm min-w-0">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 {{ $i === 0 ? 'border-primary bg-primary text-on-primary' : 'border-outline text-transparent' }} material-row-check">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                            </span>
                            <div class="min-w-0">
                                <span class="block text-[13px]">
                                    <span class="font-label-bold text-primary">{{ $mat['kode'] }}</span>
                                    <span class="font-label-bold text-on-surface">{{ $mat['nama'] }}</span>
                                </span>
                                <span class="block text-[12px] text-on-surface-variant truncate">{{ $mat['kategori'] }} &bull; {{ $mat['spesifikasi'] }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end shrink-0">
                            <span class="text-[13px] font-label-bold text-on-surface">{{ $mat['stok'] }}</span>
                            <span class="text-[11px] {{ $mat['stok_status'] === 'aman' ? 'text-green-700' : 'text-on-surface-variant' }}">{{ $mat['stok_label'] }}</span>
                        </div>
                        <input type="radio" name="material_dipilih" class="hidden" {{ $i === 0 ? 'checked' : '' }}>
                    </label>
                @endforeach

            </div>

            {{-- Detail material terpilih --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-stack-sm p-stack-md rounded-lg bg-surface-container-low">
                <div>
                    <span class="inline-block px-2 py-0.5 rounded-md bg-surface-container-high text-[11px] text-on-surface-variant mb-1" id="detail-kategori">Aksesoris Sambungan Rumah</span>
                    <p class="text-[12px] text-on-surface-variant" id="detail-spesifikasi">Bahan Ductile Iron, Baut Anti Karat, Standard SNI</p>
                </div>
                <div class="flex items-center gap-stack-sm shrink-0">
                    <span class="material-symbols-outlined text-outline text-[20px]">warehouse</span>
                    <div>
                        <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Stok GU-1 Tersedia</span>
                        <span class="block text-[13px] font-label-bold text-primary" id="detail-stok">64 Pcs (Tersedia Aman)</span>
                    </div>
                </div>
            </div>

            {{-- Satuan & Jumlah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Satuan Barang</label>
                    <input type="text" id="input-satuan" readonly value="Pcs" class="w-full px-stack-md py-base rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Jumlah / Kuantitas Diminta *</label>
                    <div class="flex items-center gap-stack-sm">
                        <button type="button" onclick="ubahJumlah(-1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                        <input type="number" id="input-jumlah" value="4" min="1" class="w-full text-center px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface font-label-bold text-body-sm shadow-sm border-2 border-primary focus:outline-none">
                        <button type="button" onclick="ubahJumlah(1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-sm hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">playlist_add_check</span>
                Simpan &amp; Tambahkan ke Daftar
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function filterKatalogMaterial(kategori, el) {
        document.querySelectorAll('.kategori-chip').forEach(function (chip) {
            chip.classList.remove('active', 'bg-primary', 'text-on-primary');
            chip.classList.add('bg-surface-container', 'text-on-surface-variant');
        });
        el.classList.add('active', 'bg-primary', 'text-on-primary');
        el.classList.remove('bg-surface-container', 'text-on-surface-variant');

        document.querySelectorAll('.material-row').forEach(function (row) {
            const cocok = (kategori === 'semua') || (row.dataset.kategori === kategori);
            row.style.display = cocok ? 'flex' : 'none';
        });
    }

    function pilihMaterial(el) {
        document.querySelectorAll('.material-row').forEach(function (row) {
            row.classList.remove('border-primary', 'bg-primary-fixed/20');
            row.classList.add('border-outline-variant', 'bg-surface-container-lowest');
            row.querySelector('input[type="radio"]').checked = false;
            const check = row.querySelector('.material-row-check');
            check.classList.remove('border-primary', 'bg-primary', 'text-on-primary');
            check.classList.add('border-outline', 'text-transparent');
        });

        el.classList.remove('border-outline-variant', 'bg-surface-container-lowest');
        el.classList.add('border-primary', 'bg-primary-fixed/20');
        el.querySelector('input[type="radio"]').checked = true;
        const check = el.querySelector('.material-row-check');
        check.classList.remove('border-outline', 'text-transparent');
        check.classList.add('border-primary', 'bg-primary', 'text-on-primary');

        document.getElementById('detail-kategori').textContent = el.dataset.kategoriLabel;
        document.getElementById('detail-spesifikasi').textContent = el.dataset.spesifikasi;
        document.getElementById('detail-stok').textContent = el.dataset.stok + ' (' + el.dataset.stokLabel + ')';
        document.getElementById('input-satuan').value = el.dataset.satuan;
    }

    function ubahJumlah(delta) {
        const input = document.getElementById('input-jumlah');
        const nilai = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
        input.value = nilai;
    }
</script>
@endpush

@endsection