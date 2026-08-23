

<?php $__env->startSection('title', 'Manajemen Stok Barang - Material Master'); ?>
<?php $__env->startSection('breadcrumb', 'Manajemen Stok Barang'); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Manajemen Stok Barang','description' => 'Kelola penempatan dan stok barang berdasarkan BIN, Row, Rak, dan Gudang.','icon' => 'warehouse']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Manajemen Stok Barang','description' => 'Kelola penempatan dan stok barang berdasarkan BIN, Row, Rak, dan Gudang.','icon' => 'warehouse']); ?>
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

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Total Barang','value' => $stokSummary['total_barang'],'icon' => 'inventory_2','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Barang','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stokSummary['total_barang']),'icon' => 'inventory_2','color' => 'primary']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Belum Ada BIN','value' => $stokSummary['belum_bin'],'icon' => 'location_off','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Belum Ada BIN','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stokSummary['belum_bin']),'icon' => 'location_off','color' => 'amber']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Total Penempatan BIN','value' => $stokSummary['total_penempatan'],'icon' => 'inventory','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Penempatan BIN','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stokSummary['total_penempatan']),'icon' => 'inventory','color' => 'green']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Gudang Aktif','value' => $stokSummary['total_gudang'],'icon' => 'warehouse','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Gudang Aktif','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stokSummary['total_gudang']),'icon' => 'warehouse','color' => 'primary']); ?>
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


