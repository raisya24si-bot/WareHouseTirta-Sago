

<?php $__env->startSection('title', 'Approval Direktur - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Penerimaan Barang PO / Approval Direktur'); ?>

<?php $__env->startSection('content'); ?>

<div class="relative w-full">
    <div class="absolute -top-10 left-1/4 w-96 h-32 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -top-10 right-10 w-72 h-28 bg-tertiary/10 rounded-full blur-2xl pointer-events-none"></div>
</div>

<div class="flex flex-col gap-base pt-container-padding">

    <nav class="flex items-center gap-stack-sm text-body-sm text-on-surface-variant font-body-sm">
        <a class="hover:text-primary transition-colors" href="#">Inventory</a>
        <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="<?php echo e(route('penerimaan.index')); ?>">Penerimaan Barang Masuk</a>
        <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
        <span class="font-label-bold text-on-surface">Approval Direktur</span>
    </nav>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-stack-md mt-base">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-bold tracking-wider uppercase">Final Approval</span>
                <span class="text-[12px] text-outline font-sidebar-nav">Direktur Operasional</span>
            </div>
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">Persetujuan Akhir Penerimaan Barang (GRN)</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-2xl mt-1">
                Dokumen di halaman ini sudah lolos verifikasi fisik &amp; alokasi bin oleh petugas gudang.
                Setujui untuk mengunci dokumen dan memperbarui stok gudang secara otomatis, atau tolak untuk
                dikembalikan diperbaiki.
            </p>
        </div>
    </div>

</div>



<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-stack-md">

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-tertiary-fixed text-on-tertiary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-tertiary/10 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-tertiary-fixed">Menunggu Approval</span>
            <span class="material-symbols-outlined text-[22px] text-tertiary-container">pending_actions</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-tertiary-fixed"><?php echo e(number_format($totalMenunggu)); ?></div>
            <div class="text-[12px] font-body-sm text-on-tertiary-fixed-variant mt-1 font-medium">Dokumen GRN di antrean Anda</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-primary-fixed text-on-primary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-primary-fixed">Disetujui Bulan Ini</span>
            <span class="material-symbols-outlined text-[22px] text-primary">task_alt</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-primary-fixed"><?php echo e(number_format($totalDisetujuiBulanIni)); ?></div>
            <div class="text-[12px] font-body-sm text-on-primary-fixed-variant mt-1 font-medium">Stok sudah masuk ke gudang</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-error-container text-on-error-container shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-error/10 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-error-container">Ditolak Bulan Ini</span>
            <span class="material-symbols-outlined text-[22px] text-error">cancel</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-error-container"><?php echo e(number_format($totalDitolakBulanIni)); ?></div>
            <div class="text-[12px] font-body-sm text-on-error-container/80 mt-1 font-medium">Dikembalikan untuk diperbaiki</div>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-secondary-fixed text-on-secondary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-secondary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-secondary-fixed">Nilai Menunggu</span>
            <span class="material-symbols-outlined text-[22px] text-secondary">payments</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-[22px] font-bold text-on-secondary-fixed">Rp <?php echo e(number_format($nilaiMenunggu, 0, ',', '.')); ?></div>
            <div class="text-[12px] font-body-sm text-on-secondary-fixed-variant mt-1 font-medium">Total nilai barang baik di halaman ini</div>
        </div>
    </div>

</div>



