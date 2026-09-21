@extends('layouts.app')

@section('title', 'Master Kategori Alasan Kerusakan - Warehouse Tirta Sago')
@section('breadcrumb', 'Kategori Alasan Kerusakan')

@section('content')
<x-master.shared.page-header
    title="Kategori Alasan Kerusakan"
    description="Kelola daftar kategori alasan kerusakan yang muncul sebagai pilihan chip di form pembuatan retur barang."
    icon="emergency"
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('master-alasan-retur.index')"
        placeholder="Cari nama alasan kerusakan..."
        addAction="openAlasanReturModal()"
        addText="Alasan Baru"
        :extraHidden="[]"
    />
    <x-master.alasan-retur.table :alasanList="$alasanList" />
    <x-master.shared.pagination :items="$alasanList" label="alasan kerusakan" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.alasan-retur.modal />
@endsection