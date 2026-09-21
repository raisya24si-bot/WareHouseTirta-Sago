@props(['alasanList'])
<div class="overflow-auto">
    <table class="w-full min-w-[700px] text-left">
        <thead class="border-b border-outline-variant bg-surface-container-low">
            <tr>
                <th class="px-4 py-3 text-label-bold">Nama Alasan Kerusakan</th>
                <th class="px-4 py-3 text-label-bold">Status</th>
                <th class="px-4 py-3 text-label-bold">Dipakai di Item Retur</th><th class="px-4 py-3 text-right text-label-bold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/50">@forelse($alasanList as $a)<tr class="hover:bg-surface-container-low/50">
                <td class="px-4 py-3">{{ $a->nm_alasan_retur }}</td>
                <td class="px-4 py-3"><x-master.shared.status-badge :status="$a->status_alasan_retur" /></td><td class="px-4 py-3">{{ $a->detail_returs_count }}</td><td class="px-4 py-3 text-right"><div class="inline-flex gap-1"><button type="button" onclick="editAlasanRetur({{ $a->id_alasan_retur }},@js($a->nm_alasan_retur),@js($a->status_alasan_retur))" class="p-1 text-outline hover:text-primary"><span class="material-symbols-outlined">edit</span></button><form method="POST" action="{{ route('master-alasan-retur.destroy',$a) }}" onsubmit="return confirm('Nonaktifkan kategori alasan ini? Chip-nya nggak akan muncul lagi di form retur baru.')">@csrf @method('DELETE')<button class="p-1 text-outline hover:text-error"><span class="material-symbols-outlined">delete</span></button></form></div></td></tr>@empty<tr><td colspan="4" class="px-4 py-12 text-center text-on-surface-variant">Belum ada kategori alasan kerusakan.</td>
            </tr>@endforelse</tbody></table></div>