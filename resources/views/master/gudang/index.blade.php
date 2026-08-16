@extends('layouts.app')

@section('title', 'Master Gudang - Material Master')
@section('breadcrumb', 'Master Gudang')

@section('content')
<x-master.shared.page-header
    title="Master Gudang"
    description="Kelola gudang dan struktur lokasi penyimpanan."
/>

<x-master.gudang.tabs :tab="$tab" />

<div class="mt-8">
    @if($tab === 'gudang')
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <x-master.shared.crud-toolbar
                :action="route('master-gudang.index')"
                placeholder="Cari kode atau nama gudang..."
                addAction="openGudangModal()"
                addText="Gudang Baru"
                filterName="status"
                filterLabel="Status"
                :filterOptions="$statuses->map(fn($s) => ['value' => $s->id_status_gudang, 'label' => $s->nm_status_gudang])->all()"
                :extraHidden="['tab' => 'gudang']"
            />
            <x-master.gudang.gudang-table :gudangs="$gudangs" />
            <x-master.shared.pagination :items="$gudangs" label="gudang" :perPage="$perPage" />
        </div>
    @elseif($tab === 'rak')
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <x-master.shared.crud-toolbar
                :action="route('master-gudang.index')"
                placeholder="Cari kode rak atau gudang..."
                addAction="openRakModal()"
                addText="Rak Baru"
                :extraHidden="['tab' => 'rak']"
            />
            <x-master.gudang.rak-table :raks="$raks" />
            <x-master.shared.pagination :items="$raks" label="rak" :perPage="$perPage" />
        </div>
    @elseif($tab === 'row')
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <x-master.shared.crud-toolbar
                :action="route('master-gudang.index')"
                placeholder="Cari kode row atau rak..."
                addAction="openRowModal()"
                addText="Row Baru"
                :extraHidden="['tab' => 'row']"
            />
            <x-master.gudang.row-table :rows="$rows" />
            <x-master.shared.pagination :items="$rows" label="row" :perPage="$perPage" />
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <x-master.shared.crud-toolbar
                :action="route('master-gudang.index')"
                placeholder="Cari kode lokasi atau bin..."
                addAction="openLokasiModal()"
                addText="Lokasi Baru"
                :extraHidden="['tab' => 'lokasi']"
            />
            <x-master.gudang.lokasi-table :lokasis="$lokasis" />
            <x-master.shared.pagination :items="$lokasis" label="lokasi" :perPage="$perPage" />
        </div>
    @endif
</div>
@endsection

@section('modals')
    <x-master.gudang.gudang-modal :statuses="$statuses" />
    <x-master.gudang.rak-modal :gudangs="$allGudangs" />
    <x-master.gudang.row-modal :raks="$allRaks" />
    <x-master.gudang.lokasi-modal :raks="$allRaks" :rows="$allRows" />
@endsection