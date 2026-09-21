<?php $__env->startSection('title', 'Penerimaan Barang Pengganti Retur - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Penerimaan Barang Pengganti Retur'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $statusBadge = function ($kode) {
        return match ($kode) {
            'MENUNGGU_KEDATANGAN' => ['bg-tertiary-fixed text-on-tertiary-fixed', 'bg-tertiary'],
            'PROSES_QC' => ['bg-primary-fixed text-on-primary-fixed', null],
            'SELESAI' => ['bg-surface-container text-on-surface', null],
            default => ['bg-surface-container-high text-on-surface-variant', null],
        };
    };
?>

<div class="flex flex-col w-full pb-container-padding">

    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-md py-stack-md">
        <div class="flex flex-col gap-base">
            <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant">
                <a class="hover:text-primary transition-colors" href="<?php echo e(route('penerimaan.index')); ?>">Penerimaan Barang Masuk (GRN)</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <a class="hover:text-primary transition-colors" href="<?php echo e(route('retur.index')); ?>">Retur Barang Masuk</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-primary font-bold">Penerimaan Barang Pengganti Retur</span>
            </nav>
            <div class="flex flex-wrap items-baseline gap-stack-sm">
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">Penerimaan Barang Pengganti Retur</h1>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-label-bold text-sidebar-nav">
                    Inbound Replacement
                </span>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-4xl">
                Verifikasi penerimaan fisik barang pengganti dari supplier atas klaim dokumen retur (BAP Retur) yang telah disetujui, pemeriksaan QC barang masuk, serta penempatan kembali ke bin penyimpanan aktif.
            </p>
        </div>

        <div class="flex items-center gap-stack-sm shrink-0 self-start md:self-auto">
            <a href="<?php echo e(route('retur.index')); ?>" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">history</span>
                Riwayat BAP Retur
            </a>
            <button class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm transition-all shadow-md" onclick="document.getElementById('modal-terima-retur').classList.remove('hidden')" type="button">
                <span class="material-symbols-outlined text-[20px]">move_to_inbox</span>
                + Terima Barang Retur
            </button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter my-stack-md">

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Menunggu Penerimaan / Kedatangan</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['menunggu_kedatangan']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-tertiary">Dokumen</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm text-on-surface-variant font-body-sm text-[12px]">
                <span class="inline-flex items-center gap-1 text-tertiary font-label-bold">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <?php echo e($summary['unit_dalam_perjalanan']); ?> Unit Barang Pengganti dlm Perjalanan
                </span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Dalam Proses QC & Verifikasi</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['proses_qc']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-primary">Dokumen</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-primary-fixed/20 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">search</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm text-on-surface-variant font-body-sm text-[12px]">
                <span class="inline-flex items-center gap-1 text-primary font-label-bold">
                    <span class="material-symbols-outlined text-[14px]">check</span>
                    Di Dock Penerimaan / Unboxing
                </span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">Penerimaan Selesai Bulan Ini</span>
                    <div class="flex items-baseline gap-stack-sm mt-stack-sm">
                        <span class="font-stat-number text-stat-number text-on-surface tracking-tight"><?php echo e($summary['selesai_bulan_ini']); ?></span>
                        <span class="font-body-sm text-body-sm font-bold text-on-surface-variant">Dokumen</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-surface-container-high text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
            </div>
            <div class="mt-stack-md pt-stack-sm text-on-surface-variant font-body-sm text-[12px]">
                <span class="inline-flex items-center gap-1 text-on-surface font-label-bold">
                    <span class="material-symbols-outlined text-[14px]">check</span>
                    <?php echo e($summary['unit_kembali_stok_bulan_ini']); ?> Unit Barang Kembali ke Stok Aktif
                </span>
            </div>
        </div>
    </div>

    <form method="GET" action="<?php echo e(route('penerimaan-retur.index')); ?>" id="filterForm">

        
        <div class="flex items-center justify-between overflow-x-auto gap-stack-md bg-surface-container-lowest px-container-padding py-stack-sm rounded-t-xl shadow-sm">
            <div class="flex items-center gap-stack-sm shrink-0">
                <?php $status = request('status', ''); ?>

                <a href="<?php echo e(route('penerimaan-retur.index', array_merge(request()->except(['status', 'page']), ['status' => '']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === '' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Semua Penerimaan</span>
                    <span class="px-1.5 py-0.2 rounded-full <?php echo e($status === '' ? 'bg-on-primary text-primary' : 'bg-surface-container-high text-on-surface'); ?> font-bold text-[11px]"><?php echo e($tabCounts['all']); ?></span>
                </a>

                <a href="<?php echo e(route('penerimaan-retur.index', array_merge(request()->except(['status', 'page']), ['status' => 'proses']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === 'proses' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Dalam Proses</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-bold text-[11px]"><?php echo e($tabCounts['proses']); ?></span>
                </a>

                <a href="<?php echo e(route('penerimaan-retur.index', array_merge(request()->except(['status', 'page']), ['status' => 'selesai']))); ?>"
                   class="px-stack-md py-2 rounded-lg font-label-bold text-body-sm flex items-center gap-stack-sm <?php echo e($status === 'selesai' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container'); ?>">
                    <span>Selesai</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-surface-container-high text-on-surface font-bold text-[11px]"><?php echo e($tabCounts['selesai']); ?></span>
                </a>
            </div>
        </div>

        <input type="hidden" name="status" value="<?php echo e($status); ?>">

        
        <div class="bg-surface-container-low px-container-padding py-stack-md shadow-sm flex flex-col lg:flex-row items-center justify-between gap-stack-md">
            <div class="relative w-full lg:w-96">
                <span class="material-symbols-outlined absolute left-stack-sm top-2.5 text-outline text-[18px]">search</span>
                <input name="search" value="<?php echo e(request('search')); ?>" class="w-full bg-surface-container-lowest pl-9 pr-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none shadow-sm" placeholder="Cari No. Penerimaan, No. Retur, No. GRN, Supplier..." type="text">
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
                <a href="<?php echo e(route('penerimaan-retur.index')); ?>" class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Reset Filter">
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
                        <th class="p-stack-md">No. Penerimaan Retur</th>
                        <th class="p-stack-md">No. BAP Retur & GRN Asal</th>
                        <th class="p-stack-md">Surat Jalan Supplier</th>
                        <th class="p-stack-md">Supplier Rekanan</th>
                        <th class="p-stack-md text-center">Total Item</th>
                        <th class="p-stack-md">Alokasi Bin Baru</th>
                        <th class="p-stack-md">Status</th>
                        <th class="p-stack-md text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm text-on-surface">
                    <?php $__empty_1 = true; $__currentLoopData = $penerimaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penerimaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            [$badgeBg] = $statusBadge($penerimaan->kode_status);
                            $binList = $penerimaan->details->map(fn ($d) => $d->binTujuan?->kd_lokasi)->filter()->unique()->values();
                        ?>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-label-bold text-primary font-mono text-[13px]"><?php echo e($penerimaan->kd_penerimaan_retur); ?></span>
                                    <span class="text-[12px] text-on-surface-variant"><?php echo e($penerimaan->created_at->translatedFormat('d M Y, H:i')); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-mono font-bold text-on-surface text-[12px]"><?php echo e($penerimaan->returBarang?->kd_retur); ?></span>
                                    <span class="text-[11px] text-outline font-mono">Asal: <?php echo e($penerimaan->returBarang?->penerimaanBarang?->kd_penerimaan); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-mono font-bold text-on-surface text-[12px]"><?php echo e($penerimaan->no_sj_supplier); ?></span>
                                    <?php if($penerimaan->returBarang?->no_resi_pengiriman): ?>
                                        <span class="text-[11px] text-outline">Resi: <?php echo e($penerimaan->returBarang->no_resi_pengiriman); ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <div class="flex flex-col">
                                    <span class="font-label-bold text-on-surface"><?php echo e($penerimaan->supplier?->nm_master_supplier ?? '-'); ?></span>
                                    <span class="text-[11px] text-outline"><?php echo e($penerimaan->supplier?->kontak_supplier ?? '-'); ?></span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-label-bold text-primary text-[15px]"><?php echo e($penerimaan->totalQtyTiba()); ?> Unit</span>
                                    <span class="text-[11px] text-outline"><?php echo e($penerimaan->details->count()); ?> SKU</span>
                                </div>
                            </td>
                            <td class="p-stack-md align-top">
                                <span class="font-mono text-[12px] text-on-surface"><?php echo e($binList->implode(', ') ?: '-'); ?></span>
                            </td>
                            <td class="p-stack-md align-top">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full <?php echo e($badgeBg); ?> font-label-bold text-[11px] w-fit">
                                    <?php echo e($penerimaan->statusPenerimaanRetur?->nm_status_penerimaan_retur); ?>

                                </span>
                            </td>
                            <td class="p-stack-md align-top text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="<?php echo e(route('penerimaan-retur.show', $penerimaan)); ?>" class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary transition-colors inline-flex" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors" title="Cetak" type="button">
                                        <span class="material-symbols-outlined text-[18px]">print</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="p-container-padding text-center text-on-surface-variant">
                                Belum ada dokumen penerimaan pengganti retur yang cocok dengan filter ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="p-container-padding bg-surface-container-lowest flex flex-col sm:flex-row items-center justify-between gap-stack-md border-t">
            <span class="font-body-sm text-[13px] text-outline">
                Menampilkan <strong class="text-on-surface"><?php echo e($penerimaans->firstItem() ?? 0); ?> - <?php echo e($penerimaans->lastItem() ?? 0); ?></strong> dari <strong class="text-on-surface"><?php echo e($penerimaans->total()); ?></strong> data penerimaan pengganti retur
            </span>
            <?php echo e($penerimaans->onEachSide(1)->links()); ?>

        </div>
    </div>
</div>


<div class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-xl flex justify-center items-start overflow-y-auto p-container-padding hidden" id="modal-terima-retur">
<div class="bg-surface-container-lowest rounded-xl shadow-md w-full max-w-5xl my-stack-md overflow-hidden flex flex-col border border-surface-container-high">

    <form method="POST" action="<?php echo e(route('penerimaan-retur.store')); ?>" id="formTerimaRetur">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="mode" id="inputMode" value="submit">

        <div class="bg-inverse-surface text-inverse-on-surface p-container-padding flex items-start justify-between">
            <div class="flex flex-col gap-1">
                <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-bold text-[10px] uppercase tracking-widest w-fit">Konfirmasi Penerimaan Barang Pengganti</span>
                <h2 class="font-headline-md text-headline-md text-inverse-on-surface leading-tight mt-1">
                    + Terima Barang Retur (Dari BAP Retur Disetujui)
                </h2>
                <p class="font-body-sm text-[12px] text-inverse-on-surface/80">
                    Pilih dokumen BAP Retur yang statusnya sedang dikirim vendor untuk memuat otomatis item klaim dan supplier.
                </p>
            </div>
            <button class="p-1.5 rounded-lg hover:bg-surface-container-highest/20 text-inverse-on-surface/70 hover:text-inverse-on-surface transition-colors" onclick="document.getElementById('modal-terima-retur').classList.add('hidden')" type="button">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <div class="p-container-padding overflow-y-auto max-h-[70vh] flex flex-col gap-stack-md">

            <?php if($returEligible->isEmpty()): ?>
                <div class="p-stack-md rounded-lg bg-error-container text-on-error-container text-[13px]">
                    Tidak ada BAP Retur berstatus "Sedang Proses Kirim / Ganti" yang menunggu diterima saat ini.
                </div>
            <?php endif; ?>

            
            <div class="bg-surface-container-low p-stack-md rounded-xl border border-surface-container flex flex-col gap-stack-sm">
                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    1. Ringkasan Pengiriman &amp; Dokumen Retur
                </span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div>
                        <label class="font-label-bold text-body-sm text-on-surface block mb-1">
                            Pilih Nomor Dokumen Retur (BAP Retur) <span class="text-error">*</span>
                        </label>
                        <select name="fk_retur" id="returSelector" required class="w-full bg-surface-container-lowest border border-surface-container-highest rounded-lg p-2.5 font-body-sm text-on-surface focus:ring-1 focus:ring-primary focus:outline-none">
                            <option value="">-- Pilih BAP Retur --</option>
                            <?php $__currentLoopData = $returEligible; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($retur->id_retur); ?>"
                                    data-supplier="<?php echo e($retur->supplier?->nm_master_supplier); ?>"
                                    data-kontak="<?php echo e($retur->supplier?->kontak_supplier); ?>"
                                >
                                    <?php echo e($retur->kd_retur); ?> (<?php echo e($retur->supplier?->nm_master_supplier); ?> - <?php echo e($retur->totalItemReject()); ?> Unit Reject)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="text-[11px] text-outline mt-1">Hanya menampilkan BAP retur yang sudah disetujui &amp; sedang dikirim vendor.</p>
                    </div>

                    <div>
                        <label class="font-label-bold text-body-sm text-on-surface block mb-1">
                            No. Surat Jalan / DO Supplier (Barang Pengganti) <span class="text-error">*</span>
                        </label>
                        <input type="text" name="no_sj_supplier" required placeholder="Contoh: SJ-PMN-2023/X/882" class="w-full bg-surface-container-lowest border border-surface-container-highest rounded-lg p-2.5 font-mono text-body-sm text-on-surface focus:ring-1 focus:ring-primary focus:outline-none">
                        <p class="text-[11px] text-outline mt-1">Pastikan sesuai fisik surat jalan yang dibawa kurir.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-stack-sm">
                    <div class="bg-surface-container-lowest p-3 rounded-lg border border-surface-container-high">
                        <p class="text-[10px] text-outline font-bold uppercase">Supplier Rekanan (Auto-Filled)</p>
                        <p class="font-label-bold text-on-surface text-[13px] mt-0.5" id="supplierNama">-</p>
                        <p class="text-[11px] text-outline" id="supplierKontak">-</p>
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-lg border border-surface-container-high">
                        <label class="text-[10px] text-outline font-bold uppercase block mb-1">Waktu Tiba di Dock</label>
                        <input type="datetime-local" name="waktu_tiba_dock" value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>" class="w-full bg-transparent text-[12px] font-label-bold text-on-surface focus:outline-none">
                        <input type="text" name="dock_number" placeholder="Dock Inbound #02" class="w-full bg-transparent text-[11px] text-outline focus:outline-none mt-1">
                    </div>
                    <div class="bg-surface-container-lowest p-3 rounded-lg border border-surface-container-high">
                        <p class="text-[10px] text-outline font-bold uppercase">Petugas Penerima / QC</p>
                        <p class="font-label-bold text-on-surface text-[13px] mt-0.5"><?php echo e(auth()->user()->name ?? 'Petugas Inbound'); ?></p>
                        <p class="text-[11px] text-outline"><?php echo e(auth()->user()->jabatan ?? ''); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="flex flex-col gap-stack-sm">
                <div class="flex items-center justify-between">
                    <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                        2. Verifikasi Fisik &amp; Alokasi Bin Barang Pengganti
                    </span>
                    <span class="text-[11px] text-outline font-label-bold" id="itemCountLabel">Pilih BAP Retur dulu</span>
                </div>

                <div class="overflow-x-auto rounded-xl border border-surface-container-high">
                    <table class="w-full text-left text-[12px]">
                        <thead class="bg-surface-container-low text-outline font-sidebar-nav text-[11px] uppercase">
                            <tr>
                                <th class="p-stack-sm">Material</th>
                                <th class="p-stack-sm text-center">Qty Diklaim</th>
                                <th class="p-stack-sm text-center">Qty Tiba</th>
                                <th class="p-stack-sm">Alokasi Bin Tujuan</th>
                                <th class="p-stack-sm text-center">Status Item</th>
                            </tr>
                        </thead>
                        <tbody id="itemRowsBody" class="divide-y bg-surface-container-lowest">
                            <tr id="itemPlaceholderRow">
                                <td colspan="5" class="p-stack-md text-center text-on-surface-variant">Pilih BAP Retur di atas untuk memuat item klaimnya.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="bg-surface-container-low p-stack-md rounded-xl border border-surface-container flex flex-col gap-stack-sm">
                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    3. Catatan Verifikasi &amp; Pernyataan Berita Acara
                </span>
                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-body-sm text-on-surface">Catatan Hasil Pemeriksaan QC &amp; Fisik</label>
                    <textarea name="catatan_verifikasi" rows="2" class="bg-surface-container-lowest px-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none resize-none border border-surface-container-highest" placeholder="Contoh: Semua unit telah diperiksa fisik dan hydro-test internal..."></textarea>
                </div>
                <label class="flex items-start gap-2.5 pt-1 cursor-pointer">
                    <input type="checkbox" name="is_consent_verifikasi" value="1" class="mt-0.5 rounded w-4 h-4 text-primary focus:ring-0">
                    <span class="text-[12px] font-label-bold text-on-surface">Saya menyatakan bahwa barang pengganti telah diperiksa dan sesuai spesifikasi klaim retur.</span>
                </label>
            </div>
        </div>

        <div class="bg-surface-container-low p-container-padding flex flex-col sm:flex-row items-center justify-between gap-stack-md border-t border-surface-container-high">
            <button class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-colors" onclick="document.getElementById('modal-terima-retur').classList.add('hidden')" type="button">
                Batal / Tutup
            </button>
            <div class="flex items-center gap-stack-sm w-full sm:w-auto justify-end">
                <button class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-bold text-body-sm transition-colors" type="submit" onclick="document.getElementById('inputMode').value='draft'">
                    Simpan Draf Pemeriksaan
                </button>
                <button class="px-container-padding py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm transition-all shadow-md flex items-center gap-1.5" type="submit" onclick="document.getElementById('inputMode').value='submit'">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Konfirmasi Terima &amp; Masukkan ke Bin Stok Aktif
                </button>
            </div>
        </div>
    </form>
</div>
</div>


<script id="binListData" type="application/json">
    <?php echo $bins->map(fn($b) => [
        'id' => $b->id_lokasi,
        'label' => $b->kd_lokasi.' ('.($b->row?->rak?->gudang?->nm_gudang ?? '-').', Rak '.($b->row?->rak?->kd_rak ?? '-').', Row '.($b->row?->kd_row ?? '-').')',
    ])->toJson(); ?>

</script>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const BIN_LIST = JSON.parse(document.getElementById('binListData').textContent);

    const returSelector = document.getElementById('returSelector');
    const itemRowsBody = document.getElementById('itemRowsBody');
    const itemCountLabel = document.getElementById('itemCountLabel');
    const supplierNama = document.getElementById('supplierNama');
    const supplierKontak = document.getElementById('supplierKontak');

    returSelector.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];

        supplierNama.textContent = opt.dataset.supplier || '-';
        supplierKontak.textContent = opt.dataset.kontak || '-';

        if (!this.value) {
            itemCountLabel.textContent = 'Pilih BAP Retur dulu';
            itemRowsBody.innerHTML = '<tr><td colspan="5" class="p-stack-md text-center text-on-surface-variant">Pilih BAP Retur di atas untuk memuat item klaimnya.</td></tr>';
            return;
        }

        itemRowsBody.innerHTML = '<tr><td colspan="5" class="p-stack-md text-center text-on-surface-variant">Memuat item klaim...</td></tr>';

        fetch(`/penerimaan-retur/retur/${this.value}/items`)
            .then(res => res.json())
            .then(data => renderItemRows(data.items))
            .catch(() => {
                itemRowsBody.innerHTML = '<tr><td colspan="5" class="p-stack-md text-center text-error">Gagal memuat item klaim. Coba lagi.</td></tr>';
            });
    });

    function renderItemRows(items) {
        itemRowsBody.innerHTML = '';

        const totalUnit = items.reduce((sum, it) => sum + it.qty_sisa_klaim, 0);
        itemCountLabel.textContent = items.length + ' Item Material (' + totalUnit + ' Unit)';

        if (items.length === 0) {
            itemRowsBody.innerHTML = '<tr><td colspan="5" class="p-stack-md text-center text-on-surface-variant">Semua item klaim BAP Retur ini sudah pernah diterima.</td></tr>';
            return;
        }

        items.forEach((item, index) => itemRowsBody.appendChild(buildItemRow(item, index)));
    }

    function buildItemRow(item, index) {
        const tr = document.createElement('tr');

        // --- Material & hidden fk_retur_detail ---
        const tdMaterial = document.createElement('td');
        tdMaterial.className = 'p-stack-sm align-top';
        tdMaterial.innerHTML = `<span class="font-label-bold text-on-surface">${item.nama_barang ?? '-'}</span>`;

        const hiddenReturDetail = document.createElement('input');
        hiddenReturDetail.type = 'hidden';
        hiddenReturDetail.name = `items[${index}][fk_retur_detail]`;
        hiddenReturDetail.value = item.fk_retur_detail;
        tdMaterial.appendChild(hiddenReturDetail);

        // --- Qty diklaim (read-only) ---
        const tdKlaim = document.createElement('td');
        tdKlaim.className = 'p-stack-sm text-center align-top font-label-bold text-on-surface-variant';
        tdKlaim.textContent = item.qty_sisa_klaim + ' Unit';

        // --- Qty tiba (input) ---
        const tdTiba = document.createElement('td');
        tdTiba.className = 'p-stack-sm text-center align-top';

        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.min = 1;
        qtyInput.max = item.qty_sisa_klaim;
        qtyInput.value = item.qty_sisa_klaim;
        qtyInput.name = `items[${index}][qty_tiba]`;
        qtyInput.className = 'w-16 text-center bg-surface-container-lowest font-label-bold text-[12px] py-1 border rounded-lg focus:outline-none';
        tdTiba.appendChild(qtyInput);

        // --- Bin tujuan ---
        const tdBin = document.createElement('td');
        tdBin.className = 'p-stack-sm align-top';

        const binSelect = document.createElement('select');
        binSelect.name = `items[${index}][fk_bin_tujuan]`;
        binSelect.required = true;
        binSelect.className = 'w-full bg-surface-container-lowest border border-surface-container-highest rounded-lg px-2 py-1.5 font-label-bold text-[12px] focus:outline-none';
        binSelect.innerHTML = '<option value="">-- Pilih Bin --</option>' +
            BIN_LIST.map(b => `<option value="${b.id}">${b.label}</option>`).join('');
        tdBin.appendChild(binSelect);

        // --- Status item (indikator visual, bukan field tersimpan) ---
        const tdStatus = document.createElement('td');
        tdStatus.className = 'p-stack-sm text-center align-top';

        function renderStatusChip() {
            const ready = binSelect.value && parseInt(qtyInput.value || '0', 10) > 0;
            tdStatus.innerHTML = ready
                ? '<span class="inline-block px-2.5 py-1 rounded-full bg-surface-container text-on-surface text-[10px] font-label-bold">Siap Masuk Stok</span>'
                : '<span class="inline-block px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[10px] font-label-bold">Menunggu Verifikasi</span>';
        }

        binSelect.addEventListener('change', renderStatusChip);
        qtyInput.addEventListener('input', renderStatusChip);
        renderStatusChip();

        tr.appendChild(tdMaterial);
        tr.appendChild(tdKlaim);
        tr.appendChild(tdTiba);
        tr.appendChild(tdBin);
        tr.appendChild(tdStatus);

        return tr;
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/penerimaan-retur/index.blade.php ENDPATH**/ ?>