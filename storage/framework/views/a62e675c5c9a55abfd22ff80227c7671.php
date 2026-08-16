<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['opnames']));

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

foreach (array_filter((['opnames']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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
    <th class="px-5 py-3 text-label-bold">Kode Opname</th>
    <th class="px-5 py-3 text-label-bold">Gudang</th>
    <th class="px-5 py-3 text-label-bold">Tgl Mulai</th>
    <th class="px-5 py-3 text-label-bold">Progress</th>
    <th class="px-5 py-3 text-label-bold">Status</th>
    <th class="px-5 py-3 text-right text-label-bold">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/50">
<?php $__empty_1 = true; $__currentLoopData = $opnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    $total = $o->details_count ?? 0;
    $counted = $o->details_counted_count ?? 0;
    $progress = $total > 0 ? (int) round(($counted / $total) * 100) : 0;
    $hasSelisih = ($o->details_selisih_count ?? 0) > 0;
?>
<tr class="hover:bg-surface-container-low/50">
    <td class="px-5 py-4">
        <a href="<?php echo e(route('opname.show', $o)); ?>" class="font-label-bold text-primary hover:underline">
            <?php echo e($o->kd_opname); ?>

        </a>
        <?php if($hasSelisih): ?>
            <span class="material-symbols-outlined align-middle text-[16px] text-orange-600 ml-1" title="Ada selisih, perlu ditinjau">warning</span>
        <?php endif; ?>
    </td>
    <td class="px-5 py-4"><?php echo e($o->gudang?->nm_gudang ?? '-'); ?></td>
    <td class="px-5 py-4"><?php echo e($o->tgl_mulai?->format('d M Y')); ?></td>
    <td class="px-5 py-4">
        <div class="flex items-center gap-2">
            <div class="h-2 w-32 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-2 rounded-full <?php echo e($hasSelisih ? 'bg-orange-500' : 'bg-primary'); ?>" style="width: <?php echo e($progress); ?>%"></div>
            </div>
            <span class="text-sm text-on-surface-variant"><?php echo e($progress); ?>%</span>
        </div>
    </td>
    <td class="px-5 py-4"><?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $o->status_opname]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($o->status_opname)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $attributes = $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $component = $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?></td>
    <td class="px-5 py-4 text-right">
        <div class="inline-flex gap-1">
            <a href="<?php echo e(route('opname.show', $o)); ?>" class="p-1 text-outline hover:text-primary" title="Lihat / Hitung">
                <span class="material-symbols-outlined">visibility</span>
            </a>
            <form method="POST" action="<?php echo e(route('opname.destroy', $o)); ?>" onsubmit="return confirm('Hapus opname ini?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="p-1 text-outline hover:text-error"><span class="material-symbols-outlined">delete</span></button>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="6" class="px-5 py-12 text-center text-on-surface-variant">Belum ada data stock opname.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/opname/table.blade.php ENDPATH**/ ?>