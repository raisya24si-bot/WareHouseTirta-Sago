@extends('layouts.app')

@section('title', 'Master Satuan - Warehouse Tirta Sago')
@section('breadcrumb', 'Master Satuan')

@section('content')
<x-master.shared.page-header
    title="Master Satuan"
    description="Kelola kode, nama, deskripsi, dan status satuan barang."
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('master-satuan.index')"
        placeholder="Cari kode atau nama satuan..."
        addAction="openSatuanModal()"
        addText="Satuan Baru"
        :extraHidden="[]"
    />
    <x-master.satuan.table :satuans="$satuans" />
    <x-master.shared.pagination :items="$satuans" label="satuan" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.satuan.modal />
@endsection