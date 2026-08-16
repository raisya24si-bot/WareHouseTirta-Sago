<?php $__env->startSection('title', 'Master Barang - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Master Barang'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Master Barang','description' => 'Kelola data barang, stok, kategori, dan satuan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Master Barang','description' => 'Kelola data barang, stok, kategori, dan satuan.']); ?>
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

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('barang.index'),'placeholder' => 'Cari kode atau nama barang...','addAction' => 'openBarangModal()','addText' => 'Barang Baru','filterName' => 'fk_kategori','filterLabel' => 'Kategori','filterOptions' => $categories->map(fn($category) => ['value' => $category->id_master_kategori, 'label' => $category->nm_master_kategori])->all(),'extraHidden' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('barang.index')),'placeholder' => 'Cari kode atau nama barang...','addAction' => 'openBarangModal()','addText' => 'Barang Baru','filterName' => 'fk_kategori','filterLabel' => 'Kategori','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories->map(fn($category) => ['value' => $category->id_master_kategori, 'label' => $category->nm_master_kategori])->all()),'extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
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
    <?php if (isset($component)) { $__componentOriginal38faf6e9f6234414a7fcd18a704730c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38faf6e9f6234414a7fcd18a704730c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.barang.table','data' => ['barangs' => $barangs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.barang.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['barangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($barangs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38faf6e9f6234414a7fcd18a704730c1)): ?>
<?php $attributes = $__attributesOriginal38faf6e9f6234414a7fcd18a704730c1; ?>
<?php unset($__attributesOriginal38faf6e9f6234414a7fcd18a704730c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38faf6e9f6234414a7fcd18a704730c1)): ?>
<?php $component = $__componentOriginal38faf6e9f6234414a7fcd18a704730c1; ?>
<?php unset($__componentOriginal38faf6e9f6234414a7fcd18a704730c1); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $barangs,'label' => 'barang','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($barangs),'label' => 'barang','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php if (isset($component)) { $__componentOriginaldfd7f41d62ce9e6732611930f7a66158 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldfd7f41d62ce9e6732611930f7a66158 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.barang.modal','data' => ['categories' => $categories,'satuans' => $satuans]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.barang.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'satuans' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($satuans)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldfd7f41d62ce9e6732611930f7a66158)): ?>
<?php $attributes = $__attributesOriginaldfd7f41d62ce9e6732611930f7a66158; ?>
<?php unset($__attributesOriginaldfd7f41d62ce9e6732611930f7a66158); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldfd7f41d62ce9e6732611930f7a66158)): ?>
<?php $component = $__componentOriginaldfd7f41d62ce9e6732611930f7a66158; ?>
<?php unset($__componentOriginaldfd7f41d62ce9e6732611930f7a66158); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/master/barang/index.blade.php ENDPATH**/ ?>