

<?php $__env->startSection('title', 'Edit Stok Barang - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Manajemen Stok Barang / Edit'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-5">

    <a
        href="<?php echo e(route('manajemen-stok.show', $stokLokasi->fk_barang)); ?>"
        class="mb-2 inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline"
    >

        <span class="material-symbols-outlined text-[18px]">
            arrow_back
        </span>

        Kembali

    </a>


    <h1 class="text-headline-md font-headline-md font-bold text-on-surface">
        Edit Stok Barang
    </h1>

    <p class="mt-1 text-sm text-on-surface-variant">
        Ubah lokasi BIN dan jumlah stok barang.
    </p>

</div>


<div class="max-w-3xl rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <form
        method="POST"
        action="<?php echo e(route('manajemen-stok.update', $stokLokasi->id_stok_lokasi)); ?>"
        class="space-y-5 p-6"
    >

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>


        <!-- BARANG -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                Barang
            </label>

            <input
                type="text"
                value="<?php echo e($stokLokasi->barang?->kd_master_barang); ?> - <?php echo e($stokLokasi->barang?->nm_master_barang); ?>"
                readonly
                class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
            >

        </div>


        <!-- BIN -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                BIN
            </label>

            <select
                name="fk_lokasi"
                required
                class="w-full rounded-lg border border-outline-variant bg-white px-3 py-2.5"
            >

                <?php $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option
                        value="<?php echo e($lokasi->id_lokasi); ?>"
                        <?php if(old('fk_lokasi', $stokLokasi->fk_lokasi) == $lokasi->id_lokasi): echo 'selected'; endif; ?>
                    >

                        <?php echo e($lokasi->bin); ?>


                        —
                        <?php echo e($lokasi->row?->kd_row ?? '-'); ?>


                        —
                        <?php echo e($lokasi->row?->rak?->kd_rak ?? '-'); ?>


                        —
                        <?php echo e($lokasi->row?->rak?->gudang?->nm_gudang ?? '-'); ?>


                    </option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>

        </div>


        <!-- STOK -->
        <div>

            <label class="mb-1 block text-sm font-semibold">
                Stok
            </label>

            <input
                type="number"
                name="qty_stok"
                min="0"
                value="<?php echo e(old('qty_stok', $stokLokasi->qty_stok)); ?>"
                required
                class="w-full rounded-lg border border-outline-variant px-3 py-2.5"
            >

        </div>


        <!-- ACTION -->
        <div class="flex justify-end gap-2 border-t border-outline-variant pt-5">

            <a
                href="<?php echo e(route('manajemen-stok.show', $stokLokasi->fk_barang)); ?>"
                class="rounded-lg border border-outline-variant px-5 py-2.5 text-sm font-semibold hover:bg-surface-container-low"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-on-primary hover:bg-primary-container"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/manajemen-stok/edit.blade.php ENDPATH**/ ?>