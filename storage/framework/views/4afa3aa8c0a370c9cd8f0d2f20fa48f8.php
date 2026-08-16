<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action',
    'placeholder' => 'Cari...',
    'addAction' => null,
    'addText' => 'Tambah Data',
    'filterName' => null,
    'filterOptions' => [],
    'filterLabel' => 'Filter',
    'extraHidden' => [],
]));

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

foreach (array_filter(([
    'action',
    'placeholder' => 'Cari...',
    'addAction' => null,
    'addText' => 'Tambah Data',
    'filterName' => null,
    'filterOptions' => [],
    'filterLabel' => 'Filter',
    'extraHidden' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low/50 p-4">
    <div class="flex flex-wrap items-center gap-2">
        <form method="GET" action="<?php echo e($action); ?>" class="flex items-center">
            <?php $__currentLoopData = $extraHidden; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($value !== null && $value !== ''): ?>
                    <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($filterName && request($filterName) !== null && request($filterName) !== ''): ?>
                <input type="hidden" name="<?php echo e($filterName); ?>" value="<?php echo e(request($filterName)); ?>">
            <?php endif; ?>
            <div class="flex items-center overflow-hidden rounded-md border border-outline-variant bg-white">
                <span class="material-symbols-outlined px-3 text-outline text-[20px]">search</span>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="<?php echo e($placeholder); ?>"
                    class="w-64 border-none bg-transparent py-2 pl-0 pr-3 text-body-sm focus:ring-0"
                >
            </div>
        </form>

        <?php if($filterName): ?>
            <button
                type="button"
                onclick="document.getElementById('<?php echo e($filterName); ?>-filter').classList.toggle('hidden')"
                class="inline-flex items-center gap-2 rounded-md border border-outline-variant bg-white px-4 py-2 text-body-sm hover:bg-surface-container-low"
            >
                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                <?php echo e($filterLabel); ?>

            </button>

            <form method="GET" action="<?php echo e($action); ?>" id="<?php echo e($filterName); ?>-filter" class="<?php echo e(request($filterName) ? '' : 'hidden'); ?> flex items-center gap-2">
                <?php $__currentLoopData = $extraHidden; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($value !== null && $value !== ''): ?>
                        <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                <select name="<?php echo e($filterName); ?>" onchange="this.form.submit()" class="rounded-md border border-outline-variant bg-white px-3 py-2 text-body-sm">
                    <option value="">Semua <?php echo e($filterLabel); ?></option>
                    <?php $__currentLoopData = $filterOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option['value']); ?>" <?php if((string) request($filterName) === (string) $option['value']): echo 'selected'; endif; ?>>
                            <?php echo e($option['label']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        <?php endif; ?>
    </div>

    <?php if($addAction): ?>
        <button
            type="button"
            onclick="<?php echo e($addAction); ?>"
            class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-body-sm font-label-bold text-on-primary shadow-sm hover:bg-primary-container"
        >
            <span class="material-symbols-outlined text-[19px]">add</span>
            <?php echo e($addText); ?>

        </button>
    <?php endif; ?>
</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_REBUILT_CLEAN_FIXED\MasterData\resources\views/components/master/shared/crud-toolbar.blade.php ENDPATH**/ ?>