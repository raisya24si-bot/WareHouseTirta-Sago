@extends('layouts.app')

@section('title', 'Detail Permintaan '.$bpb->kd_bpb.' - Warehouse Tirta Sago')
@section('breadcrumb', 'Detail Permintaan Barang')

@section('content')

@php
    $statusBadge = [
        'DRAFT' => ['label' => 'Draf Permintaan', 'classes' => 'bg-surface-container-highest text-secondary'],
        'MENUNGGU_APPROVAL' => ['label' => 'Menunggu Approval Kasubag', 'classes' => 'bg-amber-100 text-amber-800'],
        'DIPROSES_GUDANG' => ['label' => 'Sedang Disiapkan Gudang', 'classes' => 'bg-blue-100 text-primary'],
        'SIAP_AMBIL' => ['label' => 'Siap Ambil di Gudang', 'classes' => 'bg-green-100 text-green-800'],
        'SELESAI' => ['label' => 'Selesai Diambil', 'classes' => 'bg-green-100 text-green-800'],
        'DITOLAK' => ['label' => 'Ditolak', 'classes' => 'bg-error-container text-on-error-container'],
    ];
    $statusKode = $bpb->status->kd_status_bpb ?? 'DRAFT';
    $badge = $statusBadge[$statusKode] ?? $statusBadge['DRAFT'];

    $prioritasBadge = [
        'DARURAT' => 'bg-error text-on-error',
        'TINGGI' => 'bg-primary-fixed text-on-primary-fixed',
        'NORMAL' => 'bg-surface-container-high text-on-surface-variant',
    ];

    $prioritasLabel = [
        'DARURAT' => 'Sangat Mendesak / Darurat',
        'TINGGI' => 'Prioritas Tinggi',
        'NORMAL' => 'Normal',
    ];

    $urgensiKode = $bpb->urgensi->kd_urgensi_bpb ?? 'NORMAL';

    $isDraft = $bpb->isDraft();
    // BPB yang Ditolak juga boleh diedit & diajukan ulang oleh pekerja,
    // jadi tombol tambah/edit/hapus item & submit dibuka untuk keduanya.
    $isEditable = $bpb->isEditable();
    $isDitolak = $statusKode === 'DITOLAK';
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    @if(session('success'))
        <div class="px-container-padding py-stack-sm rounded-xl bg-green-100 text-green-800 text-body-sm font-label-bold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="px-container-padding py-stack-sm rounded-xl bg-error-container text-on-error-container text-body-sm font-label-bold">
            {{ $errors->first() }}
        </div>
    @endif

    @if($isDitolak)
        <div class="flex items-start gap-stack-sm px-container-padding py-stack-md rounded-xl bg-error-container text-on-error-container">
            <span class="material-symbols-outlined text-[20px] mt-0.5">info</span>
            <div class="text-body-sm">
                <span class="font-label-bold">Permintaan ini ditolak Kasubag.</span>
                Kamu masih bisa mengubah item &amp; catatan di bawah, lalu ajukan ulang kapan saja lewat tombol "Ajukan Ulang ke Kasubag" di bagian bawah halaman.
            </div>
        </div>
    @endif

    @if($statusKode === 'MENUNGGU_APPROVAL')
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-stack-sm px-container-padding py-stack-md rounded-xl bg-amber-100 text-amber-800">
            <div class="flex items-start gap-stack-sm">
                <span class="material-symbols-outlined text-[20px] mt-0.5">hourglass_top</span>
                <div class="text-body-sm">
                    <span class="font-label-bold">Menunggu keputusan Kasubag.</span>
                    Cek rincian barang di bawah, lalu setujui untuk diteruskan ke Gudang, atau tolak kalau ada yang perlu diperbaiki pekerja.
                </div>
            </div>
            <div class="flex items-center gap-stack-sm shrink-0">
                <button type="button" onclick="bukaTolak('{{ route('approval-bpb.reject', $bpb->kd_bpb) }}', '{{ $bpb->kd_bpb }}')" class="inline-flex items-center gap-1.5 px-stack-md py-2 rounded-lg bg-error-container text-error hover:bg-error hover:text-on-error text-body-sm font-label-bold transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                    Tolak
                </button>
                <form method="POST" action="{{ route('approval-bpb.approve', $bpb->kd_bpb) }}" onsubmit="return confirm('Setujui BPB {{ $bpb->kd_bpb }}? Status akan pindah ke Diproses Gudang.');">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-stack-md py-2 rounded-lg bg-primary text-on-primary hover:bg-primary-container text-body-sm font-label-bold transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">check</span>
                        Setujui (Kasubag)
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- ================= BREADCRUMB ================= --}}
    <nav class="flex items-center gap-stack-sm text-sidebar-nav text-on-surface-variant">
        <a href="{{ route('permintaan-barang.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">assignment</span>
            Permintaan Barang
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Detail Permintaan ({{ $bpb->kd_bpb }})</span>
    </nav>


    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">

        <div class="flex flex-wrap items-center gap-stack-sm">
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">{{ $bpb->kd_bpb }}</h1>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-label-bold {{ $badge['classes'] }}">
                <span class="w-2 h-2 rounded-full bg-current opacity-70"></span>
                {{ strtoupper($isDraft ? 'DRAFT (Belum Diajukan)' : $badge['label']) }}
            </span>

            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[12px] font-label-bold {{ $prioritasBadge[$urgensiKode] ?? $prioritasBadge['NORMAL'] }}">
                @if($urgensiKode === 'DARURAT')
                    <span class="material-symbols-outlined text-[14px]">bolt</span>
                @endif
                {{ $prioritasLabel[$urgensiKode] ?? ($bpb->urgensi->nm_urgensi_bpb ?? 'Normal') }}
            </span>
        </div>

        <div class="flex items-center gap-stack-sm">
            <button type="button" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-bold text-body-sm transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Cetak Draf
            </button>
            @if($isEditable)
                <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.remove('hidden')" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-md shadow-primary/20 hover:bg-primary-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Barang
                </button>
            @endif
        </div>

    </div>

    <p class="text-body-sm text-on-surface-variant -mt-2">{{ $bpb->desc_bpb ?? 'Tidak ada keterangan pekerjaan.' }}</p>


    {{-- ================= INFO HEADER ================= --}}
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-container-padding py-stack-md border-b border-outline-variant">
            <div class="flex items-center gap-stack-sm">
                <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                <h2 class="font-label-bold text-on-surface">Informasi Header Permintaan (BPB)</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-stack-md p-container-padding">

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Nomor BPB</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->kd_bpb }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Waktu Registrasi</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->created_at?->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Pegawai Pemohon</span>
                <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->createdBy->name ?? '-' }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Gudang Tujuan</span>
                <span class="block font-label-bold text-primary mt-1">{{ $bpb->gudang->nm_gudang ?? '-' }}</span>
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Rujukan SPK / Pekerjaan</span>
                @if($bpb->status_spk === 'DARURAT')
                    <span class="block font-label-bold text-tertiary mt-1">Belum Ada SPK (Sementara)</span>
                    <span class="block text-[12px] text-error">{{ $bpb->no_spk ?? '-' }}</span>
                @else
                    <span class="block font-label-bold text-on-surface mt-1">{{ $bpb->no_spk ?? '-' }}</span>
                    <span class="block text-[12px] text-on-surface-variant">Sudah Ada SPK</span>
                @endif
            </div>

            <div class="bg-surface-container-low rounded-lg p-stack-md">
                <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Status Alur Dokumen</span>
                <span class="flex items-center gap-1 font-label-bold text-on-surface-variant mt-1">
                    <span class="material-symbols-outlined text-[16px]">sentiment_neutral</span>
                    {{ $bpb->status->nm_status_bpb ?? '-' }}
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
                <span class="block text-[12px] text-on-surface-variant">Tanggal Permintaan</span>
                <span class="block text-xl font-bold {{ $urgensiKode === 'DARURAT' ? 'text-error' : 'text-on-surface' }} mt-1">{{ $bpb->tgl_bpb?->translatedFormat('d M Y') }}</span>
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

            @if($isEditable)
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
                        @if($isEditable)
                            <th class="px-container-padding py-stack-md text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-outline-variant/60">

                    @forelse($bpb->details as $i => $item)

                        <tr class="hover:bg-surface-container-low/60 transition-colors">

                            <td class="px-container-padding py-stack-md text-on-surface-variant">{{ $i + 1 }}</td>

                            <td class="px-stack-md py-stack-md">
                                <span class="block font-label-bold text-primary">{{ $item->barang->kd_master_barang ?? '-' }}</span>
                                <span class="block font-label-bold text-on-surface">{{ $item->barang->nm_master_barang ?? 'Barang tidak ditemukan' }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md">
                                <span class="inline-block px-2 py-0.5 rounded-md bg-surface-container-high text-[11px] text-on-surface-variant mb-1">{{ $item->barang->kategori->nm_master_kategori ?? '-' }}</span>
                                <span class="block text-[12px] text-on-surface-variant">{{ $item->barang->desc_master_barang ?? '-' }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">{{ $item->barang->satuan->nm_master_satuan ?? '-' }}</td>

                            <td class="px-stack-md py-stack-md font-label-bold text-on-surface">{{ $item->qty_request }}</td>

                            <td class="px-stack-md py-stack-md text-[13px] text-on-surface-variant max-w-[220px]">{{ $item->catatan ?? '-' }}</td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <span class="block font-label-bold text-on-surface">{{ $item->qty_available }} {{ $item->barang->satuan->nm_master_satuan ?? '' }}</span>
                                @if($item->isStokAman())
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

                            @if($isEditable)
                                <td class="px-container-padding py-stack-md text-right whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="bukaEditItem(this)"
                                        data-item-id="{{ $item->id_bpb_detail }}"
                                        data-kode-barang="{{ $item->barang->kd_master_barang ?? '-' }}"
                                        data-nama-barang="{{ $item->barang->nm_master_barang ?? 'Barang tidak ditemukan' }}"
                                        data-satuan="{{ $item->barang->satuan->nm_master_satuan ?? '' }}"
                                        data-qty="{{ $item->qty_request }}"
                                        data-catatan="{{ $item->catatan }}"
                                        class="p-1.5 rounded-lg text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors"
                                        title="Edit Item"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>

                                    <form method="POST" action="{{ route('permintaan-barang.items.destroy', [$bpb->kd_bpb, $item->id_bpb_detail]) }}" onsubmit="return confirm('Hapus item ini dari BPB?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-error hover:bg-error-container transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            @endif

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


    {{-- ================= FOOTER ACTIONS ================= --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-stack-sm p-container-padding rounded-xl bg-surface-container-lowest shadow-sm sticky bottom-0">

        @if($isEditable)
            <form method="POST" action="{{ route('permintaan-barang.destroy', $bpb->kd_bpb) }}" onsubmit="return confirm('Hapus permintaan BPB {{ $bpb->kd_bpb }}? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-error-container text-error font-label-bold text-body-sm hover:bg-error hover:text-on-error transition-colors">
                    <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                    {{ $isDitolak ? 'Hapus Permintaan Ini' : 'Hapus Draft Permintaan Ini' }}
                </button>
            </form>
        @else
            <span></span>
        @endif

        <div class="flex items-center gap-stack-sm">
            @if($isEditable)
                <a href="{{ route('permintaan-barang.index') }}" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-bold text-body-sm transition-colors shadow-sm" title="Item sudah otomatis tersimpan, tombol ini cuma balik ke daftar">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Draft
                </a>

                <form method="POST" action="{{ route('permintaan-barang.submit', $bpb->kd_bpb) }}" onsubmit="return confirm('{{ $isDitolak ? 'Ajukan ulang' : 'Ajukan' }} BPB {{ $bpb->kd_bpb }} ke Kasubag?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-md shadow-primary/20 hover:bg-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
                        {{ $isDitolak ? 'Ajukan Ulang ke Kasubag' : 'Ajukan / Submit Permintaan' }}
                    </button>
                </form>
            @endif
        </div>

    </div>

</div>

@if($isEditable)
{{-- ================= MODAL: TAMBAH ITEM MATERIAL LAPANGAN ================= --}}
<div id="modal-tambah-barang" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <form method="POST" action="{{ route('permintaan-barang.items.store', $bpb->kd_bpb) }}" class="w-full max-w-xl bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        @csrf

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

            <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Pilih Material Lapangan *</label>

            {{-- Filter kategori barang --}}
            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[11px] text-on-surface-variant uppercase tracking-wider" for="filter-kategori-material">Filter Kategori</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">filter_alt</span>
                    <select id="filter-kategori-material" onchange="filterKatalogMaterial(this.value)" class="w-full appearance-none pl-8 pr-8 py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm border border-outline-variant focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="semua">Semua Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->nm_master_kategori }}">{{ $kategori->nm_master_kategori }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-stack-sm text-outline text-[18px] pointer-events-none">expand_more</span>
                </div>
            </div>

            {{-- Search box --}}
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">search</span>
                <input type="text" id="search-material" placeholder="Cari kode atau nama material..." class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary border border-outline-variant">
            </div>

            {{-- Daftar material (radio list) --}}
            <div class="flex flex-col gap-1.5 max-h-64 overflow-y-auto custom-scrollbar" id="list-material">

                @forelse($katalogMaterial as $i => $mat)
                    @php
                        $stokAman = $mat->stok_status === 'NORMAL';
                        $satuanNama = $mat->satuan->nm_master_satuan ?? '';
                    @endphp
                    <label
                        class="material-row flex items-center justify-between gap-stack-sm p-stack-md rounded-lg border-2 {{ $i === 0 ? 'border-primary bg-primary-fixed/20' : 'border-outline-variant bg-surface-container-lowest' }} cursor-pointer transition-colors"
                        data-kategori="{{ $mat->kategori->nm_master_kategori ?? '' }}"
                        data-id="{{ $mat->id_master_barang }}"
                        data-kode="{{ $mat->kd_master_barang }}"
                        data-nama="{{ $mat->nm_master_barang }}"
                        data-spesifikasi="{{ $mat->desc_master_barang }}"
                        data-kategori-label="{{ $mat->kategori->nm_master_kategori ?? '-' }}"
                        data-satuan="{{ $satuanNama }}"
                        data-stok="{{ $mat->stok_saat_ini }} {{ $satuanNama }}"
                        data-stok-status="{{ $stokAman ? 'aman' : 'terbatas' }}"
                        data-stok-label="{{ $stokAman ? 'Tersedia Aman' : ($mat->stok_status === 'HABIS' ? 'Stok Habis' : 'Stok Menipis') }}"
                        onclick="pilihMaterial(this)"
                    >
                        <div class="flex items-center gap-stack-sm min-w-0">
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 {{ $i === 0 ? 'border-primary bg-primary text-on-primary' : 'border-outline text-transparent' }} material-row-check">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                            </span>
                            <div class="min-w-0">
                                <span class="block text-[13px]">
                                    <span class="font-label-bold text-primary">{{ $mat->kd_master_barang }}</span>
                                    <span class="font-label-bold text-on-surface">{{ $mat->nm_master_barang }}</span>
                                </span>
                                <span class="block text-[12px] text-on-surface-variant truncate">{{ $mat->kategori->nm_master_kategori ?? '-' }} &bull; {{ $mat->desc_master_barang }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end shrink-0">
                            <span class="text-[13px] font-label-bold text-on-surface">{{ $mat->stok_saat_ini }} {{ $satuanNama }}</span>
                            <span class="text-[11px] {{ $stokAman ? 'text-green-700' : 'text-on-surface-variant' }}">{{ $stokAman ? 'Tersedia Aman' : ($mat->stok_status === 'HABIS' ? 'Stok Habis' : 'Stok Menipis') }}</span>
                        </div>
                        <input type="radio" name="material_dipilih" class="hidden" {{ $i === 0 ? 'checked' : '' }}>
                    </label>
                @empty
                    <p class="text-body-sm text-on-surface-variant text-center py-stack-md">Belum ada master barang aktif.</p>
                @endforelse

            </div>

            @php $defaultMat = $katalogMaterial->first(); @endphp
            <input type="hidden" name="fk_barang" id="input-fk-barang" value="{{ $defaultMat->id_master_barang ?? '' }}">

            {{-- Detail material terpilih --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-stack-sm p-stack-md rounded-lg bg-surface-container-low">
                <div>
                    <span class="inline-block px-2 py-0.5 rounded-md bg-surface-container-high text-[11px] text-on-surface-variant mb-1" id="detail-kategori">{{ $defaultMat?->kategori?->nm_master_kategori ?? '-' }}</span>
                    <p class="text-[12px] text-on-surface-variant" id="detail-spesifikasi">{{ $defaultMat?->desc_master_barang ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-stack-sm shrink-0">
                    <span class="material-symbols-outlined text-outline text-[20px]">warehouse</span>
                    <div>
                        <span class="block text-[11px] uppercase tracking-wider text-outline font-bold">Stok Tersedia</span>
                        <span class="block text-[13px] font-label-bold text-primary" id="detail-stok">
                            {{ $defaultMat->stok_saat_ini ?? 0 }} {{ $defaultMat?->satuan?->nm_master_satuan ?? '' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Satuan & Jumlah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Satuan Barang</label>
                    <input type="text" id="input-satuan" readonly value="{{ $defaultMat?->satuan?->nm_master_satuan ?? '' }}" class="w-full px-stack-md py-base rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Jumlah / Kuantitas Diminta *</label>
                    <div class="flex items-center gap-stack-sm">
                        <button type="button" onclick="ubahJumlah(-1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                        <input type="number" name="qty_request" id="input-jumlah" value="1" min="1" required class="w-full text-center px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface font-label-bold text-body-sm shadow-sm border-2 border-primary focus:outline-none">
                        <button type="button" onclick="ubahJumlah(1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Catatan Keperluan Lapangan</label>
                <textarea name="catatan" rows="2" placeholder="Contoh: Untuk titik sambungan pipa primer patah..." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none"></textarea>
            </div>

        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-tambah-barang').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-sm hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">playlist_add_check</span>
                Simpan &amp; Tambahkan ke Daftar
            </button>
        </div>

    </form>
</div>

{{-- ================= MODAL: EDIT ITEM MATERIAL ================= --}}
<div id="modal-edit-barang" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <form method="POST" id="form-edit-barang" action="" class="w-full max-w-lg bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        @csrf
        @method('PUT')

        <div class="px-container-padding py-stack-md flex items-start justify-between shrink-0 border-b border-outline-variant">
            <div class="flex items-start gap-stack-sm">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary-fixed text-primary">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                </div>
                <div>
                    <h2 class="text-body-lg font-label-bold text-on-surface">Edit Item Material</h2>
                    <span class="text-[12px] text-on-surface-variant">Ubah jumlah atau catatan keperluan lapangan untuk item ini</span>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('modal-edit-barang').classList.add('hidden')" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-container-padding flex flex-col gap-stack-md overflow-y-auto custom-scrollbar">

            <div class="flex flex-col gap-stack-sm p-stack-md rounded-lg bg-surface-container-low">
                <span class="text-[13px]">
                    <span class="font-label-bold text-primary" id="edit-kode-barang"></span>
                    <span class="font-label-bold text-on-surface" id="edit-nama-barang"></span>
                </span>
                <span class="text-[12px] text-on-surface-variant">Material tidak bisa diganti lewat form edit ini. Kalau perlu material berbeda, hapus item ini lalu tambahkan ulang.</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Satuan Barang</label>
                    <input type="text" id="edit-satuan" readonly class="w-full px-stack-md py-base rounded-lg bg-surface-container-low text-on-surface-variant text-body-sm cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Jumlah / Kuantitas Diminta *</label>
                    <div class="flex items-center gap-stack-sm">
                        <button type="button" onclick="ubahJumlahEdit(-1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                        <input type="number" name="qty_request" id="edit-jumlah" value="1" min="1" required class="w-full text-center px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface font-label-bold text-body-sm shadow-sm border-2 border-primary focus:outline-none">
                        <button type="button" onclick="ubahJumlahEdit(1)" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Catatan Keperluan Lapangan</label>
                <textarea name="catatan" id="edit-catatan" rows="2" placeholder="Contoh: Untuk titik sambungan pipa primer patah..." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none"></textarea>
            </div>

        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-edit-barang').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-sm hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endif

@if($statusKode === 'MENUNGGU_APPROVAL')
{{-- ================= MODAL: TOLAK BPB (Approval Kasubag) ================= --}}
<div id="modal-tolak-bpb" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <form method="POST" id="form-tolak-bpb" action="" class="w-full max-w-md bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col">
        @csrf

        <div class="px-container-padding py-stack-md flex items-start justify-between shrink-0 border-b border-outline-variant">
            <div>
                <h2 class="text-body-lg font-label-bold text-on-surface">Tolak Permintaan <span id="tolak-kode-bpb"></span></h2>
                <span class="text-[12px] text-on-surface-variant">Alasan penolakan akan tercatat pada dokumen BPB ini</span>
            </div>
            <button type="button" onclick="document.getElementById('modal-tolak-bpb').classList.add('hidden')" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-container-padding flex flex-col gap-stack-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Alasan Penolakan</label>
                <textarea name="alasan_tolak" rows="3" placeholder="Contoh: Belum sesuai kuota gudang bulan ini, silakan ajukan ulang bulan depan." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none border border-outline-variant"></textarea>
            </div>
        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-tolak-bpb').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-error text-on-error font-label-bold text-body-sm shadow-sm hover:bg-error-container hover:text-error transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
                Tolak Permintaan
            </button>
        </div>

    </form>
</div>
@endif

@push('scripts')
<script>
    function filterKatalogMaterial(kategori) {
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
        document.getElementById('input-fk-barang').value = el.dataset.id;
    }

    function ubahJumlah(delta) {
        const input = document.getElementById('input-jumlah');
        const nilai = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
        input.value = nilai;
    }

    // Template URL untuk update item, item id diganti lewat JS saat modal edit dibuka.
    // Dibangun pakai route() Laravel supaya slash di kd_bpb (format "BPB/2026/09/1")
    // ter-generate sama persis seperti route items.destroy yang sudah jalan.
    const itemsUpdateUrlTemplate = "{{ route('permintaan-barang.items.update', [$bpb->kd_bpb, '__ITEM__']) }}";

    function bukaEditItem(el) {
        const d = el.dataset;

        document.getElementById('edit-kode-barang').textContent = d.kodeBarang;
        document.getElementById('edit-nama-barang').textContent = d.namaBarang;
        document.getElementById('edit-satuan').value = d.satuan;
        document.getElementById('edit-jumlah').value = d.qty;
        document.getElementById('edit-catatan').value = d.catatan || '';

        document.getElementById('form-edit-barang').action = itemsUpdateUrlTemplate.replace('__ITEM__', d.itemId);

        document.getElementById('modal-edit-barang').classList.remove('hidden');
    }

    function ubahJumlahEdit(delta) {
        const input = document.getElementById('edit-jumlah');
        const nilai = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
        input.value = nilai;
    }

    document.getElementById('search-material')?.addEventListener('input', function (e) {
        const kata = e.target.value.toLowerCase();
        document.querySelectorAll('.material-row').forEach(function (row) {
            const cocok = row.dataset.kode.toLowerCase().includes(kata) || row.dataset.nama.toLowerCase().includes(kata);
            row.style.display = cocok ? 'flex' : 'none';
        });
    });

    function bukaTolak(actionUrl, kode) {
        document.getElementById('form-tolak-bpb').action = actionUrl;
        document.getElementById('tolak-kode-bpb').textContent = kode;
        document.getElementById('modal-tolak-bpb').classList.remove('hidden');
    }
</script>
@endpush

@endsection