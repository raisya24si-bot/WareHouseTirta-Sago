@extends('layouts.app')

@section('title', 'Approval Direktur - Warehouse Tirta Sago')
@section('breadcrumb', 'Penerimaan Barang PO / Approval Direktur')

@section('content')

<div class="relative w-full">
    <div class="absolute -top-10 left-1/4 w-96 h-32 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -top-10 right-10 w-72 h-28 bg-tertiary/10 rounded-full blur-2xl pointer-events-none"></div>
</div>

<div class="flex flex-col gap-base pt-container-padding">

    <nav class="flex items-center gap-stack-sm text-body-sm text-on-surface-variant font-body-sm">
        <a class="hover:text-primary transition-colors" href="#">Inventory</a>
        <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('penerimaan.index') }}">Penerimaan Barang Masuk</a>
        <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
        <span class="font-label-bold text-on-surface">Approval Direktur</span>
    </nav>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-stack-md mt-base">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-bold tracking-wider uppercase">Final Approval</span>
                <span class="text-[12px] text-outline font-sidebar-nav">Direktur Operasional</span>
            </div>
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">Persetujuan Akhir Penerimaan Barang (GRN)</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-2xl mt-1">
                Dokumen di halaman ini sudah lolos verifikasi fisik &amp; alokasi bin oleh petugas gudang.
                Setujui untuk mengunci dokumen dan memperbarui stok gudang secara otomatis, atau tolak untuk
                dikembalikan diperbaiki.
            </p>
        </div>
    </div>

</div>