<div class="mt-stack-md rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

    <div class="p-container-padding border-b border-outline-variant">

        <form method="GET" action="<?php echo e(route('penerimaan.approval-direktur.index')); ?>" class="flex items-center gap-stack-sm">

            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Cari No. Penerimaan, No. PO, atau nama supplier..."
                    class="w-full h-11 pl-10 pr-3 rounded-lg border border-outline-variant bg-surface-container-lowest text-[13px] focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>

            <button type="submit" class="h-11 px-container-padding rounded-lg bg-primary text-on-primary font-label-bold text-[13px] hover:bg-primary-container transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Cari
            </button>

            <?php if(request()->hasAny(['search', 'per_page'])): ?>
                <a href="<?php echo e(route('penerimaan.approval-direktur.index')); ?>" class="h-11 px-3 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-lowest flex items-center justify-center transition-colors" title="Reset">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                </a>
            <?php endif; ?>

        </form>

    </div>


    
    <div class="w-full overflow-x-auto">

        <table class="w-full text-left font-body-sm text-body-sm text-on-surface">

            <thead class="bg-surface-container-low font-label-bold text-label-bold text-on-surface-variant text-[12px] uppercase tracking-wider">
                <tr>
                    <th class="py-3 px-stack-md">No. Penerimaan</th>
                    <th class="py-3 px-stack-md">Disubmit</th>
                    <th class="py-3 px-stack-md">No. PO Ref</th>
                    <th class="py-3 px-stack-md">Supplier</th>
                    <th class="py-3 px-stack-md text-right">Item / Nilai</th>
                    <th class="py-3 px-stack-md">Kondisi</th>
                    <th class="py-3 px-stack-md">Disubmit Oleh</th>
                    <th class="py-3 px-stack-md text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-none">

                <?php $__empty_1 = true; $__currentLoopData = $penerimaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penerimaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $supplierName = $penerimaan->po?->supplier?->nm_master_supplier ?? '-';

                        $totalBaik = $penerimaan->details->sum('qty_baik');
                        $totalRusak = $penerimaan->details->sum('qty_rusak');

                        $totalNilai = $penerimaan->details->sum(
                            fn ($detail) => ((int) $detail->qty_baik) * ((float) ($detail->harga_satuan ?? 0))
                        );

                        $belumLokasiBaik = $penerimaan->details->contains(
                            fn ($detail) => (int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang
                        );

                        $belumLokasiKarantina = $penerimaan->details->contains(
                            fn ($detail) => (int) $detail->qty_rusak > 0 && ! $detail->fk_lokasi_karantina
                        );

                        $siapApprove = ! $belumLokasiBaik && ! $belumLokasiKarantina;
                    ?>

                    <tr class="hover:bg-surface-container-low/60 transition-colors">

                        <td class="py-3.5 px-stack-md">
                            <a href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>" class="font-label-bold text-primary flex items-center gap-2 hover:underline">
                                <span class="material-symbols-outlined text-[16px] text-outline">description</span>
                                <?php echo e($penerimaan->kd_penerimaan); ?>

                            </a>
                        </td>

                        <td class="py-3.5 px-stack-md text-on-surface-variant">
                            <?php echo e($penerimaan->submit_at?->format('d M Y') ?? '-'); ?>

                            <span class="text-[11px] text-outline block"><?php echo e($penerimaan->submit_at?->format('H:i') ?? '-'); ?> WIB</span>
                        </td>

                        <td class="py-3.5 px-stack-md font-medium text-on-surface">
                            <?php echo e($penerimaan->po?->kd_po ?? '-'); ?>

                        </td>

                        <td class="py-3.5 px-stack-md">
                            <div class="font-label-bold text-on-surface"><?php echo e($supplierName); ?></div>
                            <div class="text-[11px] text-on-surface-variant"><?php echo e($penerimaan->no_sjinv_supplier ?: 'Tanpa No. SJ/Invoice'); ?></div>
                        </td>

                        <td class="py-3.5 px-stack-md text-right">
                            <span class="font-label-bold text-primary">Rp <?php echo e(number_format($totalNilai, 0, ',', '.')); ?></span>
                            <span class="text-[11px] text-on-surface-variant block">
                                <?php echo e($penerimaan->totalSku()); ?> SKU &bull; <?php echo e(number_format($totalBaik)); ?> baik
                                <?php if($totalRusak > 0): ?>
                                    &bull; <?php echo e(number_format($totalRusak)); ?> rusak
                                <?php endif; ?>
                            </span>
                        </td>

                        <td class="py-3.5 px-stack-md">
                            <?php if($siapApprove): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">
                                    <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                    Siap Disetujui
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-label-bold">
                                    <span class="material-symbols-outlined text-[13px]">warning</span>
                                    Bin Belum Lengkap
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="py-3.5 px-stack-md">
                            <?php $pic = $penerimaan->submittedBy?->name ?? '-'; ?>
                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">
                                    <?php echo e($pic !== '-' ? strtoupper(substr($pic, 0, 2)) : '--'); ?>

                                </div>
                                <span class="text-[13px] text-on-surface"><?php echo e($pic); ?></span>
                            </div>
                        </td>

                        <td class="py-3.5 px-stack-md text-center">
                            <a
                                href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] shadow-sm hover:bg-primary-container transition-all"
                            >
                                <span class="material-symbols-outlined text-[14px]">fact_check</span>
                                Review &amp; Approve
                            </a>
                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="8" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl text-outline mb-2">task_alt</span>
                                <span class="font-label-bold text-on-surface">Tidak ada dokumen menunggu approval</span>
                                <span class="text-sm mt-1">Semua GRN sudah diputuskan. Kerja bagus!</span>
                            </div>
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $penerimaans,'label' => 'dokumen','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($penerimaans),'label' => 'dokumen','per-page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/approval/direktur/index.blade.php ENDPATH**/ ?>