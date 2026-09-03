@extends('layouts.app')

@section('title', 'Detail Stok Barang - Warehouse Tirta Sago')
@section('breadcrumb', 'Manajemen Stok Barang / Detail')

@section('content')

<div class="mb-6">

    <a
        href="{{ route('manajemen-stok.index') }}"
        class="mb-3 inline-flex items-center gap-1 text-sm text-primary hover:underline"
    >

        <span class="material-symbols-outlined text-[18px]">
            arrow_back
        </span>

        Kembali

    </a>


    <x-master.shared.page-header
        title="Detail Stok Barang"
        description="Informasi lokasi penyimpanan dan stok barang."
    />

</div>


<!-- INFORMASI BARANG -->

<div class="mb-6 rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

    <div class="grid grid-cols-1 gap-5 md:grid-cols-4">

        <div>

            <p class="text-xs text-on-surface-variant">
                Kode Barang
            </p>

            <p class="mt-1">
                {{ $masterBarang->kd_master_barang }}
            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Nama Barang
            </p>

            <p class="mt-1">
                {{ $masterBarang->nm_master_barang }}
            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Kategori
            </p>

            <p class="mt-1">
                {{ $masterBarang->kategori?->nm_master_kategori ?? '-' }}
            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Satuan
            </p>

            <p class="mt-1">
                {{ $masterBarang->satuan?->nm_master_satuan ?? '-' }}
            </p>

        </div>

    </div>

</div>


<!-- LOKASI STOK -->

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="border-b border-outline-variant bg-surface-container-low/50 px-5 py-4">

        <h2 class="font-bold text-on-surface">
            Lokasi Stok
        </h2>

        <p class="mt-1 text-sm text-on-surface-variant">
            Daftar BIN tempat barang disimpan.
        </p>

    </div>


    <div class="overflow-auto">

        <table class="w-full min-w-[900px] text-left">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-5 py-3 text-label-bold">
                        No
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

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/50">

                @forelse($masterBarang->stokLokasis as $stok)

                    <tr class="hover:bg-surface-container-low/50">

                        <td class="px-5 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $stok->lokasi?->bin ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $stok->lokasi?->row?->kd_row ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $stok->lokasi?->row?->rak?->kd_rak ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $stok->lokasi?->row?->rak?->gudang?->nm_gudang ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ number_format($stok->qty_stok) }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center text-on-surface-variant"
                        >

                            Barang ini belum memiliki BIN.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection