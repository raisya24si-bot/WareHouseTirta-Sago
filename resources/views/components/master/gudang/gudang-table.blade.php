@props(['gudangs'])

<div class="overflow-auto">

    <table class="w-full min-w-[1100px] text-left">

        <thead class="border-b border-outline-variant bg-surface-container-low">

            <tr>
                <th class="px-5 py-3 text-label-bold">
                    Kode
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Nama Gudang
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Kategori
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Lokasi
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Manager
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Status
                </th>

                <th class="px-5 py-3 text-right text-label-bold">
                    Aksi
                </th>
            </tr>

        </thead>

        <tbody class="divide-y divide-outline-variant/50">

            @forelse($gudangs as $g)

                <tr class="hover:bg-surface-container-low/50">

                    {{-- KODE --}}
                    <td class="px-5 py-4">
                        {{ $g->kd_gudang }}
                    </td>

                    {{-- NAMA GUDANG --}}
                    <td class="px-5 py-4 font-medium">
                        {{ $g->nm_gudang }}
                    </td>

            {{-- KATEGORI --}}
            <td class="px-5 py-4">

                @php
                    $kategori = trim(
                        $g->kategoriGudang?->nm_kategori_gudang ?? ''
                    );

                    $kategoriStyle = match (strtolower($kategori)) {

                        'storage' => [
                            'badge' => 'bg-emerald-100 text-emerald-700',
                            'dot'   => 'bg-emerald-500',
                        ],

                        'transit' => [
                            'badge' => 'bg-blue-100 text-blue-700',
                            'dot'   => 'bg-blue-500',
                        ],

                        'rejected' => [
                            'badge' => 'bg-red-100 text-red-700',
                            'dot'   => 'bg-red-500',
                        ],

                        default => [
                            'badge' => 'bg-surface-container-high text-on-surface-variant',
                            'dot'   => 'bg-outline',
                        ],
                    };
                @endphp

                @if ($kategori)

                    <span
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-medium {{ $kategoriStyle['badge'] }}"
                    >

                        <span
                            class="h-2 w-2 rounded-full {{ $kategoriStyle['dot'] }}"
                        ></span>

                        {{ $kategori }}

                    </span>

                @else

                    <span class="text-sm text-on-surface-variant">
                        -
                    </span>

                @endif

            </td>

                    {{-- LOKASI --}}
                    <td class="px-5 py-4 text-on-surface-variant">
                        {{ $g->alamat_gudang ?: $g->desc_gudang ?: '-' }}
                    </td>

                    {{-- MANAGER --}}
                    <td class="px-5 py-4">
                        {{ $g->kepala_gudang ?: '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-5 py-4">

                        <x-master.shared.status-badge
                            :status="$g->statusGudang?->nm_status_gudang ?? 'Tidak Aktif'"
                        />

                    </td>

                    {{-- AKSI --}}
                    <td class="px-5 py-4 text-right">

                        <div class="inline-flex gap-1">

                            {{-- EDIT --}}
                            <button
                                type="button"
                                onclick="editGudang(
                                    {{ $g->id_gudang }},
                                    @js($g->nm_gudang),
                                    @js($g->kepala_gudang),
                                    @js($g->alamat_gudang ?: $g->desc_gudang),
                                    {{ $g->fk_status_gudang }},
                                    {{ $g->fk_kategori_gudang ?? 'null' }}
                                )"
                                class="p-1 text-outline hover:text-primary"
                                title="Edit"
                            >

                                <span class="material-symbols-outlined">
                                    edit
                                </span>

                            </button>

                            {{-- DELETE --}}
                            <form
                                method="POST"
                                action="{{ route('master-gudang.destroy', $g) }}"
                                onsubmit="return confirm('Hapus gudang ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="p-1 text-outline hover:text-error"
                                    title="Hapus"
                                >

                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="px-5 py-12 text-center text-on-surface-variant"
                    >
                        Belum ada data gudang.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>