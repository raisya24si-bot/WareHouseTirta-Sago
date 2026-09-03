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
    $classes = match (true) {
        in_array($value, ['AKTIF', 'ONGOING']) => 'bg-blue-100 text-primary',
        in_array($value, ['MAINTENANCE', 'SELISIH']) => 'bg-orange-100 text-orange-800',
        in_array($value, ['COMPLETED', 'SESUAI', 'APPROVED']) => 'bg-green-100 text-green-800',
        str_starts_with($value, 'PENDING') => 'bg-amber-100 text-amber-800',
        $value === 'REJECTED' => 'bg-red-100 text-red-700',
        $value === 'DRAFT' => 'bg-gray-100 text-gray-700',
        default => 'bg-gray-100 text-gray-700',
    };
    $dot = match (true) {
        in_array($value, ['AKTIF', 'ONGOING']) => 'bg-primary',
        in_array($value, ['MAINTENANCE', 'SELISIH']) => 'bg-orange-700',
        in_array($value, ['COMPLETED', 'SESUAI', 'APPROVED']) => 'bg-green-700',
        str_starts_with($value, 'PENDING') => 'bg-amber-600',
        $value === 'REJECTED' => 'bg-red-600',
        default => 'bg-gray-500',
    };
    $label = match ($value) {
        'PENDING_KASUBAG' => 'Pending Kasubag',
        'PENDING_KABAG' => 'Pending Kabag',
        'PENDING_DIREKTUR' => 'Pending Direktur',
        default => $status,
    };
?>
<span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm <?php echo e($classes); ?>">
    <span class="h-2 w-2 rounded-full <?php echo e($dot); ?>"></span><?php echo e($label); ?>

</span><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/master/shared/status-badge.blade.php ENDPATH**/ ?>