<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['categories','satuans']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['categories','satuans']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="barang-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeBarangModal()"></div><div class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="barang-modal-title" class="text-xl font-semibold">Tambah Barang Baru</h2><button type="button" onclick="closeBarangModal()"><span class="material-symbols-outlined">close</span></button></div><form id="barang-form" method="POST" action="<?php echo e(route('barang.store')); ?>" class="space-y-4 p-6"><?php echo csrf_field(); ?><div><label class="mb-1 block font-semibold">Kode Barang</label><input value="[otomatis]" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div><div><label class="mb-1 block font-semibold">Nama Barang *</label><input id="barang-nama" name="nm_master_barang" required maxlength="100" class="w-full rounded-md border border-outline-variant px-3 py-2"></div><div><label class="mb-1 block font-semibold">Deskripsi</label><textarea id="barang-desc" name="desc_master_barang" rows="3" class="w-full rounded-md border border-outline-variant px-3 py-2"></textarea></div><div class="grid gap-4 md:grid-cols-2"><div><label class="mb-1 block font-semibold">Kategori *</label><select id="barang-kategori" name="fk_kategori" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id_master_kategori); ?>"><?php echo e($c->nm_master_kategori); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div><label class="mb-1 block font-semibold">Satuan *</label><select id="barang-satuan" name="fk_satuan" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $satuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id_master_satuan); ?>"><?php echo e($s->nm_master_satuan); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div></div><div class="grid gap-4 md:grid-cols-2"><div><label class="mb-1 block font-semibold">Stok Saat Ini *</label><input id="barang-stok" name="stok_saat_ini" type="number" min="0" required class="w-full rounded-md border border-outline-variant px-3 py-2"></div><div><label class="mb-1 block font-semibold">Minimum Stok *</label><input id="barang-min" name="minimum_stok" type="number" min="0" required class="w-full rounded-md border border-outline-variant px-3 py-2"></div></div><div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeBarangModal()" class="rounded-md border border-outline-variant px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan Barang</button></div></form></div></div>
<script>
function openBarangModal(){const m=document.getElementById('barang-modal');m.classList.remove('hidden');m.classList.add('flex');document.getElementById('barang-modal-title').textContent='Tambah Barang Baru';document.getElementById('barang-form').action='<?php echo e(route('barang.store')); ?>';document.getElementById('barang-form').querySelector('[name="_method"]')?.remove();}
function closeBarangModal(){const m=document.getElementById('barang-modal');m.classList.add('hidden');m.classList.remove('flex');}
function editBarang(id,nama,desc,kategori,satuan,status,stok,min){openBarangModal();document.getElementById('barang-modal-title').textContent='Edit Data Barang';document.getElementById('barang-form').action='<?php echo e(url('/barang')); ?>/'+id;let method=document.getElementById('barang-form').querySelector('[name="_method"]');if(!method){method=document.createElement('input');method.type='hidden';method.name='_method';document.getElementById('barang-form').prepend(method)}method.value='PUT';document.getElementById('barang-nama').value=nama||'';document.getElementById('barang-desc').value=desc||'';document.getElementById('barang-kategori').value=kategori;document.getElementById('barang-satuan').value=satuan;document.getElementById('barang-stok').value=stok;document.getElementById('barang-min').value=min;}
</script>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/master/barang/modal.blade.php ENDPATH**/ ?>