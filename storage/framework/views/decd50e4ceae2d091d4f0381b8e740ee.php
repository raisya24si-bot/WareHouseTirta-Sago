

<?php $__env->startSection('title', 'Detail Penerimaan Retur '.$penerimaan->kd_penerimaan_retur.' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Detail Penerimaan Retur'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $badgeMap = [
        'MENUNGGU_KEDATANGAN' => 'bg-tertiary-fixed text-on-tertiary-fixed',
        'PROSES_QC' => 'bg-primary-fixed text-on-primary-fixed',
        'SELESAI' => 'bg-surface-container text-on-surface',
    ];
    $badge = $badgeMap[$penerimaan->kode_status] ?? 'bg-surface-container text-on-surface-variant';
?>

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant py-stack-md">
        <a class="hover:text-primary transition-colors" href="<?php echo e(route('penerimaan-retur.index')); ?>">Penerimaan Barang Pengganti Retur</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold"><?php echo e($penerimaan->kd_penerimaan_retur); ?></span>
    </nav>

    <?php if(session('success')): ?>
        <div class="p-stack-md rounded-lg bg-primary-fixed text-on-primary-fixed text-[13px] font-label-bold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight"><?php echo e($penerimaan->kd_penerimaan_retur); ?></h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full <?php echo e($badge); ?> text-[12px] font-label-bold">
                    <?php echo e($penerimaan->statusPenerimaanRetur?->nm_status_penerimaan_retur); ?>

                </span>
            </div>
            <p class="text-[13px] text-on-surface-variant">
                BAP Retur Asal <strong class="font-mono"><?php echo e($penerimaan->returBarang?->kd_retur); ?></strong>
                — GRN <strong class="font-mono"><?php echo e($penerimaan->returBarang?->penerimaanBarang?->kd_penerimaan); ?></strong>
                — Supplier <strong><?php echo e($penerimaan->supplier?->nm_master_supplier ?? '-'); ?></strong>
            </p>
        </div>
        <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm" type="button">
            <span class="material-symbols-outlined text-[18px]">print</span>
            Cetak Berita Acara
        </button>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">No. Surat Jalan Supplier</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1 font-mono"><?php echo e($penerimaan->no_sj_supplier); ?></div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Waktu Tiba di Dock</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($penerimaan->waktu_tiba_dock?->translatedFormat('d M Y, H:i') ?? '-'); ?></div>
            <div class="text-[11px] text-outline"><?php echo e($penerimaan->dock_number ?? '-'); ?></div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Total Barang Tiba</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($penerimaan->totalQtyTiba()); ?> Unit (<?php echo e($penerimaan->details->count()); ?> SKU)</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Petugas Penerima / QC</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($penerimaan->submittedBy?->name ?? '-'); ?></div>
        </div>
    </div>

    <?php if($penerimaan->catatan_verifikasi): ?>
        <div class="bg-surface-container-low p-stack-md rounded-xl text-[13px] text-on-surface-variant">
            <strong class="text-on-surface">Catatan Verifikasi:</strong> <?php echo e($penerimaan->catatan_verifikasi); ?>

        </div>
    <?php endif; ?>

    
    <div class="flex flex-col gap-stack-sm">
        <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Item Barang Pengganti</span>

        <?php $__currentLoopData = $penerimaan->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col gap-stack-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b">
                    <div class="flex flex-col">
                        <span class="font-label-bold text-body-sm text-on-surface"><?php echo e($detail->barang?->nm_master_barang); ?></span>
                        <span class="text-[11px] text-outline">Qty Diklaim: <?php echo e($detail->qty_diklaim); ?> — Qty Tiba: <strong class="text-primary"><?php echo e($detail->qty_tiba); ?></strong></span>
                    </div>
                    <span class="font-mono text-[12px] text-on-surface"><?php echo e($detail->binTujuan?->kd_lokasi); ?> (<?php echo e($detail->binTujuan?->row?->rak?->gudang?->nm_gudang); ?>)</span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/penerimaan-retur/show.blade.php ENDPATH**/ ?>