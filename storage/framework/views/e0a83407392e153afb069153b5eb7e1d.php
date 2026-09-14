<?php $__env->startSection('title', 'Stock Monitoring & Procurement - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Stock Monitoring & Procurement'); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Stock Monitoring & Procurement','description' => 'Pantau stok kritis dan kelola Purchase Order ke supplier.','icon' => 'shopping_cart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stock Monitoring & Procurement','description' => 'Pantau stok kritis dan kelola Purchase Order ke supplier.','icon' => 'shopping_cart']); ?>
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


<div class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_360px]">

    <!-- ========================================================= -->
    <!-- LEFT -->
    <!-- ========================================================= -->

    <div class="min-w-0 space-y-6">


        <!-- ========================================================= -->
        <!-- STAT CARDS -->
        <!-- ========================================================= -->

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Out of Stock Items','value' => $outOfStockCount,'icon' => 'production_quantity_limits','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Out of Stock Items','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($outOfStockCount),'icon' => 'production_quantity_limits','color' => 'red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $attributes = $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $component = $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Low Stock Alerts','value' => $lowStockCount,'icon' => 'trending_down','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Low Stock Alerts','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lowStockCount),'icon' => 'trending_down','color' => 'amber']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $attributes = $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $component = $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Pending POs','value' => $pendingPoCount,'icon' => 'pending_actions','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending POs','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingPoCount),'icon' => 'pending_actions','color' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $attributes = $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $component = $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Expected Shipments','value' => $expectedShipmentCount,'icon' => 'local_shipping','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Expected Shipments','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($expectedShipmentCount),'icon' => 'local_shipping','color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $attributes = $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27)): ?>
<?php $component = $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27; ?>
<?php unset($__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27); ?>
<?php endif; ?>

        </div>


        <!-- ========================================================= -->
        <!-- CRITICAL STOCK -->
        <!-- ========================================================= -->

        <div id="critical-stock-card">

            <?php echo $__env->make('procurement.partials.critical-stock', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>


        <!-- ========================================================= -->
        <!-- PURCHASE ORDER -->
        <!-- ========================================================= -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('procurement.index'),'placeholder' => 'Cari kode PO atau nama supplier...','filterName' => 'status','filterLabel' => 'Status','filterOptions' => [
                    ['value' => 'DRAFT', 'label' => 'Draft'],
                    ['value' => 'PENDING_KASUBAG', 'label' => 'Pending Kasubag'],
                    ['value' => 'PENDING_KABAG', 'label' => 'Pending Kabag'],
                    ['value' => 'PENDING_DIREKTUR', 'label' => 'Pending Direktur'],
                    ['value' => 'APPROVED', 'label' => 'Approved'],
                    ['value' => 'REJECTED', 'label' => 'Rejected'],
                ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('procurement.index')),'placeholder' => 'Cari kode PO atau nama supplier...','filterName' => 'status','filterLabel' => 'Status','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    ['value' => 'DRAFT', 'label' => 'Draft'],
                    ['value' => 'PENDING_KASUBAG', 'label' => 'Pending Kasubag'],
                    ['value' => 'PENDING_KABAG', 'label' => 'Pending Kabag'],
                    ['value' => 'PENDING_DIREKTUR', 'label' => 'Pending Direktur'],
                    ['value' => 'APPROVED', 'label' => 'Approved'],
                    ['value' => 'REJECTED', 'label' => 'Rejected'],
                ])]); ?>
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


            <div class="border-t border-outline-variant px-5 py-3">

                <p class="font-bold text-on-surface">
                    Daftar Purchase Order
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[720px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                PO Number
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Supplier Name
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Order Date
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Total Items
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Status
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        <?php $__empty_1 = true; $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr class="transition hover:bg-surface-container-low/60">

                                <td class="px-4 py-3 font-medium text-primary">
                                    <?php echo e($po->kd_po); ?>

                                </td>


                                <td class="px-4 py-3">
                                    <?php echo e($po->supplier?->nm_master_supplier ?? '-'); ?>

                                </td>


                                <td class="px-4 py-3 text-on-surface-variant">
                                    <span class="block"><?php echo e($po->created_at?->translatedFormat('d M Y') ?? '-'); ?></span>
                                    <span class="block text-xs text-outline"><?php echo e($po->created_at?->format('H:i') ?? ''); ?></span>
                                </td>


                                <td class="px-4 py-3">
                                    <?php echo e($po->details->count()); ?> items
                                </td>


                                <td class="px-4 py-3">

                                    <?php if($po->kode_status === 'DRAFT'): ?>

                                        <?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $po->kode_status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($po->kode_status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $attributes = $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $component = $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>

                                    <?php else: ?>

                                        <?php if (isset($component)) { $__componentOriginale2f1cee10a04971b859f2235c7713696 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2f1cee10a04971b859f2235c7713696 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.procurement.approval-status','data' => ['po' => $po,'compact' => true,'class' => 'max-w-[200px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('procurement.approval-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['po' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($po),'compact' => true,'class' => 'max-w-[200px]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2f1cee10a04971b859f2235c7713696)): ?>
<?php $attributes = $__attributesOriginale2f1cee10a04971b859f2235c7713696; ?>
<?php unset($__attributesOriginale2f1cee10a04971b859f2235c7713696); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2f1cee10a04971b859f2235c7713696)): ?>
<?php $component = $__componentOriginale2f1cee10a04971b859f2235c7713696; ?>
<?php unset($__componentOriginale2f1cee10a04971b859f2235c7713696); ?>
<?php endif; ?>

                                    <?php endif; ?>

                                    <?php if($po->kode_status === 'REJECTED' && $po->reject_note): ?>

                                        <p
                                            class="mt-1 max-w-[220px] truncate text-xs text-red-600"
                                            title="Ditolak oleh <?php echo e($po->reject_level ? ucfirst(strtolower($po->reject_level)) : ''); ?>: <?php echo e($po->reject_note); ?>"
                                        >
                                            Ditolak <?php echo e($po->reject_level ? ucfirst(strtolower($po->reject_level)) : ''); ?>: <?php echo e($po->reject_note); ?>

                                        </p>

                                    <?php endif; ?>

                                </td>


                                <td class="px-4 py-3">

                                    <div class="flex items-center justify-end gap-1">

                                        <?php if(in_array($po->kode_status, ['DRAFT', 'REJECTED'], true)): ?>

                                            

                                            <a
                                                href="<?php echo e(route('procurement.edit', $po)); ?>"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="Edit"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    edit
                                                </span>

                                            </a>


                                            <a
                                                href="<?php echo e(route('procurement.show', $po)); ?>"
                                                class="rounded p-1.5 text-outline transition hover:bg-green-100 hover:text-green-700"
                                                title="Lihat Detail & Submit untuk Approval"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    send
                                                </span>

                                            </a>

                                        <?php else: ?>

                                            

                                            <a
                                                href="<?php echo e(route('procurement.show', $po)); ?>"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="View"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility
                                                </span>

                                            </a>

                                        <?php endif; ?>


                                        <!-- DELETE -->

                                        <form
                                            method="POST"
                                            action="<?php echo e(route('procurement.destroy', $po)); ?>"
                                            onsubmit="return confirm('Hapus Purchase Order <?php echo e($po->kd_po); ?>?')"
                                        >

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>


                                            <button
                                                type="submit"
                                                class="rounded p-1.5 text-outline transition hover:bg-error/10 hover:text-error"
                                                title="Delete"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    delete
                                                </span>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-4 py-12 text-center text-on-surface-variant"
                                >
                                    Belum ada Purchase Order.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $purchaseOrders,'label' => 'purchase order','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($purchaseOrders),'label' => 'purchase order','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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

    </div>


    <!-- ========================================================= -->
    <!-- RIGHT : CURRENT PO DRAFT -->
    <!-- ========================================================= -->

    <div class="xl:sticky xl:top-4 xl:self-start">

        <div id="draft-panel-card">

            <?php echo $__env->make('procurement.partials.draft-panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/procurement/index.blade.php ENDPATH**/ ?>