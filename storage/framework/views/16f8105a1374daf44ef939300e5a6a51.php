<?php $__env->startSection('title', 'Master Kategori - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Master Kategori'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Master Kategori','description' => 'Kelola kode, nama, deskripsi, dan status kategori barang.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Master Kategori','description' => 'Kelola kode, nama, deskripsi, dan status kategori barang.']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-kategori.index'),'placeholder' => 'Cari kode atau nama kategori...','addAction' => 'openKategoriModal()','addText' => 'Kategori Baru','extraHidden' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-kategori.index')),'placeholder' => 'Cari kode atau nama kategori...','addAction' => 'openKategoriModal()','addText' => 'Kategori Baru','extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
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
    <?php if (isset($component)) { $__componentOriginal60528e11d540e1f640fa2bfafcc0fb6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal60528e11d540e1f640fa2bfafcc0fb6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.kategori.table','data' => ['categories' => $categories]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.kategori.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal60528e11d540e1f640fa2bfafcc0fb6f)): ?>
<?php $attributes = $__attributesOriginal60528e11d540e1f640fa2bfafcc0fb6f; ?>
<?php unset($__attributesOriginal60528e11d540e1f640fa2bfafcc0fb6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal60528e11d540e1f640fa2bfafcc0fb6f)): ?>
<?php $component = $__componentOriginal60528e11d540e1f640fa2bfafcc0fb6f; ?>
<?php unset($__componentOriginal60528e11d540e1f640fa2bfafcc0fb6f); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $categories,'label' => 'kategori']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'label' => 'kategori']); ?>
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
<?php if (isset($component)) { $__componentOriginalbe22389eda27396c6a61e688ae9f0f09 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe22389eda27396c6a61e688ae9f0f09 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.kategori.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.kategori.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe22389eda27396c6a61e688ae9f0f09)): ?>
<?php $attributes = $__attributesOriginalbe22389eda27396c6a61e688ae9f0f09; ?>
<?php unset($__attributesOriginalbe22389eda27396c6a61e688ae9f0f09); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe22389eda27396c6a61e688ae9f0f09)): ?>
<?php $component = $__componentOriginalbe22389eda27396c6a61e688ae9f0f09; ?>
<?php unset($__componentOriginalbe22389eda27396c6a61e688ae9f0f09); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_REBUILT_CLEAN_FIXED\MasterData\resources\views/master/kategori/index.blade.php ENDPATH**/ ?>