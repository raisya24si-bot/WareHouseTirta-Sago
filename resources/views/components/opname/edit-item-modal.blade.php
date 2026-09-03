@props(['opname'])
<div id="edit-item-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div class="absolute inset-0" onclick="closeEditItemModal()"></div>
    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <h2 class="text-xl font-semibold">Edit Barang</h2>
            <button type="button" onclick="closeEditItemModal()"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="edit-item-form" method="POST" action="" class="space-y-4 p-6">
            @csrf
            @method('PUT')
            <div>
                <label class="mb-1 block font-semibold">System Qty *</label>
                <input id="edit-item-stok-sistem" type="number" name="stok_sistem" min="0" required class="w-full rounded-md border border-outline-variant px-3 py-2">
                <p class="mt-1 text-xs text-on-surface-variant">Kalau item ini sudah diisi Actual Qty, selisih & status dihitung ulang otomatis mengikuti angka baru ini.</p>
            </div>
            <div>
                <label class="mb-1 block font-semibold">Keterangan</label>
                <textarea id="edit-item-keterangan" name="keterangan" rows="2" class="w-full rounded-md border border-outline-variant px-3 py-2" placeholder="Opsional"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">
                <button type="button" onclick="closeEditItemModal()" class="rounded-md border border-outline-variant px-4 py-2">Batal</button>
                <button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openEditItemModal(itemId, stokSistem, keterangan) {
        const form = document.getElementById('edit-item-form');
        form.action = '{{ url('/opname') }}/{{ $opname->id_opname }}/items/' + itemId;
        document.getElementById('edit-item-stok-sistem').value = stokSistem;
        document.getElementById('edit-item-keterangan').value = keterangan || '';

        const m = document.getElementById('edit-item-modal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeEditItemModal() {
        const m = document.getElementById('edit-item-modal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }
</script>