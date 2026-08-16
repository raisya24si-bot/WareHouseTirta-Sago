<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['statuses']));

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

foreach (array_filter((['statuses']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="gudang-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeGudangModal()"></div><div class="relative w-full max-w-2xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="gudang-title" class="text-xl font-semibold">Tambah Gudang Baru</h2><button type="button" onclick="closeGudangModal()"><span class="material-symbols-outlined">close</span></button></div><form id="gudang-form" method="POST" action="<?php echo e(route('master-gudang.store')); ?>" class="space-y-4 p-6"><?php echo csrf_field(); ?><div class="grid gap-4 md:grid-cols-2"><div><label class="mb-1 block font-semibold">Kode Gudang</label><input id="gudang-kode" value="[otomatis]" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div><div><label class="mb-1 block font-semibold">Nama Gudang *</label><input id="gudang-nama" name="nm_gudang" required maxlength="50" placeholder="Contoh: Gudang Transit" class="w-full rounded-md border border-outline-variant px-3 py-2"></div></div><div><label class="mb-1 block font-semibold">Kepala Gudang</label><input id="gudang-kepala" name="kepala_gudang" maxlength="100" placeholder="Nama Manager" class="w-full rounded-md border border-outline-variant px-3 py-2"></div><div><label class="mb-1 block font-semibold">Alamat / Lokasi</label><textarea id="gudang-alamat" name="alamat_gudang" rows="3" placeholder="Alamat lengkap gudang..." class="w-full rounded-md border border-outline-variant px-3 py-2"></textarea></div><div><label class="mb-1 block font-semibold">Status *</label><select id="gudang-status" name="fk_status_gudang" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id_status_gudang); ?>"><?php echo e($s->nm_status_gudang); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeGudangModal()" class="rounded-md border border-outline-variant px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan Gudang</button></div></form></div></div><script>function openGudangModal(){const m=document.getElementById('gudang-modal');m.classList.remove('hidden');m.classList.add('flex');document.getElementById('gudang-title').textContent='Tambah Gudang Baru';document.getElementById('gudang-form').action='<?php echo e(route('master-gudang.store')); ?>';document.getElementById('gudang-form').querySelector('[name="_method"]')?.remove();document.getElementById('gudang-kode').value='[otomatis]'}function closeGudangModal(){const m=document.getElementById('gudang-modal');m.classList.add('hidden');m.classList.remove('flex')}function editGudang(id,nama,kepala,alamat,status){openGudangModal();document.getElementById('gudang-title').textContent='Edit Gudang';document.getElementById('gudang-form').action='<?php echo e(url('/master-gudang')); ?>/'+id;let m=document.getElementById('gudang-form').querySelector('[name="_method"]');if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('gudang-form').prepend(m)}m.value='PUT';document.getElementById('gudang-kode').value='Kode otomatis';document.getElementById('gudang-nama').value=nama||'';document.getElementById('gudang-kepala').value=kepala||'';document.getElementById('gudang-alamat').value=alamat||'';document.getElementById('gudang-status').value=status}</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/master/gudang/gudang-modal.blade.php ENDPATH**/ ?>