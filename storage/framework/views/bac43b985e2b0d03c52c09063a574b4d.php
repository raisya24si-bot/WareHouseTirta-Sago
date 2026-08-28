<?php $__env->startSection('title', $opname->kd_opname . ' - Actual Stok - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Stock Opname'); ?>

<?php $__env->startSection('content'); ?>
<style>
    @media print {
        aside, header, #opname-print-hide, nav, .no-print { display: none !important; }
        main, body { padding: 0 !important; margin: 0 !important; }
        input { border: none !important; }
    }
</style>
<div class="mb-6">
    <a href="<?php echo e(route('opname.index')); ?>" class="mb-2 inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke daftar opname
    </a>
    <div class="flex items-center gap-3">
        <h1 class="text-display-lg font-display-lg text-on-surface leading-tight"><?php echo e($opname->kd_opname); ?></h1>
        <?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $opname->status_opname]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opname->status_opname)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $attributes = $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980)): ?>
<?php $component = $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980; ?>
<?php unset($__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980); ?>
<?php endif; ?>
    </div>
    <p class="mt-1 flex items-center gap-1 text-body-lg text-on-surface-variant">
        <span class="material-symbols-outlined text-[18px]">location_on</span>
        <?php echo e($opname->gudang?->nm_gudang ?? '-'); ?> &middot; Mulai <?php echo e($opname->tgl_mulai?->format('d M Y')); ?>

        <?php if($opname->tgl_selesai): ?> &middot; Selesai <?php echo e($opname->tgl_selesai->format('d M Y')); ?> <?php endif; ?>
    </p>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Barang di Opname</p>
        <p class="text-2xl font-bold"><?php echo e($totalItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Cocok</p>
        <p class="text-2xl font-bold text-green-700 transition-all" id="stat-cocok"><?php echo e($countedItems - $selisihItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Tidak Cocok</p>
        <p class="text-2xl font-bold text-orange-700 transition-all" id="stat-tidak-cocok"><?php echo e($selisihItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
            <span class="material-symbols-outlined">more_horiz</span>
        </div>
        <p class="text-sm text-on-surface-variant">Belum di Opname</p>
        <p class="text-2xl font-bold transition-all" id="stat-belum"><?php echo e($totalItems - $countedItems); ?></p>
        <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-surface-container-high">
            <div class="h-1.5 rounded-full bg-primary transition-all duration-300" id="stat-progress-bar" style="width: <?php echo e($progress); ?>%"></div>
        </div>
        <p class="mt-1 text-xs text-on-surface-variant" id="stat-progress-text"><?php echo e($progress); ?>% Completed</p>
    </div>
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
    <div class="no-print flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low/50 p-4">
        <?php if (isset($component)) { $__componentOriginal778e8091b3f0626b9482cfb19294fdf3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal778e8091b3f0626b9482cfb19294fdf3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.search-filter','data' => ['action' => route('opname.show', $opname),'placeholder' => 'Search bin or material...','filterName' => 'bin','filterLabel' => 'Bin','filterOptions' => $bins->map(fn($b) => ['value' => $b->id_lokasi, 'label' => $b->bin])->all()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.search-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('opname.show', $opname)),'placeholder' => 'Search bin or material...','filterName' => 'bin','filterLabel' => 'Bin','filterOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bins->map(fn($b) => ['value' => $b->id_lokasi, 'label' => $b->bin])->all())]); ?>
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
        <div class="flex items-center gap-2">
            <?php if($selectedBin): ?>
                <form method="POST" action="<?php echo e(route('opname.delete-bin', [$opname, $selectedBin])); ?>" onsubmit="return confirm('Keluarkan bin <?php echo e($selectedBin->bin); ?> dari opname ini?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        <?php if(!$selectedBinCanDelete): echo 'disabled'; endif; ?>
                        title="<?php echo e($selectedBinCanDelete ? 'Keluarkan bin ini dari opname' : 'Masih ada barang yang sudah dihitung di bin ini'); ?>"
                        class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-error hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-transparent">
                        <span class="material-symbols-outlined text-[19px]">delete</span>
                        Hapus Bin Ini
                    </button>
                </form>
            <?php endif; ?>
            <button type="button" onclick="openAddItemModal()" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-primary hover:bg-surface-container-low">
                <span class="material-symbols-outlined text-[19px]">add</span>
                Tambah Barang
            </button>
        </div>
    </div>

    <form id="opname-detail-form" method="POST" action="<?php echo e(route('opname.update', $opname)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
    </form>

    <?php if (isset($component)) { $__componentOriginal4245ad562478bd66068050c769982bc4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4245ad562478bd66068050c769982bc4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.detail-table','data' => ['details' => $details,'emptyBins' => $emptyBins,'opname' => $opname]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.detail-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['details' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($details),'emptyBins' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyBins),'opname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opname)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4245ad562478bd66068050c769982bc4)): ?>
