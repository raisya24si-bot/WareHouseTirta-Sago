<?php $__env->startSection('title', 'Stock Opname - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Stock Opname'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Stock Opname','description' => 'Kelola sesi hitung fisik stok per gudang dan bin.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stock Opname','description' => 'Kelola sesi hitung fisik stok per gudang dan bin.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5)): ?>
<?php $attributes = $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5; ?>
<?php unset($__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5)): ?>
<?php $component = $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5; ?>
<?php unset($__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5); ?>
<?php endif; ?>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <a href="<?php echo e(route('opname.index', ['status' => 'ONGOING'])); ?>" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Ongoing Opnames</p>
        <p class="text-2xl font-bold"><?php echo e($summary['ongoing']); ?></p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-primary">Lihat detail <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
    <a href="<?php echo e(route('opname.index', ['status' => 'ONGOING', 'issue' => 1])); ?>" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Discrepancies Found</p>
        <p class="text-2xl font-bold"><?php echo e($summary['discrepancies']); ?></p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-orange-700">Perlu ditinjau <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
    <a href="<?php echo e(route('opname.index', ['status' => 'COMPLETED'])); ?>" class="block rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Completed this Month</p>
        <p class="text-2xl font-bold"><?php echo e($summary['completed_this_month']); ?></p>
        <p class="mt-2 inline-flex items-center gap-1 text-xs font-label-bold text-green-700">Lihat riwayat <span class="material-symbols-outlined text-[16px]">arrow_forward</span></p>
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('opname.index'),'placeholder' => 'Cari kode opname atau gudang...','addAction' => 'openOpnameModal()','addText' => 'Create New Opname','filterName' => 'status','filterLabel' => 'Status','filterOptions' => [['value' => 'ONGOING', 'label' => 'Ongoing'], ['value' => 'COMPLETED', 'label' => 'Completed']],'extraHidden' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('opname.index')),'placeholder' => 'Cari kode opname atau gudang...','addAction' => 'openOpnameModal()','addText' => 'Create New Opname','filterName' => 'status','filterLabel' => 'Status','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['value' => 'ONGOING', 'label' => 'Ongoing'], ['value' => 'COMPLETED', 'label' => 'Completed']]),'extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8)): ?>
<?php $attributes = $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8; ?>
<?php unset($__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal399821676c4282dd8c2aaef10a9bfaf8)): ?>
<?php $component = $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8; ?>
<?php unset($__componentOriginal399821676c4282dd8c2aaef10a9bfaf8); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal13c78651412e64fcf4413fb4746ee6e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13c78651412e64fcf4413fb4746ee6e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.table','data' => ['opnames' => $opnames]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['opnames' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opnames)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13c78651412e64fcf4413fb4746ee6e9)): ?>
<?php $attributes = $__attributesOriginal13c78651412e64fcf4413fb4746ee6e9; ?>
<?php unset($__attributesOriginal13c78651412e64fcf4413fb4746ee6e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13c78651412e64fcf4413fb4746ee6e9)): ?>
<?php $component = $__componentOriginal13c78651412e64fcf4413fb4746ee6e9; ?>
<?php unset($__componentOriginal13c78651412e64fcf4413fb4746ee6e9); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $opnames,'label' => 'opname','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opnames),'label' => 'opname','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27cf80496510f134775277283842cfa5)): ?>
<?php $attributes = $__attributesOriginal27cf80496510f134775277283842cfa5; ?>
<?php unset($__attributesOriginal27cf80496510f134775277283842cfa5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27cf80496510f134775277283842cfa5)): ?>
<?php $component = $__componentOriginal27cf80496510f134775277283842cfa5; ?>
<?php unset($__componentOriginal27cf80496510f134775277283842cfa5); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
<?php if (isset($component)) { $__componentOriginal3624506249b2e6901fb7de94fb9540ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3624506249b2e6901fb7de94fb9540ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.create-modal','data' => ['gudangs' => $gudangs,'lokasis' => $lokasis]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.create-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['gudangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($gudangs),'lokasis' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lokasis)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3624506249b2e6901fb7de94fb9540ca)): ?>
<?php $attributes = $__attributesOriginal3624506249b2e6901fb7de94fb9540ca; ?>
<?php unset($__attributesOriginal3624506249b2e6901fb7de94fb9540ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3624506249b2e6901fb7de94fb9540ca)): ?>
<?php $component = $__componentOriginal3624506249b2e6901fb7de94fb9540ca; ?>
<?php unset($__componentOriginal3624506249b2e6901fb7de94fb9540ca); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/opname/index.blade.php ENDPATH**/ ?>