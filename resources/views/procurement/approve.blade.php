@extends('layouts.app')

@section('title', 'Approve ' . $po->kd_po . ' - Warehouse Tirta Sago')
@section('breadcrumb', 'Approve Purchase Order')

@section('content')

<a
    href="{{ route('procurement.index') }}"
    class="mb-4 inline-flex items-center gap-1.5 text-sm text-on-surface-variant transition hover:text-primary"
>

    <span class="material-symbols-outlined text-[18px]">
        arrow_back
    </span>

    Kembali ke Stock Monitoring & Procurement

</a>


@if(session('success'))

    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

        <div class="flex items-center gap-2">

            <span class="material-symbols-outlined text-[18px]">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    </div>

@endif


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
            Purchase Order
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            {{ $po->kd_po }}
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
        <!-- ITEMS -->
        <!-- ===================================================== -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <div class="flex items-center gap-2 border-b border-outline-variant p-5">

                <span class="material-symbols-outlined text-primary">
                    inventory_2
                </span>

                <p class="font-bold text-on-surface">
                    Purchase Order Items
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[650px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Item Code
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Name
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Current Stock
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Min Level
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Order Qty
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


                                <td class="px-4 py-3 font-medium text-primary">

                                    {{ $item->barang->kd_master_barang }}

                                </td>


                                <td class="px-4 py-3">

                                    {{ $item->barang->nm_master_barang }}

                                </td>


                                <td class="px-4 py-3">

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


                                <td class="px-4 py-3 text-on-surface-variant">

                                    {{ $item->qty_min_stok_at_request }}

                                </td>


                                <td class="px-4 py-3 font-medium">

                                    {{ $item->qty_request }}

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

        </div>


        <!-- ===================================================== -->
        <!-- DESCRIPTION -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <p class="mb-2 font-bold text-on-surface">
                Deskripsi / Alasan
            </p>


            <p class="text-sm text-on-surface-variant">
                {{ $po->desc_po ?: '-' }}
            </p>

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

                        <dt class="text-xs text-on-surface-variant">
                            Company
                        </dt>

                        <dd class="font-medium text-on-surface">
                            {{ $po->supplier->nm_master_supplier }}
                        </dd>

                    </div>


                    <div>

                        <dt class="text-xs text-on-surface-variant">
                            Kontak / Telepon
                        </dt>

                        <dd class="font-medium text-on-surface">
                            {{ $po->supplier->kontak_supplier ?: '-' }}
                        </dd>

                    </div>


                    <div>

                        <dt class="text-xs text-on-surface-variant">
                            Address
                        </dt>

                        <dd class="font-medium text-on-surface">
                            {{ $po->supplier->alamat_supplier ?: '-' }}
                        </dd>

                    </div>

                </dl>

            @else

                <p class="text-sm text-on-surface-variant">
                    Belum ada supplier dipilih.
                </p>

            @endif

        </div>


        <!-- ===================================================== -->
        <!-- APPROVAL -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    verified
                </span>

                <p class="font-bold text-on-surface">
                    Approval
                </p>

            </div>


            @if($po->kode_status === 'APPROVED')

                <!-- ============================================= -->
                <!-- APPROVED -->
                <!-- ============================================= -->

                <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                    <div class="flex items-center gap-2 text-green-700">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span class="font-bold">
                            Purchase Order Approved
                        </span>

                    </div>


                    <p class="mt-2 text-xs text-green-600">
                        Purchase Order ini sudah disetujui dan tidak dapat diedit lagi.
                    </p>

                </div>


            @else

                <!-- ============================================= -->
                <!-- BELUM APPROVED -->
                <!-- ============================================= -->

                <p class="mb-4 text-sm text-on-surface-variant">
                    Periksa kembali barang, supplier, dan jumlah pesanan sebelum menyetujui Purchase Order ini.
                </p>


                <form
                    method="POST"
                    action="{{ route('procurement.approve.submit', $po) }}"
                    onsubmit="return confirm('Apakah kamu yakin ingin menyetujui Purchase Order {{ $po->kd_po }}?')"
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


                <a
                    href="{{ route('procurement.edit', $po) }}"
                    class="mt-2 flex w-full items-center justify-center gap-2 rounded-lg border border-outline-variant px-5 py-3 text-sm font-label-bold text-on-surface-variant transition hover:bg-surface-container-low"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        edit
                    </span>

                    Edit Purchase Order

                </a>

            @endif

        </div>

    </div>

</div>

@endsection