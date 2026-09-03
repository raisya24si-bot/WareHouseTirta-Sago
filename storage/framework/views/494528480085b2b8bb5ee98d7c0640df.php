<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['action', 'placeholder' => 'Cari...', 'filterName' => null, 'filterOptions' => [], 'filterLabel' => 'Filter']));

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

foreach (array_filter((['action', 'placeholder' => 'Cari...', 'filterName' => null, 'filterOptions' => [], 'filterLabel' => 'Filter']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="flex flex-wrap items-center gap-2">
    <form method="GET" action="<?php echo e($action); ?>" class="flex items-center">
        <?php $__currentLoopData = request()->except(['search','page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_scalar($value) && $value !== ''): ?><input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>"><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center overflow-hidden rounded-md border border-outline-variant bg-surface">
            <span class="material-symbols-outlined px-3 text-outline text-[20px]">search</span>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="w-64 border-none bg-transparent py-2 pl-0 pr-3 text-body-sm focus:ring-0" placeholder="<?php echo e($placeholder); ?>">
        </div>
    </form>
    <?php if($filterName): ?>
        <button type="button" onclick="document.getElementById('<?php echo e($filterName); ?>-filter').classList.toggle('hidden')" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2 font-label-bold hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">filter_list</span><?php echo e($filterLabel); ?>

        </button>
    <?php endif; ?>
</div>
<?php if($filterName): ?>
<div id="<?php echo e($filterName); ?>-filter" class="<?php echo e(request($filterName) ? '' : 'hidden'); ?> mt-3 w-full rounded-lg border border-outline-variant bg-white p-3">
    <form method="GET" action="<?php echo e($action); ?>" class="flex flex-wrap items-end gap-3">
        <?php if(request('search')): ?><input type="hidden" name="search" value="<?php echo e(request('search')); ?>"><?php endif; ?>
        <?php $__currentLoopData = request()->except(['search','page',$filterName]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_scalar($value) && $value !== ''): ?><input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>"><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div><label class="mb-1 block text-sm font-semibold"><?php echo e($filterLabel); ?></label><select name="<?php echo e($filterName); ?>" class="rounded-md border border-outline-variant bg-white px-3 py-2"><option value="">Semua</option><?php $__currentLoopData = $filterOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($option['value']); ?>" <?php if((string)request($filterName)===(string)$option['value']): echo 'selected'; endif; ?>><?php echo e($option['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <button class="rounded-md bg-primary px-4 py-2 font-label-bold text-on-primary">Terapkan</button>
        <a href="<?php echo e($action); ?>" class="rounded-md border border-outline-variant px-4 py-2">Reset</a>
    </form>
</div>
<?php endif; ?>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/master/shared/search-filter.blade.php ENDPATH**/ ?>