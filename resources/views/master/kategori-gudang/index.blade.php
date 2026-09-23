@extends('layouts.app')

@section('title', 'Master Jenis Gudang - Warehouse Tirta Sago')
@section('breadcrumb', 'Jenis Gudang')

@section('content')
<x-master.shared.page-header
    title="Jenis Gudang"
    description="Kelola daftar jenis/kategori gudang (Storage, Transit, Rejected, dsb) yang bisa dipilih saat membuat gudang baru."
    icon="warehouse"
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('master-kategori-gudang.index')"
        placeholder="Cari jenis gudang..."
        addAction="openKategoriGudangModal()"
        addText="Jenis Baru"
        :extraHidden="[]"
    />
    <x-master.kategori-gudang.table :kategoriList="$kategoriList" />
    <x-master.shared.pagination :items="$kategoriList" label="jenis gudang" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.kategori-gudang.modal />
@endsection