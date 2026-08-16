<?php $__env->startSection('title', 'Master Satuan - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Master Satuan'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Master Satuan','description' => 'Kelola kode, nama, deskripsi, dan status satuan barang.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Master Satuan','description' => 'Kelola kode, nama, deskripsi, dan status satuan barang.']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-satuan.index'),'placeholder' => 'Cari kode atau nama satuan...','addAction' => 'openSatuanModal()','addText' => 'Satuan Baru','extraHidden' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-satuan.index')),'placeholder' => 'Cari kode atau nama satuan...','addAction' => 'openSatuanModal()','addText' => 'Satuan Baru','extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
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
    <?php if (isset($component)) { $__componentOriginala2ae341c247df528dcb846feee7a8ce3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2ae341c247df528dcb846feee7a8ce3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.satuan.table','data' => ['satuans' => $satuans]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.satuan.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['satuans' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($satuans)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2ae341c247df528dcb846feee7a8ce3)): ?>
<?php $attributes = $__attributesOriginala2ae341c247df528dcb846feee7a8ce3; ?>
<?php unset($__attributesOriginala2ae341c247df528dcb846feee7a8ce3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2ae341c247df528dcb846feee7a8ce3)): ?>
<?php $component = $__componentOriginala2ae341c247df528dcb846feee7a8ce3; ?>
<?php unset($__componentOriginala2ae341c247df528dcb846feee7a8ce3); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $satuans,'label' => 'satuan','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($satuans),'label' => 'satuan','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php if (isset($component)) { $__componentOriginalb9020a87c19c67a9c5db932d820402d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9020a87c19c67a9c5db932d820402d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.satuan.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.satuan.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9020a87c19c67a9c5db932d820402d8)): ?>
<?php $attributes = $__attributesOriginalb9020a87c19c67a9c5db932d820402d8; ?>
<?php unset($__attributesOriginalb9020a87c19c67a9c5db932d820402d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9020a87c19c67a9c5db932d820402d8)): ?>
<?php $component = $__componentOriginalb9020a87c19c67a9c5db932d820402d8; ?>
<?php unset($__componentOriginalb9020a87c19c67a9c5db932d820402d8); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/master/satuan/index.blade.php ENDPATH**/ ?>