<?php $attributes = $__attributesOriginal4245ad562478bd66068050c769982bc4; ?>
<?php unset($__attributesOriginal4245ad562478bd66068050c769982bc4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4245ad562478bd66068050c769982bc4)): ?>
<?php $component = $__componentOriginal4245ad562478bd66068050c769982bc4; ?>
<?php unset($__componentOriginal4245ad562478bd66068050c769982bc4); ?>
<?php endif; ?>

    <div class="flex flex-col gap-3 border-t border-outline-variant bg-surface-container-low px-4 py-3 sm:flex-row sm:items-center sm:justify-between" id="opname-print-hide">
        <div class="text-sm text-on-surface-variant">
            Showing <?php echo e($details->count()); ?> of <?php echo e($totalItems); ?> Items | Progress: <span id="footer-progress-text"><?php echo e($countedItems); ?>/<?php echo e($totalItems); ?> (<?php echo e($progress); ?>%)</span>
            <div class="mt-1 h-1.5 w-48 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-1.5 rounded-full bg-primary transition-all duration-300" id="footer-progress-bar" style="width: <?php echo e($progress); ?>%"></div>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="submit" form="opname-detail-form" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-primary hover:bg-surface-container-lowest">
                <span class="material-symbols-outlined text-[19px]">save</span>
                Save Progress
            </button>
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2.5 text-body-sm font-label-bold text-on-surface hover:bg-surface-container-lowest">
                <span class="material-symbols-outlined text-[19px]">print</span>
                Print
            </button>
           <?php if($opname->status_opname === 'ONGOING'): ?>
            <form
                method="POST"
                action="<?php echo e(route('opname.submit-adjustment', $opname)); ?>"
                onsubmit="return confirmSubmitAdjustment(<?php echo e($selisihItems); ?>)"
            >
                <?php echo csrf_field(); ?>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-body-sm font-label-bold text-on-primary shadow-sm hover:bg-primary-container"
                >
                    <span class="material-symbols-outlined text-[19px]">
                        check_circle
                    </span>

                    Submit Adjustment
                </button>
            </form>
        <?php else: ?>
            <span
                class="inline-flex items-center gap-2 rounded-md bg-gray-100 px-5 py-2.5 text-body-sm font-label-bold text-gray-600"
            >
                <span class="material-symbols-outlined text-[19px]">
                    check_circle
                </span>

                Opname Completed
            </span>
        <?php endif; ?>
        </div>
    </div>

    <div class="no-print">
        <?php if (isset($component)) { $__componentOriginal27cf80496510f134775277283842cfa5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27cf80496510f134775277283842cfa5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.pagination','data' => ['items' => $details,'label' => 'item','perPage' => $perPage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($details),'label' => 'item','perPage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perPage)]); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
