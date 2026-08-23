@extends('layouts.app')

@section('title', 'Manajemen Stok Barang - Material Master')
@section('breadcrumb', 'Manajemen Stok Barang')

@section('content')

<x-master.shared.page-header
    title="Manajemen Stok Barang"
    description="Kelola penempatan dan stok barang berdasarkan BIN, Row, Rak, dan Gudang."
    icon="warehouse"
/>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-master.shared.stat-card
        label="Total Barang"
        :value="$stokSummary['total_barang']"
        icon="inventory_2"
        color="primary"
    />
    <x-master.shared.stat-card
        label="Belum Ada BIN"
        :value="$stokSummary['belum_bin']"
        icon="location_off"
        color="amber"
    />
    <x-master.shared.stat-card
        label="Total Penempatan BIN"
        :value="$stokSummary['total_penempatan']"
        icon="inventory"
        color="green"
    />
    <x-master.shared.stat-card
        label="Gudang Aktif"
        :value="$stokSummary['total_gudang']"
        icon="warehouse"
        color="primary"
    />
</div>


<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    {{-- =========================================================
        FILTER
    ========================================================== --}}

    <x-master.shared.crud-toolbar
        :action="route('manajemen-stok.index')"
        placeholder="Cari nama barang, kode, BIN..."
        filterName="gudang"
        filterLabel="Gudang"
        :filterOptions="$gudangs->map(fn ($gudang) => [
            'value' => $gudang->id_gudang,
            'label' => $gudang->nm_gudang,
        ])->values()->all()"
    />


    {{-- =========================================================
        TABLE
    ========================================================== --}}

    <div class="overflow-auto">

        <table class="w-full min-w-[1100px] text-left">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-5 py-3 text-label-bold">
                        No
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Nama Barang
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        BIN
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Row
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Rak
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Gudang
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Stok
                    </th>

                    <th class="px-5 py-3 text-right text-label-bold">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/50">

                @forelse($barangs as $barang)

                    {{-- =================================================
                        BARANG SUDAH PUNYA BIN
                    ================================================== --}}

                    @if($barang->stokLokasis->isNotEmpty())

                        @foreach($barang->stokLokasis as $stok)

                            <tr class="hover:bg-surface-container-low/50">

                                {{-- NO --}}

                                <td class="px-5 py-4">

                                    @if(method_exists($barangs, 'firstItem'))

                                        {{ $barangs->firstItem() + $loop->parent->index }}

                                    @else

                                        {{ $loop->parent->index + 1 }}

                                    @endif

                                </td>


                                {{-- NAMA BARANG --}}

                                <td class="px-5 py-4">

                                    <div>
                                        {{ $barang->nm_master_barang }}
                                    </div>

                                    <div class="mt-1 text-xs text-on-surface-variant">
                                        {{ $barang->kd_master_barang }}
                                    </div>

                                </td>


                                {{-- BIN --}}

                                <td class="px-5 py-4">

                                    {{ $stok->lokasi?->bin ?? '-' }}

                                </td>


                                {{-- ROW --}}

                                <td class="px-5 py-4">

                                    {{ $stok->lokasi?->row?->kd_row ?? '-' }}

                                </td>


                                {{-- RAK --}}

                                <td class="px-5 py-4">

                                    {{ $stok->lokasi?->row?->rak?->kd_rak ?? '-' }}

                                </td>


                                {{-- GUDANG --}}

                                <td class="px-5 py-4">

                                    {{ $stok->lokasi?->row?->rak?->gudang?->nm_gudang ?? '-' }}

                                </td>


                                {{-- STOK --}}

                                <td class="px-5 py-4">

                                    <span class="font-label-bold tabular-nums">
                                        {{ number_format($stok->qty_stok) }}
                                    </span>

                                </td>


                                {{-- AKSI --}}

                                <td class="px-5 py-4 text-right">

                                    <div class="inline-flex items-center gap-1">

                                        {{-- VIEW --}}

                                        <a
                                            href="{{ route('manajemen-stok.show', $barang) }}"
                                            class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                            title="View"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                visibility
                                            </span>

                                        </a>


                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            onclick="openEditStokModal(
                                                {{ $stok->id_stok_lokasi }},
                                                @js($barang->nm_master_barang),
                                                {{ $stok->fk_lokasi }},
                                                {{ $stok->qty_stok }}
                                            )"
                                            class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                            title="Edit"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                edit
                                            </span>

                                        </button>


                                        {{-- DELETE --}}

                                        <form
                                            method="POST"
                                            action="{{ route('manajemen-stok.destroy', $stok->id_stok_lokasi) }}"
                                            onsubmit="return confirm('Lepas barang {{ $barang->nm_master_barang }} dari BIN {{ $stok->lokasi?->bin }}? Data stok di BIN ini akan dihapus.')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex p-1.5 text-outline transition hover:text-error"
                                                title="Delete"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    delete
                                                </span>

                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach


                    {{-- =================================================
                        BARANG BELUM PUNYA BIN
                    ================================================== --}}

                    @else

                        <tr class="hover:bg-surface-container-low/50">

                            {{-- NO --}}

                            <td class="px-5 py-4">

                                @if(method_exists($barangs, 'firstItem'))

                                    {{ $barangs->firstItem() + $loop->index }}

                                @else

                                    {{ $loop->index + 1 }}

                                @endif

                            </td>


                            {{-- NAMA BARANG --}}

                            <td class="px-5 py-4">

                                <div>
                                    {{ $barang->nm_master_barang }}
                                </div>

                                <div class="mt-1 text-xs text-on-surface-variant">
                                    {{ $barang->kd_master_barang }}
                                </div>

                            </td>


                            {{-- BIN KOSONG = ADD BIN --}}

                            <td class="px-5 py-4">

                                <button
                                    type="button"
                                    onclick="openAddBinModal(
                                        {{ $barang->id_master_barang }},
                                        @js($barang->nm_master_barang)
                                    )"
                                    class="inline-flex items-center rounded-md border border-primary/30 bg-primary/5 px-2.5 py-1 text-sm font-normal text-primary transition hover:border-primary/50 hover:bg-primary/10"
                                >

                                    + Add BIN

                                </button>

                            </td>


                            {{-- ROW --}}

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            {{-- RAK --}}

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            {{-- GUDANG --}}

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            {{-- STOK --}}

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            {{-- AKSI --}}

                            <td class="px-5 py-4 text-right">

                                <div class="inline-flex items-center gap-1">

                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('manajemen-stok.show', $barang) }}"
                                        class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                        title="View"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            visibility
                                        </span>

                                    </a>


                                    {{-- EDIT
                                         Tidak ada record stok lokasi,
                                         jadi tombol edit dibuat nonaktif.
                                    --}}

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex cursor-not-allowed p-1.5 text-outline/40"
                                        title="Belum ada BIN"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            edit
                                        </span>

                                    </button>


                                    {{-- DELETE
                                         Sama, belum ada apa-apa untuk dihapus.
                                    --}}

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex cursor-not-allowed p-1.5 text-outline/40"
                                        title="Belum ada BIN"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            delete
                                        </span>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endif

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="px-5 py-12 text-center text-on-surface-variant"
                        >

                            Belum ada data barang.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =========================================================
        PAGINATION
    ========================================================== --}}

    @if(method_exists($barangs, 'links'))

        <x-master.shared.pagination
            :items="$barangs"
            label="barang"
            :perPage="$perPage"
        />

    @else

        <div class="flex items-center justify-between border-t border-outline-variant bg-surface-container-low px-5 py-3">

            <span class="text-sm text-on-surface-variant">
                Menampilkan {{ $barangs->count() }} barang
            </span>

        </div>

    @endif

