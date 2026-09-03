@extends('layouts.app')

@section('title', 'Master Kategori - Warehouse Tirta Sago')
@section('breadcrumb', 'Master Kategori')

@section('content')
<x-master.shared.page-header
    title="Master Kategori"
    description="Kelola kode, nama, deskripsi, dan status kategori barang."
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('master-kategori.index')"
        placeholder="Cari kode atau nama kategori..."
        addAction="openKategoriModal()"
        addText="Kategori Baru"
        :extraHidden="[]"
    />
    <x-master.kategori.table :categories="$categories" />
    <x-master.shared.pagination :items="$categories" label="kategori" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.kategori.modal />
@endsection