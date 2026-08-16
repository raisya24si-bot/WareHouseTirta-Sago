<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['details', 'emptyBins' => null, 'opname']));

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

foreach (array_filter((['details', 'emptyBins' => null, 'opname']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="overflow-auto">
<table class="w-full min-w-[1000px] text-left">
<thead class="border-b border-outline-variant bg-surface-container-low">
<tr>
    <th class="px-4 py-3 text-label-bold">Status</th>
    <th class="px-4 py-3 text-label-bold">Bin</th>
    <th class="px-4 py-3 text-label-bold">Item Code</th>
    <th class="px-4 py-3 text-label-bold">Description</th>
    <th class="px-4 py-3 text-label-bold">System Qty</th>
    <th class="px-4 py-3 text-label-bold">Actual Qty</th>
    <th class="px-4 py-3 text-label-bold">Diff</th>
    <th class="px-4 py-3 text-right text-label-bold">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/50">
<?php if($emptyBins): ?>
<?php $__currentLoopData = $emptyBins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="bg-gray-50/60">
    <td class="px-4 py-3">
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500" title="Bin kosong"><span class="material-symbols-outlined text-[18px]">inbox</span></span>
    </td>
    <td class="px-4 py-3">
        <span class="rounded-md bg-surface-container-high px-2 py-1 text-xs font-label-bold"><?php echo e($eb->bin); ?></span>
    </td>
    <td colspan="4" class="px-4 py-3 italic text-on-surface-variant">[Empty Bin] Belum ada barang tercatat di lokasi ini.</td>
    <td class="px-4 py-3 text-right" colspan="2">
        <button type="button" onclick="openAddItemModal(<?php echo e($eb->id_lokasi); ?>)" class="inline-flex items-center gap-1 rounded-md bg-primary px-3 py-1.5 text-xs font-label-bold text-on-primary hover:bg-primary-container">
            <span class="material-symbols-outlined text-[16px]">add</span>
            Add Item
        </button>
        <form method="POST" action="<?php echo e(route('opname.delete-bin', [$opname, $eb])); ?>" class="inline" onsubmit="return confirm('Keluarkan bin ' + '<?php echo e($eb->bin); ?>' + ' dari opname ini?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="ml-1 inline-flex items-center gap-1 rounded-md border border-outline-variant px-3 py-1.5 text-xs font-label-bold text-error hover:bg-red-50" title="Keluarkan bin ini dari opname">
                <span class="material-symbols-outlined text-[16px]">delete</span>
            </button>
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
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
            form="opname-detail-form"
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
    <td class="px-4 py-3 text-right">
        <div class="inline-flex items-center gap-1">
            <button type="button"
                onclick="openEditItemModal(<?php echo e($d->id_opname_detail); ?>, <?php echo e($d->stok_sistem); ?>, <?php echo \Illuminate\Support\Js::from($d->keterangan)->toHtml() ?>)"
                class="p-1 text-outline hover:text-primary" title="Edit barang">
                <span class="material-symbols-outlined text-[18px]">edit</span>
            </button>
            <?php if($d->stok_aktual === null): ?>
            <form method="POST" action="<?php echo e(route('opname.delete-item', [$opname, $d])); ?>" onsubmit="return confirm('Hapus barang ini dari opname?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="p-1 text-outline hover:text-error" title="Hapus dari opname">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>
            </form>
            <?php else: ?>
            <span class="p-1 text-outline/40" title="Sudah dihitung, tidak bisa dihapus">
                <span class="material-symbols-outlined text-[18px]">lock</span>
            </span>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php if(!$emptyBins || $emptyBins->isEmpty()): ?>
    <tr><td colspan="8" class="px-4 py-12 text-center text-on-surface-variant">Belum ada barang tercatat pada bin yang dipilih. Klik "Tambah Barang" untuk mulai mencatat.</td></tr>
    <?php endif; ?>
<?php endif; ?>
</tbody>
</table>
</div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/opname/detail-table.blade.php ENDPATH**/ ?>