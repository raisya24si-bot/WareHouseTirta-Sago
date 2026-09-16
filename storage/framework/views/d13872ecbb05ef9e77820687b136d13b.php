<?php $__env->startSection('title', 'Review ' . $po->kd_po . ' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Review Persetujuan ' . $config['label']); ?>

<?php $__env->startSection('content'); ?>

<a
    href="<?php echo e(route('approval.index', $level)); ?>"
    class="mb-4 inline-flex items-center gap-1.5 text-sm text-on-surface-variant transition hover:text-primary"
>

    <span class="material-symbols-outlined text-[18px]">
        arrow_back
    </span>

    Kembali ke Antrean Persetujuan <?php echo e($config['label']); ?>


</a>


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
            Detail Review Permintaan Material
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            #<?php echo e($po->kd_po); ?>

            &middot;
            Diajukan oleh <?php echo e($po->submittedBy?->name ?? '-'); ?>

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
        <!-- WORKFLOW TRACKER -->
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

            <div class="flex items-center justify-between gap-2 border-b border-outline-variant p-5">

                <div class="flex items-center gap-2">

                    <span class="material-symbols-outlined text-primary">
                        inventory_2
                    </span>

                    <p class="font-bold text-on-surface">
                        Daftar Item Material
                    </p>

                </div>

                <span class="text-sm text-on-surface-variant">
                    <?php echo e($po->details->count()); ?> item(s)
                </span>

            </div>


            <div class="overflow-x-auto custom-scrollbar">

                <table class="w-full min-w-[650px] text-left text-sm">

                    <thead class="border-b border-outline-variant bg-surface-container-low">

                        <tr>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Item Code
                            </th>

                            <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                                Nama Barang
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Qty Request
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Stok Saat Ini
                            </th>

                            <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                                Min Level
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

                                <td class="px-4 py-3 font-bold text-primary">
                                    <?php echo e($item->barang->kd_master_barang); ?>

                                </td>

                                <td class="px-4 py-3 font-medium text-on-surface">
                                    <?php echo e($item->barang->nm_master_barang); ?>

                                </td>

                                <td class="px-4 py-3 text-right font-bold text-on-surface">
                                    <?php echo e($item->qty_request); ?>

                                </td>

                                <td class="px-4 py-3 text-right">

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

                                <td class="px-4 py-3 text-right text-on-surface-variant">
                                    <?php echo e($item->qty_min_stok_at_request); ?>

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


            <div class="border-t border-outline-variant bg-surface-container-lowest p-5">

                <p class="mb-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">
                    Justifikasi &amp; Catatan Permintaan
                </p>

                <p class="rounded-lg bg-surface-container-low p-4 text-sm text-on-surface-variant">
                    <?php echo e($po->desc_po ?: '-'); ?>

                </p>

            </div>

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
                        <dt class="text-xs text-on-surface-variant">Company</dt>
                        <dd class="font-medium text-on-surface"><?php echo e($po->supplier->nm_master_supplier); ?></dd>
                    </div>

                    <div>
                        <dt class="text-xs text-on-surface-variant">Kontak / Telepon</dt>
                        <dd class="font-medium text-on-surface"><?php echo e($po->supplier->kontak_supplier ?: '-'); ?></dd>
                    </div>

                    <div>
                        <dt class="text-xs text-on-surface-variant">Address</dt>
                        <dd class="font-medium text-on-surface"><?php echo e($po->supplier->alamat_supplier ?: '-'); ?></dd>
                    </div>

                </dl>

            <?php else: ?>

                <p class="text-sm text-on-surface-variant">
                    Belum ada supplier dipilih.
                </p>

            <?php endif; ?>

        </div>


        <!-- ===================================================== -->
        <!-- KEPUTUSAN -->
        <!-- ===================================================== -->

        <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

            <div class="mb-4 flex items-center gap-2">

                <span class="material-symbols-outlined text-primary">
                    verified
                </span>

                <p class="font-bold text-on-surface">
                    Keputusan <?php echo e($config['label']); ?>

                </p>

            </div>


            <?php if($po->isPendingAt($level)): ?>

                <!-- ============================================= -->
                <!-- MASIH BISA DIPUTUSKAN -->
                <!-- ============================================= -->

                <p class="mb-4 text-sm text-on-surface-variant">
                    Periksa kembali barang dan justifikasi sebelum memberi keputusan.
                </p>


                <form
                    method="POST"
                    action="<?php echo e(route('approval.approve', [$level, $po])); ?>"
                    onsubmit="return confirm('Approve Purchase Order <?php echo e($po->kd_po); ?> di tingkat <?php echo e($config['label']); ?>?')"
                    class="mb-3"
                >

                    <?php echo csrf_field(); ?>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-5 py-3 text-sm font-label-bold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md active:scale-[0.98]"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            check_circle
                        </span>

                        Approve Purchase Order

                    </button>

                </form>


                <form
                    method="POST"
                    action="<?php echo e(route('approval.reject', [$level, $po])); ?>"
                    onsubmit="return confirm('Kembalikan Purchase Order <?php echo e($po->kd_po); ?> ke petugas untuk direvisi?')"
                >

                    <?php echo csrf_field(); ?>

                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                        Catatan / Alasan Revisi
                    </label>

                    <textarea
                        name="reject_note"
                        rows="3"
                        required
                        maxlength="500"
                        placeholder="Tulis alasan penolakan atau revisi yang perlu dilakukan petugas..."
                        class="mb-3 w-full rounded-md border border-outline-variant px-3 py-2 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    ><?php echo e(old('reject_note')); ?></textarea>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-error px-5 py-3 text-sm font-label-bold text-white shadow-sm transition hover:opacity-90 active:scale-[0.98]"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            cancel
                        </span>

                        Reject &amp; Kembalikan ke Petugas

                    </button>

                </form>

            <?php elseif($po->isApproved()): ?>

                <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                    <div class="flex items-center gap-2 text-green-700">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span class="font-bold">Purchase Order Approved</span>
                    </div>

                    <p class="mt-2 text-xs text-green-600">
                        Semua tingkat sudah menyetujui. Purchase Order ini sudah tidak dapat diubah.
                    </p>

                </div>

            <?php elseif($po->isRejected()): ?>

                <div class="rounded-lg border border-red-200 bg-red-50 p-4">

                    <div class="flex items-center gap-2 text-red-700">
                        <span class="material-symbols-outlined">cancel</span>
                        <span class="font-bold">Sudah Ditolak</span>
                    </div>

                    <p class="mt-2 text-xs text-red-600">
                        Purchase Order ini sudah dikembalikan ke petugas untuk direvisi. Lihat catatan di riwayat approval.
                    </p>

                </div>

            <?php else: ?>

                <?php if($po->hasPassedLevel($level)): ?>

                    <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                        <div class="flex items-center gap-2 text-green-700">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span class="font-bold">Sudah Anda Setujui</span>
                        </div>

                        <p class="mt-2 text-xs text-green-600">
                            Anda sudah memberikan persetujuan di tingkat ini sebelumnya dan tidak dapat approve/reject ulang.
                        </p>

                    </div>

                <?php else: ?>

                    <div class="rounded-lg border border-outline-variant bg-surface-container-low p-4">

                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined">hourglass_top</span>
                            <span class="font-bold">Belum Giliran <?php echo e($config['label']); ?></span>
                        </div>

                        <p class="mt-2 text-xs text-on-surface-variant">
                            Purchase Order ini masih menunggu tingkat approval sebelumnya.
                        </p>

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/approval/review.blade.php ENDPATH**/ ?>