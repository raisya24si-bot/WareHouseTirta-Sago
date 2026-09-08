

<?php $__env->startSection('title', 'Penerimaan Barang PO - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Penerimaan Barang PO'); ?>

<?php $__env->startSection('content'); ?>
<!-- Top Ambient Glow -->
<div class="relative w-full">
<div class="absolute -top-10 left-1/4 w-96 h-32 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
<div class="absolute -top-10 right-10 w-72 h-28 bg-tertiary/10 rounded-full blur-2xl pointer-events-none"></div>
</div>
<!-- Breadcrumbs & Screen Header -->
<div class="flex flex-col gap-base pt-container-padding">
<nav class="flex items-center gap-stack-sm text-body-sm text-on-surface-variant font-body-sm">
<a class="hover:text-primary transition-colors" href="#">Inventory</a>
<span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
<a class="hover:text-primary transition-colors" href="#">Penerimaan Barang Masuk</a>
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
<!-- Live Sync Status & Direct Action -->
<div class="flex items-center gap-stack-sm shrink-0">
<div class="hidden xl:flex flex-col items-end px-3 py-1.5 rounded-lg bg-surface-container-low text-right">
<span class="text-[11px] text-on-surface-variant font-body-sm flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-primary animate-ping"></span> ERP Sync Aktif
          </span>
