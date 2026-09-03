

<?php $__env->startSection('title', 'Notifikasi - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Notifikasi','description' => 'Riwayat kejadian penting: stok habis, selisih opname, dan barang masuk.','icon' => 'notifications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Notifikasi','description' => 'Riwayat kejadian penting: stok habis, selisih opname, dan barang masuk.','icon' => 'notifications']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Total Notifikasi','value' => $summary['total'],'icon' => 'notifications','color' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Notifikasi','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['total']),'icon' => 'notifications','color' => 'primary']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Belum Dibaca','value' => $summary['belum_dibaca'],'icon' => 'mark_email_unread','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Belum Dibaca','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['belum_dibaca']),'icon' => 'mark_email_unread','color' => 'amber']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Stok Habis','value' => $summary['stok_habis'],'icon' => 'production_quantity_limits','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Stok Habis','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['stok_habis']),'icon' => 'production_quantity_limits','color' => 'red']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.stat-card','data' => ['label' => 'Opname Selisih','value' => $summary['opname_selisih'],'icon' => 'warning','color' => 'amber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Opname Selisih','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($summary['opname_selisih']),'icon' => 'warning','color' => 'amber']); ?>
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

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant p-4">

        <div class="flex flex-wrap items-center gap-2">

            <a
                href="<?php echo e(route('notifikasi.index')); ?>"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition <?php echo e(! request('tipe') && ! request('unread_only') ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high'); ?>"
            >
                Semua
            </a>

            <a
                href="<?php echo e(route('notifikasi.index', ['unread_only' => 1])); ?>"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition <?php echo e(request('unread_only') ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high'); ?>"
            >
                Belum Dibaca
            </a>

            <a
                href="<?php echo e(route('notifikasi.index', ['tipe' => 'STOK_HABIS'])); ?>"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition <?php echo e(request('tipe') === 'STOK_HABIS' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100'); ?>"
            >
                Stok Habis
            </a>

            <a
                href="<?php echo e(route('notifikasi.index', ['tipe' => 'OPNAME_SELISIH'])); ?>"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition <?php echo e(request('tipe') === 'OPNAME_SELISIH' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100'); ?>"
            >
                Opname Selisih
            </a>

            <a
                href="<?php echo e(route('notifikasi.index', ['tipe' => 'BARANG_MASUK'])); ?>"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition <?php echo e(request('tipe') === 'BARANG_MASUK' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100'); ?>"
            >
                Barang Masuk
            </a>

        </div>

        <form method="POST" action="<?php echo e(route('notifikasi.mark-all-read')); ?>">
            <?php echo csrf_field(); ?>
            <button
                type="submit"
                class="inline-flex items-center gap-1.5 rounded-md border border-outline-variant px-3 py-1.5 text-xs font-semibold text-on-surface-variant transition hover:border-primary/40 hover:bg-primary/5 hover:text-primary"
            >
                <span class="material-symbols-outlined text-[16px]">done_all</span>
                Tandai semua sudah dibaca
            </button>
        </form>

    </div>

    <div class="divide-y divide-outline-variant/60">

        <?php $__empty_1 = true; $__currentLoopData = $notifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <?php
                $colorMap = [
                    'red' => ['bg' => 'bg-red-50', 'icon' => 'bg-red-100 text-red-700', 'border' => 'border-l-red-400'],
                    'amber' => ['bg' => 'bg-amber-50', 'icon' => 'bg-amber-100 text-amber-700', 'border' => 'border-l-amber-400'],
                    'green' => ['bg' => 'bg-green-50', 'icon' => 'bg-green-100 text-green-700', 'border' => 'border-l-green-400'],
                    'primary' => ['bg' => 'bg-blue-50', 'icon' => 'bg-primary/10 text-primary', 'border' => 'border-l-primary'],
                ];
                $palette = $colorMap[$notif->color] ?? $colorMap['primary'];
            ?>

            <a
                href="<?php echo e(route('notifikasi.open', $notif)); ?>"
                class="flex items-start gap-4 border-l-[3px] px-5 py-4 transition hover:bg-surface-container-low/60 <?php echo e($notif->isRead() ? 'border-l-transparent' : $palette['border'] . ' ' . $palette['bg'] . '/40'); ?>"
            >
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full <?php echo e($palette['icon']); ?>">
                    <span class="material-symbols-outlined text-[20px]"><?php echo e($notif->icon); ?></span>
                </span>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-on-surface"><?php echo e($notif->judul); ?></p>
                        <?php if (! ($notif->isRead())): ?>
                            <span class="h-2 w-2 shrink-0 rounded-full bg-primary"></span>
                        <?php endif; ?>
                    </div>
                    <p class="mt-1 text-sm text-on-surface-variant"><?php echo e($notif->pesan); ?></p>
                    <p class="mt-2 flex items-center gap-1.5 text-xs text-outline">
                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                        <?php echo e($notif->created_at->translatedFormat('d F Y, H:i')); ?>

                        (<?php echo e($notif->created_at->diffForHumans()); ?>)
                    </p>
                </div>

                <span class="material-symbols-outlined shrink-0 text-[18px] text-outline-variant">chevron_right</span>
            </a>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <div class="px-5 py-16 text-center">
                <span class="material-symbols-outlined text-[40px] text-outline-variant">notifications_off</span>
                <p class="mt-3 text-sm text-on-surface-variant">Belum ada notifikasi.</p>
            </div>

        <?php endif; ?>

    </div>

    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $notifikasis,'label' => 'notifikasi','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notifikasis),'label' => 'notifikasi','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/notifikasi/index.blade.php ENDPATH**/ ?>