</div>

@endsection


{{-- =============================================================
    MODAL
============================================================= --}}

@section('modals')


{{-- =============================================================
    MODAL EDIT
============================================================= --}}

<div
    id="edit-stok-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>

    <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

        {{-- HEADER --}}

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-5">

            <h2 class="text-xl font-bold text-on-surface">
                Edit Barang
            </h2>

            <button
                type="button"
                onclick="closeEditStokModal()"
                class="text-on-surface-variant transition hover:text-on-surface"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        {{-- FORM --}}

        <form
            id="edit-stok-form"
            method="POST"
            class="p-6"
        >

            @csrf

            @method('PUT')


            {{-- BARANG --}}

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    Nama Barang
                </label>

                <input
                    id="edit-stok-barang"
                    type="text"
                    readonly
                    class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
                >

            </div>


            {{-- BIN --}}

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    BIN
                </label>

                <select
                    id="edit-stok-lokasi"
                    name="fk_lokasi"
                    required
                    class="w-full rounded-md border border-outline-variant bg-white px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

                    <option value="">
                        Pilih BIN
                    </option>

                    @foreach($lokasis as $lokasi)

                        <option value="{{ $lokasi->id_lokasi }}">

                            {{ $lokasi->bin }}
                            —
                            {{ $lokasi->row?->kd_row ?? '-' }}
                            —
                            {{ $lokasi->row?->rak?->kd_rak ?? '-' }}
                            —
                            {{ $lokasi->row?->rak?->gudang?->nm_gudang ?? '-' }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- STOK --}}

            <div class="mb-6">

                <label class="mb-2 block text-sm">
                    Stok
                </label>

                <input
                    id="edit-stok-qty"
                    type="number"
                    name="qty_stok"
                    min="0"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

            </div>


            {{-- FOOTER --}}

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeEditStokModal()"
                    class="rounded-md border border-outline-variant px-4 py-2.5 text-sm transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2.5 text-sm text-on-primary transition hover:opacity-90"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>



