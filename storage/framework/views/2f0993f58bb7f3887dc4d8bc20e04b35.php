<?php $__env->startSection('title', 'Master Gudang - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Master Gudang'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Master Gudang','description' => 'Kelola gudang dan struktur lokasi penyimpanan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Master Gudang','description' => 'Kelola gudang dan struktur lokasi penyimpanan.']); ?>
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

<?php if (isset($component)) { $__componentOriginaled834df5b17e89f08eeb17155830cd60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled834df5b17e89f08eeb17155830cd60 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.tabs','data' => ['tab' => $tab]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tab)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled834df5b17e89f08eeb17155830cd60)): ?>
<?php $attributes = $__attributesOriginaled834df5b17e89f08eeb17155830cd60; ?>
<?php unset($__attributesOriginaled834df5b17e89f08eeb17155830cd60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled834df5b17e89f08eeb17155830cd60)): ?>
<?php $component = $__componentOriginaled834df5b17e89f08eeb17155830cd60; ?>
<?php unset($__componentOriginaled834df5b17e89f08eeb17155830cd60); ?>
<?php endif; ?>

<div class="mt-8">
    <?php if($tab === 'gudang'): ?>
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-gudang.index'),'placeholder' => 'Cari kode atau nama gudang...','addAction' => 'openGudangModal()','addText' => 'Gudang Baru','filterName' => 'status','filterLabel' => 'Status','filterOptions' => $statuses->map(fn($s) => ['value' => $s->id_status_gudang, 'label' => $s->nm_status_gudang])->all(),'extraHidden' => ['tab' => 'gudang']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-gudang.index')),'placeholder' => 'Cari kode atau nama gudang...','addAction' => 'openGudangModal()','addText' => 'Gudang Baru','filterName' => 'status','filterLabel' => 'Status','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statuses->map(fn($s) => ['value' => $s->id_status_gudang, 'label' => $s->nm_status_gudang])->all()),'extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['tab' => 'gudang'])]); ?>
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
            <?php if (isset($component)) { $__componentOriginal192d36ba6cd50c4cca61f140dd024b90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal192d36ba6cd50c4cca61f140dd024b90 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.gudang-table','data' => ['gudangs' => $gudangs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.gudang-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['gudangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($gudangs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal192d36ba6cd50c4cca61f140dd024b90)): ?>
<?php $attributes = $__attributesOriginal192d36ba6cd50c4cca61f140dd024b90; ?>
<?php unset($__attributesOriginal192d36ba6cd50c4cca61f140dd024b90); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal192d36ba6cd50c4cca61f140dd024b90)): ?>
<?php $component = $__componentOriginal192d36ba6cd50c4cca61f140dd024b90; ?>
<?php unset($__componentOriginal192d36ba6cd50c4cca61f140dd024b90); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $gudangs,'label' => 'gudang','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($gudangs),'label' => 'gudang','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
    <?php elseif($tab === 'rak'): ?>
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-gudang.index'),'placeholder' => 'Cari kode rak atau gudang...','addAction' => 'openRakModal()','addText' => 'Rak Baru','extraHidden' => ['tab' => 'rak']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-gudang.index')),'placeholder' => 'Cari kode rak atau gudang...','addAction' => 'openRakModal()','addText' => 'Rak Baru','extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['tab' => 'rak'])]); ?>
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
            <?php if (isset($component)) { $__componentOriginal638be04bec701983f5f920c8651243cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal638be04bec701983f5f920c8651243cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.rak-table','data' => ['raks' => $raks]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.rak-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['raks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($raks)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal638be04bec701983f5f920c8651243cf)): ?>
<?php $attributes = $__attributesOriginal638be04bec701983f5f920c8651243cf; ?>
<?php unset($__attributesOriginal638be04bec701983f5f920c8651243cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal638be04bec701983f5f920c8651243cf)): ?>
<?php $component = $__componentOriginal638be04bec701983f5f920c8651243cf; ?>
<?php unset($__componentOriginal638be04bec701983f5f920c8651243cf); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $raks,'label' => 'rak','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($raks),'label' => 'rak','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
    <?php elseif($tab === 'row'): ?>
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-gudang.index'),'placeholder' => 'Cari kode row atau rak...','addAction' => 'openRowModal()','addText' => 'Row Baru','extraHidden' => ['tab' => 'row']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-gudang.index')),'placeholder' => 'Cari kode row atau rak...','addAction' => 'openRowModal()','addText' => 'Row Baru','extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['tab' => 'row'])]); ?>
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
            <?php if (isset($component)) { $__componentOriginala9712a9e9ec0607378d0f00a418a8ee0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9712a9e9ec0607378d0f00a418a8ee0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.row-table','data' => ['rows' => $rows]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.row-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9712a9e9ec0607378d0f00a418a8ee0)): ?>
<?php $attributes = $__attributesOriginala9712a9e9ec0607378d0f00a418a8ee0; ?>
<?php unset($__attributesOriginala9712a9e9ec0607378d0f00a418a8ee0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9712a9e9ec0607378d0f00a418a8ee0)): ?>
<?php $component = $__componentOriginala9712a9e9ec0607378d0f00a418a8ee0; ?>
<?php unset($__componentOriginala9712a9e9ec0607378d0f00a418a8ee0); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $rows,'label' => 'row','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows),'label' => 'row','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
    <?php else: ?>
        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
            <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('master-gudang.index'),'placeholder' => 'Cari kode lokasi atau bin...','addAction' => 'openLokasiModal()','addText' => 'Lokasi Baru','extraHidden' => ['tab' => 'lokasi']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('master-gudang.index')),'placeholder' => 'Cari kode lokasi atau bin...','addAction' => 'openLokasiModal()','addText' => 'Lokasi Baru','extraHidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['tab' => 'lokasi'])]); ?>
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
            <?php if (isset($component)) { $__componentOriginalc6c035610136320a7a831f39fd493abb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc6c035610136320a7a831f39fd493abb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.lokasi-table','data' => ['lokasis' => $lokasis]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.lokasi-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['lokasis' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lokasis)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc6c035610136320a7a831f39fd493abb)): ?>
<?php $attributes = $__attributesOriginalc6c035610136320a7a831f39fd493abb; ?>
<?php unset($__attributesOriginalc6c035610136320a7a831f39fd493abb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc6c035610136320a7a831f39fd493abb)): ?>
<?php $component = $__componentOriginalc6c035610136320a7a831f39fd493abb; ?>
<?php unset($__componentOriginalc6c035610136320a7a831f39fd493abb); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $lokasis,'label' => 'lokasi','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lokasis),'label' => 'lokasi','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php if (isset($component)) { $__componentOriginal864d0696638730aedb766dbeac42d363 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal864d0696638730aedb766dbeac42d363 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.gudang-modal','data' => ['statuses' => $statuses,'kategoriGudangs' => $kategoriGudangs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.gudang-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['statuses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statuses),'kategoriGudangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kategoriGudangs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal864d0696638730aedb766dbeac42d363)): ?>
<?php $attributes = $__attributesOriginal864d0696638730aedb766dbeac42d363; ?>
<?php unset($__attributesOriginal864d0696638730aedb766dbeac42d363); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal864d0696638730aedb766dbeac42d363)): ?>
<?php $component = $__componentOriginal864d0696638730aedb766dbeac42d363; ?>
<?php unset($__componentOriginal864d0696638730aedb766dbeac42d363); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal577e39c6ac54c6207af820499ce65cb3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal577e39c6ac54c6207af820499ce65cb3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.rak-modal','data' => ['gudangs' => $allGudangs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.rak-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['gudangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allGudangs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal577e39c6ac54c6207af820499ce65cb3)): ?>
<?php $attributes = $__attributesOriginal577e39c6ac54c6207af820499ce65cb3; ?>
<?php unset($__attributesOriginal577e39c6ac54c6207af820499ce65cb3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal577e39c6ac54c6207af820499ce65cb3)): ?>
<?php $component = $__componentOriginal577e39c6ac54c6207af820499ce65cb3; ?>
<?php unset($__componentOriginal577e39c6ac54c6207af820499ce65cb3); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal74c5e49569b97d83cac5dea2d31bce05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal74c5e49569b97d83cac5dea2d31bce05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.row-modal','data' => ['raks' => $allRaks]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.row-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['raks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRaks)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal74c5e49569b97d83cac5dea2d31bce05)): ?>
<?php $attributes = $__attributesOriginal74c5e49569b97d83cac5dea2d31bce05; ?>
<?php unset($__attributesOriginal74c5e49569b97d83cac5dea2d31bce05); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal74c5e49569b97d83cac5dea2d31bce05)): ?>
<?php $component = $__componentOriginal74c5e49569b97d83cac5dea2d31bce05; ?>
<?php unset($__componentOriginal74c5e49569b97d83cac5dea2d31bce05); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalba47a1465b167d39e67db4d4ffa3c811 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalba47a1465b167d39e67db4d4ffa3c811 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.gudang.lokasi-modal','data' => ['raks' => $allRaks,'rows' => $allRows]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.gudang.lokasi-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['raks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRaks),'rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allRows)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalba47a1465b167d39e67db4d4ffa3c811)): ?>
<?php $attributes = $__attributesOriginalba47a1465b167d39e67db4d4ffa3c811; ?>
<?php unset($__attributesOriginalba47a1465b167d39e67db4d4ffa3c811); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalba47a1465b167d39e67db4d4ffa3c811)): ?>
<?php $component = $__componentOriginalba47a1465b167d39e67db4d4ffa3c811; ?>
<?php unset($__componentOriginalba47a1465b167d39e67db4d4ffa3c811); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/master/gudang/index.blade.php ENDPATH**/ ?>