<?php $__env->startSection('title', 'Master Supplier - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Master Supplier'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Master Supplier','description' => 'Kelola data supplier barang dan statusnya.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Master Supplier','description' => 'Kelola data supplier barang dan statusnya.']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-supplier.index'),'placeholder' => 'Cari kode, nama, atau kontak supplier...','addAction' => 'openSupplierModal()','addText' => 'Supplier Baru','filterName' => 'status','filterLabel' => 'Status','filterOptions' => [['value' => 'AKTIF', 'label' => 'AKTIF'], ['value' => 'TIDAK AKTIF', 'label' => 'TIDAK AKTIF']],'extraHidden' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-supplier.index')),'placeholder' => 'Cari kode, nama, atau kontak supplier...','addAction' => 'openSupplierModal()','addText' => 'Supplier Baru','filterName' => 'status','filterLabel' => 'Status','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['value' => 'AKTIF', 'label' => 'AKTIF'], ['value' => 'TIDAK AKTIF', 'label' => 'TIDAK AKTIF']]),'extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
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
    <?php if (isset($component)) { $__componentOriginal7f2e7ff7035a57e5913d0698da54bf92 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f2e7ff7035a57e5913d0698da54bf92 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.supplier.table','data' => ['suppliers' => $suppliers]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.supplier.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['suppliers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suppliers)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f2e7ff7035a57e5913d0698da54bf92)): ?>
<?php $attributes = $__attributesOriginal7f2e7ff7035a57e5913d0698da54bf92; ?>
<?php unset($__attributesOriginal7f2e7ff7035a57e5913d0698da54bf92); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f2e7ff7035a57e5913d0698da54bf92)): ?>
<?php $component = $__componentOriginal7f2e7ff7035a57e5913d0698da54bf92; ?>
<?php unset($__componentOriginal7f2e7ff7035a57e5913d0698da54bf92); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $suppliers,'label' => 'supplier','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($suppliers),'label' => 'supplier','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php if (isset($component)) { $__componentOriginal507998ff280b49245f5282f22acea41d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal507998ff280b49245f5282f22acea41d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.supplier.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.supplier.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal507998ff280b49245f5282f22acea41d)): ?>
<?php $attributes = $__attributesOriginal507998ff280b49245f5282f22acea41d; ?>
<?php unset($__attributesOriginal507998ff280b49245f5282f22acea41d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal507998ff280b49245f5282f22acea41d)): ?>
<?php $component = $__componentOriginal507998ff280b49245f5282f22acea41d; ?>
<?php unset($__componentOriginal507998ff280b49245f5282f22acea41d); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/master/supplier/index.blade.php ENDPATH**/ ?>