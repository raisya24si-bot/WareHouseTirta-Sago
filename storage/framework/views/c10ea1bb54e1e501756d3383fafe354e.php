<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items', 'label' => 'data']));

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

foreach (array_filter((['items', 'label' => 'data']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if($items->hasPages()): ?>
<div class="flex flex-wrap items-center justify-between gap-3 border-t border-outline-variant bg-surface-container-low px-4 py-3 text-sm text-on-surface-variant">
    <span>Menampilkan <?php echo e($items->firstItem()); ?> - <?php echo e($items->lastItem()); ?> dari <?php echo e($items->total()); ?> <?php echo e($label); ?></span>
    <div class="flex items-center gap-1">
        <?php if($items->onFirstPage()): ?><span class="flex h-8 w-8 items-center justify-center opacity-40"><span class="material-symbols-outlined">chevron_left</span></span><?php else: ?><a href="<?php echo e($items->previousPageUrl()); ?>" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant"><span class="material-symbols-outlined">chevron_left</span></a><?php endif; ?>
        <?php $__currentLoopData = $items->getUrlRange(max(1,$items->currentPage()-2),min($items->lastPage(),$items->currentPage()+2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page=>$url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($page==$items->currentPage()): ?><span class="flex h-8 w-8 items-center justify-center rounded bg-primary text-on-primary"><?php echo e($page); ?></span><?php else: ?><a href="<?php echo e($url); ?>" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant"><?php echo e($page); ?></a><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($items->hasMorePages()): ?><a href="<?php echo e($items->nextPageUrl()); ?>" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant"><span class="material-symbols-outlined">chevron_right</span></a><?php else: ?><span class="flex h-8 w-8 items-center justify-center opacity-40"><span class="material-symbols-outlined">chevron_right</span></span><?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_REBUILT_CLEAN_FIXED\MasterData\resources\views/components/master/shared/pagination.blade.php ENDPATH**/ ?>