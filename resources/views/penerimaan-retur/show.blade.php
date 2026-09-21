@extends('layouts.app')

@section('title', 'Detail Penerimaan Retur '.$penerimaan->kd_penerimaan_retur.' - Warehouse Tirta Sago')
@section('breadcrumb', 'Detail Penerimaan Retur')

@section('content')

@php
    $badgeMap = [
        'MENUNGGU_KEDATANGAN' => 'bg-tertiary-fixed text-on-tertiary-fixed',
        'PROSES_QC' => 'bg-primary-fixed text-on-primary-fixed',
        'SELESAI' => 'bg-surface-container text-on-surface',
    ];
    $badge = $badgeMap[$penerimaan->kode_status] ?? 'bg-surface-container text-on-surface-variant';
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant py-stack-md">
        <a class="hover:text-primary transition-colors" href="{{ route('penerimaan-retur.index') }}">Penerimaan Barang Pengganti Retur</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">{{ $penerimaan->kd_penerimaan_retur }}</span>
    </nav>

    @if(session('success'))
        <div class="p-stack-md rounded-lg bg-primary-fixed text-on-primary-fixed text-[13px] font-label-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">{{ $penerimaan->kd_penerimaan_retur }}</h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full {{ $badge }} text-[12px] font-label-bold">
                    {{ $penerimaan->statusPenerimaanRetur?->nm_status_penerimaan_retur }}
                </span>
            </div>
            <p class="text-[13px] text-on-surface-variant">
                BAP Retur Asal <strong class="font-mono">{{ $penerimaan->returBarang?->kd_retur }}</strong>
                — GRN <strong class="font-mono">{{ $penerimaan->returBarang?->penerimaanBarang?->kd_penerimaan }}</strong>
                — Supplier <strong>{{ $penerimaan->supplier?->nm_master_supplier ?? '-' }}</strong>
            </p>
        </div>
        <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm" type="button">
            <span class="material-symbols-outlined text-[18px]">print</span>
            Cetak Berita Acara
        </button>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">No. Surat Jalan Supplier</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1 font-mono">{{ $penerimaan->no_sj_supplier }}</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Waktu Tiba di Dock</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $penerimaan->waktu_tiba_dock?->translatedFormat('d M Y, H:i') ?? '-' }}</div>
            <div class="text-[11px] text-outline">{{ $penerimaan->dock_number ?? '-' }}</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Total Barang Tiba</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $penerimaan->totalQtyTiba() }} Unit ({{ $penerimaan->details->count() }} SKU)</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Petugas Penerima / QC</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $penerimaan->submittedBy?->name ?? '-' }}</div>
        </div>
    </div>

    @if($penerimaan->catatan_verifikasi)
        <div class="bg-surface-container-low p-stack-md rounded-xl text-[13px] text-on-surface-variant">
            <strong class="text-on-surface">Catatan Verifikasi:</strong> {{ $penerimaan->catatan_verifikasi }}
        </div>
    @endif

    {{-- Detail item --}}
    <div class="flex flex-col gap-stack-sm">
        <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Item Barang Pengganti</span>

        @foreach($penerimaan->details as $detail)
            <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col gap-stack-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b">
                    <div class="flex flex-col">
                        <span class="font-label-bold text-body-sm text-on-surface">{{ $detail->barang?->nm_master_barang }}</span>
                        <span class="text-[11px] text-outline">Qty Diklaim: {{ $detail->qty_diklaim }} — Qty Tiba: <strong class="text-primary">{{ $detail->qty_tiba }}</strong></span>
                    </div>
                    <span class="font-mono text-[12px] text-on-surface">{{ $detail->binTujuan?->kd_lokasi }} ({{ $detail->binTujuan?->row?->rak?->gudang?->nm_gudang }})</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection