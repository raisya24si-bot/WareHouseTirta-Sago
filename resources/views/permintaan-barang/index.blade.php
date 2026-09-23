@extends('layouts.app')

@section('title', 'Permintaan Barang (BPB) - Warehouse Tirta Sago')
@section('breadcrumb', 'Permintaan Barang')

@section('content')

@php
    $statusBadge = [
        'draft' => ['label' => 'Draf Permintaan', 'classes' => 'bg-surface-container-highest text-secondary', 'dot' => 'bg-secondary'],
        'menunggu_approval' => ['label' => 'Menunggu Approval Kasubag', 'classes' => 'bg-amber-100 text-amber-800', 'dot' => 'bg-amber-600'],
        'diproses_gudang' => ['label' => 'Sedang Disiapkan Gudang', 'classes' => 'bg-blue-100 text-primary', 'dot' => 'bg-primary'],
        'siap_ambil' => ['label' => 'Siap Ambil di Gudang', 'classes' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-700'],
    ];

    $prioritasBadge = [
        'darurat' => 'bg-error-container text-on-error-container',
        'tinggi' => 'bg-primary-fixed text-on-primary-fixed',
        'normal' => 'bg-surface-container-high text-on-surface-variant',
    ];
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-gutter">

        <div class="flex flex-col">
            <div class="flex items-center gap-stack-sm">
                <h1 class="font-headline-md text-headline-md text-on-surface tracking-tight">
                    Permintaan Barang (BPB)
                </h1>
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold uppercase tracking-wider">
                    Subbag Distribusi
                </span>
            </div>
            <p class="text-body-sm text-on-surface-variant mt-1">
                Kelola dan pantau seluruh siklus Bon Pengeluaran Barang teknis pipa dan utilitas air.
            </p>
        </div>

        <div class="flex items-center gap-stack-sm self-start md:self-center">

            <button type="button" class="inline-flex items-center gap-base px-stack-md py-stack-sm rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors font-label-bold text-body-sm shadow-sm">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Export Log
            </button>

            <button type="button" onclick="document.getElementById('modal-create-bpb').classList.remove('hidden')" class="inline-flex items-center gap-stack-sm px-container-padding py-stack-sm rounded-lg bg-primary text-on-primary hover:bg-primary-container transition-all font-label-bold text-body-sm shadow-md shadow-primary/20 hover:shadow-lg">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Buat Permintaan Baru
            </button>

        </div>

    </div>


    {{-- ================= KPI CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-gutter">

        <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-on-surface-variant uppercase tracking-wider font-label-bold">Total Pengajuan</span>
                <span class="p-1.5 rounded-lg bg-primary-fixed text-primary text-[18px] material-symbols-outlined">assignment</span>
            </div>
            <div class="mt-stack-sm flex items-baseline gap-2">
                <span class="text-2xl font-bold text-on-surface">{{ $stats['total'] }}</span>
                <span class="text-body-sm text-on-surface-variant">Dokumen</span>
            </div>
            <div class="mt-stack-sm h-1 w-full rounded-full bg-gradient-to-r from-primary to-transparent"></div>
        </div>

        <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-secondary uppercase tracking-wider font-label-bold">Draf / Belum Diajukan</span>
                <span class="p-1.5 rounded-lg bg-secondary-container text-secondary text-[18px] material-symbols-outlined">edit_document</span>
            </div>
            <div class="mt-stack-sm flex items-baseline gap-2">
                <span class="text-2xl font-bold text-secondary">{{ $stats['draft'] }}</span>
                <span class="text-body-sm text-on-surface-variant">Dokumen</span>
            </div>
            <div class="mt-stack-sm h-1 w-full rounded-full bg-gradient-to-r from-secondary to-transparent"></div>
        </div>

        <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-tertiary uppercase tracking-wider font-label-bold">Menunggu Approval</span>
                <span class="p-1.5 rounded-lg bg-tertiary-fixed text-tertiary text-[18px] material-symbols-outlined">hourglass_top</span>
            </div>
            <div class="mt-stack-sm flex items-baseline gap-2">
                <span class="text-2xl font-bold text-tertiary">{{ $stats['menunggu_approval'] }}</span>
                <span class="text-body-sm text-on-surface-variant">Kasubag</span>
            </div>
            <div class="mt-stack-sm h-1 w-full rounded-full bg-gradient-to-r from-tertiary to-transparent"></div>
        </div>

        <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-primary uppercase tracking-wider font-label-bold">Diproses Gudang</span>
                <span class="p-1.5 rounded-lg bg-primary-fixed-dim text-on-primary-fixed-variant text-[18px] material-symbols-outlined">shelves</span>
            </div>
            <div class="mt-stack-sm flex items-baseline gap-2">
                <span class="text-2xl font-bold text-primary">{{ $stats['diproses_gudang'] }}</span>
                <span class="text-body-sm text-on-surface-variant">Picking</span>
            </div>
            <div class="mt-stack-sm h-1 w-full rounded-full bg-gradient-to-r from-primary-container to-transparent"></div>
        </div>

        <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-on-surface-variant uppercase tracking-wider font-label-bold">Siap Ambil / Selesai</span>
                <span class="p-1.5 rounded-lg bg-surface-container-high text-on-surface text-[18px] material-symbols-outlined">fact_check</span>
            </div>
            <div class="mt-stack-sm flex items-baseline gap-2">
                <span class="text-2xl font-bold text-on-surface">{{ $stats['siap_ambil'] }}</span>
                <span class="text-body-sm text-on-surface-variant">Staging</span>
            </div>
            <div class="mt-stack-sm h-1 w-full rounded-full bg-gradient-to-r from-outline to-transparent"></div>
        </div>

    </div>


    {{-- ================= FILTER BAR ================= --}}
    <div class="p-stack-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-stack-md">

        <div class="flex flex-wrap items-center gap-stack-sm">
            <button type="button" class="px-stack-md py-base rounded-lg bg-primary text-on-primary font-label-bold text-body-sm">Semua ({{ $stats['total'] }})</button>
            <button type="button" class="px-stack-md py-base rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors text-body-sm">Draf ({{ $stats['draft'] }})</button>
            <button type="button" class="px-stack-md py-base rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors text-body-sm">Approval Kasubag ({{ $stats['menunggu_approval'] }})</button>
            <button type="button" class="px-stack-md py-base rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors text-body-sm">Diproses Gudang ({{ $stats['diproses_gudang'] }})</button>
            <button type="button" class="px-stack-md py-base rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors text-body-sm">Siap Ambil ({{ $stats['siap_ambil'] }})</button>
        </div>

        <div class="flex items-center gap-stack-sm">

            <div class="relative w-full md:w-64">
                <span class="material-symbols-outlined absolute left-stack-sm top-2 text-outline text-[18px]">filter_alt</span>
                <select class="w-full pl-8 pr-stack-sm py-base rounded-lg bg-surface-container-low text-on-surface text-[13px] focus:outline-none focus:bg-surface-container-lowest">
                    <option>Filter: Semua Prioritas</option>
                    <option>Sangat Mendesak (Darurat)</option>
                    <option>Prioritas Tinggi</option>
                    <option>Normal / Terencana</option>
                </select>
            </div>

            <div class="relative w-full md:w-56">
                <span class="material-symbols-outlined absolute left-stack-sm top-2 text-outline text-[18px]">warehouse</span>
                <select class="w-full pl-8 pr-stack-sm py-base rounded-lg bg-surface-container-low text-on-surface text-[13px] focus:outline-none">
                    <option>Semua Gudang Tujuan</option>
                    <option>GU-1 Gudang Induk</option>
                    <option>GU-2 Distribusi Selatan</option>
                    <option>GU-3 Instalasi Pengolahan</option>
                </select>
            </div>

        </div>

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="w-full rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

        <div class="overflow-x-auto custom-scrollbar">

            <table class="w-full min-w-[900px] text-left text-body-sm border-collapse">

                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-bold text-[12px] uppercase tracking-wider">
                        <th class="px-container-padding py-stack-md">No Permintaan Barang</th>
                        <th class="px-stack-md py-stack-md">Tanggal &amp; Waktu</th>
                        <th class="px-stack-md py-stack-md">Status SPK Pekerjaan</th>
                        <th class="px-stack-md py-stack-md">Status Permohonan</th>
                        <th class="px-container-padding py-stack-md text-right">Aksi Operasional</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-outline-variant/60">

                    @forelse($permintaan as $bpb)

                        @php
                            $badge = $statusBadge[$bpb['status']] ?? $statusBadge['draft'];
                        @endphp

                        <tr class="hover:bg-surface-container-low/60 transition-colors">

                            <td class="px-container-padding py-stack-md">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('permintaan-barang.show', $bpb['kode']) }}" class="font-label-bold text-primary hover:underline">
                                            {{ $bpb['kode'] }}
                                        </a>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-label-bold {{ $prioritasBadge[$bpb['prioritas_kode']] ?? $prioritasBadge['normal'] }}">
                                            {{ $bpb['prioritas'] }}
                                        </span>
                                    </div>
                                    <span class="text-[13px] text-on-surface font-medium mt-1">{{ $bpb['judul'] }}</span>
                                    <span class="text-[11px] text-outline mt-0.5">{{ $bpb['total_jenis_barang'] }} item barang{{ $bpb['status'] === 'draft' ? ' disiapkan' : '' }} &bull; {{ $bpb['gudang_tujuan'] }}</span>
                                </div>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-label-bold text-on-surface">{{ $bpb['tanggal'] }}</span>
                                    <span class="text-[12px] text-outline">{{ $bpb['waktu'] }}</span>
                                </div>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <div class="flex flex-col">
                                    @if($bpb['spk_status'] === 'belum_ada')
                                        <span class="inline-flex items-center gap-1 text-[11px] font-label-bold px-2 py-0.5 rounded-md bg-tertiary-fixed text-on-tertiary-fixed w-fit">
                                            <span class="material-symbols-outlined text-[13px]">warning</span> {{ $bpb['spk_label'] }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-label-bold px-2 py-0.5 rounded-md bg-secondary-container text-on-secondary-fixed w-fit">
                                            <span class="material-symbols-outlined text-[13px]">verified</span> {{ $bpb['spk_label'] }}
                                        </span>
                                    @endif
                                    <span class="text-[11px] text-outline font-mono mt-0.5">{{ $bpb['spk_kode'] }}</span>
                                </div>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[12px] font-label-bold {{ $badge['classes'] }}">
                                    <span class="w-2 h-2 rounded-full {{ $badge['dot'] }}"></span>
                                    {{ $badge['label'] }}
                                </span>
                            </td>

                            <td class="px-container-padding py-stack-md text-right whitespace-nowrap">

                                <div class="inline-flex items-center justify-end gap-1.5">

                                    @if($bpb['status'] === 'draft')

                                        <button type="button" class="p-1.5 rounded-lg text-primary hover:bg-primary-fixed transition-colors" title="Edit Header Permintaan">
                                            <span class="material-symbols-outlined text-[18px]">edit_note</span>
                                        </button>

                                        <a href="{{ route('permintaan-barang.show', $bpb['kode']) }}" class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors" title="Tambah / Kelola Item Barang">
                                            <span class="material-symbols-outlined text-[18px]">post_add</span>
                                        </a>

                                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-primary text-on-primary hover:bg-primary-container text-[12px] font-label-bold transition-colors" title="Ajukan ke Kasubag">
                                            <span class="material-symbols-outlined text-[15px]">send</span>
                                            Ajukan
                                        </button>

                                        <button type="button" class="p-1.5 rounded-lg text-error hover:bg-error-container transition-colors" title="Hapus Dokumen Draf">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>

                                    @elseif($bpb['status'] === 'menunggu_approval')

                                        <a href="{{ route('permintaan-barang.show', $bpb['kode']) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high text-[12px] font-label-bold transition-colors" title="Lihat Detail">
                                            <span class="material-symbols-outlined text-[15px]">visibility</span>
                                            Lihat Detail
                                        </a>
                                        <span class="text-[11px] text-outline">Terkunci</span>

                                    @elseif($bpb['status'] === 'diproses_gudang')

                                        <a href="{{ route('permintaan-barang.show', $bpb['kode']) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high text-[12px] font-label-bold transition-colors" title="Tracking Gudang">
                                            <span class="material-symbols-outlined text-[15px]">local_shipping</span>
                                            Tracking Gudang
                                        </a>

                                    @elseif($bpb['status'] === 'siap_ambil')

                                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-600 text-white hover:bg-green-700 text-[12px] font-label-bold transition-colors" title="Ambil Barang">
                                            <span class="material-symbols-outlined text-[15px]">move_to_inbox</span>
                                            Ambil Barang
                                        </button>

                                    @endif

                                    {{-- Selalu tersedia: akses cepat ke halaman detail / show blade --}}
                                    <a href="{{ route('permintaan-barang.show', $bpb['kode']) }}" class="p-1.5 rounded-lg text-outline hover:bg-primary/10 hover:text-primary transition-colors" title="Lihat Halaman Detail">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-container-padding py-12 text-center text-on-surface-variant">
                                Belum ada permintaan barang.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-stack-sm px-container-padding py-stack-md border-t border-outline-variant text-[13px] text-on-surface-variant">
            <span>Menampilkan 1-{{ $permintaan->count() }} dari {{ $stats['total'] }} permohonan aktif</span>
            <div class="flex items-center gap-1">
                <button type="button" class="px-3 py-1.5 rounded-lg text-outline cursor-not-allowed" disabled>Sebelumnya</button>
                <button type="button" class="px-3 py-1.5 rounded-lg bg-primary text-on-primary font-label-bold">1</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high">2</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high">3</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high">Selanjutnya</button>
            </div>
        </div>

    </div>


    {{-- ================= SOP INFO ================= --}}
    <div class="p-container-padding rounded-xl bg-surface-container-lowest shadow-sm">

        <div class="flex items-center gap-stack-sm mb-stack-md">
            <span class="material-symbols-outlined text-primary text-[22px]">account_tree</span>
            <h2 class="font-label-bold text-on-surface">Standar Operasional Pengajuan Permintaan Barang (BPB)</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">

            <div class="flex gap-stack-md p-stack-md rounded-xl bg-surface-container-low">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-on-primary font-label-bold">1</span>
                <div>
                    <p class="font-label-bold text-on-surface">Langkah 1: Buat Header Permintaan (Simpan Draft)</p>
                    <p class="text-[13px] text-on-surface-variant mt-1">
                        Klik tombol <span class="text-primary font-label-bold">+ Buat Permintaan Baru</span>. Tentukan data referensi utama seperti Subbagian Pemohon, Nomor SPK (atau pilih opsi Darurat jika belum ada nomor pekerjaan formal), Gudang Pengambilan, dan Tingkat Urgensi. Sistem akan membuat nomor tiket BPB baru berstatus <span class="font-label-bold">Draft</span>.
                    </p>
                </div>
            </div>

            <div class="flex gap-stack-md p-stack-md rounded-xl bg-surface-container-low">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-on-primary font-label-bold">2</span>
                <div>
                    <p class="font-label-bold text-on-surface">Langkah 2: Tambah Rincian Barang &amp; Final Submit</p>
                    <p class="text-[13px] text-on-surface-variant mt-1">
                        Pilih aksi Detail &amp; Tambah Item pada baris draft. Masukkan kode material/pipa, tentukan volume kuantum barang dan spesifikasi teknis, lalu tekan <span class="text-primary font-label-bold">Ajukan Permintaan</span> untuk meneruskan otorisasi otomatis ke Kasubag Pemeliharaan dan tim gudang.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>


{{-- ================= MODAL: BUAT PERMINTAAN BARU (visual only) ================= --}}
<div id="modal-create-bpb" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <div class="w-full max-w-2xl bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-between shrink-0">
            <div class="flex flex-col">
                <h2 class="text-body-lg font-label-bold text-on-surface">Buat Permintaan Barang Baru (Header BPB)</h2>
                <span class="text-[12px] text-on-surface-variant">Langkah 1: Lengkapi informasi header permintaan. Rincian item barang ditambahkan di halaman detail.</span>
            </div>
            <button type="button" onclick="document.getElementById('modal-create-bpb').classList.add('hidden')" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-container-padding flex flex-col gap-stack-md overflow-y-auto custom-scrollbar">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Nomor BPB (Otomatis)</label>
                    <input type="text" readonly value="BPB-2023-1111" class="px-stack-md py-base rounded-lg bg-surface-container-low text-on-surface font-mono text-body-sm font-label-bold cursor-not-allowed">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Tanggal Pengajuan</label>
                    <input type="date" class="px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Subbagian Pemohon *</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-stack-sm text-primary text-[18px] pointer-events-none">apartment</span>
                    <select class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <option selected>Sub. Bagian Distribusi</option>
                        <option>Sub. Bagian Produksi</option>
                        <option>Sub. Bagian Perencana Teknik</option>
                        <option>Sub. Bagian IT</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Pemohon / User Pemohon *</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">person</span>
                        <input type="text" readonly value="Budi Pratama (Teknisi Distribusi)" class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-low text-on-surface text-body-sm cursor-not-allowed">
                    </div>
                    <span class="text-[11px] text-outline">* Otomatis terisi dari akun yang sedang login</span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Keterangan Permintaan</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">description</span>
                        <input type="text" placeholder="Contoh: Untuk pengerjaan perbaikan pipa bocor..." class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary">
                    </div>
                </div>
            </div>

            {{-- Pilihan Jenis / Status SPK Pekerjaan --}}
            <div class="flex flex-col gap-2 p-stack-md rounded-lg bg-surface-container-low">

                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Pilihan Jenis / Status SPK Pekerjaan</label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-sm">

                    <label class="spk-option flex items-start gap-stack-sm p-stack-md rounded-lg bg-surface-container-lowest border-2 border-primary cursor-pointer" onclick="toggleSpkField(true, this)">
                        <input type="radio" name="status_spk" id="radio-spk-ada" checked class="mt-1">
                        <span class="flex flex-col">
                            <span class="font-label-bold text-body-sm text-on-surface">Sudah Ada Nomor SPK</span>
                            <span class="text-[12px] text-on-surface-variant">Pekerjaan terencana / proyek dinas</span>
                        </span>
                    </label>

                    <label class="spk-option flex items-start gap-stack-sm p-stack-md rounded-lg bg-surface-container-lowest border-2 border-transparent cursor-pointer" onclick="toggleSpkField(false, this)">
                        <input type="radio" name="status_spk" id="radio-spk-darurat" class="mt-1">
                        <span class="flex flex-col">
                            <span class="font-label-bold text-body-sm text-on-surface">Belum Ada SPK / Sementara</span>
                            <span class="text-[12px] text-tertiary">Pipa bocor mendesak (Emergency Ticket)</span>
                        </span>
                    </label>

                </div>

                <div class="flex flex-col gap-1 mt-1">
                    <label class="font-label-bold text-[11px] text-on-surface-variant uppercase tracking-wider" id="label-nomor-spk">Nomor SPK Aktif / Rujukan Dokumen</label>
                    <input type="text" id="input-nomor-spk" placeholder="Contoh: SPK-DIST-2023-112 atau pilih..." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Gudang Pengambilan *</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-stack-sm text-outline text-[18px] pointer-events-none">warehouse</span>
                        <select class="w-full pl-8 pr-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary">
                            <option>GU-1 Gudang Induk Distribusi</option>
                            <option>GU-2 Distribusi Selatan</option>
                            <option>GU-3 Instalasi Pengolahan</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Tingkat Urgensi / Prioritas *</label>
                    <div class="grid grid-cols-3 gap-1.5">
                        <label class="urgensi-option flex items-center justify-center gap-1 p-stack-sm rounded-lg bg-surface-container-lowest border-2 border-primary cursor-pointer" onclick="toggleUrgensi(this)">
                            <input type="radio" name="urgensi" checked class="hidden">
                            <span class="text-[13px] font-label-bold text-primary">Normal</span>
                        </label>
                        <label class="urgensi-option flex items-center justify-center gap-1 p-stack-sm rounded-lg bg-surface-container-lowest border-2 border-transparent cursor-pointer" onclick="toggleUrgensi(this)">
                            <input type="radio" name="urgensi" class="hidden">
                            <span class="text-[13px] text-on-surface-variant">Tinggi</span>
                        </label>
                        <label class="urgensi-option flex items-center justify-center gap-1 p-stack-sm rounded-lg bg-surface-container-lowest border-2 border-transparent cursor-pointer" onclick="toggleUrgensi(this)">
                            <input type="radio" name="urgensi" class="hidden">
                            <span class="text-[13px] text-on-surface-variant">Sangat Mendesak</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Catatan / Peruntukan Pekerjaan Teknis</label>
                <textarea rows="3" placeholder="Tuliskan spesifikasi lokasi perbaikan, koordinat, atau keperluan pemakaian barang teknis..." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none"></textarea>
            </div>

        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-create-bpb').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <a href="{{ route('permintaan-barang.show', 'BPB-2023-1110') }}" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary text-on-primary font-label-bold text-body-sm shadow-sm hover:bg-primary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan &amp; Lanjut ke Detail
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function toggleSpkField(adaSpk, el) {
        document.querySelectorAll('.spk-option').forEach(function (opt) {
            opt.classList.remove('border-primary');
            opt.classList.add('border-transparent');
        });
        el.classList.remove('border-transparent');
        el.classList.add('border-primary');

        const label = document.getElementById('label-nomor-spk');
        const input = document.getElementById('input-nomor-spk');

        if (adaSpk) {
            label.textContent = 'Nomor SPK Aktif / Rujukan Dokumen';
            input.placeholder = 'Contoh: SPK-DIST-2023-112 atau pilih...';
            input.disabled = false;
            input.classList.remove('bg-surface-container-low', 'cursor-not-allowed');
            input.classList.add('bg-surface-container-lowest');
        } else {
            label.textContent = 'Keterangan Darurat (Sementara, SPK Menyusul)';
            input.placeholder = 'Contoh: Pipa bocor Jl. Sudirman - emergency, SPK akan disusulkan';
            input.value = '';
        }
    }

    function toggleUrgensi(el) {
        document.querySelectorAll('.urgensi-option').forEach(function (opt) {
            opt.classList.remove('border-primary');
            opt.classList.add('border-transparent');
            opt.querySelector('span:last-child').classList.remove('font-label-bold', 'text-primary');
            opt.querySelector('span:last-child').classList.add('text-on-surface-variant');
        });
        el.classList.remove('border-transparent');
        el.classList.add('border-primary');
        el.querySelector('span:last-child').classList.remove('text-on-surface-variant');
        el.querySelector('span:last-child').classList.add('font-label-bold', 'text-primary');
    }
</script>
@endpush

@endsection