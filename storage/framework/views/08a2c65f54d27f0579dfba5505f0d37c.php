<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['details']));

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

foreach (array_filter((['details']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="overflow-auto">
<table class="w-full min-w-[900px] text-left">
<thead class="border-b border-outline-variant bg-surface-container-low">
<tr>
    <th class="px-4 py-3 text-label-bold">Status</th>
    <th class="px-4 py-3 text-label-bold">Bin</th>
    <th class="px-4 py-3 text-label-bold">Item Code</th>
    <th class="px-4 py-3 text-label-bold">Description</th>
    <th class="px-4 py-3 text-label-bold">System Qty</th>
    <th class="px-4 py-3 text-label-bold">Actual Qty</th>
    <th class="px-4 py-3 text-label-bold">Diff</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/50">
<?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="hover:bg-surface-container-low/50 <?php echo e($d->status_item === 'SELISIH' ? 'bg-orange-50/50' : ''); ?>" id="detail-row-<?php echo e($d->id_opname_detail); ?>">
    <td class="px-4 py-3">
        <span id="detail-icon-<?php echo e($d->id_opname_detail); ?>">
            <?php if($d->status_item === 'SESUAI'): ?>
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-white" title="Sesuai"><span class="material-symbols-outlined text-[18px]">check</span></span>
            <?php elseif($d->status_item === 'SELISIH'): ?>
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-100 text-orange-700" title="Ada selisih"><span class="material-symbols-outlined text-[18px]">warning</span></span>
            <?php else: ?>
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500" title="Belum dihitung"><span class="material-symbols-outlined text-[18px]">more_horiz</span></span>
            <?php endif; ?>
        </span>
    </td>
    <td class="px-4 py-3">
        <span class="rounded-md bg-surface-container-high px-2 py-1 text-xs font-label-bold"><?php echo e($d->lokasi?->bin ?? '-'); ?></span>
    </td>
    <td class="px-4 py-3"><?php echo e($d->barang?->kd_master_barang ?? '-'); ?></td>
    <td class="px-4 py-3"><?php echo e($d->barang?->nm_master_barang ?? '-'); ?></td>
    <td class="px-4 py-3 text-on-surface-variant"><?php echo e($d->stok_sistem); ?></td>
    <td class="px-4 py-3">
        <input
            type="number"
            min="0"
            name="detail[<?php echo e($d->id_opname_detail); ?>]"
            value="<?php echo e($d->stok_aktual); ?>"
            data-sistem="<?php echo e($d->stok_sistem); ?>"
            oninput="opnameDetailRecalc(<?php echo e($d->id_opname_detail); ?>)"
            placeholder="Enter"
            class="w-24 rounded-md border px-3 py-1.5 <?php echo e($d->status_item === 'SELISIH' ? 'border-error' : 'border-outline-variant'); ?>"
        >
    </td>
    <td class="px-4 py-3">
        <span id="detail-diff-<?php echo e($d->id_opname_detail); ?>" class="font-label-bold <?php echo e($d->selisih === null ? 'text-on-surface-variant' : ($d->selisih === 0 ? 'text-green-700' : 'text-error')); ?>">
            <?php echo e($d->selisih === null ? '--' : ($d->selisih > 0 ? '+' . $d->selisih : $d->selisih)); ?>

        </span>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="7" class="px-4 py-12 text-center text-on-surface-variant">Belum ada barang tercatat pada bin yang dipilih. Klik "Tambah Barang" untuk mulai mencatat.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/opname/detail-table.blade.php ENDPATH**/ ?>