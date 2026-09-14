<?php $__env->startSection('title', $po->kd_po . ' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Detail Purchase Order'); ?>

<?php $__env->startSection('content'); ?>

<a
    href="<?php echo e(route('procurement.index')); ?>"
    class="mb-4 inline-flex items-center gap-1.5 text-sm text-on-surface-variant transition hover:text-primary"
>

    <span class="material-symbols-outlined text-[18px]">
        arrow_back
    </span>

    Kembali ke Stock Monitoring & Procurement

</a>


<?php if(session('success')): ?>

    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

        <div class="flex items-center gap-2">

            <span class="material-symbols-outlined text-[18px]">
                check_circle
            </span>

            <?php echo e(session('success')); ?>


        </div>

    </div>

<?php endif; ?>


<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->

<div class="mb-6 flex flex-wrap items-center gap-3">

    <div>

        <h1 class="text-2xl font-bold text-on-surface">
            Purchase Order
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            <?php echo e($po->kd_po); ?>

        </p>

    </div>


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

</div>


<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


    <!-- ========================================================= -->
    <!-- LEFT -->
    <!-- ========================================================= -->

    <div class="space-y-6 lg:col-span-2">


        <!-- ===================================================== -->
        <!-- TIMELINE -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <?php if (isset($component)) { $__componentOriginale2f1cee10a04971b859f2235c7713696 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2f1cee10a04971b859f2235c7713696 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.procurement.approval-status','data' => ['po' => $po,'withDetails' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('procurement.approval-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['po' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($po),'with-details' => true]); ?>
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

        </div>


        <!-- ===================================================== -->
        <!-- ITEMS -->
        <!-- ===================================================== -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <div class="flex items-center gap-2 border-b border-outline-variant p-5">

                <span class="material-symbols-outlined text-primary">
                    inventory_2
                </span>

                <p class="font-bold text-on-surface">
                    Purchase Order Items
                </p>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[650px] text-left text-sm">

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
                                Min Level
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Order Qty
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-outline-variant/60">

                        <?php $__empty_1 = true; $__currentLoopData = $po->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <?php

                                $isLow =
                                    $item->qty_stok_at_request
                                    <=
                                    $item->qty_min_stok_at_request;

                            ?>


                            <tr class="transition hover:bg-surface-container-low/60">


                                <td class="px-4 py-3 font-medium text-primary">

                                    <?php echo e($item->barang->kd_master_barang); ?>


                                </td>


                                <td class="px-4 py-3">

                                    <?php echo e($item->barang->nm_master_barang); ?>


                                </td>


                                <td class="px-4 py-3">

                                    <span
                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold
                                        <?php echo e($isLow
                                                ? (
                                                    $item->qty_stok_at_request <= 0
                                                        ? 'bg-red-100 text-red-700'
                                                        : 'bg-amber-100 text-amber-700'
                                                )
                                                : 'bg-surface-container-high text-on-surface-variant'); ?>"
                                    >

                                        <?php echo e($item->qty_stok_at_request); ?>


                                    </span>

                                </td>


                                <td class="px-4 py-3 text-on-surface-variant">

                                    <?php echo e($item->qty_min_stok_at_request); ?>


                                </td>


                                <td class="px-4 py-3 font-medium">

                                    <?php echo e($item->qty_request); ?>


                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-4 py-10 text-center text-on-surface-variant"
                                >

                                    Belum ada barang di Purchase Order.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- DESCRIPTION -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <p class="mb-2 font-bold text-on-surface">
                Deskripsi / Alasan
            </p>


            <p class="text-sm text-on-surface-variant">
                <?php echo e($po->desc_po ?: '-'); ?>

            </p>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- RIGHT -->
    <!-- ========================================================= -->

    <div class="space-y-6">


        <!-- ===================================================== -->
        <!-- SUPPLIER -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    storefront
                </span>

                <p class="font-bold text-on-surface">
                    Supplier Details
                </p>

            </div>


            <?php if($po->supplier): ?>

                <dl class="space-y-3 text-sm">

                    <div>

                        <dt class="text-xs text-on-surface-variant">
                            Company
                        </dt>

                        <dd class="font-medium text-on-surface">
                            <?php echo e($po->supplier->nm_master_supplier); ?>

                        </dd>

                    </div>


                    <div>

                        <dt class="text-xs text-on-surface-variant">
                            Kontak / Telepon
                        </dt>

                        <dd class="font-medium text-on-surface">
                            <?php echo e($po->supplier->kontak_supplier ?: '-'); ?>

                        </dd>

                    </div>


                    <div>

                        <dt class="text-xs text-on-surface-variant">
                            Address
                        </dt>

                        <dd class="font-medium text-on-surface">
                            <?php echo e($po->supplier->alamat_supplier ?: '-'); ?>

                        </dd>

                    </div>

                </dl>

            <?php else: ?>

                <p class="text-sm text-on-surface-variant">
                    Belum ada supplier dipilih.
                </p>

            <?php endif; ?>

        </div>


        <?php if($po->canBeEdited()): ?>

            <a
                href="<?php echo e(route('procurement.edit', $po)); ?>"
                class="flex w-full items-center justify-center gap-2 rounded-lg border border-outline-variant px-5 py-3 text-sm font-label-bold text-on-surface-variant transition hover:bg-surface-container-low"
            >

                <span class="material-symbols-outlined text-[18px]">
                    edit
                </span>

                Edit Purchase Order

            </a>


            <form
                method="POST"
                action="<?php echo e(route('procurement.submit', $po)); ?>"
                onsubmit="return confirm('Ajukan Purchase Order <?php echo e($po->kd_po); ?> untuk persetujuan Kasubag?')"
            >

                <?php echo csrf_field(); ?>

                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        send
                    </span>

                    Submit for Approval

                </button>

            </form>

        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/procurement/show.blade.php ENDPATH**/ ?>