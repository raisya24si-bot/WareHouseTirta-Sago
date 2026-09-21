

<?php $__env->startSection('title', 'Detail Retur '.$retur->kd_retur.' - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Detail Retur Barang'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $badgeMap = [
        'DRAFT' => 'bg-surface-container-high text-on-surface-variant',
        'MENUNGGU_RESPON_VENDOR' => 'bg-tertiary-fixed text-on-tertiary-fixed',
        'PROSES_KIRIM_GANTI' => 'bg-primary-fixed text-on-primary-fixed',
        'SELESAI' => 'bg-surface-container text-on-surface',
    ];
    $badge = $badgeMap[$retur->kode_status] ?? 'bg-surface-container text-on-surface-variant';
?>

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant py-stack-md">
        <a class="hover:text-primary transition-colors" href="<?php echo e(route('retur.index')); ?>">Retur Barang Masuk</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold"><?php echo e($retur->kd_retur); ?></span>
    </nav>

    <?php if(session('success')): ?>
        <div class="p-stack-md rounded-lg bg-primary-fixed text-on-primary-fixed text-[13px] font-label-bold">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight"><?php echo e($retur->kd_retur); ?></h1>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full <?php echo e($badge); ?> text-[12px] font-label-bold">
                    <?php echo e($retur->statusRetur?->nm_status_retur); ?>

                </span>
            </div>
            <p class="text-[13px] text-on-surface-variant">
                Dari GRN <strong class="font-mono"><?php echo e($retur->penerimaanBarang?->kd_penerimaan); ?></strong>
                — PO <strong class="font-mono"><?php echo e($retur->penerimaanBarang?->po?->kd_po); ?></strong>
                — Supplier <strong><?php echo e($retur->supplier?->nm_master_supplier ?? '-'); ?></strong>
            </p>
        </div>
        <div class="flex items-center gap-stack-sm">
            <?php if($retur->canBeEdited()): ?>
                <a href="<?php echo e(route('retur.edit', $retur)); ?>" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Edit Draf
                </a>
            <?php endif; ?>

            <?php if($retur->canBeDeleted()): ?>
                <form method="POST" action="<?php echo e(route('retur.destroy', $retur)); ?>" onsubmit="return confirm('Hapus draf retur <?php echo e($retur->kd_retur); ?>? Tindakan ini tidak bisa dibatalkan.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-error-container hover:text-on-error-container text-error font-label-bold text-body-sm transition-all shadow-sm" type="submit">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Hapus Draf
                    </button>
                </form>
            <?php endif; ?>

            <?php if($retur->canCetakBap()): ?>
                <a href="<?php echo e(route('retur.cetak', $retur)); ?>" target="_blank" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Cetak BAP PDF
                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Tanggal Retur</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($retur->tgl_retur?->translatedFormat('d M Y')); ?></div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Total Item Reject</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($retur->totalItemReject()); ?> Unit (<?php echo e($retur->details->count()); ?> SKU)</div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Nilai Total Retur</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1">Rp <?php echo e(number_format($retur->nilai_total_retur, 0, ',', '.')); ?></div>
        </div>
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Resi / Ekspedisi</span>
            <div class="font-label-bold text-on-surface text-[15px] mt-1"><?php echo e($retur->no_resi_pengiriman ?? '-'); ?> <?php if($retur->nm_ekspedisi): ?> (<?php echo e($retur->nm_ekspedisi); ?>) <?php endif; ?></div>
        </div>
    </div>

    <?php if($retur->catatan_retur): ?>
        <div class="bg-surface-container-low p-stack-md rounded-xl text-[13px] text-on-surface-variant">
            <strong class="text-on-surface">Catatan:</strong> <?php echo e($retur->catatan_retur); ?>

        </div>
    <?php endif; ?>

    
    <div class="flex flex-col gap-stack-sm">
        <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Item yang Diretur</span>

        <?php $__currentLoopData = $retur->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col gap-stack-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b">
                    <div class="flex flex-col">
                        <span class="font-label-bold text-body-sm text-on-surface"><?php echo e($detail->barang?->nm_master_barang); ?></span>
                        <span class="text-[11px] text-outline">Qty Reject QC: <?php echo e($detail->qty_reject_qc); ?> — Qty Diretur: <strong class="text-error"><?php echo e($detail->qty_diretur); ?></strong></span>
                    </div>
                    <span class="font-label-bold text-on-surface text-[14px]">Rp <?php echo e(number_format($detail->subtotal_retur, 0, ',', '.')); ?></span>
                </div>

                <div class="flex flex-wrap gap-1.5">
                    <?php $__currentLoopData = $detail->alasan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alasan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-bold text-[11px]">
                            <span class="material-symbols-outlined text-[13px]">check_circle</span>
                            <?php echo e($alasan->nm_alasan_retur); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($detail->catatan_detail): ?>
                    <p class="text-[12px] text-on-surface-variant"><?php echo e($detail->catatan_detail); ?></p>
                <?php endif; ?>

                <?php if($detail->fotos->isNotEmpty()): ?>
                    <div class="flex flex-wrap gap-2 mt-1">
                        <?php $__currentLoopData = $detail->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($foto->url); ?>" target="_blank" class="block w-20 h-20 rounded-lg overflow-hidden border border-surface-container-high">
                                <img src="<?php echo e($foto->url); ?>" alt="<?php echo e($foto->nama_file); ?>" class="w-full h-full object-cover">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/retur/show.blade.php ENDPATH**/ ?>