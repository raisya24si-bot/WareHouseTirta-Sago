@extends('layouts.app')

@section('title', 'Edit Stok Barang - Material Master')
@section('breadcrumb', 'Manajemen Stok Barang / Edit')

@section('content')

<div class="mb-5">

    <a
        href="{{ route('manajemen-stok.show', $stokLokasi->fk_barang) }}"
        class="mb-2 inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline"
    >

        <span class="material-symbols-outlined text-[18px]">
            arrow_back
        </span>

        Kembali

    </a>


    <h1 class="text-headline-md font-headline-md font-bold text-on-surface">
        Edit Stok Barang
    </h1>

    <p class="mt-1 text-sm text-on-surface-variant">
        Ubah lokasi BIN dan jumlah stok barang.
    </p>

</div>


<div class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <form
        method="POST"
        action="{{ route('manajemen-stok.update', $stokLokasi->id_stok_lokasi) }}"
        class="space-y-5 p-6"
    >

        @csrf
        @method('PUT')


        <!-- BARANG -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                Barang
            </label>

            <input
                type="text"
                value="{{ $stokLokasi->barang?->kd_master_barang }} - {{ $stokLokasi->barang?->nm_master_barang }}"
                readonly
                class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
            >

        </div>


        <!-- BIN -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                BIN
            </label>

            <select
                name="fk_lokasi"
                required
                class="w-full rounded-lg border border-outline-variant bg-white px-3 py-2.5"
            >

                @foreach($lokasis as $lokasi)

                    <option
                        value="{{ $lokasi->id_lokasi }}"
                        @selected(old('fk_lokasi', $stokLokasi->fk_lokasi) == $lokasi->id_lokasi)
                    >

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


        <!-- STOK -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                Stok
            </label>

            <input
                type="number"
                name="qty_stok"
                min="0"
                value="{{ old('qty_stok', $stokLokasi->qty_stok) }}"
                required
                class="w-full rounded-lg border border-outline-variant px-3 py-2.5"
            >

        </div>


        <!-- ACTION -->
        <div class="flex justify-end gap-2 border-t border-outline-variant pt-5">

            <a
                href="{{ route('manajemen-stok.show', $stokLokasi->fk_barang) }}"
                class="rounded-lg border border-outline-variant px-5 py-2.5 text-sm font-semibold hover:bg-surface-container-low"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-on-primary hover:bg-primary-container"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection