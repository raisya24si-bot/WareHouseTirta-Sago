<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label', 'value', 'icon' => 'insights', 'color' => 'primary']));

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

foreach (array_filter((['label', 'value', 'icon' => 'insights', 'color' => 'primary']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $palette = match ($color) {
        'red' => [
            'bg' => 'bg-red-50',
            'ring' => 'ring-red-100',
            'icon' => 'bg-red-100 text-red-700',
            'value' => 'text-red-700',
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'ring' => 'ring-amber-100',
            'icon' => 'bg-amber-100 text-amber-700',
            'value' => 'text-amber-700',
        ],
        'green' => [
            'bg' => 'bg-green-50',
            'ring' => 'ring-green-100',
            'icon' => 'bg-green-100 text-green-700',
            'value' => 'text-green-700',
        ],
        default => [
            'bg' => 'bg-blue-50',
            'ring' => 'ring-blue-100',
            'icon' => 'bg-primary/10 text-primary',
            'value' => 'text-primary',
        ],
    };
?>

<div class="group flex items-center gap-4 rounded-xl border border-outline-variant <?php echo e($palette['bg']); ?> p-4 shadow-sm ring-1 <?php echo e($palette['ring']); ?> transition duration-150 hover:-translate-y-0.5 hover:shadow-md">

    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg <?php echo e($palette['icon']); ?> transition group-hover:scale-105">
        <span class="material-symbols-outlined text-[22px]"><?php echo e($icon); ?></span>
    </div>

    <div class="min-w-0">
        <p class="text-xs font-medium text-on-surface-variant"><?php echo e($label); ?></p>
        <p class="text-2xl font-bold tabular-nums <?php echo e($palette['value']); ?>"><?php echo e($value); ?></p>
    </div>

</div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/master/shared/stat-card.blade.php ENDPATH**/ ?>