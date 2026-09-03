

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

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

            <div class="flex items-center justify-between border-b border-outline-variant px-5 py-4">

                <p class="font-bold text-on-surface">
                    Critical Stock Action List
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[720px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Item Code
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Name
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Current Stock
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Minimal Stock
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Recommended Order
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        <?php $__empty_1 = true; $__currentLoopData = $criticalItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <?php

                                /*
                                |--------------------------------------------------------------------------
                                | BARANG ID
                                |--------------------------------------------------------------------------
                                */

                                $barangId =
                                    $row->barang->id_master_barang;


                                /*
                                |--------------------------------------------------------------------------
                                | CEK CURRENT PO DRAFT
                                |--------------------------------------------------------------------------
                                */

                                $alreadyInCart =
                                    $cartItems->contains(
                                        fn ($c) =>
                                            $c->barang->id_master_barang ===
                                            $barangId
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | CEK PO YANG SUDAH ADA
                                |--------------------------------------------------------------------------
                                |
                                | Kalau barang sudah masuk PO aktif,
                                | ambil nomor PO-nya.
                                |
                                */

                                $existingPoNumber =
                                    $poPerBarang[$barangId]
                                    ?? null;

                            ?>


                            <tr class="transition hover:bg-surface-container-low/60">

                                <td class="px-4 py-3 font-medium text-primary">
                                    <?php echo e($row->barang->kd_master_barang); ?>

                                </td>


                                <td class="px-4 py-3">
                                    <?php echo e($row->barang->nm_master_barang); ?>

                                </td>


                                <td class="px-4 py-3">

                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-bold
                                        <?php echo e($row->current_stock <= 0
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-amber-100 text-amber-700'); ?>"
                                    >

                                        <?php echo e($row->current_stock); ?> unit

                                    </span>

                                </td>


                                <td class="px-4 py-3 text-on-surface-variant">
                                    <?php echo e($row->minimum_stock); ?> unit
                                </td>


                                <td class="px-4 py-3 font-medium">
                                    <?php echo e($row->recommended_order); ?> unit
                                </td>


                                <!-- ================================================= -->
                                <!-- ACTION -->
                                <!-- ================================================= -->

                                <td class="px-4 py-3 text-right">

                                    <?php if($existingPoNumber): ?>

                                        
                                        
                                        

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700"
                                            title="Barang sudah masuk ke Purchase Order"
                                        >

                                            <span class="material-symbols-outlined text-[16px]">
                                                check_circle
                                            </span>

                                            <?php echo e($existingPoNumber); ?>


                                        </span>


                                    <?php elseif($alreadyInCart): ?>

                                        
                                        
                                        

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md bg-primary/10 px-3 py-1.5 text-xs font-medium text-primary"
                                            title="Barang sudah ditambahkan ke draft PO"
                                        >

                                            <span class="material-symbols-outlined text-[16px]">
                                                check
                                            </span>

                                            Added

                                        </span>


                                    <?php else: ?>

                                        
                                        
                                        

                                        <form
                                            method="POST"
                                            action="<?php echo e(route('procurement.draft.add-item')); ?>"
                                            data-no-loading
                                        >

                                            <?php echo csrf_field(); ?>

                                            <input
                                                type="hidden"
                                                name="fk_barang"
                                                value="<?php echo e($row->barang->id_master_barang); ?>"
                                            >


                                            <input
                                                type="hidden"
                                                name="qty"
                                                value="<?php echo e($row->recommended_order > 0 ? $row->recommended_order : 1); ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-md border border-primary/30 bg-primary/5 px-3 py-1.5 text-xs font-medium text-primary transition hover:bg-primary/10"
                                            >

                                                <span class="material-symbols-outlined text-[16px]">
                                                    add_shopping_cart
                                                </span>

                                                Add to PO

                                            </button>

                                        </form>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-4 py-12 text-center text-on-surface-variant"
                                >
                                    Semua stok barang aman, nggak ada yang di bawah minimal stock. 🎉
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

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

                                </td>


                                <td class="px-4 py-3">

                                    <div class="flex items-center justify-end gap-1">

                                        <?php if($po->kode_status === 'APPROVED'): ?>

                                            

                                            <a
                                                href="<?php echo e(route('procurement.approve', $po)); ?>"
                                                class="rounded p-1.5 text-outline transition hover:bg-primary/10 hover:text-primary"
                                                title="View"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility
                                                </span>

                                            </a>

                                        <?php else: ?>

                                            

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
                                                href="<?php echo e(route('procurement.approve', $po)); ?>"
                                                class="rounded p-1.5 text-outline transition hover:bg-green-100 hover:text-green-700"
                                                title="Approve"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    check_circle
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

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <div class="flex items-center gap-2 border-b border-outline-variant px-5 py-4">

                <span class="material-symbols-outlined text-primary">
                    shopping_cart
                </span>

                <p class="font-bold text-on-surface">
                    Current PO Draft
                </p>

            </div>


            <div class="p-5">

                <?php if($errors->has('draft')): ?>

                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
                        <?php echo e($errors->first('draft')); ?>

                    </div>

                <?php endif; ?>


                <?php if(session('success')): ?>

                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700">
                        <?php echo e(session('success')); ?>

                    </div>

                <?php endif; ?>


                <!-- SUPPLIER FORM -->

                <form
                    method="POST"
                    action="<?php echo e(route('procurement.draft.set-supplier')); ?>"
                    id="draft-supplier-form"
                    class="mb-5 space-y-3"
                    data-no-loading
                >

                    <?php echo csrf_field(); ?>


                    <div>

                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                            Select Supplier
                        </label>


                        <select
                            name="fk_supplier"
                            onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                            class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >

                            <option value="">
                                -- Pilih Supplier --
                            </option>


                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($supplier->id_master_supplier); ?>"
                                    <?php echo e($cartSupplier?->id_master_supplier === $supplier->id_master_supplier ? 'selected' : ''); ?>

                                >
                                    <?php echo e($supplier->nm_master_supplier); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>


                    <div>

                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                            Deskripsi / Alasan (opsional)
                        </label>


                        <input
                            type="text"
                            name="desc_po"
                            maxlength="100"
                            value="<?php echo e($cart['desc_po'] ?? ''); ?>"
                            onchange="document.getElementById('draft-supplier-form').requestSubmit()"
                            placeholder="Contoh: Restock kebutuhan proyek Line 3"
                            class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >

                    </div>

                </form>


                <p class="mb-2 text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Items (<?php echo e($cartItems->count()); ?>)
                </p>


                <?php if($cartItems->isEmpty()): ?>

                    <div class="flex flex-col items-center rounded-lg border border-dashed border-outline-variant py-10 text-center">

                        <span class="material-symbols-outlined text-[32px] text-outline-variant">
                            shopping_cart
                        </span>

                        <p class="mt-2 px-4 text-xs text-on-surface-variant">
                            Add items from the critical stock list to build your purchase order.
                        </p>

                    </div>

                <?php else: ?>

                    <div class="space-y-2">

                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="rounded-lg border border-outline-variant p-3">

                                <div class="mb-2 flex items-start justify-between gap-2">

                                    <div class="min-w-0">

                                        <p class="truncate text-xs font-bold text-on-surface">
                                            <?php echo e($item->barang->kd_master_barang); ?>

                                        </p>

                                        <p class="truncate text-sm text-on-surface-variant">
                                            <?php echo e($item->barang->nm_master_barang); ?>

                                        </p>

                                    </div>


                                    <form
                                        method="POST"
                                        action="<?php echo e(route('procurement.draft.remove-item', $item->barang)); ?>"
                                        data-no-loading
                                    >

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>


                                        <button
                                            type="submit"
                                            class="text-outline transition hover:text-error"
                                            title="Hapus"
                                        >

                                            <span class="material-symbols-outlined text-[18px]">
                                                close
                                            </span>

                                        </button>

                                    </form>

                                </div>


                                <form
                                    method="POST"
                                    action="<?php echo e(route('procurement.draft.update-item', $item->barang)); ?>"
                                    class="flex items-center gap-2"
                                    data-no-loading
                                >

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>


                                    <span class="text-xs text-on-surface-variant">
                                        Qty:
                                    </span>


                                    <div class="flex items-center rounded-md border border-outline-variant">

                                        <button
                                            type="button"
                                            onclick="this.nextElementSibling.stepDown(); this.closest('form').requestSubmit();"
                                            class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                        >
                                            -
                                        </button>


                                        <input
                                            type="number"
                                            name="qty"
                                            value="<?php echo e($item->qty); ?>"
                                            min="1"
                                            onchange="this.closest('form').requestSubmit()"
                                            class="w-14 border-none bg-transparent px-1 py-1 text-center text-sm focus:ring-0"
                                        >


                                        <button
                                            type="button"
                                            onclick="this.previousElementSibling.stepUp(); this.closest('form').requestSubmit();"
                                            class="px-2 py-1 text-on-surface-variant hover:text-primary"
                                        >
                                            +
                                        </button>

                                    </div>

                                </form>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>

            </div>


            <div class="border-t border-outline-variant p-5">

                <div class="mb-3 flex items-center justify-between text-sm">

                    <span class="text-on-surface-variant">
                        Total Items:
                    </span>

                    <span class="font-bold text-on-surface">
                        <?php echo e($cartItems->count()); ?>

                    </span>

                </div>


                <form
                    method="POST"
                    action="<?php echo e(route('procurement.draft.create')); ?>"
                >

                    <?php echo csrf_field(); ?>


                    <button
                        type="submit"
                        <?php echo e($cartItems->isEmpty() ? 'disabled' : ''); ?>

                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            send
                        </span>

                        Create Purchase Order

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/procurement/index.blade.php ENDPATH**/ ?>