@extends('layouts.app')

@section('title', 'Master Barang - Material Master')
@section('breadcrumb', 'Master Barang')

@section('content')
<x-master.shared.page-header
    title="Master Barang"
    description="Kelola data barang, stok, kategori, dan satuan."
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('barang.index')"
        placeholder="Cari kode atau nama barang..."
        addAction="openBarangModal()"
        addText="Barang Baru"
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
@endsection
