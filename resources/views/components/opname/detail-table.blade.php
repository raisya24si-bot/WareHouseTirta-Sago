@props([
    'details',
    'emptyBins' => null,
    'opname',
])

<div class="overflow-auto">

<table class="w-full min-w-[1300px] text-left">

<thead class="border-b border-outline-variant bg-surface-container-low">

<tr>
    <th class="px-4 py-3 text-label-bold">
        Status
    </th>

    <th class="px-4 py-3 text-label-bold">
        Bin
    </th>

    <th class="px-4 py-3 text-label-bold">
        Item Code
    </th>

    <th class="px-4 py-3 text-label-bold">
        Description
    </th>

    <th class="px-4 py-3 text-label-bold">
        System
    </th>

    <th class="px-4 py-3 text-label-bold">
        Baik
    </th>

    <th class="px-4 py-3 text-label-bold">
        Rusak
    </th>

    <th class="px-4 py-3 text-label-bold">
        Actual
    </th>

    <th class="px-4 py-3 text-label-bold">
        Diff
    </th>

    <th class="px-4 py-3 text-right text-label-bold">
        Aksi
    </th>
</tr>

</thead>

<tbody class="divide-y divide-outline-variant/50">

{{-- EMPTY BIN --}}

@if($emptyBins)

    @foreach($emptyBins as $eb)

        <tr class="bg-gray-50/60">

            <td class="px-4 py-3">

                <span
                    class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500"
                    title="Bin kosong"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        inbox
                    </span>
                </span>

            </td>

            <td class="px-4 py-3">

                <span class="rounded-md bg-surface-container-high px-2 py-1 text-xs font-label-bold">
                    {{ $eb->bin }}
                </span>

            </td>

            <td
                colspan="6"
                class="px-4 py-3 italic text-on-surface-variant"
            >
                [Empty Bin] Belum ada barang tercatat di lokasi ini.
            </td>

            <td
                class="px-4 py-3 text-right"
                colspan="2"
            >

                <button
                    type="button"
                    onclick="openAddItemModal({{ $eb->id_lokasi }})"
                    class="inline-flex items-center gap-1 rounded-md bg-primary px-3 py-1.5 text-xs font-label-bold text-on-primary"
                >
                    <span class="material-symbols-outlined text-[16px]">
                        add
                    </span>

                    Add Item
                </button>

                <form
                    method="POST"
                    action="{{ route('opname.delete-bin', [$opname, $eb]) }}"
                    class="inline"
                    onsubmit="return confirm('Keluarkan bin ini dari opname?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        class="ml-1 inline-flex items-center gap-1 rounded-md border border-outline-variant px-3 py-1.5 text-xs font-label-bold text-error"
                    >
                        <span class="material-symbols-outlined text-[16px]">
                            delete
                        </span>
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

@endif


{{-- DETAIL --}}

@forelse($details as $d)

<tr
    class="hover:bg-surface-container-low/50
    {{ $d->status_item === 'SELISIH' ? 'bg-orange-50/50' : '' }}"
    id="detail-row-{{ $d->id_opname_detail }}"
