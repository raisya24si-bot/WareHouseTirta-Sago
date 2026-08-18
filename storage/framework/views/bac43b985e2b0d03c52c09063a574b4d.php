<?php $__env->startSection('title', $opname->kd_opname . ' - Actual Stok - Material Master'); ?>
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
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <p class="text-sm text-on-surface-variant">Total Barang di Opname</p>
        <p class="text-2xl font-bold"><?php echo e($totalItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-primary">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Cocok</p>
        <p class="text-2xl font-bold"><?php echo e($countedItems - $selisihItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
            <span class="material-symbols-outlined">warning</span>
        </div>
        <p class="text-sm text-on-surface-variant">Jumlah Barang Tidak Cocok</p>
        <p class="text-2xl font-bold"><?php echo e($selisihItems); ?></p>
    </div>
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
            <span class="material-symbols-outlined">more_horiz</span>
        </div>
        <p class="text-sm text-on-surface-variant">Belum di Opname</p>
        <p class="text-2xl font-bold"><?php echo e($totalItems - $countedItems); ?></p>
        <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-surface-container-high">
            <div class="h-1.5 rounded-full bg-primary" style="width: <?php echo e($progress); ?>%"></div>
        </div>
        <p class="mt-1 text-xs text-on-surface-variant"><?php echo e($progress); ?>% Completed</p>
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
            Showing <?php echo e($details->count()); ?> of <?php echo e($totalItems); ?> Items | Progress: <?php echo e($countedItems); ?>/<?php echo e($totalItems); ?> (<?php echo e($progress); ?>%)
            <div class="mt-1 h-1.5 w-48 overflow-hidden rounded-full bg-surface-container-high">
                <div class="h-1.5 rounded-full bg-primary" style="width: <?php echo e($progress); ?>%"></div>
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
                onsubmit="return confirm('Submit adjustment? Setelah disubmit, stok resmi pada tbl_stok_lokasi akan diperbarui dan opname tidak dapat diedit lagi.')"
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.opname.add-item-modal','data' => ['opname' => $opname,'bins' => $bins,'allBarangs' => $allBarangs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('opname.add-item-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['opname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($opname),'bins' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bins),'allBarangs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($allBarangs)]); ?>
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
function opnameDetailRecalc(id) {

    const actualInput =
        document.querySelector(
            `input[name="detail[${id}][actual]"]`
        );

    const baikInput =
        document.getElementById(
            'baik-' + id
        );

    const rusakInput =
        document.getElementById(
            'rusak-' + id
        );

    const diffEl =
        document.getElementById(
            'detail-diff-' + id
        );

    const sistem =
        Number(actualInput.dataset.sistem);

    const actual =
        actualInput.value === ''
            ? null
            : Number(actualInput.value);

    const baik =
        baikInput.value === ''
            ? 0
            : Number(baikInput.value);

    const rusak =
        rusakInput.value === ''
            ? 0
            : Number(rusakInput.value);

    if (actual === null) {

        diffEl.textContent = '--';

        diffEl.className =
            'font-label-bold text-on-surface-variant';

        return;
    }

    const diff =
        actual - sistem;

    diffEl.textContent =
        diff > 0
            ? '+' + diff
            : String(diff);

    diffEl.className =
        'font-label-bold ' +
        (
            diff === 0
                ? 'text-green-700'
                : 'text-error'
        );

    /*
    |--------------------------------------------------------------------------
    | Validasi Actual = Baik + Rusak
    |--------------------------------------------------------------------------
    */

    const total =
        baik + rusak;

    if (total !== actual) {

        actualInput.classList.add(
            'border-error'
        );

        baikInput.classList.add(
            'border-error'
        );

        rusakInput.classList.add(
            'border-error'
        );

    } else {

        actualInput.classList.remove(
            'border-error'
        );

        baikInput.classList.remove(
            'border-error'
        );

        rusakInput.classList.remove(
            'border-error'
        );
    }
}
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/opname/show.blade.php ENDPATH**/ ?>