<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['barangs']));

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

foreach (array_filter((['barangs']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="overflow-auto custom-scrollbar"><table class="w-full min-w-[1000px] text-left"><thead class="border-b border-outline-variant bg-surface-container-low"><tr><th class="px-4 py-3 text-label-bold text-on-surface-variant">Kode Barang</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Nama Barang</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Kategori</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Satuan</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Min. Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Status Stok</th><th class="px-4 py-3 text-label-bold text-on-surface-variant">Status</th><th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">Aksi</th></tr></thead><tbody class="divide-y divide-outline-variant/50 text-body-sm">
<?php $__empty_1 = true; $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    $stockClass = match($barang->stok_status) {
        'HABIS' => 'bg-red-100 text-red-700',
        'MENIPIS' => 'bg-amber-100 text-amber-700',
        default => 'bg-green-100 text-green-700',
    };
    $accentClass = match($barang->stok_status) {
        'HABIS' => 'border-l-red-500',
        'MENIPIS' => 'border-l-amber-500',
        default => 'border-l-transparent',
    };
?>
<tr class="border-l-[3px] <?php echo e($accentClass); ?> transition hover:bg-surface-container-low/60"><td class="px-4 py-3 font-medium"><?php echo e($barang->kd_master_barang); ?></td><td class="px-4 py-3"><?php echo e($barang->nm_master_barang); ?></td><td class="px-4 py-3 text-on-surface-variant"><?php echo e($barang->kategori?->nm_master_kategori ?? '-'); ?></td><td class="px-4 py-3 text-on-surface-variant"><?php echo e($barang->satuan?->nm_master_satuan ?? '-'); ?></td><td class="px-4 py-3 tabular-nums"><?php echo e(number_format($barang->stok_saat_ini)); ?></td><td class="px-4 py-3 tabular-nums"><?php echo e(number_format($barang->minimum_stok)); ?></td><td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($stockClass); ?>"><?php echo e($barang->stok_status); ?></span></td><td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $barang->status_master_barang === 'AKTIF' ? 'AKTIF' : 'TIDAK AKTIF']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($barang->status_master_barang === 'AKTIF' ? 'AKTIF' : 'TIDAK AKTIF')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $attributes = $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $component = $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?></td><td class="px-4 py-3 text-right"><div class="inline-flex gap-1"><button type="button" onclick="editBarang(<?php echo e($barang->id_master_barang); ?>,<?php echo \Illuminate\Support\Js::from($barang->nm_master_barang)->toHtml() ?>,<?php echo \Illuminate\Support\Js::from($barang->desc_master_barang)->toHtml() ?>,<?php echo e($barang->fk_kategori); ?>,<?php echo e($barang->fk_satuan); ?>,<?php echo \Illuminate\Support\Js::from($barang->status_master_barang)->toHtml() ?>,<?php echo e($barang->stok_saat_ini); ?>,<?php echo e($barang->minimum_stok); ?>)" class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"><span class="material-symbols-outlined text-[20px]">edit</span></button><form method="POST" action="<?php echo e(route('barang.destroy',$barang)); ?>" onsubmit="return confirm('Nonaktifkan barang ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="rounded p-1.5 text-outline transition hover:bg-error/10 hover:text-error"><span class="material-symbols-outlined text-[20px]">delete</span></button></form></div></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="9" class="px-4 py-12 text-center text-on-surface-variant">Belum ada data barang.</td></tr><?php endif; ?>
</tbody></table></div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/master/barang/table.blade.php ENDPATH**/ ?>