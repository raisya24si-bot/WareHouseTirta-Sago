<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <?php echo $__env->make('layouts.partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-background min-h-screen flex items-center justify-center p-6">

    <?php if(session('success')): ?>
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flash-message flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 shadow-lg">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flash-message flex items-center gap-2 rounded-lg bg-blue-50 border border-blue-200 text-primary px-4 py-3 shadow-lg">
            <span class="material-symbols-outlined text-[20px]">info</span>
            <span><?php echo e(session('info')); ?></span>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

</body>

</html><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/layouts/guest.blade.php ENDPATH**/ ?>