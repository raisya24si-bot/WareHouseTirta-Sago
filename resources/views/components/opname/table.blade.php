@props(['opnames'])
<div class="overflow-auto">
<table class="w-full min-w-[900px] text-left">
<thead class="border-b border-outline-variant bg-surface-container-low">
<tr>
    <th class="px-5 py-3 text-label-bold">Kode Opname</th>
    <th class="px-5 py-3 text-label-bold">Gudang</th>
    <th class="px-5 py-3 text-label-bold">Tgl Mulai</th>
    <th class="px-5 py-3 text-label-bold">Progress</th>
    <th class="px-5 py-3 text-label-bold">Status</th>
    <th class="px-5 py-3 text-right text-label-bold">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/50">
@forelse($opnames as $o)
@php
    $total = $o->details_count ?? 0;
    $counted = $o->details_counted_count ?? 0;
    $progress = $total > 0 ? (int) round(($counted / $total) * 100) : 0;
    $hasSelisih = ($o->details_selisih_count ?? 0) > 0;
@endphp
<tr class="hover:bg-surface-container-low/50">
    <td class="px-5 py-4">
        <a href="{{ route('opname.show', $o) }}" class="font-label-bold text-primary hover:underline">
            {{ $o->kd_opname }}
        </a>
        @if($hasSelisih)
            <span class="material-symbols-outlined align-middle text-[16px] text-orange-600 ml-1" title="Ada selisih, perlu ditinjau">warning</span>
        @endif
    </td>
    <td class="px-5 py-4">{{ $o->gudang?->nm_gudang ?? '-' }}</td>
    <td class="px-5 py-4">{{ $o->tgl_mulai?->format('d M Y') }}</td>
    <td class="px-5 py-4">
        <div class="flex items-center gap-2">
            <div class="h-2 w-32 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-2 rounded-full {{ $hasSelisih ? 'bg-orange-500' : 'bg-primary' }}" style="width: {{ $progress }}%"></div>
            </div>
            <span class="text-sm text-on-surface-variant">{{ $progress }}%</span>
        </div>
    </td>
    <td class="px-5 py-4"><x-master.shared.status-badge :status="$o->status_opname" /></td>
    <td class="px-5 py-4 text-right">
        <div class="inline-flex gap-1">
            <a href="{{ route('opname.show', $o) }}" class="p-1 text-outline hover:text-primary" title="Lihat / Hitung">
                <span class="material-symbols-outlined">visibility</span>
            </a>
            <form method="POST" action="{{ route('opname.destroy', $o) }}" onsubmit="return confirm('Hapus opname ini?')">
                @csrf @method('DELETE')
                <button class="p-1 text-outline hover:text-error"><span class="material-symbols-outlined">delete</span></button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr><td colspan="6" class="px-5 py-12 text-center text-on-surface-variant">Belum ada data stock opname.</td></tr>
@endforelse
</tbody>
</table>
</div>
