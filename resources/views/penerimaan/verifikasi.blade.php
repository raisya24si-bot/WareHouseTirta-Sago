@extends('layouts.app')

@section('title', 'Verifikasi Penerimaan - Warehouse Tirta Sago')
@section('breadcrumb', 'Penerimaan Barang PO / Verifikasi')

@section('content')

@php
    $status = $penerimaan->statusPenerimaan?->kd_status_penerimaan_barang ?? 'DRAFT';

    $statusLabel = match ($status) {
        'DRAFT' => 'Draft',
        'REJECTED' => 'Ditolak / Perlu Perbaikan',
        'PENDING_KASUBAG' => 'Menunggu Approval Kasubag',
        'PENDING_KABAG' => 'Menunggu Approval Kabag',
        'PENDING_DIREKTUR' => 'Menunggu Approval Direktur',
        'APPROVED' => 'Disetujui',
        default => $status,
    };

    $statusClass = match ($status) {
        'DRAFT', 'REJECTED'
            => 'bg-surface-container text-on-surface-variant',

        'APPROVED'
            => 'bg-primary-fixed text-on-primary-fixed',

        default
            => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
    };

    $canEdit = $penerimaan->canBeEdited();

    $totalQtyPo = $penerimaan->details->sum('qty_request');
    $totalBaik = $penerimaan->details->sum('qty_baik');
    $totalRusak = $penerimaan->details->sum('qty_rusak');

    // Selisih boleh negatif / positif.
    // Contoh PO 100, baik 78, rusak 2 => -20.
    $totalSelisih = $totalBaik + $totalRusak - $totalQtyPo;

    $totalSku = $penerimaan->details->count();

    $itemBelumLokasi = $penerimaan->details
        ->filter(function ($detail) {
            return (int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang;
        })
        ->count();

    $itemDenganReject = $penerimaan->details
        ->filter(fn ($detail) => (int) $detail->qty_rusak > 0)
        ->count();

    // Item baik yang sudah punya bin (untuk badge ringkasan tabel).
    $itemTerpetakan = $penerimaan->details
        ->filter(fn ($detail) => (int) $detail->qty_baik > 0 && $detail->fk_lokasi_barang)
        ->count();

    $lokasiOptions = $lokasis->map(function ($lokasi) {
        $gudang = $lokasi->row?->rak?->gudang;
        $rak = $lokasi->row?->rak;
        $row = $lokasi->row;

        return [
            'id' => $lokasi->id_lokasi,
            'bin' => $lokasi->bin,
            'kode' => $lokasi->kd_lokasi,
            'gudang_id' => $gudang?->id_gudang,
            'gudang' => $gudang?->nm_gudang,
            'rak_id' => $rak?->id_rak,
            'rak' => $rak?->kd_rak,
            'row_id' => $row?->id_row,
            'row' => $row?->kd_row,
            'label' => collect([
                $gudang?->nm_gudang,
                $rak?->kd_rak,
                $row?->kd_row,
                $lokasi->bin ?: $lokasi->kd_lokasi,
            ])->filter()->implode(' • '),
        ];
    })->values();

    $gudangOptions = $lokasiOptions
        ->filter(fn ($item) => $item['gudang_id'])
        ->unique('gudang_id')
        ->values();

    $po = $penerimaan->po;
    $supplier = $po?->supplier;

    $totalNilaiBaik = $penerimaan->details->sum(function ($detail) {
        $harga = (float) ($detail->harga_satuan ?? $detail->barang?->harga ?? 0);
        return ((int) $detail->qty_baik) * $harga;
    });
@endphp

<div class="py-stack-md flex flex-col gap-stack-md">

    {{-- =========================================================
        BREADCRUMB / META
    ========================================================== --}}
    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant">
            <a
                href="{{ route('penerimaan.index') }}"
                class="hover:text-primary transition-colors"
            >
                Penerimaan Barang Masuk
            </a>

            <span class="material-symbols-outlined text-[16px] text-outline-variant">
                chevron_right
            </span>

            <span class="text-on-surface font-label-bold">
                Verifikasi & Setting Lokasi
            </span>
        </div>

        <div class="flex items-center gap-1.5 text-outline text-[12px] font-sidebar-nav">
            <span class="material-symbols-outlined text-[14px]">
                history
            </span>

            <span>
                {{ $penerimaan->updated_at?->format('d M Y H:i') ?? '-' }} WIB
            </span>
        </div>

    </div>


    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-stack-md bg-surface-container-lowest p-container-padding rounded-xl shadow-sm">

        <div class="flex flex-col gap-base">

            <div class="flex flex-wrap items-center gap-stack-sm">

                <span class="px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-bold text-[12px] uppercase tracking-wide">
                    {{ $penerimaan->kd_penerimaan }}
                </span>

                <span class="px-2.5 py-1 rounded-full {{ $statusClass }} font-label-bold text-[12px] flex items-center gap-1">

                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>

                    Status: {{ $statusLabel }}

                </span>

                <span class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-sidebar-nav text-[12px]">
                    {{ $totalSku }} Item
                </span>

            </div>

            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight mt-1">
                Verifikasi Fisik & Alokasi Lokasi Barang Masuk
            </h1>

            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-4xl">
                Pencocokan kuantitas fisik aktual dari supplier, inspeksi kondisi material,
                serta pemetaan lokasi penyimpanan barang sebelum dokumen diteruskan ke proses approval.
            </p>

        </div>


        <div class="flex flex-wrap items-center gap-stack-sm shrink-0">

            <a
                href="{{ route('penerimaan.index') }}"
                class="px-stack-md py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-label-bold flex items-center gap-stack-sm transition-colors"
            >
                <span class="material-symbols-outlined text-[18px]">
                    arrow_back
                </span>

                Daftar Penerimaan
            </a>

            @if($canEdit)

                <button
                    type="button"
                    onclick="saveDraft()"
                    class="px-stack-md py-2 rounded-lg bg-surface-container-high hover:bg-secondary-fixed text-on-surface font-label-bold text-label-bold flex items-center gap-stack-sm border border-outline-variant transition-colors"
                >
                    <span class="material-symbols-outlined text-primary text-[18px]">
                        bookmark
                    </span>

                    Simpan Draf
                </button>

            @endif

        </div>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">

        {{-- BAIK --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-primary">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Total Diterima Baik
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-baik"
                        class="font-display-lg text-[24px] text-primary font-bold"
                    >
                        {{ number_format($totalBaik) }}
                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit
                    </span>

                </div>

                <span class="text-[12px] text-on-surface-variant mt-0.5 flex items-center gap-1">

                    <span class="material-symbols-outlined text-[14px] text-primary">
                        check_circle
                    </span>

                    Siap alokasi ke Rak Aktif

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    verified
                </span>

            </div>

        </div>


        {{-- RUSAK --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-error">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-error font-bold">
                    Total Rusak / Cacat
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-rusak"
                        class="font-display-lg text-[24px] text-error font-bold"
                    >
                        {{ number_format($totalRusak) }}
                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit
                    </span>

                </div>

                <span class="text-[12px] text-error flex items-center gap-1 mt-0.5">

                    <span class="material-symbols-outlined text-[14px]">
                        report_problem
                    </span>

                    Wajib Karantina & BAP Retur

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-error-container text-on-error-container flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    inventory_2
                </span>

            </div>

        </div>


        {{-- SELISIH --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-tertiary">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-tertiary font-bold">
                    Discrepancy / Selisih PO
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-selisih"
                        class="font-display-lg text-[24px] text-tertiary font-bold"
                    >
                        {{ $totalSelisih > 0 ? '+' : '' }}{{ number_format($totalSelisih) }}
                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit {{ $totalSelisih < 0 ? 'Kurang Terima' : ($totalSelisih > 0 ? 'Lebih Terima' : '') }}
                    </span>

                </div>

                <span class="text-[12px] text-on-surface-variant mt-0.5 flex items-center gap-1">

                    <span class="material-symbols-outlined text-[14px] text-tertiary">
                        schedule
                    </span>

                    Menunggu Batch 2 (Surat Pernyataan)

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    difference
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
        DOCUMENT INFO
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">

        {{-- PO --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    receipt_long
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Purchase Order
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    {{ $po?->kd_po ?? '-' }}
                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    {{ $supplier?->nm_master_supplier ?? 'Supplier belum tersedia' }}
                </span>

            </div>

        </div>


        {{-- INVOICE / SJ --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    description
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Faktur / Surat Jalan
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    {{ $penerimaan->no_sjinv_supplier ?: '-' }}
                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    Referensi Supplier
                </span>

            </div>

        </div>


        {{-- TANGGAL --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    event_available
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Waktu Penerimaan
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    {{ $penerimaan->tgl_penerimaan_barang?->format('d M Y') ?? '-' }}
                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    {{ $penerimaan->created_at?->format('H:i') ?? '-' }} WIB
                </span>

            </div>

        </div>


        {{-- PETUGAS --}}
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    verified_user
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Petugas Verifikator
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    {{ $penerimaan->submittedBy?->name ?? auth()->user()?->name ?? '-' }}
                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    Petugas Penerimaan
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
        WARNING
    ========================================================== --}}
    @if($itemBelumLokasi > 0 || $totalRusak > 0)

        <div class="bg-tertiary-fixed text-on-tertiary-fixed p-stack-md rounded-xl flex flex-col lg:flex-row lg:items-center justify-between gap-stack-md shadow-sm">

            <div class="flex items-start gap-stack-md">

                <div class="w-10 h-10 rounded-lg bg-tertiary-container text-on-tertiary-container flex items-center justify-center shrink-0">

                    <span class="material-symbols-outlined text-[22px]">
                        warning
                    </span>

                </div>

                <div class="flex flex-col">

                    <span class="font-label-bold text-label-bold text-on-tertiary-fixed">
                        Perhatian: Terdapat
                        @if($itemBelumLokasi > 0)
                            {{ $itemBelumLokasi }} item belum berlokasi rak
                        @endif
                        @if($itemBelumLokasi > 0 && $totalRusak > 0)
                            dan
                        @endif
                        @if($totalRusak > 0)
                            {{ $totalRusak }} unit cacat/rusak fisik terdeteksi!
                        @endif
                    </span>

                    <span class="font-body-sm text-[13px] text-on-tertiary-fixed-variant">
                        @if($totalRusak > 0)
                            Barang berstatus rusak otomatis dipisahkan ke Gudang Karantina (Bin Retur)
                            dan sistem menerbitkan draf Berita Acara Kerusakan (BAP Retur) resmi
                            ke supplier {{ $penerimaan->po?->supplier?->nm_master_supplier ?? '-' }}.
                        @else
                            Pastikan seluruh item baik sudah dipetakan ke bin sebelum dokumen disubmit.
                        @endif
                    </span>

                </div>

            </div>

            <div class="flex items-center gap-stack-sm shrink-0">

                @if($totalRusak > 0)

                    <button
                        type="button"
                        onclick="window.print()"
                        class="px-3 py-1.5 rounded-lg bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-bold text-[12px] flex items-center gap-1.5 border border-outline-variant transition-colors"
                    >
                        <span class="material-symbols-outlined text-[16px]">description</span>
                        Draf BAP Retur
                    </button>

                @endif

                <span class="px-2.5 py-1.5 rounded bg-tertiary text-on-tertiary font-label-bold text-[11px] uppercase tracking-wider">
                    Tindakan Diperlukan
                </span>

            </div>

        </div>

    @endif


    {{-- =========================================================
        FORM VERIFIKASI
    ========================================================== --}}
    <form
        id="verification-form"
        method="POST"
        action="{{ route('penerimaan.save-draft', $penerimaan) }}"
        enctype="multipart/form-data"
    >

        @csrf


        {{-- =====================================================
            HEADER DATA (disembunyikan — sudah ditampilkan di kartu
            info PO/Faktur/Waktu/Petugas di atas. Input tetap dikirim
            sebagai hidden field karena backend saveDraft/submit
            masih memvalidasinya).
        ====================================================== --}}
        <input
            type="hidden"
            name="no_sjinv_supplier"
            value="{{ old('no_sjinv_supplier', $penerimaan->no_sjinv_supplier) }}"
        >

        <input
            type="hidden"
            name="tgl_penerimaan_barang"
            value="{{ old('tgl_penerimaan_barang', $penerimaan->tgl_penerimaan_barang?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
        >

        <input
            type="hidden"
            name="desc_penerimaan_barang"
            value="{{ old('desc_penerimaan_barang', $penerimaan->desc_penerimaan_barang) }}"
        >


        {{-- =====================================================
            ITEM TABLE
        ====================================================== --}}
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

            <div class="p-container-padding flex flex-col lg:flex-row lg:items-center justify-between gap-stack-sm bg-surface-container-low">

                <div class="flex items-center gap-stack-sm">

                    <span class="material-symbols-outlined text-primary text-[22px]">
                        inventory
                    </span>

                    <div class="flex flex-col">

                        <div class="flex items-center gap-stack-sm">

                            <h2 class="font-headline-md text-headline-md text-on-surface">
                                Daftar Item Verifikasi & Pemetaan Lokasi
                            </h2>

                            <span class="px-2 py-0.5 rounded-full bg-surface-container-highest text-on-surface-variant text-[12px] font-label-bold">
                                {{ $totalSku }} Item
                            </span>

                        </div>

                        <span class="text-[12px] text-on-surface-variant">
                            Input jumlah baik, rusak, dan lokasi penyimpanan untuk setiap barang.
                        </span>

                    </div>

                </div>

                <div class="flex flex-wrap items-center gap-stack-sm">

                    <div class="flex flex-wrap items-center gap-3 text-[12px] text-on-surface-variant">

                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            Terpetakan Baik: {{ $itemTerpetakan }} Item
                        </span>

                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            Ada Reject: {{ $itemDenganReject }} Item ({{ $totalRusak }} Unit)
                        </span>

                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                            Pending Bin: {{ $itemBelumLokasi }} Item
                        </span>

                    </div>

                    <span class="px-3 py-1.5 rounded-full bg-primary text-on-primary font-label-bold text-[12px] flex items-center gap-1.5 shrink-0">
                        <span class="material-symbols-outlined text-[16px]">
                            payments
                        </span>
                        <span id="header-total-nilai">Total Nilai Diterima: Rp {{ number_format($totalNilaiBaik, 0, ',', '.') }}</span>
                    </span>

                </div>

            </div>


            <div class="w-full overflow-x-auto">

                <table class="w-full min-w-[1900px] text-left font-body-sm text-body-sm">

                    <thead class="bg-surface-container text-on-surface-variant font-label-bold text-[12px] uppercase tracking-wider">

                        <tr>

                            <th class="py-stack-md px-container-padding">
                                Kode Barang
                            </th>

                            <th class="py-stack-md px-stack-md">
                                Nama Barang & Spesifikasi
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Qty PO
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Qty Diterima Baik
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Kondisi Rusak (Reject)
                            </th>

                            <th class="py-stack-md px-stack-md text-right">
                                Harga @ Satuan
                            </th>

                            <th class="py-stack-md px-stack-md text-right">
                                Total (Qty Baik × Harga)
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Status Kesesuaian
                            </th>

                            <th class="py-stack-md px-stack-md">
                                Lokasi Penyimpanan / Karantina
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Aksi Alokasi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="text-on-surface divide-y divide-surface-container">

                        @forelse($penerimaan->details as $detail)

                            @php
                                $barang = $detail->barang;

                                $qtyPo = (int) $detail->qty_request;
                                $qtyBaik = (int) $detail->qty_baik;
                                $qtyRusak = (int) $detail->qty_rusak;
                                $selisih = ($qtyBaik + $qtyRusak) - $qtyPo;

                                $selectedLokasi = $detail->lokasi;
                                $selectedLokasiKarantina = $detail->lokasiKarantina;

                                // Harga satuan sekarang diinput manual per detail penerimaan
                                // (kolom harga_satuan) — bisa diedit langsung di tabel.
                                $hargaSatuan = (float) old(
                                    "details.{$detail->id_penerimaan_barang_detail}.harga_satuan",
                                    $detail->harga_satuan ?? $barang?->harga ?? 0
                                );
                                $totalNilaiItem = $qtyBaik * $hargaSatuan;

                                $sesuaiFisik = $selisih === 0 && $qtyRusak === 0;
                            @endphp

                            <tr
                                class="
                                    transition-colors
                                    {{ $qtyRusak > 0
                                        ? 'bg-error-container/10 hover:bg-error-container/20'
                                        : 'hover:bg-surface-container-low/60' }}
                                "
                                data-detail-row="{{ $detail->id_penerimaan_barang_detail }}"
                                data-qty-po="{{ $qtyPo }}"
                            >

                                {{-- KODE --}}
                                <td class="py-stack-md px-container-padding align-top">

                                    <div class="flex flex-col">

                                        <span class="font-label-bold text-primary">
                                            {{ $barang?->kd_master_barang ?? '-' }}
                                        </span>

                                        @if($barang?->satuan)
                                            <span class="text-[11px] text-outline font-sidebar-nav">
                                                {{ $barang->satuan->nm_satuan ?? $barang->satuan->nama_satuan ?? '' }}
                                            </span>
                                        @endif

                                    </div>

                                </td>


                                {{-- BARANG --}}
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col max-w-md">

                                        <span class="font-label-bold text-on-surface">
                                            {{ $barang?->nm_master_barang ?? 'Barang tidak ditemukan' }}
                                        </span>

                                        @if($barang?->desc_master_barang)

                                            <span class="text-on-surface-variant text-[13px] mt-0.5">
                                                {{ $barang->desc_master_barang }}
                                            </span>

                                        @endif

                                        @if($qtyRusak > 0)

                                            <div class="mt-2 inline-flex items-center gap-1.5 w-fit px-2 py-1 rounded-lg bg-error-container text-on-error-container text-[11px] font-label-bold">

                                                <span class="material-symbols-outlined text-[15px]">
                                                    report_problem
                                                </span>

                                                {{ $qtyRusak }} Unit Rusak

                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- QTY PO --}}
                                <td class="py-stack-md px-stack-md text-center align-top">

                                    <span class="font-label-bold text-on-surface">
                                        {{ number_format($qtyPo) }}
                                    </span>

                                </td>


                                {{-- QTY BAIK --}}
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col items-center gap-1">

                                        <div class="flex items-center justify-center gap-1">

                                            <input
                                                type="number"
                                                min="0"
                                                step="1"
                                                name="details[{{ $detail->id_penerimaan_barang_detail }}][qty_baik]"
                                                value="{{ old("details.{$detail->id_penerimaan_barang_detail}.qty_baik", $qtyBaik) }}"
                                                {{ $canEdit ? '' : 'disabled' }}
                                                class="qty-baik w-24 rounded-lg border border-outline-variant bg-surface-container-low text-center font-label-bold text-primary py-2 px-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                                            >

                                            <span class="text-[12px] text-outline">
                                                Unit
                                            </span>

                                        </div>

                                        <span class="text-[11px] text-on-surface-variant">
                                            Kondisi baik / lolos QC
                                        </span>

                                    </div>

                                </td>


                                {{-- QTY RUSAK --}}
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col items-center gap-1">

                                        <div class="flex items-center justify-center gap-1">

                                            <input
                                                type="number"
                                                min="0"
                                                step="1"
                                                name="details[{{ $detail->id_penerimaan_barang_detail }}][qty_rusak]"
                                                value="{{ old("details.{$detail->id_penerimaan_barang_detail}.qty_rusak", $qtyRusak) }}"
                                                {{ $canEdit ? '' : 'disabled' }}
                                                class="qty-rusak w-20 rounded-lg border {{ $qtyRusak > 0 ? 'border-error/30 bg-error-container text-on-error-container' : 'border-outline-variant bg-surface-container' }} text-center font-label-bold py-2 px-1 focus:outline-none focus:ring-1 focus:ring-error disabled:opacity-60"
                                            >

                                            <span class="text-[11px] text-outline">
                                                Unit
                                            </span>

                                        </div>

                                        <span class="reject-label text-[11px] {{ $qtyRusak > 0 ? 'text-error font-label-bold' : 'text-outline-variant italic' }}">
                                            {{ $qtyRusak > 0 ? 'Butuh BAP Retur' : 'Nihil' }}
                                        </span>

                                    </div>

                                </td>


                                {{-- HARGA SATUAN (bisa diedit langsung) --}}
                                <td class="py-stack-md px-stack-md text-right align-top">

                                    <div class="relative inline-block w-full max-w-[140px]">

                                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[12px] text-outline pointer-events-none">
                                            Rp
                                        </span>

                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            inputmode="numeric"
                                            name="details[{{ $detail->id_penerimaan_barang_detail }}][harga_satuan]"
                                            value="{{ (int) $hargaSatuan }}"
                                            {{ $canEdit ? '' : 'disabled' }}
                                            class="harga-input w-full rounded-lg border border-outline-variant bg-surface-container-lowest pl-8 pr-2 py-1.5 text-right text-[13px] font-label-bold text-on-surface focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                                        >

                                    </div>

                                    <div class="text-[10px] text-outline mt-1">
                                        per {{ $barang?->satuan?->nm_master_satuan ?? 'unit' }}
                                    </div>

                                </td>


                                {{-- TOTAL --}}
                                <td class="py-stack-md px-stack-md text-right align-top">

                                    <span class="total-value font-label-bold text-primary">
                                        Rp {{ number_format($totalNilaiItem, 0, ',', '.') }}
                                    </span>

                                    <div class="total-sub text-[10px] text-outline">
                                        {{ $qtyBaik }} × Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                    </div>

                                </td>


                                {{-- STATUS KESESUAIAN --}}
                                <td class="py-stack-md px-stack-md text-center align-top">

                                    <div class="status-kesesuaian flex flex-col items-center gap-1">

                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[12px]
                                            {{ $sesuaiFisik
                                                ? 'bg-primary-fixed text-on-primary-fixed'
                                                : 'bg-tertiary-fixed text-on-tertiary-fixed-variant' }}"
                                        >
                                            <span class="material-symbols-outlined text-[15px]">
                                                {{ $sesuaiFisik ? 'check_circle' : 'difference' }}
                                            </span>

                                            {{ $sesuaiFisik
                                                ? 'Sesuai Fisik'
                                                : 'Selisih (' . ($selisih > 0 ? '+' : '') . $selisih . ' Unit)' }}
                                        </span>

                                        @if($qtyRusak > 0)
                                            <span class="text-[10px] text-error">
                                                {{ $qtyRusak }} cacat fisik terdeteksi
                                            </span>
                                        @elseif(!$sesuaiFisik)
                                            <span class="text-[10px] text-outline">
                                                Baik + Rusak − PO
                                            </span>
                                        @endif

                                    </div>

                                </td>


                                {{-- LOKASI PENYIMPANAN / KARANTINA --}}
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col gap-2 min-w-[220px]">

                                        @if($qtyBaik > 0)

                                            <div
                                                class="lokasi-chip flex items-center gap-1.5 text-[12px] {{ $selectedLokasi ? 'text-primary' : 'text-outline italic' }}"
                                                id="lokasi-label-{{ $detail->id_penerimaan_barang_detail }}"
                                            >
                                                <span class="material-symbols-outlined text-[15px]">
                                                    {{ $selectedLokasi ? 'location_on' : 'location_off' }}
                                                </span>

                                                <span class="lokasi-chip-text">
                                                    {{ $selectedLokasi
                                                        ? ($selectedLokasi->kd_lokasi ?? $selectedLokasi->bin)
                                                        : 'Belum diatur' }}
                                                </span>
                                            </div>

                                            {{-- Value asli yang dikirim ke server; diisi oleh drawer alokasi (mode baik). --}}
                                            <select
                                                name="details[{{ $detail->id_penerimaan_barang_detail }}][fk_lokasi_barang]"
                                                {{ $canEdit ? '' : 'disabled' }}
                                                class="hidden lokasi-select"
                                            >

                                                <option value="">-- Pilih Bin Penyimpanan --</option>

                                                @foreach($lokasiOptions as $lokasiOption)

                                                    <option
                                                        value="{{ $lokasiOption['id'] }}"
                                                        data-label="{{ $lokasiOption['label'] }}"
                                                        @selected((string) old(
                                                            "details.{$detail->id_penerimaan_barang_detail}.fk_lokasi_barang",
                                                            $detail->fk_lokasi_barang
                                                        ) === (string) $lokasiOption['id'])
                                                    >
                                                        {{ $lokasiOption['label'] }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        @else

                                            <span class="text-[12px] text-outline italic">
                                                Tidak ada barang baik.
                                            </span>

                                        @endif


                                        @if($qtyRusak > 0)

                                            <div class="rounded-lg bg-error-container/40 border border-error-container p-2 flex flex-col gap-1">

                                                <div class="flex items-start gap-1.5">

                                                    <span class="material-symbols-outlined text-[15px] text-error mt-0.5">
                                                        inventory_2
                                                    </span>

                                                    <span class="text-[11px] text-on-error-container">
                                                        Wajib Karantina &amp; BAP Retur
                                                        ({{ $qtyRusak }} Unit)
                                                    </span>

                                                </div>

                                                <div
                                                    class="lokasi-karantina-chip flex items-center gap-1.5 text-[11px] {{ $selectedLokasiKarantina ? 'text-error font-label-bold' : 'text-error/70 italic' }}"
                                                    id="lokasi-karantina-label-{{ $detail->id_penerimaan_barang_detail }}"
                                                >
                                                    <span class="material-symbols-outlined text-[14px]">
                                                        {{ $selectedLokasiKarantina ? 'location_on' : 'location_off' }}
                                                    </span>

                                                    <span class="lokasi-chip-text">
                                                        {{ $selectedLokasiKarantina
                                                            ? ($selectedLokasiKarantina->kd_lokasi ?? $selectedLokasiKarantina->bin)
                                                            : 'Bin karantina belum diatur' }}
                                                    </span>
                                                </div>

                                                {{-- Value asli yang dikirim ke server; diisi oleh drawer alokasi (mode karantina). --}}
                                                <select
                                                    name="details[{{ $detail->id_penerimaan_barang_detail }}][fk_lokasi_karantina]"
                                                    {{ $canEdit ? '' : 'disabled' }}
                                                    class="hidden lokasi-karantina-select"
                                                >

                                                    <option value="">-- Pilih Bin Karantina --</option>

                                                    @foreach($lokasiOptions as $lokasiOption)

                                                        <option
                                                            value="{{ $lokasiOption['id'] }}"
                                                            data-label="{{ $lokasiOption['label'] }}"
                                                            @selected((string) old(
                                                                "details.{$detail->id_penerimaan_barang_detail}.fk_lokasi_karantina",
                                                                $detail->fk_lokasi_karantina
                                                            ) === (string) $lokasiOption['id'])
                                                        >
                                                            {{ $lokasiOption['label'] }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- AKSI ALOKASI --}}
                                <td class="py-stack-md px-stack-md text-center align-top">

                                    <div class="flex flex-col items-center gap-2">

                                        @if($qtyBaik > 0)

                                            <button
                                                type="button"
                                                {{ $canEdit ? '' : 'disabled' }}
                                                onclick="openLokasiDrawer(this, 'baik')"
                                                data-detail-id="{{ $detail->id_penerimaan_barang_detail }}"
                                                data-nama-barang="{{ $barang?->nm_master_barang ?? 'Barang' }}"
                                                class="btn-alokasi w-full px-3 py-2 rounded-lg font-label-bold text-[12px] flex items-center justify-center gap-1.5 transition-colors disabled:opacity-50
                                                {{ $selectedLokasi
                                                    ? 'bg-surface-container-high hover:bg-surface-container-highest text-on-surface border border-outline-variant'
                                                    : 'bg-tertiary hover:bg-tertiary-container text-on-tertiary' }}"
                                            >
                                                <span class="material-symbols-outlined text-[16px]">
                                                    {{ $selectedLokasi ? 'edit_location_alt' : 'add_location_alt' }}
                                                </span>

                                                {{ $selectedLokasi
                                                    ? ($qtyRusak > 0 ? 'Ubah Rak Baik' : 'Ubah Bin')
                                                    : '+ Pilih / Setting Lokasi Bin' }}
                                            </button>

                                        @endif

                                        @if($qtyRusak > 0)

                                            <button
                                                type="button"
                                                {{ $canEdit ? '' : 'disabled' }}
                                                onclick="openLokasiDrawer(this, 'karantina')"
                                                data-detail-id="{{ $detail->id_penerimaan_barang_detail }}"
                                                data-nama-barang="{{ $barang?->nm_master_barang ?? 'Barang' }}"
                                                class="btn-alokasi-karantina w-full px-3 py-2 rounded-lg font-label-bold text-[12px] flex items-center justify-center gap-1.5 transition-colors disabled:opacity-50
                                                {{ $selectedLokasiKarantina
                                                    ? 'bg-surface-container-high hover:bg-surface-container-highest text-on-surface border border-outline-variant'
                                                    : 'bg-error hover:bg-error-container text-on-error' }}"
                                            >
                                                <span class="material-symbols-outlined text-[15px]">
                                                    {{ $selectedLokasiKarantina ? 'edit_location_alt' : 'inventory' }}
                                                </span>
                                                {{ $selectedLokasiKarantina ? 'Ubah Bin Karantina' : 'Karantina Bin' }}
                                            </button>

                                        @endif

                                        @if($qtyBaik == 0 && $qtyRusak == 0)

                                            <span class="text-[11px] text-outline italic">
                                                Menunggu input qty
                                            </span>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="10"
                                    class="py-12 text-center text-on-surface-variant"
                                >

                                    <span class="material-symbols-outlined text-[40px] text-outline-variant">
                                        inventory_2
                                    </span>

                                    <p class="mt-2">
                                        Belum ada detail barang pada penerimaan ini.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    <tfoot class="bg-surface-container-low border-t border-surface-container">

                        <tr>

                            <td
                                colspan="2"
                                class="py-stack-md px-container-padding"
                            >

                                <span class="font-label-bold text-[13px] uppercase tracking-wider">
                                    Total
                                </span>

                            </td>

                            <td class="py-stack-md px-stack-md text-center font-label-bold">
                                {{ number_format($totalQtyPo) }}
                            </td>

                            <td
                                id="footer-baik"
                                class="py-stack-md px-stack-md text-center font-label-bold text-primary"
                            >
                                {{ number_format($totalBaik) }}
                            </td>

                            <td
                                id="footer-rusak"
                                class="py-stack-md px-stack-md text-center font-label-bold text-error"
                            >
                                {{ number_format($totalRusak) }}
                            </td>

                            <td class="py-stack-md px-stack-md text-outline text-center text-[11px]">
                                &mdash;
                            </td>

                            <td
                                id="footer-total-nilai"
                                class="py-stack-md px-stack-md text-right font-label-bold text-primary"
                            >
                                Rp {{ number_format($totalNilaiBaik, 0, ',', '.') }}
                            </td>

                            <td class="py-stack-md px-stack-md text-center">
                                <span class="px-2.5 py-1 rounded-full bg-primary text-on-primary text-[11px] font-label-bold">
                                    Terverifikasi Siap Stok
                                </span>
                            </td>

                            <td></td>
                            <td></td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        {{-- =====================================================
            UPLOAD FOTO
        ====================================================== --}}
        <div class="bg-surface-container-lowest p-container-padding rounded-xl shadow-sm">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-stack-md">

                <div class="flex items-start gap-stack-sm">

                    <div class="w-9 h-9 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">

                        <span class="material-symbols-outlined text-[20px]">
                            photo_camera
                        </span>

                    </div>

                    <div class="flex flex-col">

                        <h2 class="font-headline-md text-[18px] text-on-surface font-bold">
                            Dokumentasi Foto Penerimaan
                        </h2>

                        <span class="text-[12px] text-on-surface-variant">
                            Upload foto kondisi fisik barang saat proses penerimaan.
                        </span>

                    </div>

                </div>


                @if($canEdit)

                    <label
                        for="foto_penerimaan"
                        class="no-print inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-bold text-[13px] cursor-pointer hover:bg-primary-container transition-colors"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            add_a_photo
                        </span>

                        + Unggah Foto

                    </label>

                @endif

            </div>


            {{-- INPUT FILE --}}
            @if($canEdit)

                <input
                    id="foto_penerimaan"
                    type="file"
                    name="bukti_dukung[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    class="hidden"
                >

            @endif


            {{-- INFO --}}
            <div class="mt-4 rounded-lg bg-surface-container-low border border-outline-variant p-3">

                <div class="flex items-start gap-2">

                    <span class="material-symbols-outlined text-[18px] text-primary shrink-0">
                        info
                    </span>

                    <div class="text-[12px] text-on-surface-variant">

                        <span class="font-label-bold text-on-surface">
                            Dokumentasi penerimaan
                        </span>

                        <p class="mt-0.5">
                            Maksimal 5 foto. Format JPG, PNG atau WEBP.
                            Foto digunakan sebagai bukti kondisi fisik saat penerimaan.
                        </p>

                    </div>

                </div>

            </div>


            {{-- EXISTING FILES --}}
            @if($penerimaan->buktiDukungs->count())

                <div class="mt-4">

                    <div class="flex items-center gap-2 mb-2">

                        <span class="font-label-bold text-[12px] text-on-surface">
                            Dokumentasi Tersimpan
                        </span>

                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-[10px] font-label-bold text-on-surface-variant">
                            {{ $penerimaan->buktiDukungs->count() }} File
                        </span>

                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

                        @foreach($penerimaan->buktiDukungs as $bukti)

                            @if($bukti->path_file ?? false)

                                <div class="relative rounded-lg overflow-hidden border border-outline-variant bg-surface-container group">

                                    <a
                                        href="{{ asset('storage/' . $bukti->path_file) }}"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $bukti->path_file) }}"
                                            alt="{{ $bukti->nama_file ?? 'Dokumentasi penerimaan' }}"
                                            class="w-full h-28 object-cover group-hover:opacity-90 transition-opacity"
                                        >
                                    </a>

                                    <div class="px-2 py-1.5 bg-surface-container-lowest">

                                        <p class="text-[10px] font-label-bold text-on-surface truncate" title="{{ $bukti->nama_file }}">
                                            {{ $bukti->nama_file ?? 'foto.jpg' }}
                                        </p>

                                        <p class="text-[9px] text-outline truncate">
                                            {{ $bukti->creator?->name ?? 'Petugas' }}
                                            &bull;
                                            {{ $bukti->created_at?->format('d M Y H:i') }}
                                        </p>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- PREVIEW BARU --}}
            <div
                id="photo-preview"
                class="hidden mt-4"
            >

                <div class="flex items-center justify-between mb-2">

                    <span class="font-label-bold text-[12px] text-on-surface">
                        Foto yang Akan Diunggah
                    </span>

                    <button
                        type="button"
                        onclick="clearPhotoSelection()"
                        class="text-[11px] text-error hover:underline"
                    >
                        Hapus Semua
                    </button>

                </div>

                <div
                    id="photo-preview-grid"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3"
                ></div>

            </div>

        </div>


        {{-- =====================================================
            GUIDELINE
        ====================================================== --}}
        <div class="bg-primary-fixed/60 border border-primary/10 p-stack-md rounded-xl">

            <div class="flex items-start gap-stack-sm">

                <div class="w-8 h-8 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">

                    <span class="material-symbols-outlined text-[18px]">
                        info
                    </span>

                </div>

                <div class="flex flex-col">

                    <span class="font-label-bold text-[13px] text-on-surface">
                        Alur stok gudang
                    </span>

                    <span class="font-body-sm text-[12px] text-on-surface-variant mt-0.5">
                        Simpan Draf dan Submit Penerimaan <strong>tidak langsung menambah stok</strong>.
                        Setelah dokumen melewati approval sampai Direktur dan berstatus APPROVED,
                        barulah stok fisik diproses ke lokasi gudang.
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
            PANDUAN AKSI DOKUMEN — beda dampak Simpan Draft vs Submit
        ====================================================== --}}
        <div class="rounded-xl border border-outline-variant bg-surface-container-low p-container-padding flex flex-col gap-stack-sm">

            <div class="flex items-start gap-2">

                <div class="w-7 h-7 rounded-full bg-primary-fixed text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[16px]">info</span>
                </div>

                <div class="flex flex-col">
                    <span class="font-label-bold text-[13px] text-on-surface">
                        Panduan Aksi Dokumen: Perbedaan Simpan (Draft) vs Submit (Final)
                    </span>
                    <span class="text-[12px] text-on-surface-variant">
                        Pahami perbedaan dampak aksi verifikasi sebelum melanjutkan transaksi inbound perpipaan.
                    </span>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-sm">

                <div class="rounded-lg bg-surface-container-lowest border border-outline-variant p-stack-sm flex items-start gap-2">
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant mt-0.5">bookmark</span>
                    <div class="flex flex-col text-[12px]">
                        <span class="font-label-bold text-on-surface">Simpan (Save Draft):</span>
                        <span class="text-on-surface-variant">
                            Menyimpan progres fisik &amp; slot sementara. Data tidak hilang namun
                            <span class="font-label-bold text-on-surface">belum menambah stok master inventaris gudang</span>.
                        </span>
                    </div>
                </div>

                <div class="rounded-lg bg-primary-fixed/40 border border-primary/20 p-stack-sm flex items-start gap-2">
                    <span class="material-symbols-outlined text-[18px] text-primary mt-0.5">task_alt</span>
                    <div class="flex flex-col text-[12px]">
                        <span class="font-label-bold text-primary">Submit (Finalisasi):</span>
                        <span class="text-on-surface-variant">
                            Mengunci dokumen GRN &amp; <span class="font-label-bold text-on-surface">mengirim ke antrian approval Direktur</span>.
                            Stok gudang baru diperbarui otomatis setelah Direktur menyetujui.
                        </span>
                    </div>
                </div>

            </div>

        </div>


        {{-- =====================================================
            BOTTOM ACTION BAR
        ====================================================== --}}
        <div class="sticky bottom-4 z-30 w-full bg-surface-container-lowest/95 backdrop-blur-xl p-container-padding rounded-xl shadow-xl border border-outline-variant flex flex-col xl:flex-row items-start xl:items-center justify-between gap-stack-md">

            <div class="flex items-start gap-stack-sm">

                <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary shrink-0">

                    <span class="material-symbols-outlined text-[22px]">
                        task_alt
                    </span>

                </div>

                <div class="flex flex-col">

                    <div class="flex flex-wrap items-center gap-stack-sm">

                        <span class="font-label-bold text-label-bold text-on-surface">
                            Status Verifikasi
                        </span>

                        <span
                            id="verification-counter"
                            class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-bold text-[11px]"
                        >
                            {{ $totalSku }} Item
                        </span>

                    </div>

                    <span
                        id="location-warning"
                        class="font-body-sm text-[12px] {{ $itemBelumLokasi > 0 ? 'text-tertiary' : 'text-primary' }} font-label-bold flex items-center gap-1 mt-0.5"
                    >

                        <span class="material-symbols-outlined text-[15px]">
                            {{ $itemBelumLokasi > 0 ? 'pending_actions' : 'check_circle' }}
                        </span>

                        {{ $itemBelumLokasi > 0
                            ? $itemBelumLokasi . ' item masih membutuhkan lokasi'
                            : 'Seluruh item baik sudah memiliki lokasi' }}

                    </span>

                </div>

            </div>


            <div class="flex flex-wrap items-center gap-stack-sm w-full xl:w-auto justify-end">

                <a
                    href="{{ route('penerimaan.index') }}"
                    class="px-stack-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-bold text-body-sm border border-outline-variant transition-colors"
                >
                    Batal / Kembali
                </a>


                <button
                    type="button"
                    onclick="window.print()"
                    class="px-stack-md py-2.5 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-bold text-body-sm flex items-center gap-1.5 border border-outline-variant transition-colors"
                >

                    <span class="material-symbols-outlined text-[18px] text-outline">
                        print
                    </span>

                    Cetak Bukti Sementara

                </button>


                @if($canEdit)

                    <button
                        type="button"
                        onclick="saveDraft()"
                        class="px-stack-md py-2.5 rounded-lg bg-surface-container-highest hover:bg-secondary-fixed text-on-surface font-label-bold text-body-sm flex items-center gap-1.5 border border-outline-variant transition-colors"
                    >

                        <span class="material-symbols-outlined text-primary text-[18px]">
                            bookmark
                        </span>

                        Simpan Draf

                    </button>


                    <button
                        type="button"
                        onclick="submitReception()"
                        class="px-container-padding py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm flex items-center gap-stack-sm shadow-md transition-all"
                    >

                        <span class="material-symbols-outlined text-[20px]">
                            verified
                        </span>

                        <div class="flex flex-col items-start leading-tight">

                            <span>
                                Submit Penerimaan
                            </span>

                            <span class="text-[10px] font-normal text-on-primary/80">
                                Kirim ke Antrian Approval Direktur
                            </span>

                        </div>

                    </button>

                @elseif($status === 'PENDING_DIREKTUR')

                    <button
                        type="button"
                        onclick="openRejectModal()"
                        class="px-stack-md py-2.5 rounded-lg bg-error-container hover:bg-error text-on-error-container hover:text-on-error font-label-bold text-body-sm flex items-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                        Tolak
                    </button>

                    <button
                        type="button"
                        onclick="approveReception()"
                        class="px-container-padding py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm flex items-center gap-stack-sm shadow-md transition-all"
                    >
                        <span class="material-symbols-outlined text-[20px]">task_alt</span>

                        <div class="flex flex-col items-start leading-tight">
                            <span>Setujui (Approve)</span>
                            <span class="text-[10px] font-normal text-on-primary/80">
                                Update stok gudang & kunci dokumen
                            </span>
                        </div>
                    </button>

                @else

                    <span class="px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-label-bold text-sm">
                        {{ $statusLabel }}
                    </span>

                @endif

            </div>

        </div>

    </form>


    {{-- =============================================================
        DRAWER: ALOKASI PENYIMPANAN (Gudang > Rak > Row > Bin)
        Satu drawer dipakai ulang untuk semua baris item.
    ============================================================= --}}
    <div
        id="lokasi-drawer-overlay"
        class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4"
    >

        <div class="bg-surface-container-lowest w-full max-w-3xl rounded-xl shadow-xl max-h-[90vh] overflow-y-auto">

            {{-- HEADER --}}
            <div class="p-container-padding border-b border-outline-variant flex items-start justify-between gap-stack-sm sticky top-0 bg-surface-container-lowest z-10">

                <div class="flex items-start gap-stack-sm">

                    <div class="w-9 h-9 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">
                            inventory
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="font-headline-md text-[16px] text-on-surface">
                            <span id="drawer-title-label">Alokasi Penyimpanan:</span> <span id="drawer-nama-barang">-</span>
                        </span>
                        <span class="text-[12px] text-on-surface-variant">
                            Tentukan hierarki penempatan fisik dari gudang, blok rak, tingkat rak, hingga spesifik bin code.
                        </span>
                    </div>

                </div>

                <button
                    type="button"
                    onclick="closeLokasiDrawer()"
                    class="text-outline hover:text-on-surface shrink-0"
                >
                    <span class="material-symbols-outlined text-[22px]">close</span>
                </button>

            </div>


            {{-- BODY --}}
            <div class="p-container-padding flex flex-col gap-stack-md">

                <div id="drawer-error" class="hidden rounded-lg bg-error-container text-on-error-container px-3 py-2 text-[12px]"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-stack-sm">

                    {{-- 1. GUDANG --}}
                    <div>
                        <label class="mb-1.5 block text-[11px] font-label-bold text-on-surface-variant uppercase">
                            1. Gudang Penyimpanan
                        </label>
                        <select
                            id="drawer-select-gudang"
                            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-[13px] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        >
                            <option value="">Memuat...</option>
                        </select>
                        <p id="drawer-gudang-info" class="mt-1 text-[11px] text-outline"></p>
                    </div>

                    {{-- 2. RAK --}}
                    <div>
                        <label class="mb-1.5 block text-[11px] font-label-bold text-on-surface-variant uppercase">
                            2. Blok Rak
                        </label>
                        <select
                            id="drawer-select-rak"
                            disabled
                            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-[13px] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-50"
                        >
                            <option value="">-- Pilih Gudang Dahulu --</option>
                        </select>
                        <p id="drawer-rak-info" class="mt-1 text-[11px] text-outline"></p>
                    </div>

                    {{-- 3. ROW --}}
                    <div>
                        <label class="mb-1.5 block text-[11px] font-label-bold text-on-surface-variant uppercase">
                            3. Tingkat / Row Level
                        </label>
                        <select
                            id="drawer-select-row"
                            disabled
                            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-[13px] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-50"
                        >
                            <option value="">-- Pilih Rak Dahulu --</option>
                        </select>
                        <p id="drawer-row-info" class="mt-1 text-[11px] text-outline"></p>
                    </div>

                    {{-- 4. BIN --}}
                    <div>
                        <label class="mb-1.5 block text-[11px] font-label-bold text-on-surface-variant uppercase">
                            4. Bin Box Slot
                        </label>
                        <select
                            id="drawer-select-bin"
                            disabled
                            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2 text-[13px] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-50"
                        >
                            <option value="">-- Pilih Row Dahulu --</option>
                        </select>
                        <p id="drawer-bin-info" class="mt-1 text-[11px] text-outline"></p>
                    </div>

                </div>


                {{-- DOKUMENTASI FOTO (ringkas) + ESTIMASI KAPASITAS --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-stack-sm">

                    {{-- DOKUMENTASI FOTO MASUK FISIK (ringkas) --}}
                    <div class="rounded-xl bg-surface-container p-stack-sm flex flex-col gap-2">

                        <div class="flex items-center justify-between">
                            <span class="font-label-bold text-[12px] text-on-surface">
                                Dokumentasi Foto Masuk Fisik
                            </span>

                            @if($canEdit)
                                <button
                                    type="button"
                                    onclick="document.getElementById('foto_penerimaan').click()"
                                    class="text-[11px] font-label-bold text-primary hover:underline flex items-center gap-0.5"
                                >
                                    <span class="material-symbols-outlined text-[14px]">add_a_photo</span>
                                    Unggah Foto
                                </button>
                            @endif
                        </div>

                        @if($penerimaan->buktiDukungs->count())

                            <div class="grid grid-cols-3 gap-1.5">

                                @foreach($penerimaan->buktiDukungs->take(3) as $bukti)

                                    @if($bukti->path_file ?? false)

                                        <a
                                            href="{{ asset('storage/' . $bukti->path_file) }}"
                                            target="_blank"
                                            rel="noopener"
                                            class="block rounded-md overflow-hidden border border-outline-variant relative group"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $bukti->path_file) }}"
                                                alt="{{ $bukti->nama_file ?? 'Dokumentasi' }}"
                                                class="w-full h-16 object-cover group-hover:opacity-90"
                                            >
                                        </a>

                                    @endif

                                @endforeach

                            </div>

                            <span class="text-[10px] text-outline">
                                Diunggah oleh {{ $penerimaan->buktiDukungs->last()?->creator?->name ?? 'Petugas' }}
                                &bull; Total {{ $penerimaan->buktiDukungs->count() }} file terverifikasi
                            </span>

                        @else

                            <span class="text-[11px] text-outline italic">
                                Belum ada dokumentasi foto yang diunggah.
                            </span>

                        @endif

                    </div>


                    {{-- OKUPANSI RAK TERPILIH --}}
                    <div id="drawer-occupancy-wrap" class="hidden rounded-xl bg-surface-container p-stack-sm">

                        <div class="flex items-center justify-between mb-2">
                            <span class="font-label-bold text-[12px] text-on-surface" id="drawer-occupancy-title">
                                Okupansi Rak
                            </span>
                            <span class="font-label-bold text-[12px]" id="drawer-occupancy-percent">0%</span>
                        </div>

                        <div class="w-full h-2.5 rounded-full bg-surface-container-high overflow-hidden flex">
                            <div id="drawer-occupancy-bar" class="h-full bg-primary transition-all" style="width:0%"></div>
                        </div>

                        <div class="flex items-center gap-4 mt-2 text-[11px] text-on-surface-variant">
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                <span id="drawer-occupancy-terisi">0</span> Bin Terisi
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-surface-container-high border border-outline-variant"></span>
                                <span id="drawer-occupancy-kosong">0</span> Bin Kosong
                            </span>
                        </div>

                    </div>

                </div>


                {{-- ISI BIN TERPILIH (kalau sudah terisi barang lain) --}}
                <div id="drawer-bin-isi-wrap" class="hidden rounded-lg bg-tertiary-fixed/60 border border-tertiary/20 p-stack-sm text-[12px] text-on-tertiary-fixed-variant">
                    <span class="font-label-bold">Perhatian:</span>
                    <span id="drawer-bin-isi-text"></span>
                </div>

            </div>


            {{-- FOOTER --}}
            <div class="p-container-padding border-t border-outline-variant flex items-center justify-end gap-stack-sm sticky bottom-0 bg-surface-container-lowest">

                <button
                    type="button"
                    onclick="closeLokasiDrawer()"
                    class="px-stack-md py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-label-bold text-[13px] transition-colors"
                >
                    Batalkan
                </button>

                <button
                    type="button"
                    id="drawer-btn-simpan"
                    onclick="simpanAlokasiBin()"
                    disabled
                    class="px-stack-md py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-[13px] flex items-center gap-1.5 disabled:opacity-50 transition-colors"
                >
                    <span class="material-symbols-outlined text-[16px]">check</span>
                    <span id="drawer-btn-simpan-label">Simpan Alokasi Bin</span>
                </button>

            </div>

        </div>

    </div>

</div>


    {{-- =============================================================
        MODAL: TOLAK PENERIMAAN (alasan penolakan direktur)
    ============================================================= --}}
    @if($status === 'PENDING_DIREKTUR')

        <div
            id="reject-modal-overlay"
            class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4"
        >

            <div class="bg-surface-container-lowest w-full max-w-md rounded-xl shadow-xl">

                <div class="p-container-padding border-b border-outline-variant flex items-start justify-between gap-stack-sm">

                    <div class="flex items-start gap-stack-sm">
                        <div class="w-9 h-9 rounded-lg bg-error-container text-on-error-container flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[20px]">cancel</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline-md text-[16px] text-on-surface">
                                Tolak Penerimaan
                            </span>
                            <span class="text-[12px] text-on-surface-variant">
                                Dokumen akan dikembalikan ke status Draft untuk diperbaiki petugas gudang.
                            </span>
                        </div>
                    </div>

                    <button type="button" onclick="closeRejectModal()" class="text-outline hover:text-on-surface shrink-0">
                        <span class="material-symbols-outlined text-[22px]">close</span>
                    </button>

                </div>

                <div class="p-container-padding flex flex-col gap-stack-sm">

                    <div id="reject-error" class="hidden rounded-lg bg-error-container text-on-error-container px-3 py-2 text-[12px]"></div>

                    <label class="text-[12px] font-label-bold text-on-surface">
                        Alasan Penolakan <span class="text-error">*</span>
                    </label>

                    <textarea
                        id="reject-reason"
                        rows="4"
                        class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm focus:border-error focus:outline-none focus:ring-1 focus:ring-error"
                        placeholder="Contoh: Bin lokasi belum sesuai, harga satuan perlu dicek ulang, dst."
                    ></textarea>

                </div>

                <div class="p-container-padding border-t border-outline-variant flex items-center justify-end gap-stack-sm">
                    <button
                        type="button"
                        onclick="closeRejectModal()"
                        class="px-stack-md py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-label-bold text-[13px] transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        onclick="submitReject()"
                        class="px-stack-md py-2 rounded-lg bg-error hover:bg-error-container text-on-error font-label-bold text-[13px] flex items-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-[16px]">cancel</span>
                        Tolak Penerimaan
                    </button>
                </div>

            </div>

        </div>

    @endif


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}
<script>

    const form = document.getElementById('verification-form');

    const saveDraftUrl = @json(route('penerimaan.save-draft', $penerimaan));
    const submitUrl = @json(route('penerimaan.submit', $penerimaan));
    const uploadBuktiUrl = @json(route('penerimaan.bukti-dukung.upload', $penerimaan));
    const indexUrl = @json(route('penerimaan.index'));
    const approveUrl = @json(route('penerimaan.approval-direktur.approve', $penerimaan));
    const rejectUrl = @json(route('penerimaan.approval-direktur.reject', $penerimaan));

    const canEdit = @json($canEdit);


    /*
    |--------------------------------------------------------------------------
    | APPROVAL DIREKTUR (Setujui / Tolak)
    |--------------------------------------------------------------------------
    */

    function approveReception() {

        if (! confirm('Setujui penerimaan ini? Stok gudang akan otomatis diperbarui dan dokumen akan terkunci.')) {
            return;
        }

        const btn = event?.currentTarget;
        if (btn) btn.disabled = true;

        fetch(approveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '',
            },
        })
            .then(async response => {
                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menyetujui penerimaan.');
                }

                alert(data.message || 'Penerimaan berhasil disetujui.');
                window.location.href = indexUrl;
            })
            .catch(error => {
                console.error(error);
                alert(error.message || 'Terjadi kesalahan saat menyetujui penerimaan.');
                if (btn) btn.disabled = false;
            });
    }


    function openRejectModal() {
        document.getElementById('reject-modal-overlay')?.classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-modal-overlay')?.classList.add('hidden');
    }

    function submitReject() {

        const reasonInput = document.getElementById('reject-reason');
        const reason = reasonInput?.value?.trim() || '';
        const errorBox = document.getElementById('reject-error');

        if (!reason) {
            if (errorBox) {
                errorBox.textContent = 'Alasan penolakan wajib diisi.';
                errorBox.classList.remove('hidden');
            }
            return;
        }

        fetch(rejectUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '',
            },
            body: JSON.stringify({ catatan_approval: reason }),
        })
            .then(async response => {
                const data = await response.json().catch(() => ({}));

                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menolak penerimaan.');
                }

                alert(data.message || 'Penerimaan ditolak dan dikembalikan ke draft.');
                window.location.href = indexUrl;
            })
            .catch(error => {
                console.error(error);
                if (errorBox) {
                    errorBox.textContent = error.message || 'Terjadi kesalahan saat menolak penerimaan.';
                    errorBox.classList.remove('hidden');
                }
            });
    }


    /*
    |--------------------------------------------------------------------------
    | LOKASI DRAWER (Gudang > Rak > Row > Bin) — cascading via AJAX,
    | okupansi dihitung dari data stok asli (lihat PenerimaanController).
    |--------------------------------------------------------------------------
    */

    const lokasiUrls = {
        gudang: @json(route('penerimaan.lokasi.gudang')),
        rak: @json(route('penerimaan.lokasi.rak')),
        row: @json(route('penerimaan.lokasi.row')),
        bin: @json(route('penerimaan.lokasi.bin')),
    };

    // Peta id_lokasi -> {gudang_id, rak_id, row_id, label} dari data yang sudah
    // dirender server (dipakai untuk preselect cascading saat drawer dibuka
    // untuk baris yang sudah punya bin).
    const lokasiIndex = {};
    @foreach($lokasiOptions as $lokasiOption)
        lokasiIndex[{{ $lokasiOption['id'] }}] = {
            gudangId: {{ $lokasiOption['gudang_id'] ?? 'null' }},
            rakId: {{ $lokasiOption['rak_id'] ?? 'null' }},
            rowId: {{ $lokasiOption['row_id'] ?? 'null' }},
            label: @json($lokasiOption['label']),
        };
    @endforeach

    let drawerState = {
        detailId: null,
        mode: 'baik',
        rakCache: [],
        binCache: [],
    };

    const drawerOverlay = document.getElementById('lokasi-drawer-overlay');
    const selectGudang = document.getElementById('drawer-select-gudang');
    const selectRak = document.getElementById('drawer-select-rak');
    const selectRow = document.getElementById('drawer-select-row');
    const selectBin = document.getElementById('drawer-select-bin');
    const btnSimpan = document.getElementById('drawer-btn-simpan');


    function showDrawerError(message) {
        const box = document.getElementById('drawer-error');
        if (!box) return;

        if (!message) {
            box.classList.add('hidden');
            box.textContent = '';
            return;
        }

        box.textContent = message;
        box.classList.remove('hidden');
    }


    async function fetchJson(url, params) {
        const query = new URLSearchParams(params || {}).toString();
        const response = await fetch(query ? `${url}?${query}` : url, {
            headers: { 'Accept': 'application/json' },
        });

        if (!response.ok) {
            const data = await response.json().catch(() => ({}));
            throw new Error(data.message || 'Gagal memuat data lokasi.');
        }

        return response.json();
    }


    function resetSelect(select, placeholder, disabled = true) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = disabled;
    }


    async function openLokasiDrawer(button, mode = 'baik') {

        if (!canEdit) return;

        showDrawerError('');

        drawerState.detailId = button.dataset.detailId;
        drawerState.mode = mode;
        drawerState.rakCache = [];
        drawerState.binCache = [];

        const namaBarang = button.dataset.namaBarang || '-';

        document.getElementById('drawer-nama-barang').textContent = namaBarang;

        const titleLabel = document.getElementById('drawer-title-label');
        const btnSimpanLabel = document.getElementById('drawer-btn-simpan-label');

        if (mode === 'karantina') {
            if (titleLabel) titleLabel.textContent = 'Alokasi Karantina:';
            if (btnSimpanLabel) btnSimpanLabel.textContent = 'Simpan Bin Karantina';
        } else {
            if (titleLabel) titleLabel.textContent = 'Alokasi Penyimpanan:';
            if (btnSimpanLabel) btnSimpanLabel.textContent = 'Simpan Alokasi Bin';
        }

        document.getElementById('drawer-occupancy-wrap').classList.add('hidden');
        document.getElementById('drawer-bin-isi-wrap').classList.add('hidden');
        btnSimpan.disabled = true;

        resetSelect(selectRak, '-- Pilih Gudang Dahulu --');
        resetSelect(selectRow, '-- Pilih Rak Dahulu --');
        resetSelect(selectBin, '-- Pilih Row Dahulu --');

        drawerOverlay.classList.remove('hidden');

        // Nilai bin yang sedang aktif untuk baris ini (kalau ada), untuk preselect.
        const fieldName = mode === 'karantina' ? 'fk_lokasi_karantina' : 'fk_lokasi_barang';
        const selectClass = mode === 'karantina' ? 'lokasi-karantina-select' : 'lokasi-select';

        const hiddenSelect = document.querySelector(
            `select.${selectClass}[name="details[${drawerState.detailId}][${fieldName}]"]`
        );
        const currentLokasiId = hiddenSelect?.value || null;
        const currentPath = currentLokasiId ? lokasiIndex[currentLokasiId] : null;

        try {

            resetSelect(selectGudang, 'Memuat...', true);

            const gudangs = await fetchJson(lokasiUrls.gudang);

            selectGudang.innerHTML = '<option value="">-- Pilih Gudang --</option>' +
                gudangs.map(g => `<option value="${g.id}">${g.label}</option>`).join('');
            selectGudang.disabled = false;

            if (currentPath?.gudangId) {
                selectGudang.value = currentPath.gudangId;
                await handleGudangChange(currentPath.rakId, currentPath.rowId, currentLokasiId);
            }

        } catch (error) {
            console.error(error);
            showDrawerError(error.message || 'Gagal memuat daftar gudang.');
        }

    }


    function closeLokasiDrawer() {
        drawerOverlay.classList.add('hidden');
    }


    function renderOccupancy(title, stat) {
        const wrap = document.getElementById('drawer-occupancy-wrap');
        wrap.classList.remove('hidden');

        document.getElementById('drawer-occupancy-title').textContent = title;
        document.getElementById('drawer-occupancy-percent').textContent =
            `${stat.occupancy_percent}%`;
        document.getElementById('drawer-occupancy-bar').style.width =
            `${stat.occupancy_percent}%`;
        document.getElementById('drawer-occupancy-terisi').textContent =
            stat.bin_terisi;
        document.getElementById('drawer-occupancy-kosong').textContent =
            stat.bin_kosong;
    }


    async function handleGudangChange(preselectRakId, preselectRowId, preselectBinId) {

        showDrawerError('');
        resetSelect(selectRow, '-- Pilih Rak Dahulu --');
        resetSelect(selectBin, '-- Pilih Row Dahulu --');
        document.getElementById('drawer-occupancy-wrap').classList.add('hidden');
        document.getElementById('drawer-bin-isi-wrap').classList.add('hidden');
        btnSimpan.disabled = true;

        const gudangId = selectGudang.value;

        if (!gudangId) {
            resetSelect(selectRak, '-- Pilih Gudang Dahulu --');
            return;
        }

        try {

            resetSelect(selectRak, 'Memuat...', true);

            const raks = await fetchJson(lokasiUrls.rak, { gudang_id: gudangId });
            drawerState.rakCache = raks;

            if (!raks.length) {
                resetSelect(selectRak, 'Tidak ada rak aktif di gudang ini');
                return;
            }

            selectRak.innerHTML = '<option value="">-- Pilih Rak --</option>' +
                raks.map(r => `<option value="${r.id}">${r.label} (${r.occupancy_percent}% terisi)</option>`).join('');
            selectRak.disabled = false;

            if (preselectRakId) {
                selectRak.value = preselectRakId;
                await handleRakChange(preselectRowId, preselectBinId);
            }

        } catch (error) {
            console.error(error);
            showDrawerError(error.message || 'Gagal memuat daftar rak.');
        }
    }


    async function handleRakChange(preselectRowId, preselectBinId) {

        showDrawerError('');
        resetSelect(selectBin, '-- Pilih Row Dahulu --');
        document.getElementById('drawer-bin-isi-wrap').classList.add('hidden');
        btnSimpan.disabled = true;

        const rakId = selectRak.value;

        if (!rakId) {
            resetSelect(selectRow, '-- Pilih Rak Dahulu --');
            document.getElementById('drawer-occupancy-wrap').classList.add('hidden');
            return;
        }

        const rakStat = drawerState.rakCache.find(r => String(r.id) === String(rakId));
        if (rakStat) {
            renderOccupancy(`Okupansi Rak ${rakStat.label}`, rakStat);
        }

        try {

            resetSelect(selectRow, 'Memuat...', true);

            const rows = await fetchJson(lokasiUrls.row, { rak_id: rakId });

            if (!rows.length) {
                resetSelect(selectRow, 'Tidak ada row aktif di rak ini');
                return;
            }

            selectRow.innerHTML = '<option value="">-- Pilih Row --</option>' +
                rows.map(r => `<option value="${r.id}">${r.label} (${r.bin_kosong} slot kosong)</option>`).join('');
            selectRow.disabled = false;

            if (preselectRowId) {
                selectRow.value = preselectRowId;
                await handleRowChange(preselectBinId);
            }

        } catch (error) {
            console.error(error);
            showDrawerError(error.message || 'Gagal memuat daftar row.');
        }
    }


    async function handleRowChange(preselectBinId) {

        showDrawerError('');
        document.getElementById('drawer-bin-isi-wrap').classList.add('hidden');
        btnSimpan.disabled = true;

        const rowId = selectRow.value;

        if (!rowId) {
            resetSelect(selectBin, '-- Pilih Row Dahulu --');
            return;
        }

        try {

            resetSelect(selectBin, 'Memuat...', true);

            const bins = await fetchJson(lokasiUrls.bin, { row_id: rowId });
            drawerState.binCache = bins;

            if (!bins.length) {
                resetSelect(selectBin, 'Tidak ada bin aktif di row ini');
                return;
            }

            selectBin.innerHTML = '<option value="">-- Pilih Bin --</option>' +
                bins.map(b => `<option value="${b.id}">${b.label}${b.terisi ? ' — Terisi' : ' — Kosong'}</option>`).join('');
            selectBin.disabled = false;

            if (preselectBinId) {
                selectBin.value = preselectBinId;
                handleBinChange();
            }

        } catch (error) {
            console.error(error);
            showDrawerError(error.message || 'Gagal memuat daftar bin.');
        }
    }


    function handleBinChange() {

        const binId = selectBin.value;
        const isiWrap = document.getElementById('drawer-bin-isi-wrap');

        if (!binId) {
            isiWrap.classList.add('hidden');
            btnSimpan.disabled = true;
            return;
        }

        const bin = drawerState.binCache.find(b => String(b.id) === String(binId));

        if (bin?.terisi && bin.isi?.length) {

            const isiText = bin.isi
                .map(i => `${i.nama_barang} (${i.qty} unit)`)
                .join(', ');

            document.getElementById('drawer-bin-isi-text').textContent =
                `Bin ini sudah terisi ${isiText}. Barang baru akan disimpan di bin yang sama.`;

            isiWrap.classList.remove('hidden');

        } else {
            isiWrap.classList.add('hidden');
        }

        btnSimpan.disabled = false;
    }


    function simpanAlokasiBin() {

        const binId = selectBin.value;
        if (!binId || !drawerState.detailId) return;

        const bin = drawerState.binCache.find(b => String(b.id) === String(binId));
        const label = bin?.label || '';
        const isKarantina = drawerState.mode === 'karantina';

        const fieldName = isKarantina ? 'fk_lokasi_karantina' : 'fk_lokasi_barang';
        const selectClass = isKarantina ? 'lokasi-karantina-select' : 'lokasi-select';
        const chipId = isKarantina
            ? `lokasi-karantina-label-${drawerState.detailId}`
            : `lokasi-label-${drawerState.detailId}`;
        const buttonSelector = isKarantina
            ? `.btn-alokasi-karantina[data-detail-id="${drawerState.detailId}"]`
            : `.btn-alokasi[data-detail-id="${drawerState.detailId}"]`;

        const hiddenSelect = document.querySelector(
            `select.${selectClass}[name="details[${drawerState.detailId}][${fieldName}]"]`
        );

        if (hiddenSelect) {
            hiddenSelect.value = binId;
        }

        const chip = document.getElementById(chipId);
        if (chip) {
            chip.classList.remove('text-outline', 'italic', 'text-error/70');
            chip.classList.add(isKarantina ? 'text-error' : 'text-primary');
            if (isKarantina) chip.classList.add('font-label-bold');
            chip.querySelector('.material-symbols-outlined').textContent = 'location_on';
            chip.querySelector('.lokasi-chip-text').textContent = label;
        }

        const button = document.querySelector(buttonSelector);

        if (button) {

            if (isKarantina) {
                button.classList.remove('bg-error', 'hover:bg-error-container', 'text-on-error');
                button.classList.add('bg-surface-container-high', 'hover:bg-surface-container-highest', 'text-on-surface', 'border', 'border-outline-variant');
                button.querySelector('.material-symbols-outlined').textContent = 'edit_location_alt';
                button.lastChild.textContent = ' Ubah Bin Karantina';
            } else {
                button.classList.remove('bg-tertiary', 'hover:bg-tertiary-container', 'text-on-tertiary');
                button.classList.add('bg-surface-container-high', 'hover:bg-surface-container-highest', 'text-on-surface', 'border', 'border-outline-variant');
                button.querySelector('.material-symbols-outlined').textContent = 'edit_location_alt';

                const rejectBadge = document.querySelector(
                    `.btn-alokasi-karantina[data-detail-id="${drawerState.detailId}"]`
                );
                button.lastChild.textContent = rejectBadge ? ' Ubah Rak Baik' : ' Ubah Bin';
            }
        }

        closeLokasiDrawer();
    }


    selectGudang?.addEventListener('change', () => handleGudangChange());
    selectRak?.addEventListener('change', () => handleRakChange());
    selectRow?.addEventListener('change', () => handleRowChange());
    selectBin?.addEventListener('change', handleBinChange);


    /*
    |--------------------------------------------------------------------------
    | UPDATE SUMMARY
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        let totalBaik = 0;
        let totalRusak = 0;
        let totalPo = 0;
        let totalNilaiBaik = 0;

        document.querySelectorAll('[data-detail-row]').forEach(row => {

            const qtyPo = Number(row.dataset.qtyPo || 0);

            const baikInput = row.querySelector('.qty-baik');
            const rusakInput = row.querySelector('.qty-rusak');

            const baik = Math.max(
                0,
                Number(baikInput?.value || 0)
            );

            const rusak = Math.max(
                0,
                Number(rusakInput?.value || 0)
            );

            totalPo += qtyPo;
            totalBaik += baik;
            totalRusak += rusak;

            const selisih = (baik + rusak) - qtyPo;
            const sesuaiFisik = selisih === 0 && rusak === 0;

            /* Status Kesesuaian badge (gabungan selisih + reject) */
            const statusWrap = row.querySelector('.status-kesesuaian');

            if (statusWrap) {

                const badgeClass = sesuaiFisik
                    ? 'bg-primary-fixed text-on-primary-fixed'
                    : 'bg-tertiary-fixed text-on-tertiary-fixed-variant';

                const badgeIcon = sesuaiFisik ? 'check_circle' : 'difference';

                const badgeText = sesuaiFisik
                    ? 'Sesuai Fisik'
                    : `Selisih (${selisih > 0 ? '+' : ''}${selisih} Unit)`;

                let subtext = '';

                if (rusak > 0) {
                    subtext = `<span class="text-[10px] text-error">${rusak} cacat fisik terdeteksi</span>`;
                } else if (!sesuaiFisik) {
                    subtext = `<span class="text-[10px] text-outline">Baik + Rusak − PO</span>`;
                }

                statusWrap.innerHTML = `
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[12px] ${badgeClass}">
                        <span class="material-symbols-outlined text-[15px]">${badgeIcon}</span>
                        ${badgeText}
                    </span>
                    ${subtext}
                `;
            }

            /* Total (Qty Baik x Harga) */
            const totalElement = row.querySelector('.total-value');
            const hargaInput = row.querySelector('.harga-input');

            if (totalElement && hargaInput) {

                const harga = Number(hargaInput.value || 0);
                const total = baik * harga;

                totalElement.textContent =
                    'Rp ' + total.toLocaleString('id-ID');

                const totalSub = row.querySelector('.total-sub');

                if (totalSub) {
                    totalSub.textContent =
                        baik.toLocaleString('id-ID') +
                        ' × Rp ' +
                        harga.toLocaleString('id-ID');
                }

                totalNilaiBaik += total;
            }

            const rejectLabel = row.querySelector('.reject-label');

            if (rejectLabel) {

                rejectLabel.textContent =
                    rusak > 0
                        ? 'Butuh BAP Retur'
                        : 'Nihil';

                rejectLabel.className =
                    'reject-label text-[11px] ' +
                    (rusak > 0
                        ? 'text-error font-label-bold'
                        : 'text-outline-variant italic');
            }

        });


        const totalSelisih = (totalBaik + totalRusak) - totalPo;

        document.getElementById('summary-baik').textContent =
            totalBaik.toLocaleString('id-ID');

        document.getElementById('summary-rusak').textContent =
            totalRusak.toLocaleString('id-ID');

        document.getElementById('summary-selisih').textContent =
            (totalSelisih > 0 ? '+' : '') +
            totalSelisih.toLocaleString('id-ID');

        document.getElementById('footer-baik').textContent =
            totalBaik.toLocaleString('id-ID');

        document.getElementById('footer-rusak').textContent =
            totalRusak.toLocaleString('id-ID');

        const footerTotalNilai =
            document.getElementById('footer-total-nilai');

        if (footerTotalNilai) {
            footerTotalNilai.textContent =
                'Rp ' + totalNilaiBaik.toLocaleString('id-ID');
        }

        const headerTotalNilai =
            document.getElementById('header-total-nilai');

        if (headerTotalNilai) {
            headerTotalNilai.textContent =
                'Total Nilai Diterima: Rp ' + totalNilaiBaik.toLocaleString('id-ID');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | INPUT VALIDATION
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.qty-baik, .qty-rusak').forEach(input => {

        input.addEventListener('input', function () {

            if (Number(this.value) < 0) {
                this.value = 0;
            }

            const row = this.closest('[data-detail-row]');

            if (!row) return;

            const qtyPo = Number(row.dataset.qtyPo || 0);

            const baik =
                Number(row.querySelector('.qty-baik')?.value || 0);

            const rusak =
                Number(row.querySelector('.qty-rusak')?.value || 0);


            if (baik + rusak > qtyPo) {

                this.setCustomValidity(
                    'Qty baik + qty rusak tidak boleh melebihi Qty PO.'
                );

            } else {

                this.setCustomValidity('');

            }

            updateSummary();

        });

    });


    document.querySelectorAll('.harga-input').forEach(input => {

        input.addEventListener('input', function () {

            if (Number(this.value) < 0) {
                this.value = 0;
            }

            updateSummary();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | PHOTO UPLOAD PREVIEW
    |--------------------------------------------------------------------------
    */

    const photoInput = document.getElementById('foto_penerimaan');

    if (photoInput) {

        photoInput.addEventListener('change', function () {

            const files = Array.from(this.files || []);

            if (!files.length) {
                return;
            }

            if (files.length > 5) {

                alert('Maksimal 5 foto yang dapat diunggah dalam satu kali upload.');

                this.value = '';
                clearPhotoSelection();

                return;
            }

            const invalidFile = files.find(file =>
                !['image/jpeg', 'image/png', 'image/webp'].includes(file.type)
            );

            if (invalidFile) {

                alert('Format foto harus JPG, JPEG, PNG, atau WEBP.');
                this.value = '';
                clearPhotoSelection();

                return;
            }

            const tooLarge = files.find(file => file.size > 5 * 1024 * 1024);

            if (tooLarge) {

                alert('Ukuran setiap foto maksimal 5 MB.');
                this.value = '';
                clearPhotoSelection();

                return;
            }

            renderPhotoPreview(files);
            uploadPhotos(files);

        });

    }


    async function uploadPhotos(files) {

        if (!canEdit || !files.length) {
            return;
        }

        const formData = new FormData();

        formData.append(
            '_token',
            document.querySelector('input[name="_token"]').value
        );

        files.forEach(file => {
            formData.append('bukti_dukung[]', file);
        });

        try {

            const response = await fetch(uploadBuktiUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {

                let message = data.message || 'Gagal mengunggah foto.';

                if (data.errors) {
                    const firstError = Object.values(data.errors).flat()[0];
                    if (firstError) {
                        message = firstError;
                    }
                }

                throw new Error(message);
            }

            alert(data.message || 'Bukti pendukung berhasil diupload.');

            window.location.reload();

        } catch (error) {

            console.error(error);

            alert(
                error.message ||
                'Terjadi kesalahan saat mengunggah foto.'
            );

            clearPhotoSelection();
        }

    }


    function renderPhotoPreview(files) {

        const wrapper =
            document.getElementById('photo-preview');

        const grid =
            document.getElementById('photo-preview-grid');

        if (!wrapper || !grid) return;

        grid.innerHTML = '';

        if (!files.length) {

            wrapper.classList.add('hidden');

            return;

        }

        wrapper.classList.remove('hidden');


        files.forEach((file, index) => {

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                const item = document.createElement('div');

                item.className =
                    'relative overflow-hidden rounded-lg border border-outline-variant bg-surface-container';

                item.innerHTML = `
                    <img
                        src="${event.target.result}"
                        alt="Preview foto ${index + 1}"
                        class="w-full h-28 object-cover"
                    >

                    <div class="absolute bottom-0 inset-x-0 px-2 py-1 bg-black/60 text-white text-[10px] truncate">
                        ${file.name}
                    </div>
                `;

                grid.appendChild(item);

            };

            reader.readAsDataURL(file);

        });

    }


    function clearPhotoSelection() {

        if (photoInput) {
            photoInput.value = '';
        }

        const wrapper =
            document.getElementById('photo-preview');

        const grid =
            document.getElementById('photo-preview-grid');

        if (wrapper) {
            wrapper.classList.add('hidden');
        }

        if (grid) {
            grid.innerHTML = '';
        }

    }


    /*
    |--------------------------------------------------------------------------
    | SAVE DRAFT
    |--------------------------------------------------------------------------
    */

    function saveDraft() {

        if (!canEdit) {
            return;
        }

        const formData =
            new FormData(form);

        fetch(saveDraftUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':
                    document.querySelector('input[name="_token"]').value,

                'Accept':
                    'application/json',
            },
            body: formData
        })
        .then(async response => {

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message ||
                    'Gagal menyimpan draft.'
                );
            }

            return data;

        })
        .then(data => {

            alert(
                data.message ||
                'Draft penerimaan berhasil disimpan.'
            );

            window.location.reload();

        })
        .catch(error => {

            console.error(error);

            alert(
                error.message ||
                'Terjadi kesalahan saat menyimpan draft.'
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT FINAL
    |--------------------------------------------------------------------------
    */

    function submitReception() {

        if (!canEdit) {
            return;
        }


        /*
         * Validasi client-side.
         */

        let hasError = false;

        document.querySelectorAll('[data-detail-row]').forEach(row => {

            const qtyPo =
                Number(row.dataset.qtyPo || 0);

            const baik =
                Number(row.querySelector('.qty-baik')?.value || 0);

            const rusak =
                Number(row.querySelector('.qty-rusak')?.value || 0);

            if (baik < 0 || rusak < 0) {

                hasError = true;

            }

            /*
             * Discrepancy boleh.
             * Tetapi baik + rusak tidak boleh melebihi PO.
             */

            if (baik + rusak > qtyPo) {

                hasError = true;

            }

        });


        if (hasError) {

            alert(
                'Periksa kembali Qty Baik dan Qty Rusak. ' +
                'Jumlah Baik + Rusak tidak boleh melebihi Qty PO.'
            );

            return;
        }


        if (!confirm(
            'Submit penerimaan ini ke proses approval Kasubag?\n\n' +
            'Catatan: stok gudang BELUM akan bertambah pada tahap ini. ' +
            'Stok baru diproses setelah approval Direktur.'
        )) {

            return;
        }


        const submitForm =
            document.createElement('form');

        submitForm.method = 'POST';
        submitForm.action = submitUrl;

        const token =
            document.createElement('input');

        token.type = 'hidden';
        token.name = '_token';
        token.value =
            document.querySelector('input[name="_token"]').value;

        submitForm.appendChild(token);


        const formData =
            new FormData(form);

        formData.forEach((value, key) => {

            if (key === '_token') {
                return;
            }

            if (value instanceof File) {

                if (value.name) {

                    const input =
                        document.createElement('input');

                    input.type = 'hidden';
                    input.name = key;

                }

                return;
            }

            const input =
                document.createElement('input');

            input.type = 'hidden';
            input.name = key;
            input.value = value;

            submitForm.appendChild(input);

        });


        document.body.appendChild(submitForm);

        submitForm.submit();

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateSummary();

</script>


@push('head')

<style>

    @media print {

        #page-loading-overlay,
        header,
        aside,
        button,
        a[href],
        #lokasi-drawer-overlay,
        .no-print {
            display: none !important;
        }

        main {
            margin: 0 !important;
            width: 100% !important;
        }

        body {
            overflow: visible !important;
            background: #fff !important;
        }

        .sticky {
            position: static !important;
        }

        input, select, textarea {
            border-color: transparent !important;
            background: transparent !important;
        }

    }

</style>

@endpush

@endsection