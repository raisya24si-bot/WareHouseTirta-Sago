<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $value = strtoupper((string) $status);
    $classes = match ($value) {
        'AKTIF', 'ONGOING' => 'bg-blue-100 text-primary',
        'MAINTENANCE', 'SELISIH' => 'bg-orange-100 text-orange-800',
        'COMPLETED', 'SESUAI' => 'bg-green-100 text-green-800',
        default => 'bg-gray-100 text-gray-700',
    };
    $dot = match ($value) {
        'AKTIF', 'ONGOING' => 'bg-primary',
        'MAINTENANCE', 'SELISIH' => 'bg-orange-700',
        'COMPLETED', 'SESUAI' => 'bg-green-700',
        default => 'bg-gray-500',
    };
?>
<span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm <?php echo e($classes); ?>">
    <span class="h-2 w-2 rounded-full <?php echo e($dot); ?>"></span><?php echo e($status); ?>

</span>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/master/shared/status-badge.blade.php ENDPATH**/ ?>