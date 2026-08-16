@extends('layouts.app')

@section('title', 'Stock Opname - Material Master')
@section('breadcrumb', 'Stock Opname')

@section('content')
<x-master.shared.page-header
    title="Stock Opname"
    description="Kelola sesi hitung fisik stok per gudang dan bin."
/>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <a href="{{ route('opname.index', ['status' => 'ONGOING']) }}" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Ongoing Opnames</p>
        <p class="text-2xl font-bold">{{ $summary['ongoing'] }}</p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-primary">Lihat detail <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
    <a href="{{ route('opname.index', ['status' => 'ONGOING', 'issue' => 1]) }}" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Discrepancies Found</p>
        <p class="text-2xl font-bold">{{ $summary['discrepancies'] }}</p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-orange-700">Perlu ditinjau <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
    <a href="{{ route('opname.index', ['status' => 'COMPLETED']) }}" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Completed this Month</p>
        <p class="text-2xl font-bold">{{ $summary['completed_this_month'] }}</p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-green-700">Lihat riwayat <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('opname.index')"
        placeholder="Cari kode opname atau gudang..."
        addAction="openOpnameModal()"
        addText="Create New Opname"
        filterName="status"
        filterLabel="Status"
        :filterOptions="[['value' => 'ONGOING', 'label' => 'Ongoing'], ['value' => 'COMPLETED', 'label' => 'Completed']]"
        :extraHidden="[]"
    />
    <x-opname.table :opnames="$opnames" />
    <x-master.shared.pagination :items="$opnames" label="opname" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-opname.create-modal :gudangs="$gudangs" :lokasis="$lokasis" />
@endsection
