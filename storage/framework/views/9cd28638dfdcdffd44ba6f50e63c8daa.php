

<?php $__env->startSection('title', 'Detail Stok Barang - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Manajemen Stok Barang / Detail'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-6">

    <a
        href="<?php echo e(route('manajemen-stok.index')); ?>"
        class="mb-3 inline-flex items-center gap-1 text-sm text-primary hover:underline"
    >

        <span class="material-symbols-outlined text-[18px]">
            arrow_back
        </span>

        Kembali

    </a>


    <?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Detail Stok Barang','description' => 'Informasi lokasi penyimpanan dan stok barang.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail Stok Barang','description' => 'Informasi lokasi penyimpanan dan stok barang.']); ?>
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

</div>


<!-- INFORMASI BARANG -->

<div class="mb-6 rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

    <div class="grid grid-cols-1 gap-5 md:grid-cols-4">

        <div>

            <p class="text-xs text-on-surface-variant">
                Kode Barang
            </p>

            <p class="mt-1">
                <?php echo e($masterBarang->kd_master_barang); ?>

            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Nama Barang
            </p>

            <p class="mt-1">
                <?php echo e($masterBarang->nm_master_barang); ?>

            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Kategori
            </p>

            <p class="mt-1">
                <?php echo e($masterBarang->kategori?->nm_master_kategori ?? '-'); ?>

            </p>

        </div>


        <div>

            <p class="text-xs text-on-surface-variant">
                Satuan
            </p>

            <p class="mt-1">
                <?php echo e($masterBarang->satuan?->nm_master_satuan ?? '-'); ?>

            </p>

        </div>

    </div>

</div>


<!-- LOKASI STOK -->

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="border-b border-outline-variant bg-surface-container-low/50 px-5 py-4">

        <h2 class="font-bold text-on-surface">
            Lokasi Stok
        </h2>

        <p class="mt-1 text-sm text-on-surface-variant">
            Daftar BIN tempat barang disimpan.
        </p>

    </div>


    <div class="overflow-auto">

        <table class="w-full min-w-[900px] text-left">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-5 py-3 text-label-bold">
                        No
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        BIN
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Row
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Rak
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Gudang
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Stok
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/50">

                <?php $__empty_1 = true; $__currentLoopData = $masterBarang->stokLokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr class="hover:bg-surface-container-low/50">

                        <td class="px-5 py-4">
                            <?php echo e($loop->iteration); ?>

                        </td>

                        <td class="px-5 py-4">
                            <?php echo e($stok->lokasi?->bin ?? '-'); ?>

                        </td>

                        <td class="px-5 py-4">
                            <?php echo e($stok->lokasi?->row?->kd_row ?? '-'); ?>

                        </td>

                        <td class="px-5 py-4">
                            <?php echo e($stok->lokasi?->row?->rak?->kd_rak ?? '-'); ?>

                        </td>

                        <td class="px-5 py-4">
                            <?php echo e($stok->lokasi?->row?->rak?->gudang?->nm_gudang ?? '-'); ?>

                        </td>

                        <td class="px-5 py-4">
                            <?php echo e(number_format($stok->qty_stok)); ?>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center text-on-surface-variant"
                        >

                            Barang ini belum memiliki BIN.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/manajemen-stok/show.blade.php ENDPATH**/ ?>