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

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

            <div class="flex items-center justify-between border-b border-outline-variant px-5 py-4">

                <p class="font-bold text-on-surface">
                    Critical Stock Action List
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[720px] text-left text-sm">

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
                                Minimal Stock
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Recommended Order
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        @forelse($criticalItems as $row)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | BARANG ID
                                |--------------------------------------------------------------------------
                                */

                                $barangId =
                                    $row->barang->id_master_barang;


                                /*
                                |--------------------------------------------------------------------------
                                | CEK CURRENT PO DRAFT
                                |--------------------------------------------------------------------------
                                */

                                $alreadyInCart =
                                    $cartItems->contains(
                                        fn ($c) =>
                                            $c->barang->id_master_barang ===
                                            $barangId
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | CEK PO YANG SUDAH ADA
                                |--------------------------------------------------------------------------
                                |
                                | Kalau barang sudah masuk PO aktif,
                                | ambil nomor PO-nya.
                                |
                                */

                                $existingPoNumber =
                                    $poPerBarang[$barangId]
                                    ?? null;

                            @endphp


                            <tr class="transition hover:bg-surface-container-low/60">

                                <td class="px-4 py-3 font-medium text-primary">
                                    {{ $row->barang->kd_master_barang }}
                                </td>


                                <td class="px-4 py-3">
                                    {{ $row->barang->nm_master_barang }}
                                </td>


                                <td class="px-4 py-3">

                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-bold
                                        {{
                                            $row->current_stock <= 0
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-amber-100 text-amber-700'
                                        }}"
                                    >

                                        {{ $row->current_stock }} unit

                                    </span>

                                </td>


                                <td class="px-4 py-3 text-on-surface-variant">
                                    {{ $row->minimum_stock }} unit
                                </td>


                                <td class="px-4 py-3 font-medium">
                                    {{ $row->recommended_order }} unit
                                </td>


                                <!-- ================================================= -->
                                <!-- ACTION -->
                                <!-- ================================================= -->

                                <td class="px-4 py-3 text-right">

                                    @if($existingPoNumber)

                                        {{-- ================================================= --}}
                                        {{-- SUDAH ADA DI PO --}}
                                        {{-- ================================================= --}}

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700"
                                            title="Barang sudah masuk ke Purchase Order"
                                        >

                                            <span class="material-symbols-outlined text-[16px]">
                                                check_circle
                                            </span>

                                            {{ $existingPoNumber }}

                                        </span>


                                    @elseif($alreadyInCart)

                                        {{-- ================================================= --}}
                                        {{-- MASIH ADA DI CURRENT PO DRAFT --}}
                                        {{-- ================================================= --}}

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md bg-primary/10 px-3 py-1.5 text-xs font-medium text-primary"
                                            title="Barang sudah ditambahkan ke draft PO"
                                        >

                                            <span class="material-symbols-outlined text-[16px]">
                                                check
                                            </span>

                                            Added

                                        </span>


                                    @else

                                        {{-- ================================================= --}}
                                        {{-- BELUM ADA PO --}}
                                        {{-- ================================================= --}}

                                        <form
                                            method="POST"
                                            action="{{ route('procurement.draft.add-item') }}"
                                            data-no-loading
                                        >

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="fk_barang"
                                                value="{{ $row->barang->id_master_barang }}"
                                            >


                                            <input
                                                type="hidden"
                                                name="qty"
                                                value="{{ $row->recommended_order > 0 ? $row->recommended_order : 1 }}"
                                            >


                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-md border border-primary/30 bg-primary/5 px-3 py-1.5 text-xs font-medium text-primary transition hover:bg-primary/10"
                                            >

                                                <span class="material-symbols-outlined text-[16px]">
                                                    add_shopping_cart
                                                </span>

                                                Add to PO

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-4 py-12 text-center text-on-surface-variant"
                                >
                                    Semua stok barang aman, nggak ada yang di bawah minimal stock. 🎉
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

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

                                    <x-master.shared.status-badge
                                        :status="$po->kode_status"
                                    />

                                </td>


                                <td class="px-4 py-3">

                                    <div class="flex items-center justify-end gap-1">

                                        @if($po->kode_status === 'APPROVED')

                                            {{-- APPROVED --}}

                                            <a
                                                href="{{ route('procurement.approve', $po) }}"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="View"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility
                                                </span>

                                            </a>

                                        @else

                                            {{-- BELUM APPROVED --}}

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
                                                href="{{ route('procurement.approve', $po) }}"
                                                class="rounded p-1.5 text-outline transition hover:bg-green-100 hover:text-green-700"
                                                title="Approve"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    check_circle
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

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <div class="flex items-center gap-2 border-b border-outline-variant px-5 py-4">

                <span class="material-symbols-outlined text-primary">
                    shopping_cart
                </span>

                <p class="font-bold text-on-surface">
                    Current PO Draft
                </p>

            </div>


            <div class="p-5">

                @if($errors->has('draft'))

                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
                        {{ $errors->first('draft') }}
                    </div>

                @endif


                @if(session('success'))

                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700">
                        {{ session('success') }}
                    </div>

                @endif


                <!-- SUPPLIER FORM -->

                <form
                    method="POST"
                    action="{{ route('procurement.draft.set-supplier') }}"
                    id="draft-supplier-form"
                    class="mb-5 space-y-3"
                    data-no-loading
                >

                    @csrf


                    <div>

                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                            Select Supplier
                        </label>


                        <select
                            name="fk_supplier"
                            onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                            class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >

                            <option value="">
                                -- Pilih Supplier --
                            </option>


                            @foreach($suppliers as $supplier)

                                <option
                                    value="{{ $supplier->id_master_supplier }}"
                                    {{ $cartSupplier?->id_master_supplier === $supplier->id_master_supplier ? 'selected' : '' }}
                                >
                                    {{ $supplier->nm_master_supplier }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                            Deskripsi / Alasan (opsional)
                        </label>


                        <input
                            type="text"
                            name="desc_po"
                            maxlength="100"
                            value="{{ $cart['desc_po'] ?? '' }}"
                            onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                            placeholder="Contoh: Restock kebutuhan proyek Line 3"
                            class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >

                    </div>

                </form>


                <p class="mb-2 text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Items ({{ $cartItems->count() }})
                </p>


                @if($cartItems->isEmpty())

                    <div class="flex flex-col items-center rounded-lg border border-dashed border-outline-variant py-10 text-center">

                        <span class="material-symbols-outlined text-[32px] text-outline-variant">
                            shopping_cart
                        </span>

                        <p class="mt-2 px-4 text-xs text-on-surface-variant">
                            Add items from the critical stock list to build your purchase order.
                        </p>

                    </div>

                @else

                    <div class="space-y-2">

                        @foreach($cartItems as $item)

                            <div class="rounded-lg border border-outline-variant p-3">

                                <div class="mb-2 flex items-start justify-between gap-2">

                                    <div class="min-w-0">

                                        <p class="truncate text-xs font-bold text-on-surface">
                                            {{ $item->barang->kd_master_barang }}
                                        </p>

                                        <p class="truncate text-sm text-on-surface-variant">
                                            {{ $item->barang->nm_master_barang }}
                                        </p>

                                    </div>


                                    <form
                                        method="POST"
                                        action="{{ route('procurement.draft.remove-item', $item->barang) }}"
                                        data-no-loading
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="text-outline transition hover:text-error"
                                            title="Hapus"
                                        >

                                            <span class="material-symbols-outlined text-[18px]">
                                                close
                                            </span>

                                        </button>

                                    </form>

                                </div>


                                <form
                                    method="POST"
                                    action="{{ route('procurement.draft.update-item', $item->barang) }}"
                                    class="flex items-center gap-2"
                                    data-no-loading
                                >

                                    @csrf
                                    @method('PUT')


                                    <span class="text-xs text-on-surface-variant">
                                        Qty:
                                    </span>


                                    <div class="flex items-center rounded-md border border-outline-variant">

                                        <button
                                            type="button"
                                            onclick="this.nextElementSibling.stepDown(); this.closest('form').requestSubmit();"
                                            class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                        >
                                            -
                                        </button>


                                        <input
                                            type="number"
                                            name="qty"
                                            value="{{ $item->qty }}"
                                            min="1"
                                            onchange="this.closest('form').requestSubmit()"
                                            class="w-14 border-none bg-transparent px-1 py-1 text-center text-sm focus:ring-0"
                                        >


                                        <button
                                            type="button"
                                            onclick="this.previousElementSibling.stepUp(); this.closest('form').requestSubmit();"
                                            class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                        >
                                            +
                                        </button>

                                    </div>

                                </form>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>


            <div class="border-t border-outline-variant p-5">

                <div class="mb-3 flex items-center justify-between text-sm">

                    <span class="text-on-surface-variant">
                        Total Items:
                    </span>

                    <span class="font-bold text-on-surface">
                        {{ $cartItems->count() }}
                    </span>

                </div>


                <form
                    method="POST"
                    action="{{ route('procurement.draft.create') }}"
                >

                    @csrf


                    <button
                        type="submit"
                        {{ $cartItems->isEmpty() ? 'disabled' : '' }}
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            send
                        </span>

                        Create Purchase Order

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection