

<?php $__env->startSection('title', 'Penerimaan Barang PO - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Penerimaan Barang PO'); ?>

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
        <span class="font-label-bold text-on-surface">Daftar Penerimaan</span>
    </nav>

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-stack-md mt-base">
        <div>
            <div class="flex items-center gap-stack-sm mb-1">
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-bold tracking-wider uppercase">Inbound Operations</span>
                <span class="text-[12px] text-outline font-sidebar-nav">Shift Pagi • Bay A2-A4</span>
            </div>
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">Penerimaan Barang Masuk (Goods Receipt Note - GRN)</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-2xl mt-1">Kelola pencatatan dan verifikasi material jaringan air minum, perpipaan, sambungan rumah (SR), meter air, serta aksesoris distribusi dari vendor terdaftar.</p>
        </div>

        <div class="flex items-center gap-stack-sm shrink-0">
            <div class="hidden xl:flex flex-col items-end px-3 py-1.5 rounded-lg bg-surface-container-low text-right">
                <span class="text-[11px] text-on-surface-variant font-body-sm flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span> ERP Sync Aktif
                </span>
                <span class="text-[12px] font-label-bold text-on-surface">SAP MM • <?php echo e(now()->format('H:i')); ?> WIB</span>
            </div>
            <button class="flex items-center gap-stack-sm px-container-padding py-2.5 rounded-lg bg-primary text-on-primary font-label-bold text-label-bold shadow-md hover:bg-primary-container transition-all transform active:scale-95" id="openModalBtn" type="button">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>+ Tambah Barang Masuk</span>
            </button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-stack-md">
    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-tertiary-fixed text-on-tertiary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-tertiary/10 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-tertiary-fixed">Menunggu Verifikasi</span>
            <span class="material-symbols-outlined text-[22px] text-tertiary-container">pending_actions</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-tertiary-fixed"><?php echo e(number_format($summary['menunggu_verifikasi'])); ?></div>
            <div class="text-[12px] font-body-sm text-on-tertiary-fixed-variant mt-1 font-medium">Dokumen PO Butuh QC Staging</div>
        </div>
        <div class="mt-3 pt-2 bg-on-tertiary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
            <span>Pending Kasubag / Kabag / Direktur</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-secondary-fixed text-on-secondary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-secondary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-secondary-fixed">Dalam Proses Alokasi</span>
            <span class="material-symbols-outlined text-[22px] text-secondary">forklift</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-secondary-fixed"><?php echo e(number_format($summary['dalam_alokasi'])); ?></div>
            <div class="text-[12px] font-body-sm text-on-secondary-fixed-variant mt-1 font-medium">Dokumen yang memiliki alokasi lokasi</div>
        </div>
        <div class="mt-3 pt-2 bg-on-secondary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
            <span>Berbasis lokasi detail penerimaan</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-primary-fixed text-on-primary-fixed shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/15 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-primary-fixed">Selesai / Disetujui</span>
            <span class="material-symbols-outlined text-[22px] text-primary">task_alt</span>
        </div>
        <div class="mt-4 z-10">
            <div class="font-stat-number text-stat-number text-on-primary-fixed"><?php echo e(number_format($summary['selesai'])); ?></div>
            <div class="text-[12px] font-body-sm text-on-primary-fixed-variant mt-1 font-medium">Dokumen berstatus APPROVED</div>
        </div>
        <div class="mt-3 pt-2 bg-on-primary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
            <span>Approval selesai</span>
            <span class="material-symbols-outlined text-[14px]">trending_up</span>
        </div>
    </div>

    <div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container text-on-surface shadow-sm relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/5 group-hover:scale-125 transition-transform"></div>
        <div class="flex items-center justify-between z-10">
            <span class="font-label-bold text-label-bold uppercase tracking-wider text-on-surface-variant">Total Barang Masuk</span>
            <span class="material-symbols-outlined text-[22px] text-primary">inventory</span>
        </div>
        <div class="mt-4 z-10 flex items-baseline gap-2">
            <div class="font-stat-number text-stat-number text-on-surface"><?php echo e(number_format($summary['total_barang'])); ?></div>
            <span class="font-label-bold text-[14px] text-on-surface-variant">Unit</span>
        </div>
        <div class="mt-3 pt-2 bg-surface-container-high/60 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-body-sm text-on-surface-variant">
            <span>Total qty request seluruh dokumen</span>
            <span class="font-label-bold text-primary">Live DB</span>
        </div>
    </div>
</div>

<div class="mt-stack-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col overflow-hidden">
    <div class="p-container-padding flex flex-col gap-stack-md bg-surface-container-lowest">
        <div class="flex flex-col gap-stack-md">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex flex-wrap items-center gap-1.5 p-1 rounded-xl bg-surface-container-low w-fit" role="tablist">
                    <a href="<?php echo e(route('penerimaan.index')); ?>" class="px-3.5 py-2 rounded-lg <?php echo e(!request('status') ? 'bg-surface-container-lowest font-label-bold text-primary shadow-sm' : 'font-sidebar-nav text-on-surface-variant hover:text-on-surface'); ?> transition-colors text-[13px] whitespace-nowrap">
                        Semua (<?php echo e(number_format($tabCounts['all'])); ?>)
                    </a>
                    <a href="<?php echo e(route('penerimaan.index', ['status' => 'menunggu'])); ?>" class="px-3.5 py-2 rounded-lg <?php echo e(request('status') === 'menunggu' ? 'bg-surface-container-lowest font-label-bold text-primary shadow-sm' : 'font-sidebar-nav text-on-surface-variant hover:text-on-surface'); ?> transition-colors flex items-center gap-1.5 text-[13px] whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-tertiary-container"></span>
                        Menunggu Verifikasi (<?php echo e(number_format($tabCounts['menunggu'])); ?>)
                    </a>
                    <a href="<?php echo e(route('penerimaan.index', ['status' => 'alokasi'])); ?>" class="px-3.5 py-2 rounded-lg <?php echo e(request('status') === 'alokasi' ? 'bg-surface-container-lowest font-label-bold text-primary shadow-sm' : 'font-sidebar-nav text-on-surface-variant hover:text-on-surface'); ?> transition-colors flex items-center gap-1.5 text-[13px] whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        Dalam Alokasi (<?php echo e(number_format($tabCounts['alokasi'])); ?>)
                    </a>
                    <a href="<?php echo e(route('penerimaan.index', ['status' => 'APPROVED'])); ?>" class="px-3.5 py-2 rounded-lg <?php echo e(request('status') === 'APPROVED' ? 'bg-surface-container-lowest font-label-bold text-primary shadow-sm' : 'font-sidebar-nav text-on-surface-variant hover:text-on-surface'); ?> transition-colors flex items-center gap-1.5 text-[13px] whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        Selesai / Approved (<?php echo e(number_format($tabCounts['selesai'])); ?>)
                    </a>
                </div>

                <div class="flex items-center gap-2 self-start lg:self-auto shrink-0">
                    <a href="<?php echo e(route('penerimaan.export', request()->query())); ?>" class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-label-bold text-[13px] whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">table_view</span>
                        Export XLS
                    </a>
                    <button type="button" id="advancedFilterBtn" class="relative inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container-low transition-colors font-label-bold text-[13px] whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">tune</span>
                        Filter Lanjutan
                        <?php if(request()->hasAny(['gudang', 'per_page']) || in_array(request('status'), ['DRAFT', 'REJECTED'], true)): ?>
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 rounded-full bg-primary border-2 border-surface-container-lowest"></span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <form method="GET" action="<?php echo e(route('penerimaan.index')); ?>" id="filterForm" class="flex flex-col gap-2.5">
                <div class="flex flex-col lg:flex-row lg:items-center gap-2.5">
                    <div class="relative flex-1 min-w-0">
                        <label class="sr-only" for="penerimaanSearch">Cari penerimaan</label>
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">search</span>
                        <input id="penerimaanSearch" name="search" value="<?php echo e(request('search')); ?>" class="w-full h-11 bg-surface-container-low pl-11 pr-3.5 rounded-lg font-body-sm text-[13px] text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Cari No. Penerimaan, No. PO, Supplier, atau No. Invoice..." type="text">
                    </div>

                    <div class="relative w-full lg:w-[270px] shrink-0" id="dateRangeWrap">
                        <button type="button" id="dateRangeButton" class="w-full h-11 flex items-center gap-2.5 px-3.5 rounded-lg bg-surface-container-low border border-transparent hover:border-outline-variant focus:outline-none focus:ring-2 focus:ring-primary/20 text-left transition-all">
                            <span class="material-symbols-outlined text-outline text-[19px]">calendar_month</span>
                            <span id="dateRangeLabel" class="flex-1 truncate text-[13px] text-on-surface"><?php echo e(request('date_from') || request('date_to') ? ((request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d M Y') : 'Semua tanggal') . ' - ' . (request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d M Y') : 'Sekarang')) : 'Pilih rentang tanggal'); ?></span>
                            <span class="material-symbols-outlined text-outline text-[18px]">expand_more</span>
                        </button>
                        <div id="dateRangePopover" class="hidden absolute left-0 top-full z-30 mt-2 w-full min-w-[330px] rounded-xl border border-outline-variant bg-surface-container-lowest p-4 shadow-xl">
                            <div class="mb-3 flex items-center justify-between">
                                <div>
                                    <p class="text-[13px] font-label-bold text-on-surface">Pilih rentang tanggal</p>
                                    <p class="text-[11px] text-on-surface-variant">Pilih tanggal awal dan tanggal akhir.</p>
                                </div>
                                <button type="button" id="clearDateRange" class="text-[11px] font-label-bold text-primary hover:underline">Reset</button>
                            </div>
                            <div class="grid grid-cols-2 gap-2.5">
                                <div>
                                    <label for="dateFrom" class="mb-1 block text-[11px] font-label-bold text-on-surface-variant">Dari</label>
                                    <input id="dateFrom" name="date_from" value="<?php echo e(request('date_from')); ?>" type="date" class="w-full h-10 rounded-lg border border-outline-variant bg-surface-container-low px-2.5 text-[12px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/20">
                                </div>
                                <div>
                                    <label for="dateTo" class="mb-1 block text-[11px] font-label-bold text-on-surface-variant">Sampai</label>
                                    <input id="dateTo" name="date_to" value="<?php echo e(request('date_to')); ?>" type="date" class="w-full h-10 rounded-lg border border-outline-variant bg-surface-container-low px-2.5 text-[12px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/20">
                                </div>
                            </div>
                            <button type="button" id="applyDateRange" class="mt-3 w-full h-9 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] hover:bg-primary-container transition-colors">Terapkan Tanggal</button>
                        </div>
                    </div>

                    <div class="w-full lg:w-[230px] shrink-0">
                        <select id="gudangFilter" name="gudang" onchange="this.form.submit()" class="w-full h-11 bg-surface-container-low border border-transparent px-3.5 rounded-lg font-body-sm text-[13px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
                            <option value="">Semua Gudang</option>
                            <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gudang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($gudang->id_gudang); ?>" <?php if((string) request('gudang') === (string) $gudang->id_gudang): echo 'selected'; endif; ?>><?php echo e($gudang->nm_gudang); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" class="hidden lg:flex h-11 w-11 shrink-0 rounded-lg bg-primary text-on-primary items-center justify-center hover:bg-primary-container transition-colors" title="Terapkan filter">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </button>
                </div>

                <div id="advancedFilterPanel" class="hidden flex-col gap-3 rounded-lg border border-outline-variant bg-surface-container-low/60 p-stack-md">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-stack-sm">
                        <div>
                            <label for="statusFilter" class="mb-1 block text-[11px] font-label-bold text-on-surface-variant">Status Dokumen</label>
                            <select id="statusFilter" name="status" class="w-full h-10 bg-surface-container-lowest border border-outline-variant px-3 rounded-lg font-body-sm text-[13px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
                                <option value="">Semua Status</option>
                                <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option['value']); ?>" <?php if((string) request('status') === (string) $option['value']): echo 'selected'; endif; ?>><?php echo e($option['label']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label for="perPageFilter" class="mb-1 block text-[11px] font-label-bold text-on-surface-variant">Tampilkan per Halaman</label>
                            <select id="perPageFilter" name="per_page" class="w-full h-10 bg-surface-container-lowest border border-outline-variant px-3 rounded-lg font-body-sm text-[13px] text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
                                <?php $__currentLoopData = ['10', '20', '30', '50', 'all']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option); ?>" <?php if($perPage === $option): echo 'selected'; endif; ?>><?php echo e($option === 'all' ? 'Semua' : $option); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="h-10 flex-1 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] hover:bg-primary-container transition-colors">Terapkan Filter</button>
                            <?php if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'gudang', 'per_page'])): ?>
                                <a href="<?php echo e(route('penerimaan.index')); ?>" class="h-10 px-3 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-lowest flex items-center justify-center transition-colors" title="Reset semua filter">
                                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    <div class="w-full overflow-x-auto">
        <table class="w-full text-left font-body-sm text-body-sm text-on-surface">
            <thead class="bg-surface-container-low font-label-bold text-label-bold text-on-surface-variant text-[12px] uppercase tracking-wider">
                <tr>
                    <th class="py-3 px-stack-md">No. Penerimaan</th>
                    <th class="py-3 px-stack-md">Tgl Masuk</th>
                    <th class="py-3 px-stack-md">No. PO Ref</th>
                    <th class="py-3 px-stack-md">No. Invoice / SJ</th>
                    <th class="py-3 px-stack-md">Nama Supplier</th>
                    <th class="py-3 px-stack-md text-right">Item / Qty</th>
                    <th class="py-3 px-stack-md">PIC Penerima</th>
                    <th class="py-3 px-stack-md">Status</th>
                    <th class="py-3 px-stack-md text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-none">
                <?php $__empty_1 = true; $__currentLoopData = $penerimaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penerimaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $kodeStatus = $penerimaan->kode_status;
                        $isPending = in_array($kodeStatus, ['PENDING_KASUBAG', 'PENDING_KABAG', 'PENDING_DIREKTUR'], true);
                        $hasLocation = $penerimaan->details->contains(fn ($detail) => !is_null($detail->fk_lokasi_barang));
                        $supplierName = $penerimaan->po?->supplier?->nm_master_supplier ?? '-';
                        $firstBarang = $penerimaan->details->first()?->barang;
                        $unitName = $firstBarang?->satuan?->nm_master_satuan ?? 'Unit';
                        $statusLabel = $penerimaan->statusPenerimaan?->nm_status_penerimaan_barang ?? $kodeStatus ?? '-';
                    ?>
                    <tr class="hover:bg-surface-container-low/60 transition-colors">
                        <td class="py-3.5 px-stack-md">
                            <a href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>" class="font-label-bold text-primary flex items-center gap-2 hover:underline">
                                <span class="material-symbols-outlined text-[16px] text-outline"><?php echo e($kodeStatus === 'DRAFT' ? 'draft' : 'description'); ?></span>
                                <?php echo e($penerimaan->kd_penerimaan); ?>

                            </a>
                        </td>
                        <td class="py-3.5 px-stack-md text-on-surface-variant">
                            <?php echo e($penerimaan->tgl_penerimaan_barang?->format('d M Y') ?? '-'); ?>

                            <span class="text-[11px] text-outline block"><?php echo e($penerimaan->created_at?->format('H:i') ?? '-'); ?> WIB</span>
                        </td>
                        <td class="py-3.5 px-stack-md font-medium text-on-surface"><?php echo e($penerimaan->po?->kd_po ?? '-'); ?></td>
                        <td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant"><?php echo e($penerimaan->no_sjinv_supplier ?: '-'); ?></td>
                        <td class="py-3.5 px-stack-md">
                            <div class="font-label-bold text-on-surface"><?php echo e($supplierName); ?></div>
                            <div class="text-[11px] text-on-surface-variant"><?php echo e($penerimaan->desc_penerimaan_barang ?: 'Detail penerimaan barang dari PO'); ?></div>
                        </td>
                        <td class="py-3.5 px-stack-md text-right">
                            <span class="font-label-bold text-on-surface"><?php echo e($penerimaan->totalSku()); ?> SKU</span>
                            <span class="text-[11px] text-on-surface-variant block"><?php echo e(number_format($penerimaan->totalQtyRequest())); ?> <?php echo e($unitName); ?></span>
                        </td>
                        <td class="py-3.5 px-stack-md">
                            <?php $pic = $penerimaan->submittedBy?->name ?? '-'; ?>
                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold"><?php echo e($pic !== '-' ? strtoupper(substr($pic, 0, 2)) : '--'); ?></div>
                                <span class="text-[13px] text-on-surface"><?php echo e($pic); ?></span>
                            </div>
                        </td>
                        <td class="py-3.5 px-stack-md">
                            <?php if($isPending): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-label-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary-container"></span> <?php echo e($statusLabel); ?>

                                </span>
                            <?php elseif($kodeStatus === 'APPROVED'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> <?php echo e($statusLabel); ?>

                                </span>
                            <?php elseif($kodeStatus === 'REJECTED'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container text-[11px] font-label-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> <?php echo e($statusLabel); ?>

                                </span>
                            <?php elseif($hasLocation): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[11px] font-label-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> <?php echo e($statusLabel); ?> • Alokasi
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[11px] font-label-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> <?php echo e($statusLabel); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-stack-md text-center">
                            <?php if($kodeStatus === 'DRAFT' || $kodeStatus === 'REJECTED'): ?>
                                <a href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-surface-container text-on-surface font-label-bold text-[12px] hover:bg-surface-container-high transition-all">
                                    <span class="material-symbols-outlined text-[14px]">edit_note</span> <?php echo e($kodeStatus === 'REJECTED' ? 'Perbaiki' : 'Lanjutkan Draft'); ?>

                                </a>
                            <?php elseif($isPending): ?>
                                <a href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] shadow-sm hover:bg-primary-container transition-all">
                                    <span class="material-symbols-outlined text-[14px]">fact_check</span> <?php echo e($hasLocation ? 'Proses Putaway' : 'Verifikasi & Alokasi'); ?>

                                </a>
                            <?php else: ?>
                                <div class="flex items-center justify-center gap-1">
                                    <a href="<?php echo e(route('penerimaan.verifikasi', $penerimaan)); ?>" class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <button class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Cetak" type="button" onclick="window.print()">
                                        <span class="material-symbols-outlined text-[18px]">print</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
                                <span class="font-label-bold text-on-surface">Belum ada data penerimaan</span>
                                <span class="text-sm mt-1">Data penerimaan dari database akan muncul di sini.</span>
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
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mt-stack-md">
    <div class="lg:col-span-2 p-container-padding rounded-xl bg-surface-container-lowest shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-stack-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">domain_verification</span>
                    <h3 class="font-headline-md text-[18px] font-bold text-on-surface">Status Pintu Masuk / Inbound Bays</h3>
                </div>
                <span class="px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface-variant text-[11px] font-label-bold">Live Monitoring</span>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-stack-md">Alokasi antrean bongkar muatan armada logistik vendor di area loading dock utama.</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-stack-sm">
                <div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                    <div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 01</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-error-container text-on-error-container">Inbound</span></div>
                    <div class="text-[12px] font-body-sm text-on-surface-variant truncate">Area penerimaan material utama</div>
                    <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-primary h-full rounded-full" style="width: 70%"></div></div>
                    <span class="text-[10px] text-outline text-right">Staging aktif</span>
                </div>
                <div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                    <div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 02</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-tertiary-fixed text-on-tertiary-fixed">Staging</span></div>
                    <div class="text-[12px] font-body-sm text-on-surface-variant truncate">Area QC dan pemeriksaan barang</div>
                    <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-tertiary h-full rounded-full" style="width: 35%"></div></div>
                    <span class="text-[10px] text-outline text-right">Menunggu proses</span>
                </div>
                <div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                    <div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 03</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-primary-fixed text-on-primary-fixed">Tersedia</span></div>
                    <div class="text-[12px] font-body-sm text-on-surface-variant truncate">Siap untuk armada incoming</div>
                    <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-primary h-full rounded-full" style="width: 0%"></div></div>
                    <span class="text-[10px] text-outline text-right">Standby</span>
                </div>
            </div>
        </div>
        <div class="mt-stack-md pt-stack-sm flex items-center justify-between text-[12px] text-on-surface-variant">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-primary">verified_user</span> SOP Penerimaan Material: seluruh barang wajib inspeksi visual dan pemeriksaan dokumen pendukung.</span>
            <span class="font-label-bold text-primary">Inbound Monitoring</span>
        </div>
    </div>

    <?php
        $accuracyPct = (float) $summary['accuracy_percentage'];
        $ringRadius = 26;
        $ringCircumference = 2 * M_PI * $ringRadius;
        $ringOffset = $ringCircumference - ($accuracyPct / 100) * $ringCircumference;
    ?>
    <div class="self-start p-container-padding rounded-xl bg-surface-container-low shadow-sm flex flex-col">
        <div class="flex items-center gap-2 mb-1">
            <span class="material-symbols-outlined text-secondary text-[20px]">analytics</span>
            <h3 class="font-headline-md text-[15px] font-bold text-on-surface">Akurasi Penerimaan</h3>
        </div>
        <p class="font-body-sm text-[12px] text-on-surface-variant leading-snug">Pencapaian kesesuaian fisik vs dokumen penerimaan yang tersimpan di database.</p>

        <div class="mt-3 flex items-center gap-3">
            <div class="relative shrink-0 w-[64px] h-[64px]">
                <svg viewBox="0 0 64 64" class="w-full h-full -rotate-90">
                    <circle cx="32" cy="32" r="<?php echo e($ringRadius); ?>" fill="none" stroke-width="6" class="stroke-surface-container-highest"></circle>
                    <circle
                        cx="32" cy="32" r="<?php echo e($ringRadius); ?>" fill="none" stroke-width="6"
                        stroke-linecap="round"
                        class="stroke-primary transition-[stroke-dashoffset] duration-700 ease-out"
                        stroke-dasharray="<?php echo e($ringCircumference); ?>"
                        stroke-dashoffset="<?php echo e($ringOffset); ?>"
                    ></circle>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="font-headline-md text-[13px] font-bold text-on-surface"><?php echo e(number_format($accuracyPct, 1)); ?>%</span>
                </div>
            </div>

            <div class="flex-1 min-w-0 flex flex-col gap-1 text-[11px] font-body-sm">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-on-surface-variant">Item Sesuai:</span>
                    <span class="font-label-bold text-on-surface"><?php echo e(number_format($summary['item_sesuai'])); ?> Unit</span>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <span class="text-on-surface-variant">Discrepancy / Rusak:</span>
                    <span class="font-label-bold text-error"><?php echo e(number_format($summary['item_discrepancy'])); ?> Unit (<?php echo e(number_format($summary['discrepancy_percentage'], 1)); ?>%)</span>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <span class="text-on-surface-variant">Rata-rata Waktu Verifikasi:</span>
                    <span class="font-label-bold text-on-surface"><?php echo e(number_format($summary['avg_verifikasi_minutes'])); ?> Menit</span>
                </div>
            </div>
        </div>

        <div class="mt-3 pt-2 border-t border-outline-variant flex items-center justify-between text-[11px]">
            <span class="text-on-surface-variant">Laporan Rekonsiliasi Supplier</span>
            <a href="<?php echo e(route('penerimaan.laporan-akurasi', request()->query())); ?>" class="font-label-bold text-primary hover:underline">Unduh PDF</a>
        </div>
    </div>
</div>

<?php if($errors->any()): ?>
    <div class="fixed bottom-6 right-6 z-50 flex items-start gap-3 px-stack-md py-3 rounded-xl bg-error-container text-on-error-container shadow-2xl max-w-md">
        <span class="material-symbols-outlined text-[22px]">error</span>
        <div class="flex flex-col gap-1 text-[12px]">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><?php echo e($error); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

<div class="fixed inset-0 z-50 hidden bg-on-surface/40 backdrop-blur-[2px]" id="goodsReceiptModal">
    <div class="min-h-full flex items-center justify-center p-4">
        <div class="w-full max-w-3xl rounded-2xl bg-surface-container-lowest shadow-2xl overflow-hidden">
            <div class="px-container-padding py-stack-md border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h2 class="font-headline-md text-[20px] font-bold text-on-surface">Inisiasi Penerimaan Barang Masuk Baru</h2>
                    <p class="text-[12px] text-on-surface-variant mt-1">Buat dokumen penerimaan berdasarkan Purchase Order yang sudah APPROVED.</p>
                </div>
                <button class="p-1 rounded-lg text-outline hover:bg-surface-container-high hover:text-on-surface transition-colors" id="closeModalBtn" type="button">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form method="POST" action="<?php echo e(route('penerimaan.store')); ?>" id="goodsReceiptForm">
                <?php echo csrf_field(); ?>
                <div class="p-container-padding overflow-y-auto max-h-[70vh] flex flex-col gap-stack-md">
                    <div class="flex flex-col gap-1">
                        <label class="font-label-bold text-label-bold text-on-surface" for="poSelector">Pilih Nomor Purchase Order (PO) <span class="text-error">*</span></label>
                        <div class="relative">
                            <select name="fk_po" required class="w-full bg-surface-container-low text-on-surface px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm focus:outline-none focus:ring-2 focus:ring-primary appearance-none cursor-pointer" id="poSelector">
                                <option value="">-- Pilih PO Approved --</option>
                                <?php $__currentLoopData = $poTerbuka; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($po->id_po); ?>" <?php if(old('fk_po') == $po->id_po): echo 'selected'; endif; ?>>
                                        <?php echo e($po->kd_po); ?> — <?php echo e($po->supplier?->nm_master_supplier ?? '-'); ?> (<?php echo e($po->details->count()); ?> Item)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-stack-md top-2.5 pointer-events-none text-outline text-[20px]">expand_more</span>
                        </div>
                        <?php if($poTerbuka->isEmpty()): ?>
                            <span class="text-[11px] text-error">Tidak ada PO APPROVED yang tersedia untuk dibuatkan penerimaan.</span>
                        <?php else: ?>
                            <span class="text-[11px] text-on-surface-variant">Hanya PO APPROVED yang belum memiliki penerimaan aktif yang ditampilkan.</span>
                        <?php endif; ?>
                    </div>

                    <div class="p-stack-md rounded-lg bg-surface-container-low text-on-surface" id="poPreviewCard">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[18px]">info</span>
                            <span class="font-label-bold text-[13px]">Pilih PO untuk melihat ringkasannya.</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-stack-md">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-bold text-label-bold text-on-surface" for="invNumber">Nomor Invoice / Surat Jalan Supplier</label>
                            <input name="no_sjinv_supplier" value="<?php echo e(old('no_sjinv_supplier')); ?>" class="bg-surface-container-low px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary" id="invNumber" placeholder="Contoh: INV-2026-SMJ-9912" type="text">
                            <span class="text-[11px] text-on-surface-variant">Nomor dari dokumen fisik supplier.</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-bold text-label-bold text-on-surface" for="receivedDate">Tanggal Diterima Fisik <span class="text-error">*</span></label>
                            <input name="tgl_penerimaan_barang" value="<?php echo e(old('tgl_penerimaan_barang', now()->format('Y-m-d'))); ?>" required class="bg-surface-container-low px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary" id="receivedDate" type="date">
                            <span class="text-[11px] text-on-surface-variant">Tanggal barang diterima di loading bay.</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="font-label-bold text-label-bold text-on-surface" for="picPenerima">Petugas Penerima (PIC Gudang) <span class="text-error">*</span></label>
                        <div class="flex items-center gap-3 bg-surface-container-low px-stack-md py-2.5 rounded-lg">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-bold">
                                <?php echo e(strtoupper(substr(auth()->user()?->name ?? 'US', 0, 2))); ?>

                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="font-label-bold text-[13px] text-on-surface"><?php echo e(auth()->user()?->name ?? 'User'); ?></div>
                                <div class="text-[11px] text-on-surface-variant">User yang sedang membuka halaman penerimaan</div>
                            </div>
                            <span class="material-symbols-outlined text-primary text-[19px]">person_check</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="font-label-bold text-label-bold text-on-surface" for="shippingNotes">Catatan Penerimaan <span class="text-outline font-normal">(Opsional)</span></label>
                        <textarea name="desc_penerimaan_barang" class="bg-surface-container-low px-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary resize-none" id="shippingNotes" placeholder="Catatan kondisi barang, armada, atau informasi tambahan..." rows="3"><?php echo e(old('desc_penerimaan_barang')); ?></textarea>
                    </div>
                </div>

                <div class="px-container-padding py-stack-md bg-surface-container-low flex flex-col-reverse sm:flex-row items-center justify-end gap-stack-sm">
                    <button class="w-full sm:w-auto px-stack-md py-2 rounded-lg bg-surface-container-highest text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-bold text-label-bold transition-colors" id="cancelModalBtn" type="button">Batal</button>
                    <button class="w-full sm:w-auto px-container-padding py-2 rounded-lg bg-primary text-on-primary hover:bg-primary-container font-label-bold text-label-bold shadow-md transition-all flex items-center justify-center gap-2" id="submitModalBtn" type="submit">
                        <span>Lanjut ke Verifikasi &amp; Alokasi Barang</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-stack-md py-3 rounded-xl bg-inverse-surface text-inverse-on-surface shadow-2xl" id="toastSuccess">
        <span class="material-symbols-outlined text-primary-fixed text-[22px]">check_circle</span>
        <div class="flex flex-col">
            <span class="font-label-bold text-[13px]">Berhasil!</span>
            <span class="font-body-sm text-[11px] text-inverse-on-surface/80"><?php echo e(session('success')); ?></span>
        </div>
    </div>
<?php endif; ?>

<script>
(function () {
    const modal = document.getElementById('goodsReceiptModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const poSelector = document.getElementById('poSelector');
    const poPreview = document.getElementById('poPreviewCard');
    <?php
        $poData = $poTerbuka->map(function ($po) {
            $units = $po->details
                ->map(fn ($detail) => $detail->barang?->satuan?->nm_master_satuan)
                ->filter()
                ->unique()
                ->values();

            return [
                'id' => $po->id_po,
                'kode' => $po->kd_po,
                'supplier' => $po->supplier?->nm_master_supplier ?? '-',
                'tanggal' => $po->created_at?->format('d M Y') ?? '-',
                'items' => $po->details->count(),
                'qty' => (int) $po->details->sum('qty_request'),
                'unit' => $units->count() === 1 ? $units->first() : ($units->isEmpty() ? 'Unit' : 'Beragam Satuan'),
            ];
        })->values()->toArray();
    ?>

    const poData = <?php echo json_encode($poData); ?>;
    const dateRangeButton = document.getElementById('dateRangeButton');
    const dateRangePopover = document.getElementById('dateRangePopover');
    const dateRangeLabel = document.getElementById('dateRangeLabel');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const applyDateRange = document.getElementById('applyDateRange');
    const clearDateRange = document.getElementById('clearDateRange');
    const filterForm = dateRangeButton?.closest('form');
    const advancedFilterBtn = document.getElementById('advancedFilterBtn');
    const advancedFilterPanel = document.getElementById('advancedFilterPanel');

    advancedFilterBtn?.addEventListener('click', function () {
        advancedFilterPanel?.classList.toggle('hidden');
        advancedFilterPanel?.classList.toggle('flex');
    });

    <?php if(request()->hasAny(['per_page']) || in_array(request('status'), ['DRAFT', 'REJECTED'], true)): ?>
        advancedFilterPanel?.classList.remove('hidden');
        advancedFilterPanel?.classList.add('flex');
    <?php endif; ?>

    function formatDate(value) {
        if (!value) return '';
        const date = new Date(value + 'T00:00:00');
        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        }).format(date);
    }

    function updateDateRangeLabel() {
        if (!dateFrom?.value && !dateTo?.value) {
            if (dateRangeLabel) dateRangeLabel.textContent = 'Pilih rentang tanggal';
            return;
        }

        const from = dateFrom?.value ? formatDate(dateFrom.value) : 'Semua tanggal';
        const to = dateTo?.value ? formatDate(dateTo.value) : 'Sekarang';

        if (dateRangeLabel) dateRangeLabel.textContent = `${from} - ${to}`;
    }

    function toggleDateRange() {
        dateRangePopover?.classList.toggle('hidden');
    }

    dateRangeButton?.addEventListener('click', toggleDateRange);
    dateFrom?.addEventListener('change', function () {
        if (dateTo && dateFrom.value) dateTo.min = dateFrom.value;
        updateDateRangeLabel();
    });
    dateTo?.addEventListener('change', function () {
        if (dateFrom && dateTo.value) dateFrom.max = dateTo.value;
        updateDateRangeLabel();
    });

    applyDateRange?.addEventListener('click', function () {
        if (dateFrom?.value && dateTo?.value && dateFrom.value > dateTo.value) {
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            return;
        }

        updateDateRangeLabel();
        dateRangePopover?.classList.add('hidden');
        filterForm?.submit();
    });

    clearDateRange?.addEventListener('click', function () {
        if (dateFrom) dateFrom.value = '';
        if (dateTo) dateTo.value = '';
        if (dateTo) dateTo.removeAttribute('min');
        if (dateFrom) dateFrom.removeAttribute('max');
        updateDateRangeLabel();
    });

    document.addEventListener('click', function (event) {
        if (!document.getElementById('dateRangeWrap')?.contains(event.target)) {
            dateRangePopover?.classList.add('hidden');
        }
    });

    updateDateRangeLabel();

    function openModal() {
        modal?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal?.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function renderPreview() {
        const po = poData.find(item => String(item.id) === String(poSelector?.value));
        if (!po) {
            poPreview.innerHTML = '<div class="flex items-center gap-2"><span class="material-symbols-outlined text-primary text-[18px]">info</span><span class="font-label-bold text-[13px]">Pilih PO untuk melihat ringkasannya.</span></div>';
            return;
        }

        poPreview.innerHTML = `
            <div class="flex items-center justify-between pb-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                    <span class="font-label-bold text-[13px] text-on-surface">Data Terverifikasi dari Purchase Order</span>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">PO APPROVED</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-stack-sm text-[12px] font-body-sm pt-1">
                <div><span class="text-on-surface-variant block">Nama Supplier</span><span class="font-label-bold text-on-surface">${po.supplier}</span></div>
                <div><span class="text-on-surface-variant block">Tanggal PO</span><span class="font-label-bold text-on-surface">${po.tanggal}</span></div>
                <div><span class="text-on-surface-variant block">Total Barang Terdaftar</span><span class="font-label-bold text-primary">${po.items} Baris / ${Number(po.qty).toLocaleString('id-ID')} ${po.unit}</span></div>
                <div><span class="text-on-surface-variant block">Nomor PO</span><span class="font-label-bold text-on-surface">${po.kode}</span></div>
            </div>
        `;
    }

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
    poSelector?.addEventListener('change', renderPreview);

    modal?.addEventListener('click', function (event) {
        if (event.target === modal) closeModal();
    });

    <?php if(old('fk_po')): ?>
        openModal();
        renderPreview();
    <?php endif; ?>

    setTimeout(() => document.getElementById('toastSuccess')?.remove(), 5000);
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/penerimaan/index.blade.php ENDPATH**/ ?>