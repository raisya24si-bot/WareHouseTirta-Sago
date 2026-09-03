@extends('layouts.app')

@section('title', $opname->kd_opname . ' - Actual Stok - Warehouse Tirta Sago')
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
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Barang di Opname</p>
        <p class="text-2xl font-bold">{{ $totalItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Cocok</p>
        <p class="text-2xl font-bold text-green-700 transition-all" id="stat-cocok">{{ $countedItems - $selisihItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Tidak Cocok</p>
        <p class="text-2xl font-bold text-orange-700 transition-all" id="stat-tidak-cocok">{{ $selisihItems }}</p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
            <span class="material-symbols-outlined">more_horiz</span>
        </div>
        <p class="text-sm text-on-surface-variant">Belum di Opname</p>
        <p class="text-2xl font-bold transition-all" id="stat-belum">{{ $totalItems - $countedItems }}</p>
        <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-surface-container-high">
            <div class="h-1.5 rounded-full bg-primary transition-all duration-300" id="stat-progress-bar" style="width: {{ $progress }}%"></div>
        </div>
        <p class="mt-1 text-xs text-on-surface-variant" id="stat-progress-text">{{ $progress }}% Completed</p>
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
            Showing {{ $details->count() }} of {{ $totalItems }} Items | Progress: <span id="footer-progress-text">{{ $countedItems }}/{{ $totalItems }} ({{ $progress }}%)</span>
            <div class="mt-1 h-1.5 w-48 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-1.5 rounded-full bg-primary transition-all duration-300" id="footer-progress-bar" style="width: {{ $progress }}%"></div>
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
                onsubmit="return confirmSubmitAdjustment({{ $selisihItems }})"
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
<x-opname.add-item-modal :opname="$opname" :bins="$bins" :allBarangs="$allBarangs" :rows="$rows" />
<x-opname.edit-item-modal :opname="$opname" />
@endsection

@push('scripts')
<script>

function confirmSubmitAdjustment(selisihCount) {

    if (selisihCount > 0) {

        return confirm(
            ' Terdapat selisih stok pada ' + selisihCount + ' barang.\n\n' +
            'Stok sistem akan diubah sesuai hasil hitung fisik dan data opname akan dikunci.\n\n' +
            'Lanjutkan submit?'
        );
    }

    return confirm(
        'Submit adjustment? Setelah disubmit, stok resmi pada ' +
        'tbl_stok_lokasi akan diperbarui dan opname tidak dapat ' +
        'diedit lagi.'
    );
}

/*
|--------------------------------------------------------------------------
| STATE LIVE (client-side) UNTUK KARTU RINGKASAN & STATUS BARIS
|--------------------------------------------------------------------------
|
| $totalItems / $countedItems / $selisihItems dari server itu dihitung
| dari SELURUH data opname (bukan cuma yang tampil di halaman ini kalau
| lagi dipaginasi). Supaya angka di 4 kartu atas tetap akurat walau
| user cuma lihat 1 halaman, di sini kita nggak hitung ulang dari nol --
| kita cuma lacak PERUBAHAN status tiap baris yang ada di halaman ini
| (BELUM DIHITUNG -> SESUAI / SELISIH, atau sebaliknya) dan
| menambah/mengurangi count sesuai transisinya.
|--------------------------------------------------------------------------
*/

const opnameCounts = {
    sesuai: {{ $countedItems - $selisihItems }},
    selisih: {{ $selisihItems }},
    belum: {{ $totalItems - $countedItems }},
    total: {{ $totalItems }},
};

const opnameRowStatus = {};

document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('[id^="detail-row-"]')
        .forEach(function (row) {

            const id = row.id.replace('detail-row-', '');

            opnameRowStatus[id] = row.dataset.initialStatus;
        });
});

function updateOpnameStatCards() {

    document.getElementById('stat-cocok').textContent =
        opnameCounts.sesuai;

    document.getElementById('stat-tidak-cocok').textContent =
        opnameCounts.selisih;

    document.getElementById('stat-belum').textContent =
        opnameCounts.belum;

    const countedTotal =
        opnameCounts.sesuai + opnameCounts.selisih;

    const progress =
        opnameCounts.total > 0
            ? Math.round((countedTotal / opnameCounts.total) * 100)
            : 0;

    document.getElementById('stat-progress-bar').style.width =
        progress + '%';

    document.getElementById('stat-progress-text').textContent =
        progress + '% Completed';

    const footerBar =
        document.getElementById('footer-progress-bar');

    const footerText =
        document.getElementById('footer-progress-text');

    if (footerBar) {
        footerBar.style.width = progress + '%';
    }

    if (footerText) {
        footerText.textContent =
            countedTotal + '/' + opnameCounts.total + ' (' + progress + '%)';
    }
}

const opnameStatusIcons = {
    'SESUAI':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-white">' +
        '<span class="material-symbols-outlined text-[18px]">check</span></span>',

    'SELISIH':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-100 text-orange-700">' +
        '<span class="material-symbols-outlined text-[18px]">warning</span></span>',

    'BELUM DIHITUNG':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500">' +
        '<span class="material-symbols-outlined text-[18px]">more_horiz</span></span>',
};

const opnameRowAccent = {
    'SESUAI': 'border-l-green-400',
    'SELISIH': 'bg-orange-50/50 border-l-orange-400',
    'BELUM DIHITUNG': 'border-l-transparent',
};

function applyOpnameRowStatus(id, status) {

    const row =
        document.getElementById('detail-row-' + id);

    const icon =
        document.getElementById('detail-icon-' + id);

    if (row) {
        row.className =
            'border-l-[3px] transition-colors duration-200 hover:bg-surface-container-low/50 ' +
            opnameRowAccent[status];
    }

    if (icon) {
        icon.innerHTML = opnameStatusIcons[status];
    }
}

function opnameDetailRecalc(id) {

    /*
    |--------------------------------------------------------------------------
    | Actual Qty sekarang OTOMATIS = Baik + Rusak
    |--------------------------------------------------------------------------
    |
    | User cuma input "Baik" (Good/RFS) dan "Rusak" (Damage).
    | Field Actual read-only, dihitung di sini lalu di-submit
    | apa adanya (readonly input tetap ikut ke-POST, beda dengan disabled).
    |
    */

    const baikInput =
        document.getElementById(
            'baik-' + id
        );

    const rusakInput =
        document.getElementById(
            'rusak-' + id
        );

    const actualInput =
        document.getElementById(
            'actual-' + id
        );

    const diffEl =
        document.getElementById(
            'detail-diff-' + id
        );

    const sistem =
        Number(baikInput.dataset.sistem);

    const baikRaw = baikInput.value;
    const rusakRaw = rusakInput.value;

    let newStatus;

    /*
    | Kalau dua-duanya masih kosong,
    | anggap item ini belum dihitung sama sekali.
    */
    if (baikRaw === '' && rusakRaw === '') {

        actualInput.value = '';

        diffEl.textContent = '--';

        diffEl.className =
            'font-label-bold text-on-surface-variant';

        newStatus = 'BELUM DIHITUNG';

    } else {

        const baik =
            baikRaw === '' ? 0 : Number(baikRaw);

        const rusak =
            rusakRaw === '' ? 0 : Number(rusakRaw);

        const actual =
            baik + rusak;

        actualInput.value = actual;

        const diff =
            actual - sistem;

        diffEl.textContent =
            diff > 0
                ? '+' + diff
                : String(diff);

        diffEl.className =
            'font-label-bold transition-colors ' +
            (
                diff === 0
                    ? 'text-green-700'
                    : 'text-error'
            );

        newStatus =
            diff === 0
                ? 'SESUAI'
                : 'SELISIH';
    }

    /*
    | Update kartu ringkasan & warna baris CUMA kalau status
    | barang ini beneran berubah -- biar nggak kerja dua kali.
    */

    const previousStatus =
        opnameRowStatus[id];

    if (newStatus !== previousStatus) {

        const bucketKey = function (status) {
            if (status === 'SESUAI') return 'sesuai';
            if (status === 'SELISIH') return 'selisih';
            return 'belum';
        };

        if (previousStatus) {
            opnameCounts[bucketKey(previousStatus)]--;
        }

        opnameCounts[bucketKey(newStatus)]++;

        opnameRowStatus[id] = newStatus;

        updateOpnameStatCards();
    }

    applyOpnameRowStatus(id, newStatus);
}
</script>
@endpush