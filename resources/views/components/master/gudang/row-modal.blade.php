@props(['raks'])
<div id="row-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeRowModal()"></div><div class="relative w-full max-w-xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="row-title" class="text-xl font-semibold">Tambah Row Baru</h2><button type="button" onclick="closeRowModal()"><span class="material-symbols-outlined">close</span></button></div><form id="row-form" method="POST" action="{{ route('master-row.store') }}" class="space-y-4 p-6">@csrf

<div id="row-kode-wrap" class="hidden"><label class="mb-1 block font-semibold">Kode Row</label><input id="row-kode" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div>

<div id="row-create-fields" class="space-y-4">
<div><label class="mb-1 block font-semibold">Rak *</label><select id="row-rak" name="fk_rak" required class="w-full rounded-md border border-outline-variant px-3 py-2">@foreach($raks as $r)<option value="{{ $r->id_rak }}">{{ $r->kd_rak }} ({{ $r->gudang?->nm_gudang ?? '-' }})</option>@endforeach</select></div>
<div><label class="mb-1 block font-semibold">Jumlah Row (Total) *</label><input id="row-jumlah" type="number" name="jumlah" min="1" max="200" value="1" required class="w-full rounded-md border border-outline-variant px-3 py-2"><p class="mt-1 text-xs text-on-surface-variant">Ini jumlah TOTAL row di rak ini, bukan jumlah tambahan. Contoh: sudah ada 6 row, isi 9 → sistem otomatis buat 3 row baru (07, 08, 09) supaya totalnya 9.</p></div>
</div>

<div><label class="mb-1 block font-semibold">Status *</label><select id="row-status" name="status_row" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option>AKTIF</option><option>MAINTENANCE</option><option>TIDAK AKTIF</option></select></div>
<div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeRowModal()" class="rounded-md border px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan</button></div>
</form></div></div>
<script>
function openRowModal(){
    const m=document.getElementById('row-modal');
    m.classList.remove('hidden');m.classList.add('flex');
    document.getElementById('row-title').textContent='Tambah Row Baru';
    document.getElementById('row-form').action='{{ route('master-row.store') }}';
    document.getElementById('row-form').querySelector('[name="_method"]')?.remove();
    document.getElementById('row-kode-wrap').classList.add('hidden');
    document.getElementById('row-create-fields').classList.remove('hidden');
    document.getElementById('row-rak').required = true;
    document.getElementById('row-jumlah').required = true;
    document.getElementById('row-jumlah').value = 1;
}
function closeRowModal(){const m=document.getElementById('row-modal');m.classList.add('hidden');m.classList.remove('flex')}
function editRow(id,status){
    openRowModal();
    document.getElementById('row-title').textContent='Edit Status Row';
    document.getElementById('row-form').action='{{ url('/master-row') }}/'+id;
    let m=document.getElementById('row-form').querySelector('[name="_method"]');
    if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('row-form').prepend(m)}
    m.value='PUT';
    document.getElementById('row-kode-wrap').classList.remove('hidden');
    document.getElementById('row-kode').value='Kode tidak dapat diubah';
    document.getElementById('row-create-fields').classList.add('hidden');
    document.getElementById('row-rak').required = false;
    document.getElementById('row-jumlah').required = false;
    document.getElementById('row-status').value=status;
}
</script>