{{-- =========================================================
    RINGKASAN
========================================================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-stack-md">

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-tertiary-fixed text-on-tertiary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-tertiary/10 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-tertiary-fixed">Menunggu Approval</span>
            <span class="material-symbols-outlined text-[22px] text-tertiary-container">pending_actions</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-tertiary-fixed">{{ number_format($totalMenunggu) }}</div>
            <div class="text-[12px] font-body-sm text-on-tertiary-fixed-variant mt-1 font-medium">Dokumen GRN di antrean Anda</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-primary-fixed text-on-primary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-primary-fixed">Disetujui Bulan Ini</span>
            <span class="material-symbols-outlined text-[22px] text-primary">task_alt</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-primary-fixed">{{ number_format($totalDisetujuiBulanIni) }}</div>
            <div class="text-[12px] font-body-sm text-on-primary-fixed-variant mt-1 font-medium">Stok sudah masuk ke gudang</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-error-container text-on-error-container shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-error/10 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-error-container">Ditolak Bulan Ini</span>
            <span class="material-symbols-outlined text-[22px] text-error">cancel</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-error-container">{{ number_format($totalDitolakBulanIni) }}</div>
            <div class="text-[12px] font-body-sm text-on-error-container/80 mt-1 font-medium">Dikembalikan untuk diperbaiki</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-secondary-fixed text-on-secondary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-secondary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-secondary-fixed">Nilai Menunggu</span>
            <span class="material-symbols-outlined text-[22px] text-secondary">payments</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-[22px] font-bold text-on-secondary-fixed">Rp {{ number_format($nilaiMenunggu, 0, ',', '.') }}</div>
            <div class="text-[12px] font-body-sm text-on-secondary-fixed-variant mt-1 font-medium">Total nilai barang baik di halaman ini</div>
        </div>
    </div>

</div>


{{-- =========================================================
    SEARCH
========================================================== --}}
<div class="mt-stack-md rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

    <div class="p-container-padding border-b border-outline-variant">

        <form method="GET" action="{{ route('penerimaan.approval-direktur.index') }}" class="flex items-center gap-stack-sm">

            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari No. Penerimaan, No. PO, atau nama supplier..."
                    class="w-full h-11 pl-10 pr-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-[13px] focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>

            <button type="submit" class="h-11 px-container-padding rounded-lg bg-primary text-on-primary font-label-bold text-[13px] hover:bg-primary-container transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Cari
            </button>

            @if(request()->hasAny(['search', 'per_page']))
                <a href="{{ route('penerimaan.approval-direktur.index') }}" class="h-11 px-3 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-lowest flex items-center justify-center transition-colors" title="Reset">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                </a>
            @endif

        </form>

    </div>


    {{-- =========================================================
        TABEL
    ========================================================== --}}
    <div class="w-full overflow-x-auto">

        <table class="w-full text-left font-body-sm text-body-sm text-on-surface">

            <thead class="bg-surface-container-low font-label-bold text-label-bold text-on-surface-variant text-[12px] uppercase tracking-wider">
                <tr>
                    <th class="py-3 px-stack-md">No. Penerimaan</th>
                    <th class="py-3 px-stack-md">Disubmit</th>
                    <th class="py-3 px-stack-md">No. PO Ref</th>
                    <th class="py-3 px-stack-md">Supplier</th>
                    <th class="py-3 px-stack-md text-right">Item / Nilai</th>
                    <th class="py-3 px-stack-md">Kondisi</th>
                    <th class="py-3 px-stack-md">Disubmit Oleh</th>
                    <th class="py-3 px-stack-md text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-none">

                @forelse($penerimaans as $penerimaan)

                    @php
                        $supplierName = $penerimaan->po?->supplier?->nm_master_supplier ?? '-';

                        $totalBaik = $penerimaan->details->sum('qty_baik');
                        $totalRusak = $penerimaan->details->sum('qty_rusak');

                        $totalNilai = $penerimaan->details->sum(
                            fn ($detail) => ((int) $detail->qty_baik) * ((float) ($detail->harga_satuan ?? 0))
                        );

                        $belumLokasiBaik = $penerimaan->details->contains(
                            fn ($detail) => (int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang
                        );

                        $belumLokasiKarantina = $penerimaan->details->contains(
                            fn ($detail) => (int) $detail->qty_rusak > 0 && ! $detail->fk_lokasi_karantina
                        );

                        $siapApprove = ! $belumLokasiBaik && ! $belumLokasiKarantina;
                    @endphp

                    <tr class="hover:bg-surface-container-low/60 transition-colors">

                        <td class="py-3.5 px-stack-md">
                            <a href="{{ route('penerimaan.verifikasi', $penerimaan) }}" class="font-label-bold text-primary flex items-center gap-2 hover:underline">
                                <span class="material-symbols-outlined text-[16px] text-outline">description</span>
                                {{ $penerimaan->kd_penerimaan }}
                            </a>
                        </td>

                        <td class="py-3.5 px-stack-md text-on-surface-variant">
                            {{ $penerimaan->submit_at?->format('d M Y') ?? '-' }}
                            <span class="text-[11px] text-outline block">{{ $penerimaan->submit_at?->format('H:i') ?? '-' }} WIB</span>
                        </td>

                        <td class="py-3.5 px-stack-md font-medium text-on-surface">
                            {{ $penerimaan->po?->kd_po ?? '-' }}
                        </td>

                        <td class="py-3.5 px-stack-md">
                            <div class="font-label-bold text-on-surface">{{ $supplierName }}</div>
                            <div class="text-[11px] text-on-surface-variant">{{ $penerimaan->no_sjinv_supplier ?: 'Tanpa No. SJ/Invoice' }}</div>
                        </td>

                        <td class="py-3.5 px-stack-md text-right">
                            <span class="font-label-bold text-primary">Rp {{ number_format($totalNilai, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-on-surface-variant block">
                                {{ $penerimaan->totalSku() }} SKU &bull; {{ number_format($totalBaik) }} baik
                                @if($totalRusak > 0)
                                    &bull; {{ number_format($totalRusak) }} rusak
                                @endif
                            </span>
                        </td>

                        <td class="py-3.5 px-stack-md">
                            @if($siapApprove)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">
                                    <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                    Siap Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-label-bold">
                                    <span class="material-symbols-outlined text-[13px]">warning</span>
                                    Bin Belum Lengkap
                                </span>
                            @endif
                        </td>

                        <td class="py-3.5 px-stack-md">
                            @php $pic = $penerimaan->submittedBy?->name ?? '-'; @endphp
                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">
                                    {{ $pic !== '-' ? strtoupper(substr($pic, 0, 2)) : '--' }}
                                </div>
                                <span class="text-[13px] text-on-surface">{{ $pic }}</span>
                            </div>
                        </td>

                        <td class="py-3.5 px-stack-md text-center">
                            <a
                                href="{{ route('penerimaan.verifikasi', $penerimaan) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] shadow-sm hover:bg-primary-container transition-all"
                            >
                                <span class="material-symbols-outlined text-[14px]">fact_check</span>
                                Review &amp; Approve
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl text-outline mb-2">task_alt</span>
                                <span class="font-label-bold text-on-surface">Tidak ada dokumen menunggu approval</span>
                                <span class="text-sm mt-1">Semua GRN sudah diputuskan. Kerja bagus!</span>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <x-master.shared.pagination :items="$penerimaans" label="dokumen" :per-page="$perPage" />

</div>

@endsection