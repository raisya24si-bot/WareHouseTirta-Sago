

<?php $__env->startSection('title', 'Retur Barang Masuk - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Retur Barang Masuk'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $statusBadge = function ($kode) {
        return match (true) {
            in_array($kode, \App\Models\MasterStatusRetur::GROUP_DALAM_PROSES, true)
                => ['bg-tertiary-fixed text-on-tertiary-fixed', 'bg-tertiary animate-pulse'],
            $kode === 'SELESAI' => ['bg-surface-container text-on-surface', null],
            default => ['bg-surface-container-high text-on-surface-variant', 'bg-outline'], // DRAFT & lainnya
        };
    };

    $statusLabel = function ($retur) {
        return in_array($retur->kode_status, \App\Models\MasterStatusRetur::GROUP_DALAM_PROSES, true)
            ? 'Sedang Diproses'
            : ($retur->statusRetur?->nm_status_retur ?? '-');
    };
?>

<div class="flex flex-col w-full pb-container-padding">

    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md py-stack-md">
        <div class="flex flex-col gap-base">
            <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant">
                <a class="hover:text-primary transition-colors" href="<?php echo e(route('penerimaan.index')); ?>">Penerimaan Barang Masuk (GRN)</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-primary font-bold">Retur Barang Masuk (Supplier Return)</span>
            </nav>
            <div class="flex flex-wrap items-baseline gap-stack-sm">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">Daftar Dokumen Retur Barang Masuk</h1>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-error-container text-on-error-container font-label-bold text-sidebar-nav">
                    Reject Supplier Inbound
                </span>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-4xl">
                Pencatatan pengembalian barang reject dari bin karantina hasil inspeksi penerimaan (GRN), pengelompokan alasan kerusakan, penerbitan BAP retur, dan monitoring penggantian dari rekanan supplier.
            </p>
        </div>

        <div class="flex items-center gap-stack-sm shrink-0 self-start md:self-auto">
            <a href="<?php echo e(route('retur.export', request()->query())); ?>" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">file_download</span>
                Ekspor Rekap BAP
            </a>
            <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm transition-all shadow-md" onclick="document.getElementById('modal-buat-retur').classList.remove('hidden')" type="button">
                <span class="material-symbols-outlined text-[20px]">assignment_return</span>
                + Buat Retur Baru
            </button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-stack-md mb-container-padding">

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Total Dokumen Retur</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['total_dokumen']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-primary">BAP</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-primary-fixed text-on-primary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm flex items-center justify-between text-on-surface-variant font-body-sm text-[12px]">
                <span class="text-outline">Total <?php echo e(number_format($summary['total_unit'])); ?> Unit Rusak</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Menunggu Respon Vendor</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['menunggu_vendor']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-tertiary">Dokumen</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">outgoing_mail</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm flex items-center justify-between text-on-surface-variant font-body-sm text-[12px]">
                <span class="inline-flex items-center gap-1 text-tertiary font-label-bold">
                    <span class="material-symbols-outlined text-[14px]">schedule</span> SLA: Max 3x24 Jam
                </span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Sedang Proses Kirim / Ganti</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['proses_kirim_ganti']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-primary">Pengiriman</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-primary-fixed/20 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">local_shipping</span>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Retur Selesai Tergantikan</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['selesai']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-on-surface-variant">Selesai</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-surface-container-high text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm flex items-center justify-between text-on-surface-variant font-body-sm text-[12px]">
                <span class="text-outline">Nilai Terselamatkan:</span>
                <span class="font-label-bold text-on-surface">Rp <?php echo e(number_format($summary['nilai_terselamatkan'], 0, ',', '.')); ?></span>
            </div>
        </div>
    </div>

    <form method="GET" action="<?php echo e(route('retur.index')); ?>" id="filterForm">

        
        <div class="flex items-center justify-between overflow-x-auto gap-stack-md bg-surface-container-lowest px-container-padding py-stack-sm rounded-t-xl shadow-sm">
            <div class="flex items-center gap-stack-sm shrink-0">
                <?php $status = request('status', ''); ?>

                <a href="<?php echo e(route('retur.index', array_merge(request()->except(['status', 'page']), ['status' => '']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === '' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Semua Retur</span>
                    <span class="px-1.5 py-0.2 rounded-full <?php echo e($status === '' ? 'bg-on-primary text-primary' : 'bg-surface-container-high text-on-surface'); ?> font-bold text-[11px]"><?php echo e($tabCounts['all']); ?></span>
                </a>

                <a href="<?php echo e(route('retur.index', array_merge(request()->except(['status', 'page']), ['status' => 'proses']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === 'proses' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Dalam Proses</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-bold text-[11px]"><?php echo e($tabCounts['proses']); ?></span>
                </a>

                <a href="<?php echo e(route('retur.index', array_merge(request()->except(['status', 'page']), ['status' => 'selesai']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === 'selesai' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Selesai</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-surface-container-high text-on-surface font-bold text-[11px]"><?php echo e($tabCounts['selesai']); ?></span>
                </a>
            </div>
            <div class="text-sidebar-nav text-outline hidden lg:block">
                Terintegrasi dengan Penerimaan Barang Masuk (GRN) &amp; Lokasi Bin Karantina
            </div>
        </div>

        <input type="hidden" name="status" value="<?php echo e($status); ?>">

        
        <div class="bg-surface-container-low px-container-padding py-stack-md shadow-sm flex flex-col lg:flex-row items-center justify-between gap-stack-md">
            <div class="relative w-full lg:w-96">
                <span class="material-symbols-outlined absolute left-stack-sm top-2.5 text-outline text-[18px]">search</span>
                <input name="search" value="<?php echo e(request('search')); ?>" class="w-full bg-surface-container-lowest pl-9 pr-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none shadow-sm" placeholder="Cari No. Retur, No. GRN, Supplier..." type="text">
            </div>
            <div class="flex flex-wrap items-center gap-stack-sm w-full lg:w-auto">
                <div class="flex items-center gap-base bg-surface-container-lowest px-stack-md py-1.5 rounded-lg shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-outline">business</span>
                    <select name="supplier" onchange="document.getElementById('filterForm').submit()" class="bg-transparent font-body-sm text-body-sm text-on-surface focus:outline-none cursor-pointer pr-stack-sm">
                        <option value="">Semua Supplier</option>
                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($supplier->id_master_supplier); ?>" <?php if(request('supplier') == $supplier->id_master_supplier): echo 'selected'; endif; ?>><?php echo e($supplier->nm_master_supplier); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex items-center gap-base bg-surface-container-lowest px-stack-md py-1.5 rounded-lg shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-outline">calendar_today</span>
                    <input type="month" name="month" value="<?php echo e(request('month')); ?>" onchange="document.getElementById('filterForm').submit()" class="bg-transparent font-body-sm text-body-sm text-on-surface focus:outline-none cursor-pointer">
                </div>

                <button type="submit" class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Cari">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </button>
                <a href="<?php echo e(route('retur.index')); ?>" class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Reset Filter">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                </a>
            </div>
        </div>
    </form>

    
    <div class="flex flex-col bg-surface-container-lowest rounded-b-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-outline font-sidebar-nav text-[12px] uppercase tracking-wider">
                        <th class="p-stack-md">No. Retur &amp; Tanggal</th>
                        <th class="p-stack-md">Surat Masuk (GRN)</th>
                        <th class="p-stack-md">Supplier Rekanan</th>
                        <th class="p-stack-md text-center">Item Reject</th>
                        <th class="p-stack-md">Nilai Total Retur</th>
                        <th class="p-stack-md">Status</th>
                        <th class="p-stack-md text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-0 font-body-sm text-body-sm text-on-surface">
                    <?php $__empty_1 = true; $__currentLoopData = $returs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            [$badgeBg, $dotBg] = $statusBadge($retur->kode_status);
                            $slaSisaJam = null;

                            if ($retur->kode_status === 'MENUNGGU_RESPON_VENDOR' && $retur->submit_at) {
                                $slaSisaJam = (int) round(now()->diffInHours($retur->submit_at->addHours(72), false));
                            }
                        ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-label-bold text-primary font-mono text-[13px]"><?php echo e($retur->kd_retur); ?></span>
                                    <span class="text-[12px] text-on-surface-variant"><?php echo e($retur->created_at->translatedFormat('d M Y, H:i')); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-mono font-bold text-on-surface text-[12px]"><?php echo e($retur->penerimaanBarang?->kd_penerimaan); ?></span>
                                    <span class="text-[11px] text-outline font-mono"><?php echo e($retur->penerimaanBarang?->po?->kd_po); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col">
                                    <span class="font-label-bold text-on-surface"><?php echo e($retur->supplier?->nm_master_supplier ?? '-'); ?></span>
                                    <span class="text-[11px] text-outline"><?php echo e($retur->supplier?->kontak_supplier ?? '-'); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-label-bold text-error text-[15px]"><?php echo e($retur->totalItemReject()); ?> Unit</span>
                                    <span class="text-[11px] text-outline"><?php echo e($retur->details->count()); ?> SKU</span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col">
                                    <span class="font-label-bold text-on-surface text-[14px]">Rp <?php echo e(number_format($retur->nilai_total_retur, 0, ',', '.')); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full <?php echo e($badgeBg); ?> font-label-bold text-[11px] w-fit">
                                        <?php if($dotBg): ?><span class="w-1.5 h-1.5 rounded-full <?php echo e($dotBg); ?>"></span><?php endif; ?>
                                        <?php echo e($statusLabel($retur)); ?>

                                    </span>
                                    <?php if($slaSisaJam !== null): ?>
                                        <span class="text-[11px] font-bold <?php echo e($slaSisaJam <= 24 ? 'text-error' : 'text-tertiary'); ?>">
                                            <?php echo e($slaSisaJam > 0 ? 'Sisa SLA: '.$slaSisaJam.' Jam' : 'SLA Terlampaui'); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($retur->no_resi_pengiriman): ?>
                                        <span class="text-[11px] text-outline">Resi: <?php echo e($retur->no_resi_pengiriman); ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-stack-md align-top text-right">
                                <div class="flex items-center justify-end gap-1">
                                    
                                    <a href="<?php echo e(route('retur.show', $retur)); ?>" class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary transition-colors inline-flex" title="Lihat Detail Retur">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>

                                    
                                    <?php if($retur->canBeEdited()): ?>
                                        <a href="<?php echo e(route('retur.edit', $retur)); ?>" class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors inline-flex" title="Edit Draf Retur">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if($retur->canBeDeleted()): ?>
                                        <form method="POST" action="<?php echo e(route('retur.destroy', $retur)); ?>" onsubmit="return confirm('Hapus draf retur <?php echo e($retur->kd_retur); ?>? Tindakan ini tidak bisa dibatalkan.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="p-1.5 rounded-lg bg-surface-container hover:bg-error-container hover:text-on-error-container text-error transition-colors" title="Hapus Draf Retur" type="submit">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    
                                    <?php if($retur->canCetakBap()): ?>
                                        <a href="<?php echo e(route('retur.cetak', $retur)); ?>" target="_blank" class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors inline-flex" title="Cetak BAP PDF">
                                            <span class="material-symbols-outlined text-[18px]">print</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="p-container-padding text-center text-on-surface-variant">
                                Belum ada dokumen retur yang cocok dengan filter ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $returs,'label' => 'dokumen retur barang','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($returs),'label' => 'dokumen retur barang','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
</div>


<div class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-xl flex justify-center items-start overflow-y-auto p-container-padding hidden" id="modal-buat-retur">
<div class="bg-surface-container-lowest rounded-xl shadow-md w-full max-w-4xl my-stack-md overflow-hidden flex flex-col border border-surface-container-high">

    <form method="POST" action="<?php echo e(route('retur.store')); ?>" enctype="multipart/form-data" id="formBuatRetur">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="mode" id="inputMode" value="submit">

        <div class="bg-inverse-surface text-inverse-on-surface p-container-padding flex items-start justify-between">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-bold text-[10px] uppercase tracking-widest">Form Pembuatan BAP Retur</span>
                </div>
                <h2 class="font-headline-md text-headline-md text-inverse-on-surface leading-tight mt-1">
                    + Buat Retur Baru (Dari Reject Penerimaan GRN)
                </h2>
                <p class="font-body-sm text-[12px] text-inverse-on-surface/80">
                    Pilih dokumen penerimaan barang masuk untuk memuat otomatis supplier dan item reject dari bin karantina gudang.
                </p>
            </div>
            <button class="p-1.5 rounded-lg hover:bg-surface-container-highest/20 text-inverse-on-surface/70 hover:text-inverse-on-surface transition-colors" onclick="document.getElementById('modal-buat-retur').classList.add('hidden')" type="button">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <div class="p-container-padding overflow-y-auto max-h-[70vh] flex flex-col gap-stack-md">

            <?php if($grns->isEmpty()): ?>
                <div class="p-stack-md rounded-lg bg-error-container text-on-error-container text-[13px]">
                    Tidak ada GRN APPROVED yang memiliki catatan reject dari QC Inbound saat ini.
                </div>
            <?php endif; ?>

            
            <div class="bg-surface-container-low p-stack-md rounded-xl border border-surface-container flex flex-col gap-stack-sm">
                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    1. Hubungkan Nomor Surat Barang Masuk (GRN)
                </span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div>
                        <label class="font-label-bold text-body-sm text-on-surface block mb-1">
                            Pilih Nomor Surat Barang Masuk (No. GRN) <span class="text-error">*</span>
                        </label>
                        <select name="fk_penerimaan_barang" id="grnSelector" required class="w-full bg-surface-container-lowest border border-surface-container-highest rounded-lg p-2.5 font-body-sm text-on-surface focus:ring-1 focus:ring-primary focus:outline-none">
                            <option value="">-- Pilih GRN --</option>
                            <?php $__currentLoopData = $grns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($grn->id_penerimaan); ?>"
                                    data-supplier="<?php echo e($grn->po?->supplier?->nm_master_supplier); ?>"
                                    data-kontak="<?php echo e($grn->po?->supplier?->kontak_supplier); ?>"
                                    data-alamat="<?php echo e($grn->po?->supplier?->alamat_supplier); ?>"
                                >
                                    <?php echo e($grn->kd_penerimaan); ?> (<?php echo e($grn->tgl_penerimaan_barang?->translatedFormat('d M Y')); ?> - <?php echo e($grn->po?->kd_po); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-[11px] text-outline mt-1 block">Hanya menampilkan GRN yang memiliki catatan reject hasil QC Inbound.</span>
                    </div>

                    <div class="bg-surface-container-lowest p-3 rounded-lg border border-surface-container-high flex flex-col justify-between" id="supplierPreview">
                        <div class="flex items-start justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase font-bold text-outline tracking-wider">Supplier Rekanan (Auto-Filled)</span>
                                <span class="font-label-bold text-on-surface text-[14px] mt-0.5" id="supplierNama">-</span>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed text-[10px] font-bold font-mono">
                                <span class="material-symbols-outlined text-[12px]">lock</span> Terkunci GRN
                            </span>
                        </div>
                        <div class="mt-2 pt-2 border-t text-[11px] text-on-surface-variant flex flex-wrap gap-x-4 gap-y-1 font-mono">
                            <span>Kontak: <strong id="supplierKontak">-</strong></span>
                            <span>Alamat: <strong id="supplierAlamat">-</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="flex flex-col gap-stack-sm">
                <div class="flex items-center justify-between">
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                        2. Konfirmasi Item Reject Dari Bin Karantina &amp; Pengkategorian Alasan Rusak
                    </span>
                    <span class="text-[11px] text-outline font-label-bold" id="itemCountLabel">Pilih GRN dulu</span>
                </div>

                <div class="flex flex-col gap-stack-sm" id="itemCardsContainer">
                    <div class="p-stack-md rounded-lg bg-surface-container-low text-on-surface-variant text-[13px] text-center" id="itemPlaceholder">
                        Pilih GRN di atas untuk memuat item reject-nya.
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-body-sm text-on-surface">Catatan Retur <span class="text-outline font-normal">(Opsional)</span></label>
                <textarea name="catatan_retur" rows="2" class="bg-surface-container-low px-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none resize-none" placeholder="Catatan umum untuk dokumen retur ini..."></textarea>
            </div>
        </div>

        <div class="bg-surface-container-low p-container-padding flex flex-col sm:flex-row items-center justify-between gap-stack-md border-t border-surface-container-high">
            <div class="flex items-center gap-2 text-[12px] text-on-surface-variant">
                <span class="material-symbols-outlined text-[18px] text-primary">info</span>
                <span>Dokumen akan otomatis menerbitkan <strong>BAP Retur Resmi</strong> dan notifikasi ke supplier.</span>
            </div>
            <div class="flex items-center gap-stack-sm w-full sm:w-auto justify-end">
                <button class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-colors" onclick="document.getElementById('modal-buat-retur').classList.add('hidden')" type="button">
                    Batal
                </button>
                <button class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-bold text-body-sm transition-colors" type="submit" onclick="document.getElementById('inputMode').value='draft'">
                    Simpan Draf
                </button>
                <button class="px-container-padding py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm transition-all shadow-md flex items-center gap-1.5" type="submit" onclick="document.getElementById('inputMode').value='submit'">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    Terbitkan &amp; Kirim BAP Retur
                </button>
            </div>
        </div>
    </form>
</div>
</div>


<script id="alasanListData" type="application/json">
    <?php echo $alasanList->map(fn($a) => ['id' => $a->id_alasan_retur, 'nama' => $a->nm_alasan_retur])->toJson(); ?>

</script>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const ALASAN_LIST = JSON.parse(document.getElementById('alasanListData').textContent);

    const grnSelector = document.getElementById('grnSelector');
    const itemContainer = document.getElementById('itemCardsContainer');
    const itemCountLabel = document.getElementById('itemCountLabel');
    const supplierNama = document.getElementById('supplierNama');
    const supplierKontak = document.getElementById('supplierKontak');
    const supplierAlamat = document.getElementById('supplierAlamat');

    grnSelector.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];

        supplierNama.textContent = opt.dataset.supplier || '-';
        supplierKontak.textContent = opt.dataset.kontak || '-';
        supplierAlamat.textContent = opt.dataset.alamat || '-';

        itemContainer.innerHTML = '<div class="p-stack-md rounded-lg bg-surface-container-low text-on-surface-variant text-[13px] text-center">Memuat item reject...</div>';

        if (!this.value) {
            itemCountLabel.textContent = 'Pilih GRN dulu';
            itemContainer.innerHTML = '<div class="p-stack-md rounded-lg bg-surface-container-low text-on-surface-variant text-[13px] text-center">Pilih GRN di atas untuk memuat item reject-nya.</div>';
            return;
        }

        fetch(`/retur/grn/${this.value}/items`)
            .then(res => res.json())
            .then(data => renderItemCards(data.items))
            .catch(() => {
                itemContainer.innerHTML = '<div class="p-stack-md rounded-lg bg-error-container text-on-error-container text-[13px]">Gagal memuat item reject. Coba lagi.</div>';
            });
    });

    function renderItemCards(items) {
        itemContainer.innerHTML = '';
        itemCountLabel.textContent = items.length + ' Item Terdeteksi di Area Karantina';

        if (items.length === 0) {
            itemContainer.innerHTML = '<div class="p-stack-md rounded-lg bg-surface-container-low text-on-surface-variant text-[13px] text-center">Semua item reject GRN ini sudah pernah diretur.</div>';
            return;
        }

        items.forEach((item, index) => itemContainer.appendChild(buildItemCard(item, index)));
    }

    function buildItemCard(item, index) {
        const card = document.createElement('div');
        card.className = 'bg-surface-container-lowest p-stack-md rounded-xl border-2 border-primary/40 shadow-sm flex flex-col gap-stack-sm';

        const inputsToDisable = [];

        // --- Header: checkbox include + nama barang + qty stepper ---
        const header = document.createElement('div');
        header.className = 'flex flex-col sm:flex-row sm:items-start justify-between gap-2 pb-2 border-b';

        const includeCheckbox = document.createElement('input');
        includeCheckbox.type = 'checkbox';
        includeCheckbox.checked = true;
        includeCheckbox.className = 'rounded w-4 h-4 text-primary focus:ring-0 cursor-pointer mt-1';

        const hiddenDetailId = document.createElement('input');
        hiddenDetailId.type = 'hidden';
        hiddenDetailId.name = `items[${index}][fk_penerimaan_barang_detail]`;
        hiddenDetailId.value = item.id_penerimaan_barang_detail;
        inputsToDisable.push(hiddenDetailId);

        const infoWrap = document.createElement('div');
        infoWrap.className = 'flex flex-col';
        infoWrap.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="font-label-bold text-body-sm text-on-surface">${item.nama_barang ?? '-'}</span>
            </div>
            <div class="flex items-center gap-2 mt-1 text-[11px]">
                <span class="text-outline">Qty Reject QC: <strong class="text-error">${item.qty_rusak} Unit</strong></span>
                <span class="text-outline">Sisa Bisa Diretur: <strong>${item.qty_sisa_retur} Unit</strong></span>
            </div>
        `;

        const leftGroup = document.createElement('div');
        leftGroup.className = 'flex items-start gap-stack-sm';
        leftGroup.appendChild(includeCheckbox);
        leftGroup.appendChild(hiddenDetailId);
        leftGroup.appendChild(infoWrap);

        const stepperWrap = document.createElement('div');
        stepperWrap.className = 'flex items-center gap-stack-sm self-end sm:self-auto';

        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.min = 1;
        qtyInput.max = item.qty_sisa_retur;
        qtyInput.value = Math.min(1, item.qty_sisa_retur);
        qtyInput.name = `items[${index}][qty_diretur]`;
        qtyInput.className = 'w-14 text-center bg-surface-container-lowest font-label-bold text-[13px] py-1 focus:outline-none text-on-surface border rounded-lg';
        inputsToDisable.push(qtyInput);

        stepperWrap.innerHTML = '<span class="text-[12px] text-outline font-label-bold">Qty yang Diretur:</span>';
        stepperWrap.appendChild(qtyInput);
        stepperWrap.insertAdjacentHTML('beforeend', '<span class="text-[12px] font-bold text-on-surface">Unit</span>');

        header.appendChild(leftGroup);
        header.appendChild(stepperWrap);

        // --- Alasan chips (multi-select) ---
        const alasanWrap = document.createElement('div');
        alasanWrap.className = 'flex flex-col gap-1.5 pt-1';
        alasanWrap.innerHTML = `
            <div class="flex items-center justify-between">
                <label class="font-label-bold text-[12px] text-on-surface flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px] text-error">emergency</span>
                    Kategori &amp; Alasan Kerusakan (Bisa Pilih Lebih Dari Satu):
                </label>
            </div>
        `;

        const chipRow = document.createElement('div');
        chipRow.className = 'flex flex-wrap gap-1.5';

        ALASAN_LIST.forEach(alasan => {
            const label = document.createElement('label');
            label.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high font-label-bold text-[11px] cursor-pointer transition-colors';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'sr-only';
            checkbox.name = `items[${index}][alasan_ids][]`;
            checkbox.value = alasan.id;
            inputsToDisable.push(checkbox);

            const icon = document.createElement('span');
            icon.className = 'material-symbols-outlined text-[13px] text-outline';
            icon.textContent = 'add';

            label.appendChild(checkbox);
            label.appendChild(icon);
            label.append(' ' + alasan.nama);

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    label.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-bold text-[11px] cursor-pointer shadow-sm';
                    icon.textContent = 'check_circle';
                    icon.className = 'material-symbols-outlined text-[13px]';
                } else {
                    label.className = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high font-label-bold text-[11px] cursor-pointer transition-colors';
                    icon.textContent = 'add';
                    icon.className = 'material-symbols-outlined text-[13px] text-outline';
                }
            });

            chipRow.appendChild(label);
        });

        alasanWrap.appendChild(chipRow);

        // --- Catatan detail + upload foto ---
        const bottomRow = document.createElement('div');
        bottomRow.className = 'grid grid-cols-1 md:grid-cols-3 gap-stack-sm mt-2';

        const catatanInput = document.createElement('input');
        catatanInput.type = 'text';
        catatanInput.name = `items[${index}][catatan_detail]`;
        catatanInput.placeholder = 'Keterangan detail kerusakan fisik (opsional)...';
        catatanInput.className = 'w-full bg-surface-container-low border border-surface-container-highest rounded-lg px-3 py-1.5 font-body-sm text-[12px] text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest md:col-span-2';
        inputsToDisable.push(catatanInput);

        const fotoWrap = document.createElement('div');
        fotoWrap.className = 'flex flex-col gap-1.5';

        const fotoInput = document.createElement('input');
        fotoInput.type = 'file';
        fotoInput.name = `items[${index}][fotos][]`;
        fotoInput.multiple = true;
        fotoInput.accept = 'image/*';
        fotoInput.className = 'hidden';
        inputsToDisable.push(fotoInput);

        const fotoLabel = document.createElement('span');
        fotoLabel.className = 'text-[10px] text-outline';
        fotoLabel.textContent = 'Belum ada foto';

        const fotoBtn = document.createElement('button');
        fotoBtn.type = 'button';
        fotoBtn.className = 'inline-flex items-center gap-1 px-2 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-[11px] font-label-bold transition-colors w-full justify-center';
        fotoBtn.innerHTML = '<span class="material-symbols-outlined text-[14px] text-primary">add_photo_alternate</span> + Unggah Foto Bukti';
        fotoBtn.addEventListener('click', () => fotoInput.click());

        const fotoPreviewGrid = document.createElement('div');
        fotoPreviewGrid.className = 'flex flex-wrap gap-1.5';

        // Render ulang thumbnail preview tiap kali file berubah (baik dari
        // pilih baru maupun setelah salah satu foto dihapus).
        function renderFotoPreview() {
            fotoPreviewGrid.innerHTML = '';
            const files = Array.from(fotoInput.files);

            fotoLabel.textContent = files.length > 0 ? `${files.length} foto dipilih` : 'Belum ada foto';

            files.forEach((file, fileIndex) => {
                const thumb = document.createElement('div');
                thumb.className = 'relative w-14 h-14 rounded-lg overflow-hidden border border-surface-container-highest bg-surface-container shrink-0';

                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                img.alt = file.name;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.title = 'Hapus foto ini';
                removeBtn.className = 'absolute -top-1.5 -left-1.5 w-4 h-4 rounded-full bg-error text-on-error flex items-center justify-center shadow-sm hover:scale-110 transition-transform leading-none';
                removeBtn.innerHTML = '<span class="material-symbols-outlined text-[11px]">close</span>';
                removeBtn.addEventListener('click', () => removeFotoAt(fileIndex));

                thumb.appendChild(img);
                thumb.appendChild(removeBtn);
                fotoPreviewGrid.appendChild(thumb);

                const reader = new FileReader();
                reader.onload = (e) => { img.src = e.target.result; };
                reader.readAsDataURL(file);
            });
        }

        // Input type="file" nggak bisa diedit langsung, jadi FileList-nya
        // dibangun ulang pakai DataTransfer tanpa file yang mau dihapus.
        function removeFotoAt(removeIndex) {
            const dt = new DataTransfer();
            Array.from(fotoInput.files).forEach((file, i) => {
                if (i !== removeIndex) dt.items.add(file);
            });
            fotoInput.files = dt.files;
            renderFotoPreview();
        }

        fotoInput.addEventListener('change', renderFotoPreview);

        fotoWrap.appendChild(fotoBtn);
        fotoWrap.appendChild(fotoInput);
        fotoWrap.appendChild(fotoLabel);
        fotoWrap.appendChild(fotoPreviewGrid);

        bottomRow.appendChild(catatanInput);
        bottomRow.appendChild(fotoWrap);

        alasanWrap.appendChild(bottomRow);

        // --- Toggle disabled kalau item di-uncheck (nggak jadi diretur) ---
        includeCheckbox.addEventListener('change', function () {
            inputsToDisable.forEach(el => { el.disabled = !this.checked; });
            card.classList.toggle('opacity-50', !this.checked);
        });

        card.appendChild(header);
        card.appendChild(alasanWrap);

        return card;
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/retur/index.blade.php ENDPATH**/ ?>