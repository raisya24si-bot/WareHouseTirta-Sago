@extends('layouts.app')

@section('title', $opname->kd_opname . ' - Actual Stok - Material Master')
@section('breadcrumb', 'Stock Opname')

@section('content')
<style>
    @media print {
        aside, header, #opname-print-hide, nav, .no-print { display: none !important; }
        main, body { padding: 0 !important; margin: 0 !important; }
        input { border: none !important; }
    }
</style>
<div class="mb-6">
    <a href="{{ route('opname.index') }}" class="mb-2 inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke daftar opname
    </a>
    <div class="flex items-center gap-3">
        <h1 class="text-display-lg font-display-lg text-on-surface leading-tight">{{ $opname->kd_opname }}</h1>
        <x-master.shared.status-badge :status="$opname->status_opname" />
    </div>
    <p class="mt-1 flex items-center gap-1 text-body-lg text-on-surface-variant">
        <span class="material-symbols-outlined text-[18px]">location_on</span>
        {{ $opname->gudang?->nm_gudang ?? '-' }} &middot; Mulai {{ $opname->tgl_mulai?->format('d M Y') }}
        @if($opname->tgl_selesai) &middot; Selesai {{ $opname->tgl_selesai->format('d M Y') }} @endif
    </p>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Barang di Opname</p>
        <p class="text-2xl font-bold">{{ $totalItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Cocok</p>
        <p class="text-2xl font-bold">{{ $countedItems - $selisihItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Tidak Cocok</p>
        <p class="text-2xl font-bold">{{ $selisihItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
            <span class="material-symbols-outlined">more_horiz</span>
        </div>
        <p class="text-sm text-on-surface-variant">Belum di Opname</p>
        <p class="text-2xl font-bold">{{ $totalItems - $countedItems }}</p>
        <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-surface-container-high">
            <div class="h-1.5 rounded-full bg-primary" style="width: {{ $progress }}%"></div>
        </div>
        <p class="mt-1 text-xs text-on-surface-variant">{{ $progress }}% Completed</p>
    </div>
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <div class="no-print flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low/50 p-4">
        <x-master.shared.search-filter
            :action="route('opname.show', $opname)"
            placeholder="Search bin or material..."
            filterName="bin"
            filterLabel="Bin"
            :filterOptions="$bins->map(fn($b) => ['value' => $b->id_lokasi, 'label' => $b->bin])->all()"
        />
        <div class="flex items-center gap-2">
            @if($selectedBin)
                <form method="POST" action="{{ route('opname.delete-bin', [$opname, $selectedBin]) }}" onsubmit="return confirm('Keluarkan bin {{ $selectedBin->bin }} dari opname ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        @disabled(!$selectedBinCanDelete)
                        title="{{ $selectedBinCanDelete ? 'Keluarkan bin ini dari opname' : 'Masih ada barang yang sudah dihitung di bin ini' }}"
                        class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-error hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent">
                        <span class="material-symbols-outlined text-[19px]">delete</span>
                        Hapus Bin Ini
                    </button>
                </form>
            @endif
            <button type="button" onclick="openAddItemModal()" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-primary hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[19px]">add</span>
                Tambah Barang
            </button>
        </div>
    </div>

    <form id="opname-detail-form" method="POST" action="{{ route('opname.update', $opname) }}">
        @csrf
        @method('PUT')
    </form>

    <x-opname.detail-table :details="$details" :emptyBins="$emptyBins" :opname="$opname" />

    <div class="flex flex-col gap-3 border-t border-outline-variant bg-surface-container-low px-4 py-3 sm:flex-row sm:items-center sm:justify-between" id="opname-print-hide">
        <div class="text-sm text-on-surface-variant">
            Showing {{ $details->count() }} of {{ $totalItems }} Items | Progress: {{ $countedItems }}/{{ $totalItems }} ({{ $progress }}%)
            <div class="mt-1 h-1.5 w-48 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-1.5 rounded-full bg-primary" style="width: {{ $progress }}%"></div>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="submit" form="opname-detail-form" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-primary hover:bg-surface-container-lowest">
                <span class="material-symbols-outlined text-[19px]">save</span>
                Save Progress
            </button>
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-on-surface hover:bg-surface-container-lowest">
                <span class="material-symbols-outlined text-[19px]">print</span>
                Print
            </button>
           @if($opname->status_opname === 'ONGOING')
            <form
                method="POST"
                action="{{ route('opname.submit-adjustment', $opname) }}"
                onsubmit="return confirm('Submit adjustment? Setelah disubmit, stok resmi pada tbl_stok_lokasi akan diperbarui dan opname tidak dapat diedit lagi.')"
            >
                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-body-sm font-label-bold text-on-primary shadow-sm hover:bg-primary-container"
                >
                    <span class="material-symbols-outlined text-[19px]">
                        check_circle
                    </span>

                    Submit Adjustment
                </button>
            </form>
        @else
            <span
                class="inline-flex items-center gap-2 rounded-md bg-gray-100 px-5 py-2.5 text-body-sm font-label-bold text-gray-600"
            >
                <span class="material-symbols-outlined text-[19px]">
                    check_circle
                </span>

                Opname Completed
            </span>
        @endif
        </div>
    </div>

    <div class="no-print">
        <x-master.shared.pagination :items="$details" label="item" :perPage="$perPage" />
    </div>
</div>
@endsection

@section('modals')
<x-opname.add-item-modal :opname="$opname" :bins="$bins" :allBarangs="$allBarangs" />
<x-opname.edit-item-modal :opname="$opname" />
@endsection

@push('scripts')
<script>
function opnameDetailRecalc(id) {

    const actualInput =
        document.querySelector(
            `input[name="detail[${id}][actual]"]`
        );

    const baikInput =
        document.getElementById(
            'baik-' + id
        );

    const rusakInput =
        document.getElementById(
            'rusak-' + id
        );

    const diffEl =
        document.getElementById(
            'detail-diff-' + id
        );

    const sistem =
        Number(actualInput.dataset.sistem);

    const actual =
        actualInput.value === ''
            ? null
            : Number(actualInput.value);

    const baik =
        baikInput.value === ''
            ? 0
            : Number(baikInput.value);

    const rusak =
        rusakInput.value === ''
            ? 0
            : Number(rusakInput.value);

    if (actual === null) {

        diffEl.textContent = '--';

        diffEl.className =
            'font-label-bold text-on-surface-variant';

        return;
    }

    const diff =
        actual - sistem;

    diffEl.textContent =
        diff > 0
            ? '+' + diff
            : String(diff);

    diffEl.className =
        'font-label-bold ' +
        (
            diff === 0
                ? 'text-green-700'
                : 'text-error'
        );

    /*
    |--------------------------------------------------------------------------
    | Validasi Actual = Baik + Rusak
    |--------------------------------------------------------------------------
    */

    const total =
        baik + rusak;

    if (total !== actual) {

        actualInput.classList.add(
            'border-error'
        );

        baikInput.classList.add(
            'border-error'
        );

        rusakInput.classList.add(
            'border-error'
        );

    } else {

        actualInput.classList.remove(
            'border-error'
        );

        baikInput.classList.remove(
            'border-error'
        );

        rusakInput.classList.remove(
            'border-error'
        );
    }
}
</script>
@endpush

