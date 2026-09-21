@extends('layouts.app')

@section('title', 'Stock Monitoring & Procurement - Warehouse Tirta Sago')
@section('breadcrumb', 'Stock Monitoring & Procurement')

@section('content')

<x-master.shared.page-header
    title="Stock Monitoring & Procurement"
    description="Pantau stok kritis dan kelola Purchase Order ke supplier."
    icon="shopping_cart"
/>


<div class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_360px]">

    <!-- ========================================================= -->
    <!-- LEFT -->
    <!-- ========================================================= -->

    <div class="min-w-0 space-y-6">


        <!-- ========================================================= -->
        <!-- STAT CARDS -->
        <!-- ========================================================= -->

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <x-master.shared.stat-card
                label="Out of Stock Items"
                :value="$outOfStockCount"
                icon="production_quantity_limits"
                color="red"
            />

            <x-master.shared.stat-card
                label="Low Stock Alerts"
                :value="$lowStockCount"
                icon="trending_down"
                color="amber"
            />

            <x-master.shared.stat-card
                label="Pending POs"
                :value="$pendingPoCount"
                icon="pending_actions"
                color="primary"
            />

            <x-master.shared.stat-card
                label="Expected Shipments"
                :value="$expectedShipmentCount"
                icon="local_shipping"
                color="green"
            />

        </div>


        <!-- ========================================================= -->
        <!-- CRITICAL STOCK -->
        <!-- ========================================================= -->

        <div id="critical-stock-card">

            @include('procurement.partials.critical-stock')

        </div>


        <!-- ========================================================= -->
        <!-- PURCHASE ORDER -->
        <!-- ========================================================= -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <x-master.shared.crud-toolbar
                :action="route('procurement.index')"
                placeholder="Cari kode PO atau nama supplier..."
                filterName="status"
                filterLabel="Status"
                :filterOptions="[
                    ['value' => 'DRAFT', 'label' => 'Draft'],
                    ['value' => 'PENDING_KASUBAG', 'label' => 'Pending Kasubag'],
                    ['value' => 'PENDING_KABAG', 'label' => 'Pending Kabag'],
                    ['value' => 'PENDING_DIREKTUR', 'label' => 'Pending Direktur'],
                    ['value' => 'APPROVED', 'label' => 'Approved'],
                    ['value' => 'REJECTED', 'label' => 'Rejected'],
                ]"
            />


            <div class="border-t border-outline-variant px-5 py-3">

                <p class="font-bold text-on-surface">
                    Daftar Purchase Order
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[720px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                PO Number
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Supplier Name
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Order Date
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Total Items
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Status
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        @forelse($purchaseOrders as $po)

                            <tr class="transition hover:bg-surface-container-low/60">

                                <td class="px-4 py-3 font-medium text-primary">
                                    {{ $po->kd_po }}
                                </td>


                                <td class="px-4 py-3">
                                    {{ $po->supplier?->nm_master_supplier ?? '-' }}
                                </td>


                                <td class="px-4 py-3 text-on-surface-variant">
                                    <span class="block">{{ $po->created_at?->translatedFormat('d M Y') ?? '-' }}</span>
                                    <span class="block text-xs text-outline">{{ $po->created_at?->format('H:i') ?? '' }}</span>
                                </td>


                                <td class="px-4 py-3">
                                    {{ $po->details->count() }} items
                                </td>


                                <td class="px-4 py-3">

                                    @if($po->kode_status === 'DRAFT')

                                        <x-master.shared.status-badge
                                            :status="$po->kode_status"
                                        />

                                    @else

                                        <x-procurement.approval-status :po="$po" compact class="max-w-[200px]" />

                                    @endif

                                    @if($po->kode_status === 'REJECTED' && $po->reject_note)

                                        <p
                                            class="mt-1 max-w-[220px] truncate text-xs text-red-600"
                                            title="Ditolak oleh {{ $po->reject_level ? ucfirst(strtolower($po->reject_level)) : '' }}: {{ $po->reject_note }}"
                                        >
                                            Ditolak {{ $po->reject_level ? ucfirst(strtolower($po->reject_level)) : '' }}: {{ $po->reject_note }}
                                        </p>

                                    @endif

                                </td>


                                <td class="px-4 py-3">

                                    <div class="flex items-center justify-end gap-1">

                                        @if(in_array($po->kode_status, ['DRAFT', 'REJECTED'], true))

                                            {{-- BISA DIEDIT / DIAJUKAN --}}

                                            <a
                                                href="{{ route('procurement.edit', $po) }}"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="Edit"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    edit
                                                </span>

                                            </a>


                                            <a
                                                href="{{ route('procurement.show', $po) }}"
                                                class="rounded p-1.5 text-outline transition hover:bg-green-100 hover:text-green-700"
                                                title="Lihat Detail & Submit untuk Approval"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    send
                                                </span>

                                            </a>

                                        @else

                                            {{-- SEDANG / SUDAH DIPROSES APPROVAL --}}

                                            <a
                                                href="{{ route('procurement.show', $po) }}"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="View"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility
                                                </span>

                                            </a>

                                        @endif


                                        <!-- DELETE -->

                                        <form
                                            method="POST"
                                            action="{{ route('procurement.destroy', $po) }}"
                                            onsubmit="return confirm('Hapus Purchase Order {{ $po->kd_po }}?')"
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="rounded p-1.5 text-outline transition hover:bg-error/10 hover:text-error"
                                                title="Delete"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    delete
                                                </span>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-4 py-12 text-center text-on-surface-variant"
                                >
                                    Belum ada Purchase Order.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <x-master.shared.pagination
                :items="$purchaseOrders"
                label="purchase order"
                :perPage="$perPage"
            />

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- RIGHT : CURRENT PO DRAFT -->
    <!-- ========================================================= -->

    <div class="xl:sticky xl:top-4 xl:self-start">

        <div id="draft-panel-card">

            @include('procurement.partials.draft-panel')

        </div>

    </div>

</div>

@endsection