<span class="text-[12px] font-label-bold text-on-surface">SAP MM • 10:42 WIB</span>
</div>
<button class="flex items-center gap-stack-sm px-container-padding py-2.5 rounded-lg bg-primary text-on-primary font-label-bold text-label-bold shadow-md hover:bg-primary-container transition-all transform active:scale-95" id="openModalBtn" type="button">
<span class="material-symbols-outlined text-[20px]">add_circle</span>
<span class="">+ Tambah Barang Masuk</span>
</button>
</div>
</div>
</div>
<!-- Top Metrics Summary Cards (4-up Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-stack-md">
<!-- Card 1: Menunggu Verifikasi -->
<div class="flex flex-col justify-between p-stack-md rounded-xl bg-tertiary-fixed text-on-tertiary-fixed shadow-sm relative overflow-hidden group">
<div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-tertiary/10 group-hover:scale-125 transition-transform"></div>
<div class="flex items-center justify-between z-10">
<span class="font-label-bold text-label-bold uppercase tracking-wider text-on-tertiary-fixed">Menunggu Verifikasi</span>
<span class="material-symbols-outlined text-[22px] text-tertiary-container">pending_actions</span>
</div>
<div class="mt-4 z-10">
<div class="font-stat-number text-stat-number text-on-tertiary-fixed">5</div>
<div class="text-[12px] font-body-sm text-on-tertiary-fixed-variant mt-1 font-medium">Dokumen PO Butuh QC Staging</div>
</div>
<div class="mt-3 pt-2 bg-on-tertiary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
<span class="">Prioritas Tinggi: 2 Dokumen</span>
<span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</div>
</div>
<!-- Card 2: Dalam Proses Alokasi -->
<div class="flex flex-col justify-between p-stack-md rounded-xl bg-secondary-fixed text-on-secondary-fixed shadow-sm relative overflow-hidden group">
<div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-secondary/15 group-hover:scale-125 transition-transform"></div>
<div class="flex items-center justify-between z-10">
<span class="font-label-bold text-label-bold uppercase tracking-wider text-on-secondary-fixed">Dalam Proses Alokasi</span>
<span class="material-symbols-outlined text-[22px] text-secondary">forklift</span>
</div>
<div class="mt-4 z-10">
<div class="font-stat-number text-stat-number text-on-secondary-fixed">3</div>
<div class="text-[12px] font-body-sm text-on-secondary-fixed-variant mt-1 font-medium">Dokumen Putaway Rak Gudang</div>
</div>
<div class="mt-3 pt-2 bg-on-secondary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
<span class="">Kapasitas Bay Tersedia: 78%</span>
<span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</div>
</div>
<!-- Card 3: Disetujui / Selesai -->
<div class="flex flex-col justify-between p-stack-md rounded-xl bg-primary-fixed text-on-primary-fixed shadow-sm relative overflow-hidden group">
<div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/15 group-hover:scale-125 transition-transform"></div>
<div class="flex items-center justify-between z-10">
<span class="font-label-bold text-label-bold uppercase tracking-wider text-on-primary-fixed">Selesai / Disetujui</span>
<span class="material-symbols-outlined text-[22px] text-primary">task_alt</span>
</div>
<div class="mt-4 z-10">
<div class="font-stat-number text-stat-number text-on-primary-fixed">28</div>
<div class="text-[12px] font-body-sm text-on-primary-fixed-variant mt-1 font-medium">Dokumen Bulan Berjalan</div>
</div>
<div class="mt-3 pt-2 bg-on-primary-fixed/5 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-label-bold">
<span class="">Target SLA: 99.4% Tercapai</span>
<span class="material-symbols-outlined text-[14px]">trending_up</span>
</div>
</div>
<!-- Card 4: Total Volume Masuk -->
<div class="flex flex-col justify-between p-stack-md rounded-xl bg-surface-container text-on-surface shadow-sm relative overflow-hidden group">
<div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-primary/5 group-hover:scale-125 transition-transform"></div>
<div class="flex items-center justify-between z-10">
<span class="font-label-bold text-label-bold uppercase tracking-wider text-on-surface-variant">Total Barang Masuk</span>
<span class="material-symbols-outlined text-[22px] text-primary">inventory</span>
</div>
<div class="mt-4 z-10 flex items-baseline gap-2">
<div class="font-stat-number text-stat-number text-on-surface">1,420</div>
<span class="font-label-bold text-[14px] text-on-surface-variant">Unit</span>
</div>
<div class="mt-3 pt-2 bg-surface-container-high/60 -mx-stack-md -mb-stack-md px-stack-md py-1.5 flex items-center justify-between text-[11px] font-body-sm text-on-surface-variant">
<span class="">Volume Metrik: 184 m³</span>
<span class="font-label-bold text-primary">+12.4% MoM</span>
</div>
</div>
</div>
<!-- Main Management Panel -->
<div class="mt-stack-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col overflow-hidden">
<!-- Filter & Action Controls -->
<div class="p-container-padding flex flex-col gap-stack-md bg-surface-container-lowest">
<!-- Tabs Filter -->
<div class="flex flex-wrap items-center justify-between gap-stack-sm pb-2">
<div class="flex items-center gap-base p-1 rounded-xl bg-surface-container-low" role="tablist">
<button class="px-stack-md py-1.5 rounded-lg bg-surface-container-lowest font-label-bold text-label-bold text-primary shadow-sm transition-colors" type="button">
            Semua (36)
          </button>
<button class="px-stack-md py-1.5 rounded-lg font-sidebar-nav text-sidebar-nav text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-1.5" type="button">
<span class="w-2 h-2 rounded-full bg-tertiary-container"></span>
            Menunggu Verifikasi (5)
          </button>
<button class="px-stack-md py-1.5 rounded-lg font-sidebar-nav text-sidebar-nav text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-1.5" type="button">
<span class="w-2 h-2 rounded-full bg-secondary"></span>
            Dalam Alokasi (3)
          </button>
<button class="px-stack-md py-1.5 rounded-lg font-sidebar-nav text-sidebar-nav text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-1.5" type="button">
<span class="w-2 h-2 rounded-full bg-primary"></span>
            Selesai / Approved (28)
          </button>
</div>
<!-- Quick Filter Utility Actions -->
<div class="flex items-center gap-2 text-on-surface-variant text-body-sm">
<button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high transition-colors font-label-bold text-[13px] text-on-surface" type="button">
<span class="material-symbols-outlined text-[16px]">file_download</span>
            Export XLS
          </button>
<button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high transition-colors font-label-bold text-[13px] text-on-surface" type="button">
<span class="material-symbols-outlined text-[16px]">tune</span>
            Filter Lanjutan
          </button>
</div>
</div>
<!-- Search Bar & Date Filter -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-stack-sm items-center">
<div class="md:col-span-7 relative flex items-center">
<span class="material-symbols-outlined absolute left-stack-md text-outline text-[20px]">search</span>
<input class="w-full bg-surface-container-low pl-11 pr-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:shadow-md transition-all" placeholder="Cari No. Penerimaan, No. PO, Supplier, atau No. Invoice..." type="text">
</div>
<div class="md:col-span-3 relative flex items-center">
<span class="material-symbols-outlined absolute left-stack-md text-outline text-[18px]">calendar_today</span>
<input class="w-full bg-surface-container-low pl-10 pr-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest focus:shadow-md transition-all cursor-pointer" type="text" value="01 Okt 2023 - 24 Okt 2023">
</div>
<div class="md:col-span-2 flex items-center gap-base">
<select class="w-full bg-surface-container-low px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none cursor-pointer">
<option>Semua Gudang</option>
<option>Gudang Pusat (Bay A)</option>
<option>Gudang Transit (Bay C)</option>
<option>Cold Storage (Bay D)</option>
</select>
</div>
</div>
</div>
<!-- Data Table -->
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
<tbody class="divide-none"><tr class="hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">description</span> GRN-2023-0891</td><td class="py-3.5 px-stack-md text-on-surface-variant">24 Okt 2023 <span class="text-[11px] text-outline block">09:15 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0891</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant">INV-2023-PMN-8812</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">PT. Pipa Mas Nusantara</div><div class="text-[11px] text-on-surface-variant">Pipa HDPE &amp; Valve Distribusi</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">3 SKU</span><span class="text-[11px] text-on-surface-variant block">65 Unit (Pipa HDPE, Valve)</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">WH</div><span class="text-[13px] text-on-surface">Wahyu H.</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-tertiary-container"></span> Menunggu Verifikasi</span></td><td class="py-3.5 px-stack-md text-center"><a href="<?php echo e(route('penerimaan.verifikasi', 'GRN-2023-0891')); ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] shadow-sm hover:bg-primary-container transition-all"><span class="material-symbols-outlined text-[14px]">fact_check</span> Verifikasi &amp; Alokasi</a></td></tr><tr class="bg-surface-container-lowest hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">description</span> GRN-2023-0880</td><td class="py-3.5 px-stack-md text-on-surface-variant">24 Okt 2023 <span class="text-[11px] text-outline block">08:30 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0875</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant">INV-BAI-7719</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">PT. Barindo Anggun Industri</div><div class="text-[11px] text-on-surface-variant">Meter Air Kuningan &amp; Aksesoris SR</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">4 SKU</span><span class="text-[11px] text-on-surface-variant block">350 Unit (Water Meter 1/2" SNI)</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">BS</div><span class="text-[13px] text-on-surface">Budi Santoso</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-tertiary-container"></span> Menunggu Verifikasi</span></td><td class="py-3.5 px-stack-md text-center"><a href="<?php echo e(route('penerimaan.verifikasi', 'GRN-2023-0880')); ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-primary text-on-primary font-label-bold text-[12px] shadow-sm hover:bg-primary-container transition-all"><span class="material-symbols-outlined text-[14px]">fact_check</span> Verifikasi &amp; Alokasi</a></td></tr><tr class="hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">description</span> GRN-2023-0879</td><td class="py-3.5 px-stack-md text-on-surface-variant">23 Okt 2023 <span class="text-[11px] text-outline block">16:40 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0862</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant">INV-VJM-0941</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">PT. Vinilon Jaya Mandiri</div><div class="text-[11px] text-on-surface-variant">Pipa uPVC Limbah &amp; Air Bersih SNI</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">2 SKU</span><span class="text-[11px] text-on-surface-variant block">80 Batang (RRJ 4" &amp; 6")</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">WH</div><span class="text-[13px] text-on-surface">Wahyu H.</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Dalam Alokasi (Rak B4)</span></td><td class="py-3.5 px-stack-md text-center"><a href="<?php echo e(route('penerimaan.verifikasi', 'GRN-2023-0879')); ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-surface-container-high text-on-surface font-label-bold text-[12px] hover:bg-surface-container-highest transition-all"><span class="material-symbols-outlined text-[14px]">forklift</span> Proses Putaway</a></td></tr><tr class="hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">description</span> GRN-2023-0878</td><td class="py-3.5 px-stack-md text-on-surface-variant">23 Okt 2023 <span class="text-[11px] text-outline block">14:10 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0850</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant">INV-TKE-5520</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">CV. Tirta Kencana Engineering</div><div class="text-[11px] text-on-surface-variant">Clamp Saddle, Flange &amp; Gibault</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">12 SKU</span><span class="text-[11px] text-on-surface-variant block">450 Pcs (Clamp, Flange)</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">DA</div><span class="text-[13px] text-on-surface">Deni Anggara</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Disetujui / Selesai</span></td><td class="py-3.5 px-stack-md text-center"><div class="flex items-center justify-center gap-1"><button class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Lihat Detail" type="button"><span class="material-symbols-outlined text-[18px]">visibility</span></button><button class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Cetak Surat GRN" type="button"><span class="material-symbols-outlined text-[18px]">print</span></button></div></td></tr><tr class="hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">description</span> GRN-2023-0877</td><td class="py-3.5 px-stack-md text-on-surface-variant">22 Okt 2023 <span class="text-[11px] text-outline block">11:20 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0844</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-on-surface-variant">INV-ALT-3310</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">PT. Adhi Karya Logistik Tirta</div><div class="text-[11px] text-on-surface-variant">Pompa Submersible &amp; Panel Inverter</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">2 SKU</span><span class="text-[11px] text-on-surface-variant block">4 Unit (Pompa &amp; Panel)</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">WH</div><span class="text-[13px] text-on-surface">Wahyu H.</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Disetujui / Selesai</span></td><td class="py-3.5 px-stack-md text-center"><div class="flex items-center justify-center gap-1"><button class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Lihat Detail" type="button"><span class="material-symbols-outlined text-[18px]">visibility</span></button><button class="p-1.5 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors" title="Cetak Surat GRN" type="button"><span class="material-symbols-outlined text-[18px]">print</span></button></div></td></tr><tr class="hover:bg-surface-container-low/60 transition-colors"><td class="py-3.5 px-stack-md font-label-bold text-secondary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">draft</span> GRN-2023-0876</td><td class="py-3.5 px-stack-md text-on-surface-variant">22 Okt 2023 <span class="text-[11px] text-outline block">09:05 WIB</span></td><td class="py-3.5 px-stack-md font-medium text-on-surface">PO-2023-0839</td><td class="py-3.5 px-stack-md font-sidebar-nav text-[12px] text-outline-variant">SJ-BPI-11</td><td class="py-3.5 px-stack-md"><div class="font-label-bold text-on-surface">PT. Bakrie Pipe Industries</div><div class="text-[11px] text-on-surface-variant">Pipa Baja GI &amp; Fitting Spesial</div></td><td class="py-3.5 px-stack-md text-right"><span class="font-label-bold text-on-surface">3 SKU</span><span class="text-[11px] text-on-surface-variant block">24 Batang (Medium A 6")</span></td><td class="py-3.5 px-stack-md"><div class="flex items-center gap-1.5"><div class="w-6 h-6 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center text-[10px] font-bold">BS</div><span class="text-[13px] text-on-surface">Budi Santoso</span></div></td><td class="py-3.5 px-stack-md"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[11px] font-label-bold"><span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Draft</span></td><td class="py-3.5 px-stack-md text-center"><button class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-surface-container text-on-surface font-label-bold text-[12px] hover:bg-surface-container-high transition-all" type="button"><span class="material-symbols-outlined text-[14px]">edit_note</span> Lanjutkan Draft</button></td></tr></tbody>
</table>
</div>
<!-- Table Pagination & Counter -->
<div class="p-stack-md bg-surface-container-low flex flex-col sm:flex-row items-center justify-between gap-stack-sm text-body-sm text-on-surface-variant">
<div class="flex items-center gap-stack-sm">
<span class="">Menampilkan <span class="font-label-bold text-on-surface">1 - 6</span> dari <span class="font-label-bold text-on-surface">36</span> dokumen</span>
<span class="text-outline">|</span>
<div class="flex items-center gap-1">
<span class="text-[12px]">Baris per halaman:</span>
<select class="bg-surface-container-lowest text-on-surface py-0.5 px-2 rounded-lg text-[12px] font-label-bold focus:outline-none">
<option>10</option>
<option>25</option>
<option>50</option>
</select>
</div>
</div>
<div class="flex items-center gap-1">
<button class="p-1.5 rounded-lg text-outline hover:bg-surface-container hover:text-on-surface transition-colors disabled:opacity-40" disabled="" type="button">
<span class="material-symbols-outlined text-[18px]">chevron_left</span>
</button>
<button class="w-8 h-8 rounded-lg bg-primary text-on-primary font-label-bold text-[13px] flex items-center justify-center" type="button">1</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container font-label-bold text-[13px] flex items-center justify-center text-on-surface transition-colors" type="button">2</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container font-label-bold text-[13px] flex items-center justify-center text-on-surface transition-colors" type="button">3</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container font-label-bold text-[13px] flex items-center justify-center text-on-surface transition-colors" type="button">4</button>
<button class="p-1.5 rounded-lg text-outline hover:bg-surface-container hover:text-on-surface transition-colors" type="button">
<span class="material-symbols-outlined text-[18px]">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Warehouse Dock Information Card & Activity Insight -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mt-stack-md">
<!-- Dock Staging Overview -->
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
<div class="grid grid-cols-1 sm:grid-cols-3 gap-stack-sm"><div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1"><div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 01 (Pipa Panjang &amp; Berat)</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-error-container text-on-error-container">Unloading</span></div><div class="text-[12px] font-body-sm text-on-surface-variant truncate">Truk Tronton • PT. Pipa Mas</div><div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-primary h-full rounded-full" style="width: 70%"></div></div><span class="text-[10px] text-outline text-right">Est. 20 mnt lagi</span></div><div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1"><div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 02 (Instrumentasi &amp; Meter Air)</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-tertiary-fixed text-on-tertiary-fixed">Antre Staging</span></div><div class="text-[12px] font-body-sm text-on-surface-variant truncate">Truk Box • PT. Barindo</div><div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-tertiary h-full rounded-full" style="width: 35%"></div></div><span class="text-[10px] text-outline text-right">QC Tera Meter Air</span></div><div class="p-stack-sm rounded-lg bg-surface-container-low flex flex-col gap-1"><div class="flex items-center justify-between"><span class="font-label-bold text-[13px] text-on-surface">Dock 03 (Fitting &amp; Sambungan SR)</span><span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-primary-fixed text-on-primary-fixed">Tersedia</span></div><div class="text-[12px] font-body-sm text-on-surface-variant truncate">Siap armada incoming</div><div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden mt-1"><div class="bg-primary h-full rounded-full" style="width: 0%"></div></div><span class="text-[10px] text-outline text-right">Standby</span></div></div>
</div>
<div class="mt-stack-md pt-stack-sm flex items-center justify-between text-[12px] text-on-surface-variant"><span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-primary">verified_user</span> SOP Penerimaan Material PDAM: Seluruh barang wajib inspeksi visual, kelengkapan sertifikat SNI/ISO, segel kalibrasi metrologi untuk meter air, dan foto fisik.</span><a class="font-label-bold text-primary hover:underline" href="#">Lihat Denah Bay →</a></div>
</div>
<!-- Quick Warehouse Stats / Audit Metric -->
<div class="p-container-padding rounded-xl bg-surface-container-low shadow-sm flex flex-col justify-between">
<div>
<div class="flex items-center gap-2 mb-2">
<span class="material-symbols-outlined text-secondary text-[22px]">analytics</span>
<h3 class="font-headline-md text-[18px] font-bold text-on-surface">Akurasi Penerimaan</h3>
</div>
<p class="font-body-sm text-[13px] text-on-surface-variant">Pencapaian kesesuaian fisik vs purchase order per minggu berjalan.</p>
<div class="my-stack-md flex items-center gap-stack-md">
<div class="relative w-20 h-20 flex items-center justify-center shrink-0">
<!-- Inline SVG Progress Gauge -->
<svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
<path class="text-surface-container-highest" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
<path class="text-primary" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="98.2, 100" stroke-linecap="round" stroke-width="3.5"></path>
</svg>
<span class="absolute font-label-bold text-label-bold text-on-surface">98.2%</span>
</div>
<div class="flex flex-col gap-1 text-[12px] font-body-sm">
<div class="flex items-center justify-between gap-4">
<span class="text-on-surface-variant">Item Sesuai:</span>
<span class="font-label-bold text-on-surface">1,394 Unit</span>
</div>
<div class="flex items-center justify-between gap-4">
<span class="text-on-surface-variant">Discrepancy / Rusak:</span>
<span class="font-label-bold text-tertiary">26 Unit (1.8%)</span>
</div>
<div class="flex items-center justify-between gap-4">
<span class="text-on-surface-variant">Rata-rata Waktu Verifikasi:</span>
<span class="font-label-bold text-on-surface">28 Menit</span>
</div>
</div>
</div>
</div>
<div class="pt-2 bg-surface-container-lowest/60 rounded-lg p-2.5 flex items-center justify-between">
<span class="text-[12px] font-body-sm text-on-surface-variant">Laporan Rekonsiliasi Supplier</span>
<button class="text-[12px] font-label-bold text-primary hover:underline" type="button">Unduh PDF</button>
</div>
</div>
</div>
<!-- Interactive Modal Dialog Backdrop -->
<div class="fixed inset-0 z-50 flex items-center justify-center bg-inverse-surface/60 backdrop-blur-sm hidden transition-opacity duration-200" id="goodsReceiptModal">
<!-- Modal Card Container -->
<div class="relative w-full max-w-2xl bg-surface-container-lowest rounded-2xl shadow-xl overflow-hidden flex flex-col mx-4 my-8 max-h-[90vh]">
<!-- Modal Header -->
<div class="px-container-padding py-stack-md bg-surface-container-low flex items-start justify-between">
<div class="flex items-center gap-stack-sm">
<div class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center shrink-0 shadow-sm">
<span class="material-symbols-outlined text-[24px]">assignment_add</span>
</div>
<div>
<h2 class="font-headline-md text-headline-md text-on-surface">Inisiasi Penerimaan Barang Masuk Baru</h2>
<p class="font-body-sm text-[13px] text-on-surface-variant mt-0.5">Pilih Purchase Order (PO) yang telah disetujui dan masukkan nomor faktur/invoice dari supplier.</p>
</div>
</div>
<button class="p-1 rounded-lg text-outline hover:bg-surface-container-high hover:text-on-surface transition-colors" id="closeModalBtn" type="button">
<span class="material-symbols-outlined text-[20px]">close</span>
</button>
</div>
<!-- Modal Body (Form Inputs) -->
<div class="p-container-padding overflow-y-auto flex flex-col gap-stack-md">
<!-- Field 1: Dropdown PO Selector -->
<div class="flex flex-col gap-1">
<label class="font-label-bold text-label-bold text-on-surface flex items-center justify-between" for="poSelector">
<span class="">Pilih Nomor Purchase Order (PO) <span class="text-error">*</span></span>
<span class="font-sidebar-nav text-[11px] text-primary cursor-pointer hover:underline">Lihat Semua PO Terbuka (12)</span>
</label>
<div class="relative">
<select class="w-full bg-surface-container-low text-on-surface px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm focus:outline-none focus:ring-2 focus:ring-primary appearance-none cursor-pointer" id="poSelector">
<option selected="" value="po-1">PO-2023-0891 — PT. Sumber Maju Jaya (3 Item, Status: PO Approved)</option>
<option value="po-2">PO-2023-0894 — PT. Trafindo Prima Perkasa (8 Item, Status: PO Approved)</option>
<option value="po-3">PO-2023-0902 — CV. Pancaran Teknik (12 Item, Status: PO Approved)</option>
<option value="po-4">PO-2023-0910 — PT. Siemens Energi Global (2 Item, Status: PO Approved)</option>
</select>
<span class="material-symbols-outlined absolute right-stack-md top-2.5 pointer-events-none text-outline text-[20px]">expand_more</span>
</div>
</div>
<!-- Quick Preview Card for Selected PO -->
<div class="p-stack-md rounded-xl bg-surface-container-low text-on-surface flex flex-col gap-stack-sm transition-all" id="poPreviewCard">
<div class="flex items-center justify-between pb-2">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-[18px]">verified</span>
<span class="font-label-bold text-[13px] text-on-surface">Data Terverifikasi dari Purchase Order</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">PO APPROVED</span>
</div>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-stack-sm text-[12px] font-body-sm pt-1">
<div>
<span class="text-on-surface-variant block">Nama Supplier</span>
<span class="font-label-bold text-on-surface">PT. Sumber Maju Jaya</span>
</div>
<div>
<span class="text-on-surface-variant block">Tanggal PO</span>
<span class="font-label-bold text-on-surface">18 Okt 2023</span>
</div>
<div>
<span class="text-on-surface-variant block">Estimasi Tiba</span>
<span class="font-label-bold text-on-surface">24 Okt 2023 (Tepat Waktu)</span>
</div>
<div>
<span class="text-on-surface-variant block">Total Barang Terdaftar</span>
<span class="font-label-bold text-primary">3 Baris / 65 Unit</span>
</div>
</div>
</div>
<!-- Horizontal Input Grid: Invoice & Received Date -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-stack-md">
<!-- Field 2: No Invoice Supplier -->
<div class="flex flex-col gap-1">
<label class="font-label-bold text-label-bold text-on-surface" for="invNumber">
              Nomor Invoice / Surat Jalan Supplier <span class="text-error">*</span>
</label>
<input class="bg-surface-container-low px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary" id="invNumber" placeholder="Contoh: INV-2023-SMJ-9912" type="text" value="INV-2023-SMJ-9912">
<span class="text-[11px] text-on-surface-variant">Sesuai dengan dokumen fisik yang dibawa kurir</span>
</div>
<!-- Field 3: Tanggal Diterima Fisik -->
<div class="flex flex-col gap-1">
<label class="font-label-bold text-label-bold text-on-surface" for="receivedDate">
              Tanggal Diterima Fisik <span class="text-error">*</span>
</label>
<input class="bg-surface-container-low px-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary" id="receivedDate" type="date" value="2023-10-24">
<span class="text-[11px] text-on-surface-variant">Waktu fisik barang mendarat di loading bay</span>
</div>
</div>
<!-- Field 4: Petugas Penerima (Pre-filled PIC) -->
<div class="flex flex-col gap-1">
<label class="font-label-bold text-label-bold text-on-surface" for="picWarehouse">
            Petugas Penerima (PIC Gudang) <span class="text-error">*</span>
</label>
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-stack-md text-primary text-[20px]">badge</span>
<input class="w-full bg-surface-container-highest/60 pl-11 pr-stack-md py-2.5 rounded-lg font-body-sm text-body-sm text-on-surface cursor-not-allowed" id="picWarehouse" readonly="" type="text" value="Wahyu Hidayat (ID: WMS-WH-092)">
<span class="absolute right-stack-md text-[11px] font-label-bold text-outline">Supervisor Inbound</span>
</div>
</div>
<!-- Field 5: Catatan Pengiriman / Ekspedisi -->
<div class="flex flex-col gap-1">
<label class="font-label-bold text-label-bold text-on-surface" for="shippingNotes">
            Catatan Pengiriman / Ekspedisi <span class="text-outline font-normal">(Opsional)</span>
</label>
<textarea class="bg-surface-container-low px-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary resize-none" id="shippingNotes" placeholder="Informasi kondisi armada, nomor polisi kendaraan, atau kondisi visual luar kemasan..." rows="2">Diterima via Truk Colt Diesel (B 9182 UXT) - Segel box kontainer utuh, kondisi box luar baik.</textarea>
</div>
</div>
<!-- Modal Footer -->
<div class="px-container-padding py-stack-md bg-surface-container-low flex flex-col-reverse sm:flex-row items-center justify-end gap-stack-sm">
<button class="w-full sm:w-auto px-stack-md py-2 rounded-lg bg-surface-container-highest text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-bold text-label-bold transition-colors" id="cancelModalBtn" type="button">
          Batal
        </button>
<button class="w-full sm:w-auto px-container-padding py-2 rounded-lg bg-primary text-on-primary hover:bg-primary-container font-label-bold text-label-bold shadow-md transition-all flex items-center justify-center gap-2" id="submitModalBtn" type="button">
<span class="">Lanjut ke Verifikasi &amp; Alokasi Barang</span>
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</button>
</div>
</div>
</div>
<!-- Toast Notification Simulator (Hidden by default) -->
<div class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 px-stack-md py-3 rounded-xl bg-inverse-surface text-inverse-on-surface shadow-2xl" id="toastSuccess">
<span class="material-symbols-outlined text-primary-fixed text-[22px]">check_circle</span>
<div class="flex flex-col">
<span class="font-label-bold text-[13px]">Inisiasi Penerimaan Berhasil!</span>
<span class="font-body-sm text-[11px] text-inverse-on-surface/80">Dokumen GRN-2023-0882 dibuat. Mengarahkan ke modul verifikasi...</span>
</div>
</div>
</div>
<script>
  // Simple vanilla JS controller for Modal & Interactive Micro-actions
  (function() {
    const modal = document.getElementById('goodsReceiptModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const submitBtn = document.getElementById('submitModalBtn');
    const toast = document.getElementById('toastSuccess');
    const poSelector = document.getElementById('poSelector');
    const poPreview = document.getElementById('poPreviewCard');

    function openModal() {
      if (!modal) return;
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeModal() {
      if (!modal) return;
      modal.classList.add('hidden');
      document.body.style.overflow = '';
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close on clicking backdrop
    if (modal) {
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          closeModal();
        }
      });
    }

    // Dynamic PO combobox preview alteration simulation
    if (poSelector && poPreview) {
      poSelector.addEventListener('change', function(e) {
        const val = e.target.value;
        if (val === 'po-2') {
          poPreview.innerHTML = `
            <div class="flex items-center justify-between pb-2">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                <span class="font-label-bold text-[13px] text-on-surface">Data Terverifikasi dari Purchase Order</span>
              </div>
              <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">PO APPROVED</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-stack-sm text-[12px] font-body-sm pt-1">
              <div>
                <span class="text-on-surface-variant block">Nama Supplier</span>
                <span class="font-label-bold text-on-surface">PT. Trafindo Prima</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Tanggal PO</span>
                <span class="font-label-bold text-on-surface">19 Okt 2023</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Estimasi Tiba</span>
                <span class="font-label-bold text-on-surface">25 Okt 2023</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Total Barang Terdaftar</span>
                <span class="font-label-bold text-primary">8 Baris / 120 Unit</span>
              </div>
            </div>
          `;
        } else {
          poPreview.innerHTML = `
            <div class="flex items-center justify-between pb-2">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                <span class="font-label-bold text-[13px] text-on-surface">Data Terverifikasi dari Purchase Order</span>
              </div>
              <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px] font-label-bold">PO APPROVED</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-stack-sm text-[12px] font-body-sm pt-1">
              <div>
                <span class="text-on-surface-variant block">Nama Supplier</span>
                <span class="font-label-bold text-on-surface">PT. Sumber Maju Jaya</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Tanggal PO</span>
                <span class="font-label-bold text-on-surface">18 Okt 2023</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Estimasi Tiba</span>
                <span class="font-label-bold text-on-surface">24 Okt 2023 (Tepat Waktu)</span>
              </div>
              <div>
                <span class="text-on-surface-variant block">Total Barang Terdaftar</span>
                <span class="font-label-bold text-primary">3 Baris / 65 Unit</span>
              </div>
            </div>
          `;
        }
      });
    }

    // Submit modal -> lanjut ke halaman verifikasi dummy.
    if (submitBtn) {
      submitBtn.addEventListener('click', function() {
        window.location.href = <?php echo json_encode(route('penerimaan.verifikasi', 'GRN-2023-0882'), 512) ?>;
      });
    }
  })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/penerimaan/index.blade.php ENDPATH**/ ?>