<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    

    <?php if (isset($component)) { $__componentOriginal399821676c4282dd8c2aaef10a9bfaf8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399821676c4282dd8c2aaef10a9bfaf8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.crud-toolbar','data' => ['action' => route('manajemen-stok.index'),'placeholder' => 'Cari nama barang, kode, BIN...','filterName' => 'gudang','filterLabel' => 'Gudang','filterOptions' => $gudangs->map(fn ($gudang) => [
            'value' => $gudang->id_gudang,
            'label' => $gudang->nm_gudang,
        ])->values()->all()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.crud-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('manajemen-stok.index')),'placeholder' => 'Cari nama barang, kode, BIN...','filterName' => 'gudang','filterLabel' => 'Gudang','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($gudangs->map(fn ($gudang) => [
            'value' => $gudang->id_gudang,
            'label' => $gudang->nm_gudang,
        ])->values()->all())]); ?>
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


    

    <div class="overflow-auto">

        <table class="w-full min-w-[1100px] text-left">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-5 py-3 text-label-bold">
                        No
                    </th>

                    <th class="px-5 py-3 text-label-bold">
                        Nama Barang
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

                    <th class="px-5 py-3 text-right text-label-bold">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/50">

                <?php $__empty_1 = true; $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    

                    <?php if($barang->stokLokasis->isNotEmpty()): ?>

                        <?php $__currentLoopData = $barang->stokLokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr class="hover:bg-surface-container-low/50">

                                

                                <td class="px-5 py-4">

                                    <?php if(method_exists($barangs, 'firstItem')): ?>

                                        <?php echo e($barangs->firstItem() + $loop->parent->index); ?>


                                    <?php else: ?>

                                        <?php echo e($loop->parent->index + 1); ?>


                                    <?php endif; ?>

                                </td>


                                

                                <td class="px-5 py-4">

                                    <div>
                                        <?php echo e($barang->nm_master_barang); ?>

                                    </div>

                                    <div class="mt-1 text-xs text-on-surface-variant">
                                        <?php echo e($barang->kd_master_barang); ?>

                                    </div>

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

                                    <span class="font-label-bold tabular-nums">
                                        <?php echo e(number_format($stok->qty_stok)); ?>

                                    </span>

                                </td>


                                

                                <td class="px-5 py-4 text-right">

                                    <div class="inline-flex items-center gap-1">

                                        

                                        <a
                                            href="<?php echo e(route('manajemen-stok.show', $barang)); ?>"
                                            class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                            title="View"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                visibility
                                            </span>

                                        </a>


                                        

                                        <button
                                            type="button"
                                            onclick="openEditStokModal(
                                                <?php echo e($stok->id_stok_lokasi); ?>,
                                                <?php echo \Illuminate\Support\Js::from($barang->nm_master_barang)->toHtml() ?>,
                                                <?php echo e($stok->fk_lokasi); ?>,
                                                <?php echo e($stok->qty_stok); ?>

                                            )"
                                            class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                            title="Edit"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                edit
                                            </span>

                                        </button>


                                        

                                        <form
                                            method="POST"
                                            action="<?php echo e(route('manajemen-stok.destroy', $stok->id_stok_lokasi)); ?>"
                                            onsubmit="return confirm('Lepas barang <?php echo e($barang->nm_master_barang); ?> dari BIN <?php echo e($stok->lokasi?->bin); ?>? Data stok di BIN ini akan dihapus.')"
                                        >
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button
                                                type="submit"
                                                class="inline-flex p-1.5 text-outline transition hover:text-error"
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

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    

                    <?php else: ?>

                        <tr class="hover:bg-surface-container-low/50">

                            

                            <td class="px-5 py-4">

                                <?php if(method_exists($barangs, 'firstItem')): ?>

                                    <?php echo e($barangs->firstItem() + $loop->index); ?>


                                <?php else: ?>

                                    <?php echo e($loop->index + 1); ?>


                                <?php endif; ?>

                            </td>


                            

                            <td class="px-5 py-4">

                                <div>
                                    <?php echo e($barang->nm_master_barang); ?>

                                </div>

                                <div class="mt-1 text-xs text-on-surface-variant">
                                    <?php echo e($barang->kd_master_barang); ?>

                                </div>

                            </td>


                            

                            <td class="px-5 py-4">

                                <button
                                    type="button"
                                    onclick="openAddBinModal(
                                        <?php echo e($barang->id_master_barang); ?>,
                                        <?php echo \Illuminate\Support\Js::from($barang->nm_master_barang)->toHtml() ?>
                                    )"
                                    class="inline-flex items-center rounded-md border border-primary/30 bg-primary/5 px-2.5 py-1 text-sm font-normal text-primary transition hover:border-primary/50 hover:bg-primary/10"
                                >

                                    + Add BIN

                                </button>

                            </td>


                            

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            

                            <td class="px-5 py-4 text-on-surface-variant">
                                -
                            </td>


                            

                            <td class="px-5 py-4 text-right">

                                <div class="inline-flex items-center gap-1">

                                    

                                    <a
                                        href="<?php echo e(route('manajemen-stok.show', $barang)); ?>"
                                        class="inline-flex p-1.5 text-outline transition hover:text-primary"
                                        title="View"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            visibility
                                        </span>

                                    </a>


                                    

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex cursor-not-allowed p-1.5 text-outline/40"
                                        title="Belum ada BIN"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            edit
                                        </span>

                                    </button>


                                    

                                    <button
                                        type="button"
                                        disabled
                                        class="inline-flex cursor-not-allowed p-1.5 text-outline/40"
                                        title="Belum ada BIN"
                                    >

                                        <span class="material-symbols-outlined text-[20px]">
                                            delete
                                        </span>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="8"
                            class="px-5 py-12 text-center text-on-surface-variant"
                        >

                            Belum ada data barang.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>


    

    <?php if(method_exists($barangs, 'links')): ?>

        <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $barangs,'label' => 'barang','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($barangs),'label' => 'barang','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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

    <?php else: ?>

        <div class="flex items-center justify-between border-t border-outline-variant bg-surface-container-low px-5 py-3">

            <span class="text-sm text-on-surface-variant">
                Menampilkan <?php echo e($barangs->count()); ?> barang
            </span>

        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>




<?php $__env->startSection('modals'); ?>




