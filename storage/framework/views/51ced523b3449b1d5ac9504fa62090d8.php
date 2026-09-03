<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tab']));

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

foreach (array_filter((['tab']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="flex items-center gap-1 border-b border-outline-variant">
<?php $__currentLoopData = [['gudang','warehouse','Daftar Gudang'],['rak','shelves','Daftar Rak'],['row','view_column','Daftar Row'],['lokasi','account_tree','Struktur Lokasi']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$key,$icon,$label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<a href="<?php echo e(route('master-gudang.index',['tab'=>$key])); ?>" class="inline-flex items-center gap-2 border-b-2 px-4 py-3 font-label-bold <?php echo e($tab===$key ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:border-outline hover:text-primary'); ?>"><span class="material-symbols-outlined text-[21px]"><?php echo e($icon); ?></span><?php echo e($label); ?></a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/master/gudang/tabs.blade.php ENDPATH**/ ?>