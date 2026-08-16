<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['gudangs']));

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

foreach (array_filter((['gudangs']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="rak-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeRakModal()"></div><div class="relative w-full max-w-xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="rak-title" class="text-xl font-semibold">Tambah Rak Baru</h2><button type="button" onclick="closeRakModal()"><span class="material-symbols-outlined">close</span></button></div><form id="rak-form" method="POST" action="<?php echo e(route('master-rak.store')); ?>" class="space-y-4 p-6"><?php echo csrf_field(); ?><div><label class="mb-1 block font-semibold">Kode Rak</label><input id="rak-kode" value="[otomatis]" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div><div><label class="mb-1 block font-semibold">Nama Rak *</label><input id="rak-nama" name="nm_rak" required class="w-full rounded-md border border-outline-variant px-3 py-2"></div><div><label class="mb-1 block font-semibold">Gudang *</label><select id="rak-gudang" name="fk_gudang" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($g->id_gudang); ?>"><?php echo e($g->kd_gudang); ?> - <?php echo e($g->nm_gudang); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div><label class="mb-1 block font-semibold">Status *</label><select id="rak-status" name="status_rak" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option>AKTIF</option><option>MAINTENANCE</option><option>TIDAK AKTIF</option></select></div><div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeRakModal()" class="rounded-md border px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan Rak</button></div></form></div></div><script>function openRakModal(){const m=document.getElementById('rak-modal');m.classList.remove('hidden');m.classList.add('flex');document.getElementById('rak-title').textContent='Tambah Rak Baru';document.getElementById('rak-form').action='<?php echo e(route('master-rak.store')); ?>';document.getElementById('rak-form').querySelector('[name="_method"]')?.remove();document.getElementById('rak-kode').value='[otomatis]'}function closeRakModal(){const m=document.getElementById('rak-modal');m.classList.add('hidden');m.classList.remove('flex')}function editRak(id,nama,gudang,status){openRakModal();document.getElementById('rak-title').textContent='Edit Rak';document.getElementById('rak-form').action='<?php echo e(url('/master-rak')); ?>/'+id;let m=document.getElementById('rak-form').querySelector('[name="_method"]');if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('rak-form').prepend(m)}m.value='PUT';document.getElementById('rak-kode').value='Kode otomatis';document.getElementById('rak-nama').value=nama||'';document.getElementById('rak-gudang').value=gudang;document.getElementById('rak-status').value=status}</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_REBUILT_CLEAN_FIXED\MasterData\resources\views/components/master/gudang/rak-modal.blade.php ENDPATH**/ ?>