<div
    id="edit-stok-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>

    <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

        

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-5">

            <h2 class="text-xl font-bold text-on-surface">
                Edit Barang
            </h2>

            <button
                type="button"
                onclick="closeEditStokModal()"
                class="text-on-surface-variant transition hover:text-on-surface"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        

        <form
            id="edit-stok-form"
            method="POST"
            class="p-6"
        >

            <?php echo csrf_field(); ?>

            <?php echo method_field('PUT'); ?>


            

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    Nama Barang
                </label>

                <input
                    id="edit-stok-barang"
                    type="text"
                    readonly
                    class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
                >

            </div>


            

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    BIN
                </label>

                <select
                    id="edit-stok-lokasi"
                    name="fk_lokasi"
                    required
                    class="w-full rounded-md border border-outline-variant bg-white px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

                    <option value="">
                        Pilih BIN
                    </option>

                    <?php $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($lokasi->id_lokasi); ?>">

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


            

            <div class="mb-6">

                <label class="mb-2 block text-sm">
                    Stok
                </label>

                <input
                    id="edit-stok-qty"
                    type="number"
                    name="qty_stok"
                    min="0"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

            </div>


            

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeEditStokModal()"
                    class="rounded-md border border-outline-variant px-4 py-2.5 text-sm transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2.5 text-sm text-on-primary transition hover:opacity-90"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>





<div
    id="add-bin-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>

    <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

        

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-5">

            <h2 class="text-xl font-bold text-on-surface">
                Tambah BIN
            </h2>

            <button
                type="button"
                onclick="closeAddBinModal()"
                class="text-on-surface-variant transition hover:text-on-surface"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        

        <form
            method="POST"
            action="<?php echo e(route('manajemen-stok.add-bin')); ?>"
            class="p-6"
        >

            <?php echo csrf_field(); ?>


            <input
                id="add-bin-barang-id"
                type="hidden"
                name="fk_barang"
            >


            

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    Nama Barang
                </label>

                <input
                    id="add-bin-barang"
                    type="text"
                    readonly
                    class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm"
                >

            </div>


            

            <div class="mb-5">

                <label class="mb-2 block text-sm">
                    BIN
                </label>

                <select
                    name="fk_lokasi"
                    required
                    class="w-full rounded-md border border-outline-variant bg-white px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

                    <option value="">
                        Pilih BIN
                    </option>

                    <?php $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($lokasi->id_lokasi); ?>">

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


            

            <div class="mb-6">

                <label class="mb-2 block text-sm">
                    Stok
                </label>

                <input
                    type="number"
                    name="qty_stok"
                    min="0"
                    value="0"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm outline-none focus:border-primary"
                >

            </div>


            

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeAddBinModal()"
                    class="rounded-md border border-outline-variant px-4 py-2.5 text-sm transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2.5 text-sm text-on-primary transition hover:opacity-90"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

<script>

    /*
    |--------------------------------------------------------------------------
    | EDIT MODAL
    |--------------------------------------------------------------------------
    */

    function openEditStokModal(
        stokId,
        barangNama,
        lokasiId,
        qty
    ) {

        const modal =
            document.getElementById(
                'edit-stok-modal'
            );

        const form =
            document.getElementById(
                'edit-stok-form'
            );

        const barang =
            document.getElementById(
                'edit-stok-barang'
            );

        const lokasi =
            document.getElementById(
                'edit-stok-lokasi'
            );

        const stok =
            document.getElementById(
                'edit-stok-qty'
            );


        barang.value = barangNama;

        lokasi.value = lokasiId;

        stok.value = qty;


        form.action =
            "<?php echo e(url('/manajemen-stok/stok')); ?>/"
            + stokId;


        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    function closeEditStokModal()
    {
        const modal =
            document.getElementById(
                'edit-stok-modal'
            );

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | ADD BIN MODAL
    |--------------------------------------------------------------------------
    */

    function openAddBinModal(
        barangId,
        barangNama
    ) {

        const modal =
            document.getElementById(
                'add-bin-modal'
            );

        const barangIdInput =
            document.getElementById(
                'add-bin-barang-id'
            );

        const barangInput =
            document.getElementById(
                'add-bin-barang'
            );


        barangIdInput.value =
            barangId;

        barangInput.value =
            barangNama;


        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    function closeAddBinModal()
    {
        const modal =
            document.getElementById(
                'add-bin-modal'
            );

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | BACKDROP CLICK
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('edit-stok-modal')
        .addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeEditStokModal();
                }

            }
        );


    document
        .getElementById('add-bin-modal')
        .addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeAddBinModal();
                }

            }
        );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            closeEditStokModal();

            closeAddBinModal();

        }
    );

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/manajemen-stok/index.blade.php ENDPATH**/ ?>