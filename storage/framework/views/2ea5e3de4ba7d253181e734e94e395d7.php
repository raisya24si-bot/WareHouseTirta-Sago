<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'description', 'actionText' => null, 'action' => null]));

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

foreach (array_filter((['title', 'description', 'actionText' => null, 'action' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-display-lg font-display-lg text-on-surface leading-tight"><?php echo e($title); ?></h1>
        <p class="mt-1 text-body-lg text-on-surface-variant"><?php echo e($description); ?></p>
    </div>
    <?php if($actionText && $action): ?>
        <button type="button" onclick="<?php echo e($action); ?>" class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm hover:bg-primary-container">
            <span class="material-symbols-outlined text-[20px]">add</span><?php echo e($actionText); ?>

        </button>
    <?php endif; ?>
</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/master/shared/page-header.blade.php ENDPATH**/ ?>