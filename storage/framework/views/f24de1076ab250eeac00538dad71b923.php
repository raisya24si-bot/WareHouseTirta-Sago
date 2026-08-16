<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['raks']));

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

foreach (array_filter((['raks']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="row-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeRowModal()"></div><div class="relative w-full max-w-xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="row-title" class="text-xl font-semibold">Tambah Row Baru</h2><button type="button" onclick="closeRowModal()"><span class="material-symbols-outlined">close</span></button></div><form id="row-form" method="POST" action="<?php echo e(route('master-row.store')); ?>" class="space-y-4 p-6"><?php echo csrf_field(); ?><div><label class="mb-1 block font-semibold">Kode Row</label><input id="row-kode" value="[otomatis]" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div><div><label class="mb-1 block font-semibold">Nama Row *</label><input id="row-nama" name="nm_row" required class="w-full rounded-md border border-outline-variant px-3 py-2"></div><div><label class="mb-1 block font-semibold">Rak *</label><select id="row-rak" name="fk_rak" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $raks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->id_rak); ?>"><?php echo e($r->kd_rak); ?> - <?php echo e($r->nm_rak); ?> (<?php echo e($r->gudang?->nm_gudang ?? '-'); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div><label class="mb-1 block font-semibold">Status *</label><select id="row-status" name="status_row" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option>AKTIF</option><option>MAINTENANCE</option><option>TIDAK AKTIF</option></select></div><div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeRowModal()" class="rounded-md border px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan Row</button></div></form></div></div><script>function openRowModal(){const m=document.getElementById('row-modal');m.classList.remove('hidden');m.classList.add('flex');document.getElementById('row-title').textContent='Tambah Row Baru';document.getElementById('row-form').action='<?php echo e(route('master-row.store')); ?>';document.getElementById('row-form').querySelector('[name="_method"]')?.remove();document.getElementById('row-kode').value='[otomatis]'}function closeRowModal(){const m=document.getElementById('row-modal');m.classList.add('hidden');m.classList.remove('flex')}function editRow(id,nama,rak,status){openRowModal();document.getElementById('row-title').textContent='Edit Row';document.getElementById('row-form').action='<?php echo e(url('/master-row')); ?>/'+id;let m=document.getElementById('row-form').querySelector('[name="_method"]');if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('row-form').prepend(m)}m.value='PUT';document.getElementById('row-kode').value='Kode otomatis';document.getElementById('row-nama').value=nama||'';document.getElementById('row-rak').value=rak;document.getElementById('row-status').value=status}</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_REBUILT_CLEAN_FIXED\MasterData\resources\views/components/master/gudang/row-modal.blade.php ENDPATH**/ ?>