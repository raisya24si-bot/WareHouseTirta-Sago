

<?php $__env->startSection('title', 'Verifikasi Penerimaan - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Penerimaan Barang PO / Verifikasi'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $status = $penerimaan->statusPenerimaan?->kd_status_penerimaan_barang ?? 'DRAFT';

    $statusLabel = match ($status) {
        'DRAFT' => 'Draft',
        'REJECTED' => 'Ditolak / Perlu Perbaikan',
        'PENDING_KASUBAG' => 'Menunggu Approval Kasubag',
        'PENDING_KABAG' => 'Menunggu Approval Kabag',
        'PENDING_DIREKTUR' => 'Menunggu Approval Direktur',
        'APPROVED' => 'Disetujui',
        default => $status,
    };

    $statusClass = match ($status) {
        'DRAFT', 'REJECTED'
            => 'bg-surface-container text-on-surface-variant',

        'APPROVED'
            => 'bg-primary-fixed text-on-primary-fixed',

        default
            => 'bg-tertiary-fixed text-on-tertiary-fixed-variant',
    };

    $canEdit = $penerimaan->canBeEdited();

    $totalQtyPo = $penerimaan->details->sum('qty_request');
    $totalBaik = $penerimaan->details->sum('qty_baik');
    $totalRusak = $penerimaan->details->sum('qty_rusak');

    // Selisih boleh negatif / positif.
    // Contoh PO 100, baik 78, rusak 2 => -20.
    $totalSelisih = $totalBaik + $totalRusak - $totalQtyPo;

    $totalSku = $penerimaan->details->count();

    $itemBelumLokasi = $penerimaan->details
        ->filter(function ($detail) {
            return (int) $detail->qty_baik > 0 && ! $detail->fk_lokasi_barang;
        })
        ->count();

    $itemDenganReject = $penerimaan->details
        ->filter(fn ($detail) => (int) $detail->qty_rusak > 0)
        ->count();

    $lokasiOptions = $lokasis->map(function ($lokasi) {
        $gudang = $lokasi->row?->rak?->gudang;
        $rak = $lokasi->row?->rak;
        $row = $lokasi->row;

        return [
            'id' => $lokasi->id_lokasi,
            'bin' => $lokasi->bin,
            'kode' => $lokasi->kd_lokasi,
            'gudang_id' => $gudang?->id_gudang,
            'gudang' => $gudang?->nm_gudang,
            'rak' => $rak?->kd_rak,
            'row' => $row?->kd_row,
            'label' => collect([
                $gudang?->nm_gudang,
                $rak?->kd_rak,
                $row?->kd_row,
                $lokasi->bin ?: $lokasi->kd_lokasi,
            ])->filter()->implode(' • '),
        ];
    })->values();

    $gudangOptions = $lokasiOptions
        ->filter(fn ($item) => $item['gudang_id'])
        ->unique('gudang_id')
        ->values();

    $po = $penerimaan->po;
    $supplier = $po?->supplier;

    $totalNilaiBaik = $penerimaan->details->sum(function ($detail) {
        $harga = (float) ($detail->barang?->harga ?? 0);
        return ((int) $detail->qty_baik) * $harga;
    });
?>

<div class="py-stack-md flex flex-col gap-stack-md">

    
    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant">
            <a
                href="<?php echo e(route('penerimaan.index')); ?>"
                class="hover:text-primary transition-colors"
            >
                Penerimaan Barang Masuk
            </a>

            <span class="material-symbols-outlined text-[16px] text-outline-variant">
                chevron_right
            </span>

            <span class="text-on-surface font-label-bold">
                Verifikasi & Setting Lokasi
            </span>
        </div>

        <div class="flex items-center gap-1.5 text-outline text-[12px] font-sidebar-nav">
            <span class="material-symbols-outlined text-[14px]">
                history
            </span>

            <span>
                <?php echo e($penerimaan->updated_at?->format('d M Y H:i') ?? '-'); ?> WIB
            </span>
        </div>

    </div>


    
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-stack-md bg-surface-container-lowest p-container-padding rounded-xl shadow-sm">

        <div class="flex flex-col gap-base">

            <div class="flex flex-wrap items-center gap-stack-sm">

                <span class="px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-label-bold text-[12px] uppercase tracking-wide">
                    <?php echo e($penerimaan->kd_penerimaan); ?>

                </span>

                <span class="px-2.5 py-1 rounded-full <?php echo e($statusClass); ?> font-label-bold text-[12px] flex items-center gap-1">

                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>

                    Status: <?php echo e($statusLabel); ?>


                </span>

                <span class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-sidebar-nav text-[12px]">
                    <?php echo e($totalSku); ?> Item
                </span>

            </div>

            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight mt-1">
                Verifikasi Fisik & Alokasi Lokasi Barang Masuk
            </h1>

            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-4xl">
                Pencocokan kuantitas fisik aktual dari supplier, inspeksi kondisi material,
                serta pemetaan lokasi penyimpanan barang sebelum dokumen diteruskan ke proses approval.
            </p>

        </div>


        <div class="flex flex-wrap items-center gap-stack-sm shrink-0">

            <a
                href="<?php echo e(route('penerimaan.index')); ?>"
                class="px-stack-md py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-label-bold flex items-center gap-stack-sm transition-colors"
            >
                <span class="material-symbols-outlined text-[18px]">
                    arrow_back
                </span>

                Daftar Penerimaan
            </a>

            <?php if($canEdit): ?>

                <button
                    type="button"
                    onclick="saveDraft()"
                    class="px-stack-md py-2 rounded-lg bg-surface-container-high hover:bg-secondary-fixed text-on-surface font-label-bold text-label-bold flex items-center gap-stack-sm border border-outline-variant transition-colors"
                >
                    <span class="material-symbols-outlined text-primary text-[18px]">
                        bookmark
                    </span>

                    Simpan Draf
                </button>

            <?php endif; ?>

        </div>

    </div>


    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">

        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-primary">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Total Diterima Baik
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-baik"
                        class="font-display-lg text-[24px] text-primary font-bold"
                    >
                        <?php echo e(number_format($totalBaik)); ?>

                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit
                    </span>

                </div>

                <span class="text-[12px] text-on-surface-variant mt-0.5 flex items-center gap-1">

                    <span class="material-symbols-outlined text-[14px] text-primary">
                        check_circle
                    </span>

                    Siap masuk stok setelah approval Direktur

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    verified
                </span>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-error">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-error font-bold">
                    Total Rusak / Cacat
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-rusak"
                        class="font-display-lg text-[24px] text-error font-bold"
                    >
                        <?php echo e(number_format($totalRusak)); ?>

                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit
                    </span>

                </div>

                <span class="text-[12px] text-error flex items-center gap-1 mt-0.5">

                    <span class="material-symbols-outlined text-[14px]">
                        report_problem
                    </span>

                    Dipisahkan sebagai barang rusak

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-error-container text-on-error-container flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    inventory_2
                </span>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-center justify-between border-l-4 border-tertiary">

            <div class="flex flex-col">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-tertiary font-bold">
                    Discrepancy / Selisih PO
                </span>

                <div class="flex items-baseline gap-1 mt-1">

                    <span
                        id="summary-selisih"
                        class="font-display-lg text-[24px] text-tertiary font-bold"
                    >
                        <?php echo e($totalSelisih > 0 ? '+' : ''); ?><?php echo e(number_format($totalSelisih)); ?>

                    </span>

                    <span class="text-[12px] text-outline-variant font-sidebar-nav">
                        Unit
                    </span>

                </div>

                <span class="text-[12px] text-on-surface-variant mt-0.5 flex items-center gap-1">

                    <span class="material-symbols-outlined text-[14px] text-tertiary">
                        difference
                    </span>

                    Selisih tetap dapat disubmit

                </span>

            </div>

            <div class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant flex items-center justify-center shrink-0">

                <span class="material-symbols-outlined text-[24px]">
                    difference
                </span>

            </div>

        </div>

    </div>


    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">

        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    receipt_long
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Purchase Order
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    <?php echo e($po?->kd_po ?? '-'); ?>

                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    <?php echo e($supplier?->nm_master_supplier ?? 'Supplier belum tersedia'); ?>

                </span>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    description
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Faktur / Surat Jalan
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    <?php echo e($penerimaan->no_sjinv_supplier ?: '-'); ?>

                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    Referensi Supplier
                </span>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    event_available
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Waktu Penerimaan
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    <?php echo e($penerimaan->tgl_penerimaan_barang?->format('d M Y') ?? '-'); ?>

                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    <?php echo e($penerimaan->created_at?->format('H:i') ?? '-'); ?> WIB
                </span>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-sm flex items-start gap-stack-sm">

            <div class="p-2.5 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">
                    verified_user
                </span>
            </div>

            <div class="flex flex-col min-w-0">

                <span class="font-sidebar-nav text-[11px] uppercase tracking-wider text-outline font-bold">
                    Petugas Verifikator
                </span>

                <span class="font-headline-md text-[18px] text-on-surface font-bold truncate">
                    <?php echo e($penerimaan->submittedBy?->name ?? auth()->user()?->name ?? '-'); ?>

                </span>

                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                    Petugas Penerimaan
                </span>

            </div>

        </div>

    </div>


    
    <?php if($itemBelumLokasi > 0 || $totalRusak > 0): ?>

        <div class="bg-tertiary-fixed text-on-tertiary-fixed p-stack-md rounded-xl flex flex-col lg:flex-row lg:items-center justify-between gap-stack-md shadow-sm">

            <div class="flex items-start gap-stack-md">

                <div class="w-10 h-10 rounded-lg bg-tertiary-container text-on-tertiary-container flex items-center justify-center shrink-0">

                    <span class="material-symbols-outlined text-[22px]">
                        warning
                    </span>

                </div>

                <div class="flex flex-col">

                    <span class="font-label-bold text-label-bold text-on-tertiary-fixed">
                        Perhatian: <?php echo e($itemBelumLokasi); ?> item belum memiliki lokasi penyimpanan.
                    </span>

                    <span class="font-body-sm text-[13px] text-on-tertiary-fixed-variant">
                        <?php echo e($totalRusak); ?> unit tercatat sebagai barang rusak.
                        Pastikan data fisik sudah benar sebelum dokumen disubmit.
                    </span>

                </div>

            </div>

            <span class="px-2.5 py-1.5 rounded bg-tertiary text-on-tertiary font-label-bold text-[11px] uppercase tracking-wider shrink-0">
                Tindakan Diperlukan
            </span>

        </div>

    <?php endif; ?>


    
    <form
        id="verification-form"
        method="POST"
        action="<?php echo e(route('penerimaan.save-draft', $penerimaan)); ?>"
        enctype="multipart/form-data"
    >

        <?php echo csrf_field(); ?>


        
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

            <div class="p-container-padding bg-surface-container-low">

                <div class="flex items-center gap-stack-sm">

                    <span class="material-symbols-outlined text-primary text-[22px]">
                        edit_document
                    </span>

                    <div class="flex flex-col">

                        <h2 class="font-headline-md text-headline-md text-on-surface">
                            Data Penerimaan
                        </h2>

                        <span class="text-[12px] text-on-surface-variant">
                            Informasi surat jalan dan tanggal penerimaan fisik.
                        </span>

                    </div>

                </div>

            </div>

            <div class="p-container-padding grid grid-cols-1 md:grid-cols-2 gap-stack-md">

                <div>

                    <label class="mb-1.5 block text-[12px] font-label-bold text-on-surface">
                        Nomor Surat Jalan / Invoice
                    </label>

                    <input
                        type="text"
                        name="no_sjinv_supplier"
                        value="<?php echo e(old('no_sjinv_supplier', $penerimaan->no_sjinv_supplier)); ?>"
                        <?php echo e($canEdit ? '' : 'disabled'); ?>

                        class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                        placeholder="Contoh: SJ-2026-001"
                    >

                </div>

                <div>

                    <label class="mb-1.5 block text-[12px] font-label-bold text-on-surface">
                        Tanggal Penerimaan
                    </label>

                    <input
                        type="date"
                        name="tgl_penerimaan_barang"
                        value="<?php echo e(old('tgl_penerimaan_barang', $penerimaan->tgl_penerimaan_barang?->format('Y-m-d'))); ?>"
                        <?php echo e($canEdit ? '' : 'disabled'); ?>

                        class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                    >

                </div>

                <div class="md:col-span-2">

                    <label class="mb-1.5 block text-[12px] font-label-bold text-on-surface">
                        Keterangan Penerimaan
                    </label>

                    <textarea
                        name="desc_penerimaan_barang"
                        rows="3"
                        <?php echo e($canEdit ? '' : 'disabled'); ?>

                        class="w-full rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                        placeholder="Catatan kondisi penerimaan..."
                    ><?php echo e(old('desc_penerimaan_barang', $penerimaan->desc_penerimaan_barang)); ?></textarea>

                </div>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">

            <div class="p-container-padding flex flex-col lg:flex-row lg:items-center justify-between gap-stack-sm bg-surface-container-low">

                <div class="flex items-center gap-stack-sm">

                    <span class="material-symbols-outlined text-primary text-[22px]">
                        inventory
                    </span>

                    <div class="flex flex-col">

                        <div class="flex items-center gap-stack-sm">

                            <h2 class="font-headline-md text-headline-md text-on-surface">
                                Daftar Item Verifikasi & Pemetaan Lokasi
                            </h2>

                            <span class="px-2 py-0.5 rounded-full bg-surface-container-highest text-on-surface-variant text-[12px] font-label-bold">
                                <?php echo e($totalSku); ?> Item
                            </span>

                        </div>

                        <span class="text-[12px] text-on-surface-variant">
                            Input jumlah baik, rusak, dan lokasi penyimpanan untuk setiap barang.
                        </span>

                    </div>

                </div>

                <div class="flex flex-wrap items-center gap-3 text-[12px] text-on-surface-variant">

                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        Baik: <?php echo e($totalBaik); ?>

                    </span>

                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-error"></span>
                        Rusak: <?php echo e($totalRusak); ?>

                    </span>

                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                        Selisih: <?php echo e($totalSelisih); ?>

                    </span>

                </div>

            </div>


            <div class="w-full overflow-x-auto">

                <table class="w-full min-w-[1500px] text-left font-body-sm text-body-sm">

                    <thead class="bg-surface-container text-on-surface-variant font-label-bold text-[12px] uppercase tracking-wider">

                        <tr>

                            <th class="py-stack-md px-container-padding">
                                Kode Barang
                            </th>

                            <th class="py-stack-md px-stack-md">
                                Nama Barang
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Qty PO
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Qty Baik
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Qty Rusak
                            </th>

                            <th class="py-stack-md px-stack-md text-center">
                                Selisih
                            </th>

                            <th class="py-stack-md px-stack-md">
                                Lokasi Penyimpanan
                            </th>

                        </tr>

                    </thead>


                    <tbody class="text-on-surface divide-y divide-surface-container">

                        <?php $__empty_1 = true; $__currentLoopData = $penerimaan->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <?php
                                $barang = $detail->barang;

                                $qtyPo = (int) $detail->qty_request;
                                $qtyBaik = (int) $detail->qty_baik;
                                $qtyRusak = (int) $detail->qty_rusak;
                                $selisih = ($qtyBaik + $qtyRusak) - $qtyPo;

                                $selectedLokasi = $detail->lokasi;
                            ?>

                            <tr
                                class="
                                    transition-colors
                                    <?php echo e($qtyRusak > 0
                                        ? 'bg-error-container/10 hover:bg-error-container/20'
                                        : 'hover:bg-surface-container-low/60'); ?>

                                "
                                data-detail-row="<?php echo e($detail->id_penerimaan_barang_detail); ?>"
                                data-qty-po="<?php echo e($qtyPo); ?>"
                            >

                                
                                <td class="py-stack-md px-container-padding align-top">

                                    <div class="flex flex-col">

                                        <span class="font-label-bold text-primary">
                                            <?php echo e($barang?->kd_master_barang ?? '-'); ?>

                                        </span>

                                        <?php if($barang?->satuan): ?>
                                            <span class="text-[11px] text-outline font-sidebar-nav">
                                                <?php echo e($barang->satuan->nm_satuan ?? $barang->satuan->nama_satuan ?? ''); ?>

                                            </span>
                                        <?php endif; ?>

                                    </div>

                                </td>


                                
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col max-w-md">

                                        <span class="font-label-bold text-on-surface">
                                            <?php echo e($barang?->nm_master_barang ?? 'Barang tidak ditemukan'); ?>

                                        </span>

                                        <?php if($barang?->desc_master_barang): ?>

                                            <span class="text-on-surface-variant text-[13px] mt-0.5">
                                                <?php echo e($barang->desc_master_barang); ?>

                                            </span>

                                        <?php endif; ?>

                                        <?php if($qtyRusak > 0): ?>

                                            <div class="mt-2 inline-flex items-center gap-1.5 w-fit px-2 py-1 rounded-lg bg-error-container text-on-error-container text-[11px] font-label-bold">

                                                <span class="material-symbols-outlined text-[15px]">
                                                    report_problem
                                                </span>

                                                <?php echo e($qtyRusak); ?> Unit Rusak

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                </td>


                                
                                <td class="py-stack-md px-stack-md text-center align-top">

                                    <span class="font-label-bold text-on-surface">
                                        <?php echo e(number_format($qtyPo)); ?>

                                    </span>

                                </td>


                                
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col items-center gap-1">

                                        <div class="flex items-center justify-center gap-1">

                                            <input
                                                type="number"
                                                min="0"
                                                step="1"
                                                name="details[<?php echo e($detail->id_penerimaan_barang_detail); ?>][qty_baik]"
                                                value="<?php echo e(old("details.{$detail->id_penerimaan_barang_detail}.qty_baik", $qtyBaik)); ?>"
                                                <?php echo e($canEdit ? '' : 'disabled'); ?>

                                                class="qty-baik w-24 rounded-lg border border-outline-variant bg-surface-container-low text-center font-label-bold text-primary py-2 px-2 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                                            >

                                            <span class="text-[12px] text-outline">
                                                Unit
                                            </span>

                                        </div>

                                        <span class="text-[11px] text-on-surface-variant">
                                            Kondisi baik / lolos QC
                                        </span>

                                    </div>

                                </td>


                                
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col items-center gap-1">

                                        <div class="flex items-center justify-center gap-1">

                                            <input
                                                type="number"
                                                min="0"
                                                step="1"
                                                name="details[<?php echo e($detail->id_penerimaan_barang_detail); ?>][qty_rusak]"
                                                value="<?php echo e(old("details.{$detail->id_penerimaan_barang_detail}.qty_rusak", $qtyRusak)); ?>"
                                                <?php echo e($canEdit ? '' : 'disabled'); ?>

                                                class="qty-rusak w-20 rounded-lg border <?php echo e($qtyRusak > 0 ? 'border-error/30 bg-error-container text-on-error-container' : 'border-outline-variant bg-surface-container'); ?> text-center font-label-bold py-2 px-1 focus:outline-none focus:ring-1 focus:ring-error disabled:opacity-60"
                                            >

                                            <span class="text-[11px] text-outline">
                                                Unit
                                            </span>

                                        </div>

                                        <span class="reject-label text-[11px] <?php echo e($qtyRusak > 0 ? 'text-error font-label-bold' : 'text-outline-variant italic'); ?>">
                                            <?php echo e($qtyRusak > 0 ? 'Barang rusak' : 'Nihil'); ?>

                                        </span>

                                    </div>

                                </td>


                                
                                <td class="py-stack-md px-stack-md text-center align-top">

                                    <div class="flex flex-col items-center">

                                        <span
                                            class="selisih-value inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[12px]
                                            <?php echo e($selisih === 0
                                                ? 'bg-primary-fixed text-on-primary-fixed'
                                                : 'bg-tertiary-fixed text-on-tertiary-fixed-variant'); ?>"
                                        >
                                            <span class="material-symbols-outlined text-[15px]">
                                                <?php echo e($selisih === 0 ? 'check_circle' : 'difference'); ?>

                                            </span>

                                            <?php echo e($selisih > 0 ? '+' : ''); ?><?php echo e($selisih); ?>

                                        </span>

                                        <span class="text-[10px] text-outline mt-1">
                                            Baik + Rusak − PO
                                        </span>

                                    </div>

                                </td>


                                
                                <td class="py-stack-md px-stack-md align-top">

                                    <div class="flex flex-col gap-2 min-w-[350px]">

                                        <?php if($qtyBaik > 0): ?>

                                            <div>

                                                <label class="mb-1 block text-[11px] font-label-bold text-on-surface-variant">
                                                    Lokasi Barang Baik
                                                </label>

                                                <select
                                                    name="details[<?php echo e($detail->id_penerimaan_barang_detail); ?>][fk_lokasi_barang]"
                                                    <?php echo e($canEdit ? '' : 'disabled'); ?>

                                                    class="w-full lokasi-select rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-[12px] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary disabled:opacity-60"
                                                >

                                                    <option value="">
                                                        -- Pilih Bin Penyimpanan --
                                                    </option>

                                                    <?php $__currentLoopData = $lokasiOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasiOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option
                                                            value="<?php echo e($lokasiOption['id']); ?>"
                                                            <?php if((string) old(
                                                                "details.{$detail->id_penerimaan_barang_detail}.fk_lokasi_barang",
                                                                $detail->fk_lokasi_barang
                                                            ) === (string) $lokasiOption['id']): echo 'selected'; endif; ?>
                                                        >
                                                            <?php echo e($lokasiOption['label']); ?>

                                                        </option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>

                                            </div>

                                            <?php if($selectedLokasi): ?>

                                                <div class="flex items-center gap-1.5 text-[11px] text-primary">

                                                    <span class="material-symbols-outlined text-[15px]">
                                                        location_on
                                                    </span>

                                                    <?php echo e($selectedLokasi->kd_lokasi ?? $selectedLokasi->bin); ?>


                                                </div>

                                            <?php endif; ?>

                                        <?php else: ?>

                                            <div class="rounded-lg bg-surface-container-low px-3 py-2.5 text-[12px] text-outline">

                                                Tidak ada barang baik yang perlu dialokasikan.

                                            </div>

                                        <?php endif; ?>


                                        <?php if($qtyRusak > 0): ?>

                                            <div class="rounded-lg bg-error-container/40 border border-error-container p-2.5">

                                                <div class="flex items-center gap-1.5">

                                                    <span class="material-symbols-outlined text-[16px] text-error">
                                                        inventory_2
                                                    </span>

                                                    <span class="font-label-bold text-[11px] text-error">
                                                        <?php echo e($qtyRusak); ?> Unit Rusak
                                                    </span>

                                                </div>

                                                <span class="block mt-1 text-[11px] text-on-error-container">
                                                    Dicatat sebagai barang rusak.
                                                    Penempatan gudang/reject diproses sesuai alur approval.
                                                </span>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="7"
                                    class="py-12 text-center text-on-surface-variant"
                                >

                                    <span class="material-symbols-outlined text-[40px] text-outline-variant">
                                        inventory_2
                                    </span>

                                    <p class="mt-2">
                                        Belum ada detail barang pada penerimaan ini.
                                    </p>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>


                    <tfoot class="bg-surface-container-low border-t border-surface-container">

                        <tr>

                            <td
                                colspan="2"
                                class="py-stack-md px-container-padding"
                            >

                                <span class="font-label-bold text-[13px] uppercase tracking-wider">
                                    Total
                                </span>

                            </td>

                            <td class="py-stack-md px-stack-md text-center font-label-bold">
                                <?php echo e(number_format($totalQtyPo)); ?>

                            </td>

                            <td
                                id="footer-baik"
                                class="py-stack-md px-stack-md text-center font-label-bold text-primary"
                            >
                                <?php echo e(number_format($totalBaik)); ?>

                            </td>

                            <td
                                id="footer-rusak"
                                class="py-stack-md px-stack-md text-center font-label-bold text-error"
                            >
                                <?php echo e(number_format($totalRusak)); ?>

                            </td>

                            <td
                                id="footer-selisih"
                                class="py-stack-md px-stack-md text-center font-label-bold text-tertiary"
                            >
                                <?php echo e($totalSelisih > 0 ? '+' : ''); ?><?php echo e(number_format($totalSelisih)); ?>

                            </td>

                            <td></td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        
        <div class="bg-surface-container-lowest p-container-padding rounded-xl shadow-sm">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-stack-md">

                <div class="flex items-start gap-stack-sm">

                    <div class="w-9 h-9 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">

                        <span class="material-symbols-outlined text-[20px]">
                            photo_camera
                        </span>

                    </div>

                    <div class="flex flex-col">

                        <h2 class="font-headline-md text-[18px] text-on-surface font-bold">
                            Dokumentasi Foto Penerimaan
                        </h2>

                        <span class="text-[12px] text-on-surface-variant">
                            Upload foto kondisi fisik barang saat proses penerimaan.
                        </span>

                    </div>

                </div>


                <?php if($canEdit): ?>

                    <label
                        for="foto_penerimaan"
                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-bold text-[13px] cursor-pointer hover:bg-primary-container transition-colors"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            add_a_photo
                        </span>

                        + Unggah Foto

                    </label>

                <?php endif; ?>

            </div>


            
            <?php if($canEdit): ?>

                <input
                    id="foto_penerimaan"
                    type="file"
                    name="bukti_dukung[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    class="hidden"
                >

            <?php endif; ?>


            
            <div class="mt-4 rounded-lg bg-surface-container-low border border-outline-variant p-3">

                <div class="flex items-start gap-2">

                    <span class="material-symbols-outlined text-[18px] text-primary shrink-0">
                        info
                    </span>

                    <div class="text-[12px] text-on-surface-variant">

                        <span class="font-label-bold text-on-surface">
                            Dokumentasi penerimaan
                        </span>

                        <p class="mt-0.5">
                            Maksimal 5 foto. Format JPG, PNG atau WEBP.
                            Foto digunakan sebagai bukti kondisi fisik saat penerimaan.
                        </p>

                    </div>

                </div>

            </div>


            
            <?php if($penerimaan->buktiDukungs->count()): ?>

                <div class="mt-4">

                    <div class="flex items-center gap-2 mb-2">

                        <span class="font-label-bold text-[12px] text-on-surface">
                            Dokumentasi Tersimpan
                        </span>

                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-[10px] font-label-bold text-on-surface-variant">
                            <?php echo e($penerimaan->buktiDukungs->count()); ?> File
                        </span>

                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

                        <?php $__currentLoopData = $penerimaan->buktiDukungs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bukti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($bukti->path_file ?? false): ?>

                                <div class="relative rounded-lg overflow-hidden border border-outline-variant bg-surface-container">

                                    <img
                                        src="<?php echo e(asset('storage/' . $bukti->path_file)); ?>"
                                        alt="Dokumentasi penerimaan"
                                        class="w-full h-28 object-cover"
                                    >

                                </div>

                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>

            <?php endif; ?>


            
            <div
                id="photo-preview"
                class="hidden mt-4"
            >

                <div class="flex items-center justify-between mb-2">

                    <span class="font-label-bold text-[12px] text-on-surface">
                        Foto yang Akan Diunggah
                    </span>

                    <button
                        type="button"
                        onclick="clearPhotoSelection()"
                        class="text-[11px] text-error hover:underline"
                    >
                        Hapus Semua
                    </button>

                </div>

                <div
                    id="photo-preview-grid"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3"
                ></div>

            </div>

        </div>


        
        <div class="bg-primary-fixed/60 border border-primary/10 p-stack-md rounded-xl">

            <div class="flex items-start gap-stack-sm">

                <div class="w-8 h-8 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">

                    <span class="material-symbols-outlined text-[18px]">
                        info
                    </span>

                </div>

                <div class="flex flex-col">

                    <span class="font-label-bold text-[13px] text-on-surface">
                        Alur stok gudang
                    </span>

                    <span class="font-body-sm text-[12px] text-on-surface-variant mt-0.5">
                        Simpan Draf dan Submit Penerimaan <strong>tidak langsung menambah stok</strong>.
                        Setelah dokumen melewati approval sampai Direktur dan berstatus APPROVED,
                        barulah stok fisik diproses ke lokasi gudang.
                    </span>

                </div>

            </div>

        </div>


        
        <div class="sticky bottom-4 z-30 w-full bg-surface-container-lowest/95 backdrop-blur-xl p-container-padding rounded-xl shadow-xl border border-outline-variant flex flex-col xl:flex-row items-start xl:items-center justify-between gap-stack-md">

            <div class="flex items-start gap-stack-sm">

                <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary shrink-0">

                    <span class="material-symbols-outlined text-[22px]">
                        task_alt
                    </span>

                </div>

                <div class="flex flex-col">

                    <div class="flex flex-wrap items-center gap-stack-sm">

                        <span class="font-label-bold text-label-bold text-on-surface">
                            Status Verifikasi
                        </span>

                        <span
                            id="verification-counter"
                            class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-bold text-[11px]"
                        >
                            <?php echo e($totalSku); ?> Item
                        </span>

                    </div>

                    <span
                        id="location-warning"
                        class="font-body-sm text-[12px] <?php echo e($itemBelumLokasi > 0 ? 'text-tertiary' : 'text-primary'); ?> font-label-bold flex items-center gap-1 mt-0.5"
                    >

                        <span class="material-symbols-outlined text-[15px]">
                            <?php echo e($itemBelumLokasi > 0 ? 'pending_actions' : 'check_circle'); ?>

                        </span>

                        <?php echo e($itemBelumLokasi > 0
                            ? $itemBelumLokasi . ' item masih membutuhkan lokasi'
                            : 'Seluruh item baik sudah memiliki lokasi'); ?>


                    </span>

                </div>

            </div>


            <div class="flex flex-wrap items-center gap-stack-sm w-full xl:w-auto justify-end">

                <a
                    href="<?php echo e(route('penerimaan.index')); ?>"
                    class="px-stack-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-bold text-body-sm border border-outline-variant transition-colors"
                >
                    Batal / Kembali
                </a>


                <button
                    type="button"
                    onclick="window.print()"
                    class="px-stack-md py-2.5 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-bold text-body-sm flex items-center gap-1.5 border border-outline-variant transition-colors"
                >

                    <span class="material-symbols-outlined text-[18px] text-outline">
                        print
                    </span>

                    Cetak Bukti Sementara

                </button>


                <?php if($canEdit): ?>

                    <button
                        type="button"
                        onclick="saveDraft()"
                        class="px-stack-md py-2.5 rounded-lg bg-surface-container-highest hover:bg-secondary-fixed text-on-surface font-label-bold text-body-sm flex items-center gap-1.5 border border-outline-variant transition-colors"
                    >

                        <span class="material-symbols-outlined text-primary text-[18px]">
                            bookmark
                        </span>

                        Simpan Draf

                    </button>


                    <button
                        type="button"
                        onclick="submitReception()"
                        class="px-container-padding py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm flex items-center gap-stack-sm shadow-md transition-all"
                    >

                        <span class="material-symbols-outlined text-[20px]">
                            verified
                        </span>

                        <div class="flex flex-col items-start leading-tight">

                            <span>
                                Submit Penerimaan
                            </span>

                            <span class="text-[10px] font-normal text-on-primary/80">
                                Kirim ke Approval Kasubag
                            </span>

                        </div>

                    </button>

                <?php else: ?>

                    <span class="px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-label-bold text-sm">
                        <?php echo e($statusLabel); ?>

                    </span>

                <?php endif; ?>

            </div>

        </div>

    </form>

</div>



<script>

    const form = document.getElementById('verification-form');

    const saveDraftUrl = <?php echo json_encode(route('penerimaan.save-draft', $penerimaan), 512) ?>;
    const submitUrl = <?php echo json_encode(route('penerimaan.submit', $penerimaan), 512) ?>;
    const uploadBuktiUrl = <?php echo json_encode(route('penerimaan.bukti-dukung.upload', $penerimaan), 512) ?>;
    const indexUrl = <?php echo json_encode(route('penerimaan.index'), 15, 512) ?>;

    const canEdit = <?php echo json_encode($canEdit, 15, 512) ?>;


    /*
    |--------------------------------------------------------------------------
    | UPDATE SUMMARY
    |--------------------------------------------------------------------------
    */

    function updateSummary() {

        let totalBaik = 0;
        let totalRusak = 0;
        let totalPo = 0;

        document.querySelectorAll('[data-detail-row]').forEach(row => {

            const qtyPo = Number(row.dataset.qtyPo || 0);

            const baikInput = row.querySelector('.qty-baik');
            const rusakInput = row.querySelector('.qty-rusak');

            const baik = Math.max(
                0,
                Number(baikInput?.value || 0)
            );

            const rusak = Math.max(
                0,
                Number(rusakInput?.value || 0)
            );

            totalPo += qtyPo;
            totalBaik += baik;
            totalRusak += rusak;

            const selisih = (baik + rusak) - qtyPo;

            const selisihElement = row.querySelector('.selisih-value');

            if (selisihElement) {

                selisihElement.className =
                    'selisih-value inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[12px] ' +
                    (selisih === 0
                        ? 'bg-primary-fixed text-on-primary-fixed'
                        : 'bg-tertiary-fixed text-on-tertiary-fixed-variant');

                selisihElement.innerHTML = `
                    <span class="material-symbols-outlined text-[15px]">
                        ${selisih === 0 ? 'check_circle' : 'difference'}
                    </span>
                    ${selisih > 0 ? '+' : ''}${selisih}
                `;
            }

            const rejectLabel = row.querySelector('.reject-label');

            if (rejectLabel) {

                rejectLabel.textContent =
                    rusak > 0
                        ? 'Barang rusak'
                        : 'Nihil';

                rejectLabel.className =
                    'reject-label text-[11px] ' +
                    (rusak > 0
                        ? 'text-error font-label-bold'
                        : 'text-outline-variant italic');
            }

        });


        const totalSelisih = (totalBaik + totalRusak) - totalPo;

        document.getElementById('summary-baik').textContent =
            totalBaik.toLocaleString('id-ID');

        document.getElementById('summary-rusak').textContent =
            totalRusak.toLocaleString('id-ID');

        document.getElementById('summary-selisih').textContent =
            (totalSelisih > 0 ? '+' : '') +
            totalSelisih.toLocaleString('id-ID');

        document.getElementById('footer-baik').textContent =
            totalBaik.toLocaleString('id-ID');

        document.getElementById('footer-rusak').textContent =
            totalRusak.toLocaleString('id-ID');

        document.getElementById('footer-selisih').textContent =
            (totalSelisih > 0 ? '+' : '') +
            totalSelisih.toLocaleString('id-ID');

    }


    /*
    |--------------------------------------------------------------------------
    | INPUT VALIDATION
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.qty-baik, .qty-rusak').forEach(input => {

        input.addEventListener('input', function () {

            if (Number(this.value) < 0) {
                this.value = 0;
            }

            const row = this.closest('[data-detail-row]');

            if (!row) return;

            const qtyPo = Number(row.dataset.qtyPo || 0);

            const baik =
                Number(row.querySelector('.qty-baik')?.value || 0);

            const rusak =
                Number(row.querySelector('.qty-rusak')?.value || 0);


            if (baik + rusak > qtyPo) {

                this.setCustomValidity(
                    'Qty baik + qty rusak tidak boleh melebihi Qty PO.'
                );

            } else {

                this.setCustomValidity('');

            }

            updateSummary();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | PHOTO UPLOAD PREVIEW
    |--------------------------------------------------------------------------
    */

    const photoInput = document.getElementById('foto_penerimaan');

    if (photoInput) {

        photoInput.addEventListener('change', function () {

            const files = Array.from(this.files || []);

            if (!files.length) {
                return;
            }

            if (files.length > 5) {

                alert('Maksimal 5 foto yang dapat diunggah dalam satu kali upload.');

                this.value = '';
                clearPhotoSelection();

                return;
            }

            const invalidFile = files.find(file =>
                !['image/jpeg', 'image/png', 'image/webp'].includes(file.type)
            );

            if (invalidFile) {

                alert('Format foto harus JPG, JPEG, PNG, atau WEBP.');
\                this.value = '';
                clearPhotoSelection();

                return;
            }

            const tooLarge = files.find(file => file.size > 5 * 1024 * 1024);

            if (tooLarge) {

                alert('Ukuran setiap foto maksimal 5 MB.');
                this.value = '';
                clearPhotoSelection();

                return;
            }

            renderPhotoPreview(files);
            uploadPhotos(files);

        });

    }


    async function uploadPhotos(files) {

        if (!canEdit || !files.length) {
            return;
        }

        const formData = new FormData();

        formData.append(
            '_token',
            document.querySelector('input[name="_token"]').value
        );

        files.forEach(file => {
            formData.append('bukti_dukung[]', file);
        });

        try {

            const response = await fetch(uploadBuktiUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {

                let message = data.message || 'Gagal mengunggah foto.';

                if (data.errors) {
                    const firstError = Object.values(data.errors).flat()[0];
                    if (firstError) {
                        message = firstError;
                    }
                }

                throw new Error(message);
            }

            alert(data.message || 'Bukti pendukung berhasil diupload.');

            window.location.reload();

        } catch (error) {

            console.error(error);

            alert(
                error.message ||
                'Terjadi kesalahan saat mengunggah foto.'
            );

            clearPhotoSelection();
        }

    }


    function renderPhotoPreview(files) {

        const wrapper =
            document.getElementById('photo-preview');

        const grid =
            document.getElementById('photo-preview-grid');

        if (!wrapper || !grid) return;

        grid.innerHTML = '';

        if (!files.length) {

            wrapper.classList.add('hidden');

            return;

        }

        wrapper.classList.remove('hidden');


        files.forEach((file, index) => {

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                const item = document.createElement('div');

                item.className =
                    'relative overflow-hidden rounded-lg border border-outline-variant bg-surface-container';

                item.innerHTML = `
                    <img
                        src="${event.target.result}"
                        alt="Preview foto ${index + 1}"
                        class="w-full h-28 object-cover"
                    >

                    <div class="absolute bottom-0 inset-x-0 px-2 py-1 bg-black/60 text-white text-[10px] truncate">
                        ${file.name}
                    </div>
                `;

                grid.appendChild(item);

            };

            reader.readAsDataURL(file);

        });

    }


    function clearPhotoSelection() {

        if (photoInput) {
            photoInput.value = '';
        }

        const wrapper =
            document.getElementById('photo-preview');

        const grid =
            document.getElementById('photo-preview-grid');

        if (wrapper) {
            wrapper.classList.add('hidden');
        }

        if (grid) {
            grid.innerHTML = '';
        }

    }


    /*
    |--------------------------------------------------------------------------
    | SAVE DRAFT
    |--------------------------------------------------------------------------
    */

    function saveDraft() {

        if (!canEdit) {
            return;
        }

        const formData =
            new FormData(form);

        fetch(saveDraftUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':
                    document.querySelector('input[name="_token"]').value,

                'Accept':
                    'application/json',
            },
            body: formData
        })
        .then(async response => {

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message ||
                    'Gagal menyimpan draft.'
                );
            }

            return data;

        })
        .then(data => {

            alert(
                data.message ||
                'Draft penerimaan berhasil disimpan.'
            );

            window.location.reload();

        })
        .catch(error => {

            console.error(error);

            alert(
                error.message ||
                'Terjadi kesalahan saat menyimpan draft.'
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT FINAL
    |--------------------------------------------------------------------------
    */

    function submitReception() {

        if (!canEdit) {
            return;
        }


        /*
         * Validasi client-side.
         */

        let hasError = false;

        document.querySelectorAll('[data-detail-row]').forEach(row => {

            const qtyPo =
                Number(row.dataset.qtyPo || 0);

            const baik =
                Number(row.querySelector('.qty-baik')?.value || 0);

            const rusak =
                Number(row.querySelector('.qty-rusak')?.value || 0);

            if (baik < 0 || rusak < 0) {

                hasError = true;

            }

            /*
             * Discrepancy boleh.
             * Tetapi baik + rusak tidak boleh melebihi PO.
             */

            if (baik + rusak > qtyPo) {

                hasError = true;

            }

        });


        if (hasError) {

            alert(
                'Periksa kembali Qty Baik dan Qty Rusak. ' +
                'Jumlah Baik + Rusak tidak boleh melebihi Qty PO.'
            );

            return;
        }


        if (!confirm(
            'Submit penerimaan ini ke proses approval Kasubag?\n\n' +
            'Catatan: stok gudang BELUM akan bertambah pada tahap ini. ' +
            'Stok baru diproses setelah approval Direktur.'
        )) {

            return;
        }


        const submitForm =
            document.createElement('form');

        submitForm.method = 'POST';
        submitForm.action = submitUrl;

        const token =
            document.createElement('input');

        token.type = 'hidden';
        token.name = '_token';
        token.value =
            document.querySelector('input[name="_token"]').value;

        submitForm.appendChild(token);


        const formData =
            new FormData(form);

        formData.forEach((value, key) => {

            if (key === '_token') {
                return;
            }

            if (value instanceof File) {

                if (value.name) {

                    const input =
                        document.createElement('input');

                    input.type = 'hidden';
                    input.name = key;

                }

                return;
            }

            const input =
                document.createElement('input');

            input.type = 'hidden';
            input.name = key;
            input.value = value;

            submitForm.appendChild(input);

        });


        document.body.appendChild(submitForm);

        submitForm.submit();

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateSummary();

</script>


<?php $__env->startPush('head'); ?>

<style>

    @media print {

        #page-loading-overlay,
        header,
        aside,
        button,
        a[href],
        .no-print {
            display: none !important;
        }

        main {
            margin: 0 !important;
            width: 100% !important;
        }

        body {
            overflow: visible !important;
            background: #fff !important;
        }

        .sticky {
            position: static !important;
        }

    }

</style>

<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/penerimaan/verifikasi.blade.php ENDPATH**/ ?>