<?php if (isset($component)) { $__componentOriginalaa08cdeda0ee61a22495e6d0b0bc5562 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa08cdeda0ee61a22495e6d0b0bc5562 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.add-item-modal','data' => ['opname' => $opname,'bins' => $bins,'allBarangs' => $allBarangs,'rows' => $rows]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.add-item-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['opname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opname),'bins' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bins),'allBarangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allBarangs),'rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rows)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa08cdeda0ee61a22495e6d0b0bc5562)): ?>
<?php $attributes = $__attributesOriginalaa08cdeda0ee61a22495e6d0b0bc5562; ?>
<?php unset($__attributesOriginalaa08cdeda0ee61a22495e6d0b0bc5562); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa08cdeda0ee61a22495e6d0b0bc5562)): ?>
<?php $component = $__componentOriginalaa08cdeda0ee61a22495e6d0b0bc5562; ?>
<?php unset($__componentOriginalaa08cdeda0ee61a22495e6d0b0bc5562); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalba7ef80b04634ae9a080f4ed83a995cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalba7ef80b04634ae9a080f4ed83a995cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.edit-item-modal','data' => ['opname' => $opname]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.edit-item-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['opname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opname)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalba7ef80b04634ae9a080f4ed83a995cc)): ?>
<?php $attributes = $__attributesOriginalba7ef80b04634ae9a080f4ed83a995cc; ?>
<?php unset($__attributesOriginalba7ef80b04634ae9a080f4ed83a995cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalba7ef80b04634ae9a080f4ed83a995cc)): ?>
<?php $component = $__componentOriginalba7ef80b04634ae9a080f4ed83a995cc; ?>
<?php unset($__componentOriginalba7ef80b04634ae9a080f4ed83a995cc); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>

function confirmSubmitAdjustment(selisihCount) {

    if (selisihCount > 0) {

        return confirm(
            ' Terdapat selisih stok pada ' + selisihCount + ' barang.\n\n' +
            'Stok sistem akan diubah sesuai hasil hitung fisik dan data opname akan dikunci.\n\n' +
            'Lanjutkan submit?'
        );
    }

    return confirm(
        'Submit adjustment? Setelah disubmit, stok resmi pada ' +
        'tbl_stok_lokasi akan diperbarui dan opname tidak dapat ' +
        'diedit lagi.'
    );
}

/*
|--------------------------------------------------------------------------
| STATE LIVE (client-side) UNTUK KARTU RINGKASAN & STATUS BARIS
|--------------------------------------------------------------------------
|
| $totalItems / $countedItems / $selisihItems dari server itu dihitung
| dari SELURUH data opname (bukan cuma yang tampil di halaman ini kalau
| lagi dipaginasi). Supaya angka di 4 kartu atas tetap akurat walau
| user cuma lihat 1 halaman, di sini kita nggak hitung ulang dari nol --
| kita cuma lacak PERUBAHAN status tiap baris yang ada di halaman ini
| (BELUM DIHITUNG -> SESUAI / SELISIH, atau sebaliknya) dan
| menambah/mengurangi count sesuai transisinya.
|--------------------------------------------------------------------------
*/

const opnameCounts = {
    sesuai: <?php echo e($countedItems - $selisihItems); ?>,
    selisih: <?php echo e($selisihItems); ?>,
    belum: <?php echo e($totalItems - $countedItems); ?>,
    total: <?php echo e($totalItems); ?>,
};

const opnameRowStatus = {};

document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('[id^="detail-row-"]')
        .forEach(function (row) {

            const id = row.id.replace('detail-row-', '');

            opnameRowStatus[id] = row.dataset.initialStatus;
        });
});

function updateOpnameStatCards() {

    document.getElementById('stat-cocok').textContent =
        opnameCounts.sesuai;

    document.getElementById('stat-tidak-cocok').textContent =
        opnameCounts.selisih;

    document.getElementById('stat-belum').textContent =
        opnameCounts.belum;

    const countedTotal =
        opnameCounts.sesuai + opnameCounts.selisih;

    const progress =
        opnameCounts.total > 0
            ? Math.round((countedTotal / opnameCounts.total) * 100)
            : 0;

    document.getElementById('stat-progress-bar').style.width =
        progress + '%';

    document.getElementById('stat-progress-text').textContent =
        progress + '% Completed';

    const footerBar =
        document.getElementById('footer-progress-bar');

    const footerText =
        document.getElementById('footer-progress-text');

    if (footerBar) {
        footerBar.style.width = progress + '%';
    }

    if (footerText) {
        footerText.textContent =
            countedTotal + '/' + opnameCounts.total + ' (' + progress + '%)';
    }
}

