@props(['kategoriList'])
<div class="overflow-auto">
    <table class="w-full min-w-[700px] text-left">
        <thead class="border-b border-outline-variant bg-surface-container-low">
            <tr>
                <th class="px-4 py-3 text-label-bold">Kode</th>
                <th class="px-4 py-3 text-label-bold">Nama Jenis Gudang</th>
                <th class="px-4 py-3 text-label-bold">Keterangan</th>
                <th class="px-4 py-3 text-label-bold">Status</th>
                <th class="px-4 py-3 text-label-bold">Dipakai di Gudang</th>
                <th class="px-4 py-3 text-right text-label-bold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/50">
            @forelse($kategoriList as $k)
                <tr class="hover:bg-surface-container-low/50">
                    <td class="px-4 py-3 font-mono text-xs text-on-surface-variant">{{ $k->kd_kategori_gudang }}</td>
                    <td class="px-4 py-3">{{ $k->nm_kategori_gudang }}</td>
                    <td class="px-4 py-3 text-on-surface-variant">{{ $k->desc_kategori_gudang ?: '-' }}</td>
                    <td class="px-4 py-3"><x-master.shared.status-badge :status="$k->status_kategori_gudang" /></td>
                    <td class="px-4 py-3">{{ $k->gudangs_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="inline-flex gap-1">
                            <button
                                type="button"
                                onclick="editKategoriGudang({{ $k->id_kategori_gudang }}, @js($k->nm_kategori_gudang), @js($k->desc_kategori_gudang), @js($k->status_kategori_gudang))"
                                class="p-1 text-outline hover:text-primary"
                            >
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <form
                                method="POST"
                                action="{{ route('master-kategori-gudang.destroy', $k) }}"
                                onsubmit="return confirm('Nonaktifkan jenis gudang ini? Jenis ini nggak akan muncul lagi sebagai pilihan saat membuat gudang baru.')"
                            >
                                @csrf @method('DELETE')
                                <button class="p-1 text-outline hover:text-error">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-on-surface-variant">Belum ada jenis gudang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>