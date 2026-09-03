@props(['barangs'])
<div class="overflow-auto custom-scrollbar"><table class="w-full min-w-[1000px] text-left"><thead class="border-b border-outline-variant bg-surface-container-low"><tr><th class="px-4 py-3 text-label-bold text-on-surface-variant">Kode Barang</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Nama Barang</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Kategori</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Satuan</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Min. Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Status Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Status</th><th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">Aksi</th></tr></thead><tbody class="divide-y divide-outline-variant/50 text-body-sm">
@forelse($barangs as $barang)
@php
    $stockClass = match($barang->stok_status) {
        'HABIS' => 'bg-red-100 text-red-700',
        'MENIPIS' => 'bg-amber-100 text-amber-700',
        default => 'bg-green-100 text-green-700',
    };
    $accentClass = match($barang->stok_status) {
        'HABIS' => 'border-l-red-500',
        'MENIPIS' => 'border-l-amber-500',
        default => 'border-l-transparent',
    };
@endphp
<tr class="border-l-[3px] {{ $accentClass }} transition hover:bg-surface-container-low/60"><td class="px-4 py-3 font-medium">{{ $barang->kd_master_barang }}</td><td class="px-4 py-3">{{ $barang->nm_master_barang }}</td><td class="px-4 py-3 text-on-surface-variant">{{ $barang->kategori?->nm_master_kategori ?? '-' }}</td><td class="px-4 py-3 text-on-surface-variant">{{ $barang->satuan?->nm_master_satuan ?? '-' }}</td><td class="px-4 py-3 tabular-nums">{{ number_format($barang->stok_saat_ini) }}</td><td class="px-4 py-3 tabular-nums">{{ number_format($barang->minimum_stok) }}</td><td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $stockClass }}">{{ $barang->stok_status }}</span></td><td class="px-4 py-3"><x-master.shared.status-badge :status="$barang->status_master_barang === 'AKTIF' ? 'AKTIF' : 'TIDAK AKTIF'" /></td><td class="px-4 py-3 text-right"><div class="inline-flex gap-1"><button type="button" onclick="editBarang({{ $barang->id_master_barang }},@js($barang->nm_master_barang),@js($barang->desc_master_barang),{{ $barang->fk_kategori }},{{ $barang->fk_satuan }},@js($barang->status_master_barang),{{ $barang->stok_saat_ini }},{{ $barang->minimum_stok }})" class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"><span class="material-symbols-outlined text-[20px]">edit</span></button><form method="POST" action="{{ route('barang.destroy',$barang) }}" onsubmit="return confirm('Nonaktifkan barang ini?')">@csrf @method('DELETE')<button class="rounded p-1.5 text-outline transition hover:bg-error/10 hover:text-error"><span class="material-symbols-outlined text-[20px]">delete</span></button></form></div></td></tr>
@empty<tr><td colspan="9" class="px-4 py-12 text-center text-on-surface-variant">Belum ada data barang.</td></tr>@endforelse
</tbody></table></div>