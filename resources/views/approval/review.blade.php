@extends('layouts.app')

@section('title', 'Review ' . $po->kd_po . ' - Warehouse Tirta Sago')
@section('breadcrumb', 'Review Persetujuan ' . $config['label'])

@section('content')

<a
    href="{{ route('approval.index', $level) }}"
    class="mb-4 inline-flex items-center gap-1.5 text-sm text-on-surface-variant transition hover:text-primary"
>

    <span class="material-symbols-outlined text-[18px]">
        arrow_back
    </span>

    Kembali ke Antrean Persetujuan {{ $config['label'] }}

</a>


@if($errors->any())

    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>

@endif


<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->

<div class="mb-6 flex flex-wrap items-center gap-3">

    <div>

        <h1 class="text-2xl font-bold text-on-surface">
            Detail Review Permintaan Material
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            #{{ $po->kd_po }}
            &middot;
            Diajukan oleh {{ $po->submittedBy?->name ?? '-' }}
        </p>

    </div>


    <x-master.shared.status-badge
        :status="$po->kode_status"
    />

</div>


<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


    <!-- ========================================================= -->
    <!-- LEFT -->
    <!-- ========================================================= -->

    <div class="space-y-6 lg:col-span-2">


        <!-- ===================================================== -->
        <!-- WORKFLOW TRACKER -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <x-procurement.approval-status :po="$po" with-details />

        </div>


        <!-- ===================================================== -->
        <!-- ITEMS -->
        <!-- ===================================================== -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

            <div class="flex items-center justify-between gap-2 border-b border-outline-variant p-5">

                <div class="flex items-center gap-2">

                    <span class="material-symbols-outlined text-primary">
                        inventory_2
                    </span>

                    <p class="font-bold text-on-surface">
                        Daftar Item Material
                    </p>

                </div>

                <span class="text-sm text-on-surface-variant">
                    {{ $po->details->count() }} item(s)
                </span>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[650px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Item Code
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Nama Barang
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Qty Request
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Stok Saat Ini
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Min Level
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        @forelse($po->details as $item)

                            @php

                                $isLow =
                                    $item->qty_stok_at_request
                                    <=
                                    $item->qty_min_stok_at_request;

                            @endphp


                            <tr class="transition hover:bg-surface-container-low/60">

                                <td class="px-4 py-3 font-bold text-primary">
                                    {{ $item->barang->kd_master_barang }}
                                </td>

                                <td class="px-4 py-3 font-medium text-on-surface">
                                    {{ $item->barang->nm_master_barang }}
                                </td>

                                <td class="px-4 py-3 text-right font-bold text-on-surface">
                                    {{ $item->qty_request }}
                                </td>

                                <td class="px-4 py-3 text-right">

                                    <span
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold
                                        {{
                                            $isLow
                                                ? (
                                                    $item->qty_stok_at_request <= 0
                                                        ? 'bg-red-100 text-red-700'
                                                        : 'bg-amber-100 text-amber-700'
                                                )
                                                : 'bg-surface-container-high text-on-surface-variant'
                                        }}"
                                    >
                                        {{ $item->qty_stok_at_request }}
                                    </span>

                                </td>

                                <td class="px-4 py-3 text-right text-on-surface-variant">
                                    {{ $item->qty_min_stok_at_request }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-4 py-10 text-center text-on-surface-variant"
                                >
                                    Belum ada barang di Purchase Order.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="border-t border-outline-variant bg-surface-container-lowest p-5">

                <p class="mb-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">
                    Justifikasi &amp; Catatan Permintaan
                </p>

                <p class="rounded-lg bg-surface-container-low p-4 text-sm text-on-surface-variant">
                    {{ $po->desc_po ?: '-' }}
                </p>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- RIGHT -->
    <!-- ========================================================= -->

    <div class="space-y-6">


        <!-- ===================================================== -->
        <!-- SUPPLIER -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    storefront
                </span>

                <p class="font-bold text-on-surface">
                    Supplier Details
                </p>

            </div>


            @if($po->supplier)

                <dl class="space-y-3 text-sm">

                    <div>
                        <dt class="text-xs text-on-surface-variant">Company</dt>
                        <dd class="font-medium text-on-surface">{{ $po->supplier->nm_master_supplier }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-on-surface-variant">Kontak / Telepon</dt>
                        <dd class="font-medium text-on-surface">{{ $po->supplier->kontak_supplier ?: '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-on-surface-variant">Address</dt>
                        <dd class="font-medium text-on-surface">{{ $po->supplier->alamat_supplier ?: '-' }}</dd>
                    </div>

                </dl>

            @else

                <p class="text-sm text-on-surface-variant">
                    Belum ada supplier dipilih.
                </p>

            @endif

        </div>


        <!-- ===================================================== -->
        <!-- KEPUTUSAN -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    verified
                </span>

                <p class="font-bold text-on-surface">
                    Keputusan {{ $config['label'] }}
                </p>

            </div>


            @if($po->isPendingAt($level))

                <!-- ============================================= -->
                <!-- MASIH BISA DIPUTUSKAN -->
                <!-- ============================================= -->

                <p class="mb-4 text-sm text-on-surface-variant">
                    Periksa kembali barang dan justifikasi sebelum memberi keputusan.
                </p>


                <form
                    method="POST"
                    action="{{ route('approval.approve', [$level, $po]) }}"
                    onsubmit="return confirm('Approve Purchase Order {{ $po->kd_po }} di tingkat {{ $config['label'] }}?')"
                    class="mb-3"
                >

                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-label-bold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md active:scale-[0.98]"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            check_circle
                        </span>

                        Approve Purchase Order

                    </button>

                </form>


                <form
                    method="POST"
                    action="{{ route('approval.reject', [$level, $po]) }}"
                    onsubmit="return confirm('Kembalikan Purchase Order {{ $po->kd_po }} ke petugas untuk direvisi?')"
                >

                    @csrf

                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                        Catatan / Alasan Revisi
                    </label>

                    <textarea
                        name="reject_note"
                        rows="3"
                        required
                        maxlength="500"
                        placeholder="Tulis alasan penolakan atau revisi yang perlu dilakukan petugas..."
                        class="mb-3 w-full rounded-md border border-outline-variant px-3 py-2 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >{{ old('reject_note') }}</textarea>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-error px-5 py-3 text-sm font-label-bold text-white shadow-sm transition hover:opacity-90 active:scale-[0.98]"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            cancel
                        </span>

                        Reject &amp; Kembalikan ke Petugas

                    </button>

                </form>

            @elseif($po->isApproved())

                <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                    <div class="flex items-center gap-2 text-green-700">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span class="font-bold">Purchase Order Approved</span>
                    </div>

                    <p class="mt-2 text-xs text-green-600">
                        Semua tingkat sudah menyetujui. Purchase Order ini sudah tidak dapat diubah.
                    </p>

                </div>

            @elseif($po->isRejected())

                <div class="rounded-lg border border-red-200 bg-red-50 p-4">

                    <div class="flex items-center gap-2 text-red-700">
                        <span class="material-symbols-outlined">cancel</span>
                        <span class="font-bold">Sudah Ditolak</span>
                    </div>

                    <p class="mt-2 text-xs text-red-600">
                        Purchase Order ini sudah dikembalikan ke petugas untuk direvisi. Lihat catatan di riwayat approval.
                    </p>

                </div>

            @else

                @if($po->hasPassedLevel($level))

                    <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                        <div class="flex items-center gap-2 text-green-700">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span class="font-bold">Sudah Anda Setujui</span>
                        </div>

                        <p class="mt-2 text-xs text-green-600">
                            Anda sudah memberikan persetujuan di tingkat ini sebelumnya dan tidak dapat approve/reject ulang.
                        </p>

                    </div>

                @else

                    <div class="rounded-lg border border-outline-variant bg-surface-container-low p-4">

                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined">hourglass_top</span>
                            <span class="font-bold">Belum Giliran {{ $config['label'] }}</span>
                        </div>

                        <p class="mt-2 text-xs text-on-surface-variant">
                            Purchase Order ini masih menunggu tingkat approval sebelumnya.
                        </p>

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>

@endsection
