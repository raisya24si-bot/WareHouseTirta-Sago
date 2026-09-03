<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['gudangs']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['gudangs']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="overflow-auto">

    <table class="w-full min-w-[1100px] text-left">

        <thead class="border-b border-outline-variant bg-surface-container-low">

            <tr>
                <th class="px-5 py-3 text-label-bold">
                    Kode
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Nama Gudang
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Kategori
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Lokasi
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Manager
                </th>

                <th class="px-5 py-3 text-label-bold">
                    Status
                </th>

                <th class="px-5 py-3 text-right text-label-bold">
                    Aksi
                </th>
            </tr>

        </thead>

        <tbody class="divide-y divide-outline-variant/50">

            <?php $__empty_1 = true; $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr class="hover:bg-surface-container-low/50">

                    
                    <td class="px-5 py-4">
                        <?php echo e($g->kd_gudang); ?>

                    </td>

                    
                    <td class="px-5 py-4 font-medium">
                        <?php echo e($g->nm_gudang); ?>

                    </td>

            
            <td class="px-5 py-4">

                <?php
                    $kategori = trim(
                        $g->kategoriGudang?->nm_kategori_gudang ?? ''
                    );

                    $kategoriStyle = match (strtolower($kategori)) {

                        'storage' => [
                            'badge' => 'bg-emerald-100 text-emerald-700',
                            'dot'   => 'bg-emerald-500',
                        ],

                        'transit' => [
                            'badge' => 'bg-blue-100 text-blue-700',
                            'dot'   => 'bg-blue-500',
                        ],

                        'rejected' => [
                            'badge' => 'bg-red-100 text-red-700',
                            'dot'   => 'bg-red-500',
                        ],

                        default => [
                            'badge' => 'bg-surface-container-high text-on-surface-variant',
                            'dot'   => 'bg-outline',
                        ],
                    };
                ?>

                <?php if($kategori): ?>

                    <span
                        class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-medium <?php echo e($kategoriStyle['badge']); ?>"
                    >

                        <span
                            class="h-2 w-2 rounded-full <?php echo e($kategoriStyle['dot']); ?>"
                        ></span>

                        <?php echo e($kategori); ?>


                    </span>

                <?php else: ?>

                    <span class="text-sm text-on-surface-variant">
                        -
                    </span>

                <?php endif; ?>

            </td>

                    
                    <td class="px-5 py-4 text-on-surface-variant">
                        <?php echo e($g->alamat_gudang ?: $g->desc_gudang ?: '-'); ?>

                    </td>

                    
                    <td class="px-5 py-4">
                        <?php echo e($g->kepala_gudang ?: '-'); ?>

                    </td>

                    
                    <td class="px-5 py-4">

                        <?php if (isset($component)) { $__componentOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5691c56bcfc63ede7f3e8ced7f54a980 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.status-badge','data' => ['status' => $g->statusGudang?->nm_status_gudang ?? 'Tidak Aktif']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($g->statusGudang?->nm_status_gudang ?? 'Tidak Aktif')]); ?>
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

                    </td>

                    
                    <td class="px-5 py-4 text-right">

                        <div class="inline-flex gap-1">

                            
                            <button
                                type="button"
                                onclick="editGudang(
                                    <?php echo e($g->id_gudang); ?>,
                                    <?php echo \Illuminate\Support\Js::from($g->nm_gudang)->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from($g->kepala_gudang)->toHtml() ?>,
                                    <?php echo \Illuminate\Support\Js::from($g->alamat_gudang ?: $g->desc_gudang)->toHtml() ?>,
                                    <?php echo e($g->fk_status_gudang); ?>,
                                    <?php echo e($g->fk_kategori_gudang ?? 'null'); ?>

                                )"
                                class="p-1 text-outline hover:text-primary"
                                title="Edit"
                            >

                                <span class="material-symbols-outlined">
                                    edit
                                </span>

                            </button>

                            
                            <form
                                method="POST"
                                action="<?php echo e(route('master-gudang.destroy', $g)); ?>"
                                onsubmit="return confirm('Hapus gudang ini?')"
                            >

                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button
                                    type="submit"
                                    class="p-1 text-outline hover:text-error"
                                    title="Hapus"
                                >

                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td
                        colspan="7"
                        class="px-5 py-12 text-center text-on-surface-variant"
                    >
                        Belum ada data gudang.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

</div><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/master/gudang/gudang-table.blade.php ENDPATH**/ ?>