

<?php $__env->startSection('title', 'Edit ' . $po->kd_po . ' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Edit Purchase Order'); ?>

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


<?php if($errors->any()): ?>

    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <?php echo e($errors->first()); ?>

    </div>

<?php endif; ?>


<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->

<div class="mb-6 flex flex-wrap items-center gap-3">

    <div>

        <h1 class="text-2xl font-bold text-on-surface">
            Edit Purchase Order
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


<!-- ========================================================= -->
<!-- INFO -->
<!-- ========================================================= -->

<div class="mb-6 flex items-start gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">

    <span class="material-symbols-outlined text-[20px]">
        info
    </span>


    <div>

        <p class="font-semibold">
            Perubahan Purchase Order
        </p>

        <p class="mt-0.5 text-xs text-blue-600">
            Perubahan Qty dan Deskripsi langsung disimpan ke database. Status approval tetap seperti sebelumnya sampai Purchase Order disetujui.
        </p>

    </div>

</div>


<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


    <!-- ========================================================= -->
    <!-- LEFT -->
    <!-- ========================================================= -->

    <div class="space-y-6 lg:col-span-2">


        <!-- ===================================================== -->
        <!-- ITEMS -->
        <!-- ===================================================== -->

        <div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">


            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant p-5">

                <div class="flex items-center gap-2">

                    <span class="material-symbols-outlined text-primary">
                        inventory_2
                    </span>

                    <p class="font-bold text-on-surface">
                        Purchase Order Items
                    </p>

                </div>


                <!-- ADD ITEM -->

                <button
                    type="button"
                    onclick="document.getElementById('add-item-panel').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-xs font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container"
                >

                    <span class="material-symbols-outlined text-[16px]">
                        add_circle
                    </span>

                    Add Item

                </button>

            </div>


            <!-- ================================================= -->
            <!-- ADD ITEM PANEL -->
            <!-- ================================================= -->

            <div
                id="add-item-panel"
                class="hidden border-b border-outline-variant bg-surface-container-low/60 p-5"
            >

                <form
                    method="POST"
                    action="<?php echo e(route('procurement.add-item', $po)); ?>"
                    class="flex flex-wrap items-end gap-3"
                >

                    <?php echo csrf_field(); ?>


                    <div class="min-w-[220px] flex-1">

                        <label class="mb-1 block text-xs font-semibold text-on-surface-variant">
                            Barang
                        </label>


                        <select
                            name="fk_barang"
                            required
                            class="w-full rounded-md border border-outline-variant px-3 py-2 text-sm"
                        >

                            <option value="">
                                Pilih barang...
                            </option>


                            <?php $__currentLoopData = $availableBarangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($barang->id_master_barang); ?>"
                                >

                                    <?php echo e($barang->kd_master_barang); ?>

                                    -
                                    <?php echo e($barang->nm_master_barang); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>


                    <div class="w-28">

                        <label class="mb-1 block text-xs font-semibold text-on-surface-variant">
                            Qty
                        </label>


                        <input
                            type="number"
                            name="qty"
                            value="1"
                            min="1"
                            required
                            class="w-full rounded-md border border-outline-variant px-3 py-2 text-sm"
                        >

                    </div>


                    <button
                        type="submit"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-label-bold text-on-primary transition hover:bg-primary-container"
                    >

                        Tambahkan

                    </button>

                </form>

            </div>


            <!-- ================================================= -->
            <!-- EDIT FORM -->
            <!-- ================================================= -->

            <form
                id="po-edit-form"
                method="POST"
                action="<?php echo e(route('procurement.update', $po)); ?>"
            >

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>


                <div class="overflow-x-auto custom-scrollbar">

                    <table class="w-full min-w-[700px] text-left text-sm">


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

                                <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                    Action
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


                                    <!-- CODE -->

                                    <td class="px-4 py-3 font-medium text-primary">

                                        <a
                                            href="<?php echo e(route('manajemen-stok.show', $item->fk_barang)); ?>"
                                            class="hover:underline"
                                        >

                                            <?php echo e($item->barang->kd_master_barang); ?>


                                        </a>

                                    </td>


                                    <!-- NAME -->

                                    <td class="px-4 py-3">

                                        <?php echo e($item->barang->nm_master_barang); ?>


                                    </td>


                                    <!-- STOCK -->

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

                                            <?php if($isLow): ?>

                                                <span class="material-symbols-outlined text-[13px]">
                                                    warning
                                                </span>

                                            <?php endif; ?>


                                            <?php echo e($item->qty_stok_at_request); ?>


                                        </span>

                                    </td>


                                    <!-- MIN -->

                                    <td class="px-4 py-3 text-on-surface-variant">

                                        <?php echo e($item->qty_min_stok_at_request); ?>


                                    </td>


                                    <!-- QTY -->

                                    <td class="px-4 py-3">

                                        <input
                                            type="number"
                                            name="qty[<?php echo e($item->id_po_detail); ?>]"
                                            value="<?php echo e($item->qty_request); ?>"
                                            min="1"
                                            required
                                            class="w-24 rounded-md border border-outline-variant px-2 py-1.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                        >

                                    </td>


                                    <!-- DELETE -->

                                    <td class="px-4 py-3 text-right">

                                        <button
                                            type="submit"
                                            form="delete-item-<?php echo e($item->id_po_detail); ?>"
                                            onclick="return confirm('Hapus <?php echo e($item->barang->nm_master_barang); ?> dari PO ini?')"
                                            class="rounded p-1.5 text-outline transition hover:bg-error/10 hover:text-error"
                                            title="Delete"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                delete
                                            </span>

                                        </button>

                                    </td>

                                </tr>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-4 py-10 text-center text-on-surface-variant"
                                    >

                                        Belum ada barang di PO ini.

                                    </td>

                                </tr>

                            <?php endif; ?>


                        </tbody>

                    </table>

                </div>


                <!-- ================================================= -->
                <!-- SAVE -->
                <!-- ================================================= -->

                <div class="flex justify-end gap-2 border-t border-outline-variant p-5">


                    <a
                        href="<?php echo e(route('procurement.index')); ?>"
                        class="rounded-md border border-outline-variant px-5 py-2.5 text-sm font-label-bold text-on-surface-variant transition hover:bg-surface-container-low"
                    >

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-sm font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            save
                        </span>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>


        <!-- ===================================================== -->
        <!-- DELETE FORMS -->
        <!-- ===================================================== -->

        <?php $__currentLoopData = $po->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <form
                id="delete-item-<?php echo e($item->id_po_detail); ?>"
                method="POST"
                action="<?php echo e(route('procurement.remove-item', [$po, $item])); ?>"
                class="hidden"
            >

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

            </form>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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


        <!-- ===================================================== -->
        <!-- SUMMARY -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    receipt_long
                </span>

                <p class="font-bold text-on-surface">
                    Order Summary
                </p>

            </div>


            <dl class="space-y-3 text-sm">


                <div class="flex items-center justify-between">

                    <dt class="text-on-surface-variant">
                        Status
                    </dt>

                    <dd>

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

                    </dd>

                </div>


                <div class="flex items-center justify-between">

                    <dt class="text-on-surface-variant">
                        Total Items
                    </dt>

                    <dd class="font-bold text-on-surface">
                        <?php echo e($po->details->count()); ?>

                    </dd>

                </div>


                <div class="flex items-center justify-between">

                    <dt class="text-on-surface-variant">
                        Dibuat
                    </dt>

                    <dd class="font-medium text-on-surface">
                        <?php echo e($po->created_at?->translatedFormat('d M Y') ?? '-'); ?>

                    </dd>

                </div>

            </dl>


            <!-- ================================================= -->
            <!-- DESCRIPTION -->
            <!-- ================================================= -->

            <div class="mt-4 border-t border-outline-variant pt-4">

                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Deskripsi / Alasan
                </label>


                <textarea
                    form="po-edit-form"
                    name="desc_po"
                    rows="3"
                    maxlength="100"
                    placeholder="Contoh: Restock kebutuhan proyek Line 3"
                    class="w-full rounded-md border border-outline-variant px-3 py-2 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                ><?php echo e($po->desc_po); ?></textarea>


                <p class="mt-1.5 text-xs text-on-surface-variant">
                    Deskripsi akan langsung disimpan saat menekan Save Changes.
                </p>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/procurement/edit.blade.php ENDPATH**/ ?>