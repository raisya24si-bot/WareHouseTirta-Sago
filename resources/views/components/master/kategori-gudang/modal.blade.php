<div id="kategori-gudang-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div class="absolute inset-0" onclick="closeKategoriGudangModal()"></div>
    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-2xl">
        <div class="flex justify-between border-b border-outline-variant px-6 py-4">
            <h2 id="kategori-gudang-title" class="text-xl font-semibold">Tambah Jenis Gudang Baru</h2>
            <button type="button" onclick="closeKategoriGudangModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="kategori-gudang-form" method="POST" action="{{ route('master-kategori-gudang.store') }}" class="space-y-4 p-6">
            @csrf
            <div>
                <label class="mb-1 block font-semibold">Nama Jenis Gudang *</label>
                <input
                    id="kategori-gudang-nama"
                    name="nm_kategori_gudang"
                    required
                    maxlength="50"
                    placeholder="Contoh: Karantina"
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                <p class="mt-1 text-xs text-on-surface-variant">Ini yang bakal muncul jadi pilihan jenis gudang saat membuat/edit gudang.</p>
            </div>
            <div>
                <label class="mb-1 block font-semibold">Keterangan</label>
                <textarea
                    id="kategori-gudang-desc"
                    name="desc_kategori_gudang"
                    maxlength="255"
                    rows="2"
                    placeholder="Opsional, jelasin fungsi jenis gudang ini"
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                ></textarea>
            </div>
            <div>
                <label class="mb-1 block font-semibold">Status *</label>
                <select id="kategori-gudang-status" name="status_kategori_gudang" required class="w-full rounded-md border border-outline-variant px-3 py-2">
                    <option>AKTIF</option>
                    <option>TIDAK AKTIF</option>
                </select>
                <p class="mt-1 text-xs text-on-surface-variant">Cuma yang AKTIF yang muncul sebagai pilihan saat membuat gudang baru.</p>
            </div>
            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">
                <button type="button" onclick="closeKategoriGudangModal()" class="rounded-md border px-4 py-2">Batal</button>
                <button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
function openKategoriGudangModal() {
    const m = document.getElementById('kategori-gudang-modal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.getElementById('kategori-gudang-title').textContent = 'Tambah Jenis Gudang Baru';
    document.getElementById('kategori-gudang-form').action = '{{ route('master-kategori-gudang.store') }}';
    document.getElementById('kategori-gudang-form').querySelector('[name="_method"]')?.remove();
    document.getElementById('kategori-gudang-nama').value = '';
    document.getElementById('kategori-gudang-desc').value = '';
    document.getElementById('kategori-gudang-status').value = 'AKTIF';
}

function closeKategoriGudangModal() {
    const m = document.getElementById('kategori-gudang-modal');
    m.classList.add('hidden');
    m.classList.remove('flex');
}

function editKategoriGudang(id, nama, desc, status) {
    openKategoriGudangModal();
    document.getElementById('kategori-gudang-title').textContent = 'Edit Jenis Gudang';
    document.getElementById('kategori-gudang-form').action = '{{ url('/master-kategori-gudang') }}/' + id;

    let m = document.getElementById('kategori-gudang-form').querySelector('[name="_method"]');
    if (!m) {
        m = document.createElement('input');
        m.type = 'hidden';
        m.name = '_method';
        document.getElementById('kategori-gudang-form').prepend(m);
    }
    m.value = 'PUT';

    document.getElementById('kategori-gudang-nama').value = nama || '';
    document.getElementById('kategori-gudang-desc').value = desc || '';
    document.getElementById('kategori-gudang-status').value = status || 'AKTIF';
}
</script>