{{-- =============================================================
    MODAL ADD BIN
============================================================= --}}

<div
    id="add-bin-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>

    <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

        {{-- HEADER --}}

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-5">

            <h2 class="text-xl font-bold text-on-surface">
                Tambah BIN
            </h2>

            <button
                type="button"
                onclick="closeAddBinModal()"
                class="text-on-surface-variant transition hover:text-on-surface"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        {{-- FORM --}}

        <form
            method="POST"
            action="{{ route('manajemen-stok.add-bin') }}"
            class="p-6"
        >

            @csrf


            <input
                id="add-bin-barang-id"
                type="hidden"
                name="fk_barang"
            >


            {{-- BARANG --}}

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    Nama Barang
                </label>

                <input
                    id="add-bin-barang"
                    type="text"
                    readonly
                    class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
                >

            </div>


            {{-- BIN --}}

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    BIN
                </label>

                <select
                    name="fk_lokasi"
                    required
                    class="w-full rounded-md border border-outline-variant bg-white px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

                    <option value="">
                        Pilih BIN
                    </option>

                    @foreach($lokasis as $lokasi)

                        <option value="{{ $lokasi->id_lokasi }}">

                            {{ $lokasi->bin }}
                            —
                            {{ $lokasi->row?->kd_row ?? '-' }}
                            —
                            {{ $lokasi->row?->rak?->kd_rak ?? '-' }}
                            —
                            {{ $lokasi->row?->rak?->gudang?->nm_gudang ?? '-' }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- STOK --}}

            <div class="mb-6">

                <label class="mb-2 block text-sm">
                    Stok
                </label>

                <input
                    type="number"
                    name="qty_stok"
                    min="0"
                    value="0"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

            </div>


            {{-- FOOTER --}}

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeAddBinModal()"
                    class="rounded-md border border-outline-variant px-4 py-2.5 text-sm transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2.5 text-sm text-on-primary transition hover:opacity-90"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | EDIT MODAL
    |--------------------------------------------------------------------------
    */

    function openEditStokModal(
        stokId,
        barangNama,
        lokasiId,
        qty
    ) {

        const modal =
            document.getElementById(
                'edit-stok-modal'
            );

        const form =
            document.getElementById(
                'edit-stok-form'
            );

        const barang =
            document.getElementById(
                'edit-stok-barang'
            );

        const lokasi =
            document.getElementById(
                'edit-stok-lokasi'
            );

        const stok =
            document.getElementById(
                'edit-stok-qty'
            );


        barang.value = barangNama;

        lokasi.value = lokasiId;

        stok.value = qty;


        form.action =
            "{{ url('/manajemen-stok/stok') }}/"
            + stokId;


        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    function closeEditStokModal()
    {
        const modal =
            document.getElementById(
                'edit-stok-modal'
            );

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | ADD BIN MODAL
    |--------------------------------------------------------------------------
    */

    function openAddBinModal(
        barangId,
        barangNama
    ) {

        const modal =
            document.getElementById(
                'add-bin-modal'
            );

        const barangIdInput =
            document.getElementById(
                'add-bin-barang-id'
            );

        const barangInput =
            document.getElementById(
                'add-bin-barang'
            );


        barangIdInput.value =
            barangId;

        barangInput.value =
            barangNama;


        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    function closeAddBinModal()
    {
        const modal =
            document.getElementById(
                'add-bin-modal'
            );

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | BACKDROP CLICK
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('edit-stok-modal')
        .addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeEditStokModal();
                }

            }
        );


    document
        .getElementById('add-bin-modal')
        .addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeAddBinModal();
                }

            }
        );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            closeEditStokModal();

            closeAddBinModal();

        }
    );

</script>

@endpush