const opnameStatusIcons = {
    'SESUAI':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-white">' +
        '<span class="material-symbols-outlined text-[18px]">check</span></span>',

    'SELISIH':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-100 text-orange-700">' +
        '<span class="material-symbols-outlined text-[18px]">warning</span></span>',

    'BELUM DIHITUNG':
        '<span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-100 text-gray-500">' +
        '<span class="material-symbols-outlined text-[18px]">more_horiz</span></span>',
};

const opnameRowAccent = {
    'SESUAI': 'border-l-green-400',
    'SELISIH': 'bg-orange-50/50 border-l-orange-400',
    'BELUM DIHITUNG': 'border-l-transparent',
};

function applyOpnameRowStatus(id, status) {

    const row =
        document.getElementById('detail-row-' + id);

    const icon =
        document.getElementById('detail-icon-' + id);

    if (row) {
        row.className =
            'border-l-[3px] transition-colors duration-200 hover:bg-surface-container-low/50 ' +
            opnameRowAccent[status];
    }

    if (icon) {
        icon.innerHTML = opnameStatusIcons[status];
    }
}

function opnameDetailRecalc(id) {

    /*
    |--------------------------------------------------------------------------
    | Actual Qty sekarang OTOMATIS = Baik + Rusak
    |--------------------------------------------------------------------------
    |
    | User cuma input "Baik" (Good/RFS) dan "Rusak" (Damage).
    | Field Actual read-only, dihitung di sini lalu di-submit
    | apa adanya (readonly input tetap ikut ke-POST, beda dengan disabled).
    |
    */

    const baikInput =
        document.getElementById(
            'baik-' + id
        );

    const rusakInput =
        document.getElementById(
            'rusak-' + id
        );

    const actualInput =
        document.getElementById(
            'actual-' + id
        );

    const diffEl =
        document.getElementById(
            'detail-diff-' + id
        );

    const sistem =
        Number(baikInput.dataset.sistem);

    const baikRaw = baikInput.value;
    const rusakRaw = rusakInput.value;

    let newStatus;

    /*
    | Kalau dua-duanya masih kosong,
    | anggap item ini belum dihitung sama sekali.
    */
    if (baikRaw === '' && rusakRaw === '') {

        actualInput.value = '';

        diffEl.textContent = '--';

        diffEl.className =
            'font-label-bold text-on-surface-variant';

        newStatus = 'BELUM DIHITUNG';

    } else {

        const baik =
            baikRaw === '' ? 0 : Number(baikRaw);

        const rusak =
            rusakRaw === '' ? 0 : Number(rusakRaw);

        const actual =
            baik + rusak;

        actualInput.value = actual;

        const diff =
            actual - sistem;

        diffEl.textContent =
            diff > 0
                ? '+' + diff
                : String(diff);

        diffEl.className =
            'font-label-bold transition-colors ' +
            (
                diff === 0
                    ? 'text-green-700'
                    : 'text-error'
            );

        newStatus =
            diff === 0
                ? 'SESUAI'
                : 'SELISIH';
    }

    /*
    | Update kartu ringkasan & warna baris CUMA kalau status
    | barang ini beneran berubah -- biar nggak kerja dua kali.
    */

    const previousStatus =
        opnameRowStatus[id];

    if (newStatus !== previousStatus) {

        const bucketKey = function (status) {
            if (status === 'SESUAI') return 'sesuai';
            if (status === 'SELISIH') return 'selisih';
            return 'belum';
        };

        if (previousStatus) {
            opnameCounts[bucketKey(previousStatus)]--;
        }

        opnameCounts[bucketKey(newStatus)]++;

        opnameRowStatus[id] = newStatus;

        updateOpnameStatCards();
    }

    applyOpnameRowStatus(id, newStatus);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/opname/show.blade.php ENDPATH**/ ?>