>

    {{-- STATUS --}}

    <td class="px-4 py-3">

        <span id="detail-icon-{{ $d->id_opname_detail }}">

            @if($d->status_item === 'SESUAI')

                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-white">
                    <span class="material-symbols-outlined text-[18px]">
                        check
                    </span>
                </span>

            @elseif($d->status_item === 'SELISIH')

                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-100 text-orange-700">
                    <span class="material-symbols-outlined text-[18px]">
                        warning
                    </span>
                </span>

            @else

                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                    <span class="material-symbols-outlined text-[18px]">
                        more_horiz
                    </span>
                </span>

            @endif

        </span>

    </td>


    {{-- BIN --}}

    <td class="px-4 py-3">

        <span class="rounded-md bg-surface-container-high px-2 py-1 text-xs font-label-bold">
            {{ $d->lokasi?->bin ?? '-' }}
        </span>

    </td>


    {{-- CODE --}}

    <td class="px-4 py-3">
        {{ $d->barang?->kd_master_barang ?? '-' }}
    </td>


    {{-- DESCRIPTION --}}

    <td class="px-4 py-3">
        {{ $d->barang?->nm_master_barang ?? '-' }}
    </td>


    {{-- SYSTEM --}}

    <td class="px-4 py-3 text-on-surface-variant">
        {{ $d->stok_sistem }}
    </td>


    {{-- BAIK (Good/RFS) --}}

    <td class="px-4 py-3">

        <input
            type="number"
            min="0"
            form="opname-detail-form"
            name="detail[{{ $d->id_opname_detail }}][baik]"
            value="{{ $d->stok_baik }}"
            id="baik-{{ $d->id_opname_detail }}"
            data-sistem="{{ $d->stok_sistem }}"
            data-detail-id="{{ $d->id_opname_detail }}"
            oninput="opnameDetailRecalc({{ $d->id_opname_detail }})"
            class="w-24 rounded-md border border-outline-variant px-3 py-1.5"
            placeholder="Baik"
        >

    </td>


    {{-- RUSAK (Damage) --}}

    <td class="px-4 py-3">

        <input
            type="number"
            min="0"
            form="opname-detail-form"
            name="detail[{{ $d->id_opname_detail }}][rusak]"
            value="{{ $d->stok_rusak ?? 0 }}"
            id="rusak-{{ $d->id_opname_detail }}"
            oninput="opnameDetailRecalc({{ $d->id_opname_detail }})"
            class="w-24 rounded-md border border-outline-variant px-3 py-1.5"
            placeholder="Rusak"
        >

    </td>


    {{-- ACTUAL (auto: Baik + Rusak, tidak diinput manual) --}}

    <td class="px-4 py-3">

        <input
            type="number"
            readonly
            tabindex="-1"
            form="opname-detail-form"
            name="detail[{{ $d->id_opname_detail }}][actual]"
            value="{{ $d->stok_aktual }}"
            id="actual-{{ $d->id_opname_detail }}"
            class="w-24 cursor-not-allowed rounded-md border border-outline-variant bg-surface-container-low px-3 py-1.5 text-on-surface-variant"
            placeholder="--"
        >

    </td>


    {{-- DIFF --}}

    <td class="px-4 py-3">

        <span
            id="detail-diff-{{ $d->id_opname_detail }}"
            class="font-label-bold
            {{ $d->selisih === null
                ? 'text-on-surface-variant'
                : ($d->selisih === 0
                    ? 'text-green-700'
                    : 'text-error') }}"
        >
            @if($d->selisih === null)
                --
            @elseif($d->selisih > 0)
                +{{ $d->selisih }}
            @else
                {{ $d->selisih }}
            @endif
        </span>

    </td>


    {{-- ACTION --}}

    <td class="px-4 py-3 text-right">

        <div class="inline-flex gap-1">

            <button
                type="button"
                onclick="openEditItemModal(
                    {{ $d->id_opname_detail }},
                    {{ $d->stok_sistem }},
                    @js($d->keterangan)
                )"
                class="p-1 text-outline hover:text-primary"
            >
                <span class="material-symbols-outlined text-[18px]">
                    edit
                </span>
            </button>

            @if($d->stok_aktual === null)

                <form
                    method="POST"
                    action="{{ route('opname.delete-item', [$opname, $d]) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        class="p-1 text-outline hover:text-error"
                    >
                        <span class="material-symbols-outlined text-[18px]">
                            delete
                        </span>
                    </button>

                </form>

            @else

                <span class="p-1 text-outline/40">
                    <span class="material-symbols-outlined text-[18px]">
                        lock
                    </span>
                </span>

            @endif

        </div>

    </td>

</tr>

@empty

    @if(!$emptyBins || $emptyBins->isEmpty())

        <tr>

            <td
                colspan="10"
                class="px-4 py-12 text-center text-on-surface-variant"
            >
                Belum ada barang tercatat pada bin yang dipilih.
            </td>

        </tr>

    @endif

@endforelse

</tbody>

</table>

</div>