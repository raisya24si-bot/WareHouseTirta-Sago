@extends('layouts.app')

@section('title', 'Detail Retur '.$retur->kd_retur.' - Warehouse Tirta Sago')
@section('breadcrumb', 'Detail Retur Barang')

@section('content')

@php
    $badgeMap = [
        'DRAFT' => 'bg-surface-container-high text-on-surface-variant',
        'MENUNGGU_RESPON_VENDOR' => 'bg-tertiary-fixed text-on-tertiary-fixed',
        'PROSES_KIRIM_GANTI' => 'bg-primary-fixed text-on-primary-fixed',
        'SELESAI' => 'bg-surface-container text-on-surface',
    ];
    $badge = $badgeMap[$retur->kode_status] ?? 'bg-surface-container text-on-surface-variant';
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant py-stack-md">
        <a class="hover:text-primary transition-colors" href="{{ route('retur.index') }}">Retur Barang Masuk</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">{{ $retur->kd_retur }}</span>
    </nav>

    @if(session('success'))
        <div class="p-stack-md rounded-lg bg-primary-fixed text-on-primary-fixed text-[13px] font-label-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">{{ $retur->kd_retur }}</h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full {{ $badge }} text-[12px] font-label-bold">
                    {{ $retur->statusRetur?->nm_status_retur }}
                </span>
            </div>
            <p class="text-[13px] text-on-surface-variant">
                Dari GRN <strong class="font-mono">{{ $retur->penerimaanBarang?->kd_penerimaan }}</strong>
                — PO <strong class="font-mono">{{ $retur->penerimaanBarang?->po?->kd_po }}</strong>
                — Supplier <strong>{{ $retur->supplier?->nm_master_supplier ?? '-' }}</strong>
            </p>
        </div>
        <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm" type="button">
            <span class="material-symbols-outlined text-[18px]">print</span>
            Cetak BAP PDF
        </button>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Tanggal Retur</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $retur->tgl_retur?->translatedFormat('d M Y') }}</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Total Item Reject</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $retur->totalItemReject() }} Unit ({{ $retur->details->count() }} SKU)</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Nilai Total Retur</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">Rp {{ number_format($retur->nilai_total_retur, 0, ',', '.') }}</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Resi / Ekspedisi</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">{{ $retur->no_resi_pengiriman ?? '-' }} @if($retur->nm_ekspedisi) ({{ $retur->nm_ekspedisi }}) @endif</div>
        </div>
    </div>

    @if($retur->catatan_retur)
        <div class="bg-surface-container-low p-stack-md rounded-xl text-[13px] text-on-surface-variant">
            <strong class="text-on-surface">Catatan:</strong> {{ $retur->catatan_retur }}
        </div>
    @endif

    {{-- Detail item --}}
    <div class="flex flex-col gap-stack-sm">
        <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Item yang Diretur</span>

        @foreach($retur->details as $detail)
            <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col gap-stack-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b">
                    <div class="flex flex-col">
                        <span class="font-label-bold text-body-sm text-on-surface">{{ $detail->barang?->nm_master_barang }}</span>
                        <span class="text-[11px] text-outline">Qty Reject QC: {{ $detail->qty_reject_qc }} — Qty Diretur: <strong class="text-error">{{ $detail->qty_diretur }}</strong></span>
                    </div>
                    <span class="font-label-bold text-on-surface text-[14px]">Rp {{ number_format($detail->subtotal_retur, 0, ',', '.') }}</span>
                </div>

                <div class="flex flex-wrap gap-1.5">
                    @foreach($detail->alasan as $alasan)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-bold text-[11px]">
                            <span class="material-symbols-outlined text-[13px]">check_circle</span>
                            {{ $alasan->nm_alasan_retur }}
                        </span>
                    @endforeach
                </div>

                @if($detail->catatan_detail)
                    <p class="text-[12px] text-on-surface-variant">{{ $detail->catatan_detail }}</p>
                @endif

                @if($detail->fotos->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($detail->fotos as $foto)
                            <a href="{{ $foto->url }}" target="_blank" class="block w-20 h-20 rounded-lg overflow-hidden border border-surface-container-high">
                                <img src="{{ $foto->url }}" alt="{{ $foto->nama_file }}" class="w-full h-full object-cover">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

@endsection