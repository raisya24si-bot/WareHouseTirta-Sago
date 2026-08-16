<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['lokasis']));

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

foreach (array_filter((['lokasis']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?><div class="overflow-auto"><table class="w-full min-w-[900px] text-left"><thead class="border-b border-outline-variant bg-surface-container-low"><tr><th class="px-5 py-3 text-label-bold">Kode Lokasi</th><th class="px-5 py-3 text-label-bold">Rak</th><th class="px-5 py-3 text-label-bold">Row</th><th class="px-5 py-3 text-label-bold">Bin</th><th class="px-5 py-3 text-label-bold">Status</th><th class="px-5 py-3 text-right text-label-bold">Aksi</th></tr></thead><tbody class="divide-y divide-outline-variant/50"><?php $__empty_1 = true; $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr class="hover:bg-surface-container-low/50"><td class="px-5 py-4"><?php echo e($l->kd_lokasi); ?></td><td class="px-5 py-4"><?php echo e($l->row?->rak?->kd_rak ?? '-'); ?></td><td class="px-5 py-4"><?php echo e($l->row?->kd_row ?? '-'); ?></td><td class="px-5 py-4"><span class="rounded-md bg-surface-container-high px-2 py-1 text-xs font-label-bold"><?php echo e($l->bin); ?></span></td><td class="px-5 py-4"><?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $l->status_lokasi]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($l->status_lokasi)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $attributes = $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $component = $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?></td><td class="px-5 py-4 text-right"><div class="inline-flex gap-1"><button type="button" onclick="editLokasi(<?php echo e($l->id_lokasi); ?>,<?php echo \Illuminate\Support\Js::from($l->status_lokasi)->toHtml() ?>)" class="p-1 text-outline hover:text-primary"><span class="material-symbols-outlined">edit</span></button><form method="POST" action="<?php echo e(route('struktur-lokasi.destroy',$l)); ?>" onsubmit="return confirm('Hapus struktur lokasi ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="p-1 text-outline hover:text-error"><span class="material-symbols-outlined">delete</span></button></form></div></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6" class="px-5 py-12 text-center text-on-surface-variant">Belum ada struktur lokasi.</td></tr><?php endif; ?></tbody></table></div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/master/gudang/lokasi-table.blade.php ENDPATH**/ ?>