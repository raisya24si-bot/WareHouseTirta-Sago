<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['opname', 'bins', 'allBarangs']));

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

foreach (array_filter((['opname', 'bins', 'allBarangs']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="add-item-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div class="absolute inset-0" onclick="closeAddItemModal()"></div>
    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <h2 class="text-xl font-semibold">Tambah Barang ke Opname</h2>
            <button type="button" onclick="closeAddItemModal()"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form method="POST" action="<?php echo e(route('opname.add-item', $opname)); ?>" class="space-y-4 p-6">
            <?php echo csrf_field(); ?>
            <div>
                <label class="mb-1 block font-semibold">Bin *</label>
                <select id="add-item-bin" name="fk_lokasi" required class="w-full rounded-md border border-outline-variant px-3 py-2">
                    <option value="">Pilih bin...</option>
                    <?php $__currentLoopData = $bins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id_lokasi); ?>"><?php echo e($b->bin); ?> (<?php echo e($b->kd_lokasi); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="mb-1 block font-semibold">Barang *</label>
                <select name="fk_barang" required class="w-full rounded-md border border-outline-variant px-3 py-2">
                    <option value="">Pilih barang...</option>
                    <?php $__currentLoopData = $allBarangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id_master_barang); ?>"><?php echo e($b->kd_master_barang); ?> - <?php echo e($b->nm_master_barang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="mb-1 block font-semibold">System Qty *</label>
                <input type="number" name="stok_sistem" min="0" required class="w-full rounded-md border border-outline-variant px-3 py-2">
                <p class="mt-1 text-xs text-on-surface-variant">Jumlah stok tercatat di sistem untuk barang ini pada bin tersebut.</p>
            </div>
            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">
                <button type="button" onclick="closeAddItemModal()" class="rounded-md border border-outline-variant px-4 py-2">Batal</button>
                <button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openAddItemModal(binId) {
        const m = document.getElementById('add-item-modal');
        m.classList.remove('hidden'); m.classList.add('flex');

        const binSelect = document.getElementById('add-item-bin');
        if (binId) {
            binSelect.value = String(binId);
        } else {
            binSelect.value = '';
        }
    }
    function closeAddItemModal() {
        const m = document.getElementById('add-item-modal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }
</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/opname/add-item-modal.blade.php ENDPATH**/ ?>