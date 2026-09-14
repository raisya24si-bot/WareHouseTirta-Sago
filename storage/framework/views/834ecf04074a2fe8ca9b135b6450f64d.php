<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'po',
    'compact' => false,
    'withDetails' => false,
]));

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

foreach (array_filter(([
    'po',
    'compact' => false,
    'withDetails' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $currentOrder = $po->currentLevelOrder();
    $rejectedLevel = $po->isRejected() ? strtolower($po->reject_level ?? '') : null;
    $circleSize = $compact ? 'h-7 w-7 text-[11px]' : 'h-11 w-11 text-sm';
    $labelSize = $compact ? 'text-[10px]' : 'text-xs';

    $actorMap = [
        'kasubag' => $po->kasubagBy?->name,
        'kabag' => $po->kabagBy?->name,
        'direktur' => $po->direkturBy?->name,
    ];

    $atMap = [
        'kasubag' => $po->approve_kasubag_at,
        'kabag' => $po->apporve_kabag_at,
        'direktur' => $po->approve_direktur_at,
    ];
?>

<div <?php echo e($attributes->class(['approval-status-widget'])); ?>>

    <?php if (! ($compact)): ?>

        <p class="mb-5 text-xs font-extrabold uppercase tracking-wider text-on-surface">
            Approval Status
        </p>

    <?php endif; ?>


    <div class="flex items-start">

        <?php $__currentLoopData = \App\Models\Po::LEVELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $stepConfig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $order = $stepConfig['order'];

                $isRejectedHere = $rejectedLevel === $slug;
                $isDone = $po->hasPassedLevel($slug) && ! $isRejectedHere;
                $isCurrent = ! $isRejectedHere && ! $isDone && $currentOrder === $order;
            ?>


            <div class="flex flex-1 flex-col items-center text-center">

                <div
                    class="flex <?php echo e($circleSize); ?> shrink-0 items-center justify-center rounded-full font-bold transition-all
                    <?php echo e($isRejectedHere
                            ? 'bg-error text-white ring-8 ring-error/15'
                            : ($isDone
                                ? 'bg-green-600 text-white'
                                : ($isCurrent
                                    ? 'bg-primary text-on-primary ring-8 ring-primary/15'
                                    : 'bg-surface-container-high text-on-surface-variant'))); ?>"
                >

                    <?php if($isRejectedHere): ?>

                        <span class="material-symbols-outlined <?php echo e($compact ? 'text-[14px]' : 'text-[18px]'); ?>">
                            close
                        </span>

                    <?php elseif($isDone): ?>

                        <span class="material-symbols-outlined <?php echo e($compact ? 'text-[14px]' : 'text-[18px]'); ?>">
                            check
                        </span>

                    <?php else: ?>

                        <?php echo e($order); ?>


                    <?php endif; ?>

                </div>


                <span
                    class="mt-2 <?php echo e($labelSize); ?> font-bold
                    <?php echo e($isRejectedHere
                            ? 'text-error'
                            : ($isDone
                                ? 'text-green-700'
                                : ($isCurrent ? 'text-primary' : 'text-on-surface-variant'))); ?>"
                >
                    <?php echo e($stepConfig['label']); ?>

                </span>


                <?php if($withDetails && $isDone && $actorMap[$slug]): ?>

                    <span class="text-[11px] text-on-surface-variant">
                        <?php echo e($actorMap[$slug]); ?>

                    </span>

                    <span class="text-[11px] text-outline">
                        <?php echo e($atMap[$slug]?->translatedFormat('d M Y, H:i')); ?>

                    </span>

                <?php endif; ?>

            </div>


            <?php if($order < count(\App\Models\Po::LEVELS)): ?>

                <div
                    class="<?php echo e($compact ? 'mt-3.5' : 'mt-5'); ?> h-0.5 flex-1 rounded-full
                    <?php echo e($isDone && ! $isRejectedHere ? 'bg-green-600' : 'bg-outline-variant'); ?>"
                ></div>

            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>


    <?php if($withDetails && $po->isRejected() && $po->reject_note): ?>

        <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-4">

            <div class="flex items-center gap-2 text-red-700">

                <span class="material-symbols-outlined text-[18px]">
                    report
                </span>

                <span class="font-bold">
                    Ditolak oleh <?php echo e($po->reject_level ? ucfirst(strtolower($po->reject_level)) : 'approver'); ?>

                    <?php if($po->rejectedBy): ?>
                        (<?php echo e($po->rejectedBy->name); ?>)
                    <?php endif; ?>
                </span>

            </div>

            <p class="mt-1 text-xs text-red-600">
                <?php echo e($po->reject_at?->translatedFormat('d M Y, H:i')); ?>

            </p>

            <p class="mt-2 rounded-md bg-white/60 p-3 text-sm text-red-700">
                <?php echo e($po->reject_note); ?>

            </p>

        </div>

    <?php endif; ?>

</div>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/components/procurement/approval-status.blade.php ENDPATH**/ ?>