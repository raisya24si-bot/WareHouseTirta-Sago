@extends('layouts.app')

@section('title', 'Master Supplier - Material Master')
@section('breadcrumb', 'Master Supplier')

@section('content')
<x-master.shared.page-header
    title="Master Supplier"
    description="Kelola data supplier barang dan statusnya."
/>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <x-master.shared.crud-toolbar
        :action="route('master-supplier.index')"
        placeholder="Cari kode, nama, atau kontak supplier..."
        addAction="openSupplierModal()"
        addText="Supplier Baru"
        filterName="status"
        filterLabel="Status"
        :filterOptions="[['value' => 'AKTIF', 'label' => 'AKTIF'], ['value' => 'TIDAK AKTIF', 'label' => 'TIDAK AKTIF']]"
        :extraHidden="[]"
    />
    <x-master.supplier.table :suppliers="$suppliers" />
    <x-master.shared.pagination :items="$suppliers" label="supplier" :perPage="$perPage" />
</div>
@endsection

@section('modals')
<x-master.supplier.modal />
@endsection
