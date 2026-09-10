<?php $__env->startSection('title', 'Antrean Persetujuan - ' . $config['label'] . ' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Antrean Persetujuan ' . $config['label']); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Antrean Persetujuan - Level '.e($config['label']).'','description' => 'Kelola dan tinjau permintaan material untuk operasional harian.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Antrean Persetujuan - Level '.e($config['label']).'','description' => 'Kelola dan tinjau permintaan material untuk operasional harian.']); ?>
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
<!-- STATS -->
<!-- ========================================================= -->

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

    <?php if (isset($component)) { $__componentOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc26d0dc8a672fdd387f8f0aee5fa7d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Waiting Approval','value' => $waitingCount,'icon' => 'hourglass_empty','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Waiting Approval','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($waitingCount),'icon' => 'hourglass_empty','color' => 'amber']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Approved Today','value' => $approvedTodayCount,'icon' => 'check_circle','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Approved Today','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($approvedTodayCount),'icon' => 'check_circle','color' => 'green']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Rejected','value' => $rejectedCount,'icon' => 'cancel','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Rejected','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rejectedCount),'icon' => 'cancel','color' => 'red']); ?>
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
<!-- LIST -->
<!-- ========================================================= -->

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low p-4">

        <p class="font-bold text-on-surface">
            Daftar Permintaan Material
        </p>

        <?php if (isset($component)) { $__componentOriginal778e8091b3f0626b9482cfb19294fdf3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal778e8091b3f0626b9482cfb19294fdf3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.search-filter','data' => ['action' => route('approval.index', $level),'placeholder' => 'Cari nomor PO atau nama petugas...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.search-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('approval.index', $level)),'placeholder' => 'Cari nomor PO atau nama petugas...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal778e8091b3f0626b9482cfb19294fdf3)): ?>
<?php $attributes = $__attributesOriginal778e8091b3f0626b9482cfb19294fdf3; ?>
<?php unset($__attributesOriginal778e8091b3f0626b9482cfb19294fdf3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal778e8091b3f0626b9482cfb19294fdf3)): ?>
<?php $component = $__componentOriginal778e8091b3f0626b9482cfb19294fdf3; ?>
<?php unset($__componentOriginal778e8091b3f0626b9482cfb19294fdf3); ?>
<?php endif; ?>

    </div>


    <div class="overflow-x-auto custom-scrollbar">

        <table class="w-full min-w-[760px] text-left text-sm">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        REQ ID
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Requester
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Date
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Approval Status
                    </th>

                    <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/60">

                <?php $__empty_1 = true; $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr class="transition hover:bg-surface-container-low/60">


                        <td class="px-4 py-3">

                            <a
                                href="<?php echo e(route('approval.review', [$level, $po])); ?>"
                                class="font-bold text-primary hover:underline"
                            >
                                #<?php echo e($po->kd_po); ?>

                            </a>

                            <p class="mt-0.5 text-xs text-on-surface-variant">
                                <?php echo e($po->details->count()); ?> item(s)
                            </p>

                        </td>


                        <td class="px-4 py-3">

                            <p class="font-medium text-on-surface">
                                <?php echo e($po->submittedBy?->name ?? '-'); ?>

                            </p>

                            <p class="text-xs text-on-surface-variant">
                                <?php echo e($po->submittedBy?->email ?? ''); ?>

                            </p>

                        </td>


                        <td class="px-4 py-3 text-on-surface-variant">
                            <?php echo e($po->submit_at?->translatedFormat('d M Y') ?? '-'); ?>

                        </td>


                        <td class="px-4 py-3">

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

                        </td>


                        <td class="px-4 py-3">

                            <div class="flex items-center justify-end gap-2">

                                <a
                                    href="<?php echo e(route('approval.review', [$level, $po])); ?>"
                                    class="rounded-md border border-outline-variant px-4 py-2 text-xs font-label-bold text-on-surface transition hover:bg-surface-container-low"
                                >
                                    Review
                                </a>


                                <?php if($po->isPendingAt($level)): ?>

                                    <form
                                        method="POST"
                                        action="<?php echo e(route('approval.approve', [$level, $po])); ?>"
                                        onsubmit="return confirm('Approve Purchase Order <?php echo e($po->kd_po); ?> di tingkat <?php echo e($config['label']); ?>?')"
                                    >
                                        <?php echo csrf_field(); ?>

                                        <button
                                            type="submit"
                                            class="rounded-md bg-primary px-4 py-2 text-xs font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container"
                                        >
                                            Quick Approve
                                        </button>
                                    </form>

                                <?php elseif($po->hasPassedLevel($level)): ?>

                                    <button
                                        type="button"
                                        disabled
                                        class="flex cursor-not-allowed items-center gap-1.5 rounded-md bg-green-600 px-4 py-2 text-xs font-label-bold text-white opacity-90"
                                    >
                                        <span class="material-symbols-outlined text-[15px]">check</span>
                                        Approved
                                    </button>

                                <?php elseif($po->isRejected() && $po->reject_level === strtoupper($level)): ?>

                                    <button
                                        type="button"
                                        disabled
                                        class="flex cursor-not-allowed items-center gap-1.5 rounded-md bg-error px-4 py-2 text-xs font-label-bold text-white opacity-90"
                                    >
                                        <span class="material-symbols-outlined text-[15px]">close</span>
                                        Rejected
                                    </button>

                                <?php endif; ?>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>

                        <td
                            colspan="5"
                            class="px-4 py-10 text-center text-on-surface-variant"
                        >

                            Belum ada permintaan yang masuk ke tahap persetujuan <?php echo e($config['label']); ?>.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>


    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $purchaseOrders,'label' => 'permintaan','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($purchaseOrders),'label' => 'permintaan','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/approval/index.blade.php ENDPATH**/ ?>