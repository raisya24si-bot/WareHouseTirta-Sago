@extends('layouts.app')

@section('title', 'Master Barang - Warehouse Tirta Sago')
@section('breadcrumb', 'Master Barang')

@section('content')
<x-master.shared.page-header
    title="Master Barang"
    description="Kelola data barang, stok, kategori, dan satuan."
    icon="inventory_2"
/>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-master.shared.stat-card
        label="Total Barang"
        :value="$summary['total']"
        icon="inventory_2"
        color="primary"
    />
    <x-master.shared.stat-card
        label="Stok Menipis"
        :value="$summary['menipis']"
        icon="trending_down"
        color="amber"
    />
    <x-master.shared.stat-card
        label="Stok Habis"
        :value="$summary['habis']"
        icon="production_quantity_limits"
        color="red"
    />
    <x-master.shared.stat-card
        label="Kategori Aktif"
        :value="$summary['kategori']"
        icon="category"
        color="green"
    />
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('barang.index')"
        placeholder="Cari kode atau nama barang..."
        addAction="openBarangModal()"
        addText="Barang Baru"
        secondaryAction="openImportBarangModal()"
        secondaryText="Import CSV"
        secondaryIcon="upload_file"
        filterName="fk_kategori"
        filterLabel="Kategori"
        :filterOptions="$categories->map(fn($category) => ['value' => $category->id_master_kategori, 'label' => $category->nm_master_kategori])->all()"
        :extraHidden="[]"
    />
    <x-master.barang.table :barangs="$barangs" />
    <x-master.shared.pagination :items="$barangs" label="barang" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.barang.modal :categories="$categories" :satuans="$satuans" />
<x-master.barang.import-modal />
@endsection