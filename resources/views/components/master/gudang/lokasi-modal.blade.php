@props(['raks', 'rows'])
@php
    $rowPayload = $rows->map(fn ($r) => [
        'id' => $r->id_row,
        'kd_row' => $r->kd_row,
        'rak_id' => $r->fk_rak,
    ])->values();
@endphp
<div id="lokasi-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeLokasiModal()"></div><div class="relative w-full max-w-xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="lokasi-title" class="text-xl font-semibold">Tambah Struktur Lokasi</h2><button type="button" onclick="closeLokasiModal()"><span class="material-symbols-outlined">close</span></button></div><form id="lokasi-form" method="POST" action="{{ route('struktur-lokasi.store') }}" class="space-y-4 p-6">@csrf

<div id="lokasi-kode-wrap" class="hidden"><label class="mb-1 block font-semibold">Kode Lokasi</label><input id="lokasi-kode" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div>

<div id="lokasi-create-fields" class="space-y-4">
<div><label class="mb-1 block font-semibold">Rak *</label><select id="lokasi-rak" required onchange="lokasiOnRakChange()" class="w-full rounded-md border border-outline-variant px-3 py-2"><option value="">Pilih rak...</option>@foreach($raks as $r)<option value="{{ $r->id_rak }}">{{ $r->kd_rak }} ({{ $r->gudang?->nm_gudang ?? '-' }})</option>@endforeach</select></div>
<div><label class="mb-1 block font-semibold">Row *</label><select id="lokasi-row" name="fk_row" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option value="">Pilih rak dahulu...</option></select></div>
<div><label class="mb-1 block font-semibold">Jumlah Bin (Total) *</label><input id="lokasi-jumlah" type="number" name="jumlah" min="1" max="300" value="1" required class="w-full rounded-md border border-outline-variant px-3 py-2"><p class="mt-1 text-xs text-on-surface-variant">Ini jumlah TOTAL bin di row tersebut, bukan jumlah tambahan. Contoh: sudah ada 6 bin, isi 9 → sistem otomatis buat 3 bin baru (07, 08, 09) supaya totalnya 9.</p></div>
</div>

<div><label class="mb-1 block font-semibold">Status *</label><select id="lokasi-status" name="status_lokasi" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option>AKTIF</option><option>MAINTENANCE</option><option>TIDAK AKTIF</option></select></div>
<div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeLokasiModal()" class="rounded-md border px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan</button></div>
</form></div></div>
<script>
const lokasiRowData = @json($rowPayload);

function lokasiOnRakChange(){
    const rakId = document.getElementById('lokasi-rak').value;
    const rowSelect = document.getElementById('lokasi-row');
    rowSelect.innerHTML = '';

    if (!rakId) {
        rowSelect.innerHTML = '<option value="">Pilih rak dahulu...</option>';
        return;
    }

    const filtered = lokasiRowData.filter(r => String(r.rak_id) === String(rakId));

    if (filtered.length === 0) {
        rowSelect.innerHTML = '<option value="">Rak ini belum punya row</option>';
        return;
    }

    rowSelect.innerHTML = '<option value="">Pilih row...</option>';
    filtered.forEach(r => {
        const opt = document.createElement('option');
        opt.value = r.id; opt.textContent = r.kd_row;
        rowSelect.appendChild(opt);
    });
}

function openLokasiModal(){
    const m=document.getElementById('lokasi-modal');
    m.classList.remove('hidden');m.classList.add('flex');
    document.getElementById('lokasi-title').textContent='Tambah Struktur Lokasi';
    document.getElementById('lokasi-form').action='{{ route('struktur-lokasi.store') }}';
    document.getElementById('lokasi-form').querySelector('[name="_method"]')?.remove();
    document.getElementById('lokasi-kode-wrap').classList.add('hidden');
    document.getElementById('lokasi-create-fields').classList.remove('hidden');
    document.getElementById('lokasi-rak').required = true;
    document.getElementById('lokasi-rak').value = '';
    document.getElementById('lokasi-row').required = true;
    document.getElementById('lokasi-row').innerHTML = '<option value="">Pilih rak dahulu...</option>';
    document.getElementById('lokasi-jumlah').required = true;
    document.getElementById('lokasi-jumlah').value = 1;
}
function closeLokasiModal(){const m=document.getElementById('lokasi-modal');m.classList.add('hidden');m.classList.remove('flex')}
function editLokasi(id,status){
    openLokasiModal();
    document.getElementById('lokasi-title').textContent='Edit Status Struktur Lokasi';
    document.getElementById('lokasi-form').action='{{ url('/struktur-lokasi') }}/'+id;
    let m=document.getElementById('lokasi-form').querySelector('[name="_method"]');
    if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('lokasi-form').prepend(m)}
    m.value='PUT';
    document.getElementById('lokasi-kode-wrap').classList.remove('hidden');
    document.getElementById('lokasi-kode').value='Kode tidak dapat diubah';
    document.getElementById('lokasi-create-fields').classList.add('hidden');
    document.getElementById('lokasi-rak').required = false;
    document.getElementById('lokasi-row').required = false;
    document.getElementById('lokasi-jumlah').required = false;
    document.getElementById('lokasi-status').value=status;
}
</script>