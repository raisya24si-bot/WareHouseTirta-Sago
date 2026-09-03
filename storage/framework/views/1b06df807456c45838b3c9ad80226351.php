<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <?php echo $__env->make('layouts.partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-background flex overflow-hidden h-screen">

    <!-- FULL PAGE LOADING SCREEN (satu-satunya, dipakai semua halaman) -->
    <div id="page-loading-overlay">

        <div class="relative flex items-center justify-center">

            <div class="loading-ring absolute"></div>

            <div class="loading-badge flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-lg shadow-primary/30">
                <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">
                    warehouse
                </span>
            </div>

        </div>

        <p class="mt-6 text-sm font-bold uppercase tracking-wider text-primary">
            Warehouse Tirta Sago
        </p>

        <div class="mt-2 flex items-center justify-center gap-1.5">
            <span class="loading-dot h-1.5 w-1.5 rounded-full bg-primary" style="animation-delay: 0ms"></span>
            <span class="loading-dot h-1.5 w-1.5 rounded-full bg-primary" style="animation-delay: 150ms"></span>
            <span class="loading-dot h-1.5 w-1.5 rounded-full bg-primary" style="animation-delay: 300ms"></span>
        </div>

    </div>

    <!-- SIDEBAR (satu komponen, dipakai semua halaman) -->
    <?php if (isset($component)) { $__componentOriginal3623d0faebbae10085f2828f046806b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3623d0faebbae10085f2828f046806b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3623d0faebbae10085f2828f046806b2)): ?>
<?php $attributes = $__attributesOriginal3623d0faebbae10085f2828f046806b2; ?>
<?php unset($__attributesOriginal3623d0faebbae10085f2828f046806b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3623d0faebbae10085f2828f046806b2)): ?>
<?php $component = $__componentOriginal3623d0faebbae10085f2828f046806b2; ?>
<?php unset($__componentOriginal3623d0faebbae10085f2828f046806b2); ?>
<?php endif; ?>


    <!-- MAIN CONTENT -->
    <main
        class="flex-1 flex flex-col md:ml-[250px] w-full md:w-[calc(100%-250px)] h-screen overflow-hidden bg-background"
    >

        <!-- NAVBAR (satu komponen, breadcrumb bisa diganti per halaman) -->
        <?php if (isset($component)) { $__componentOriginal7a1851460580b016997ecb03412ebcac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a1851460580b016997ecb03412ebcac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout.navbar','data' => ['breadcrumb' => $__env->yieldContent('breadcrumb', 'Data Barang')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumb' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__env->yieldContent('breadcrumb', 'Data Barang'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a1851460580b016997ecb03412ebcac)): ?>
<?php $attributes = $__attributesOriginal7a1851460580b016997ecb03412ebcac; ?>
<?php unset($__attributesOriginal7a1851460580b016997ecb03412ebcac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a1851460580b016997ecb03412ebcac)): ?>
<?php $component = $__componentOriginal7a1851460580b016997ecb03412ebcac; ?>
<?php unset($__componentOriginal7a1851460580b016997ecb03412ebcac); ?>
<?php endif; ?>


        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-container-padding custom-scrollbar relative page-fade-in">

            <?php if(session('success')): ?>
                <div class="flash-message mb-4 flex items-start gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="flash-message mb-4 flex items-start gap-2 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    <ul class="list-disc ml-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>

        </div>

    </main>


    <!-- MODAL(S) khusus per halaman -->
    <?php echo $__env->yieldContent('modals'); ?>


    <!-- MOBILE SIDEBAR SCRIPT (satu-satunya, dipakai semua halaman) -->
    <script>
        document
            .getElementById('mobile-menu-btn')
            .addEventListener('click', function () {

                const sidebar =
                    document.getElementById('mobile-sidebar');

                if (sidebar.classList.contains('-translate-x-full')) {

                    sidebar.classList.remove('-translate-x-full');

                } else {

                    sidebar.classList.add('-translate-x-full');

                }

            });
    </script>

    <script>
    (function () {

        const overlay = document.getElementById('page-loading-overlay');

        const MIN_VISIBLE_MS = 400;

        let shownAt = Date.now();

        function showLoading() {

            shownAt = Date.now();

            overlay.classList.remove('is-hidden');
        }

        function hideLoading() {

            const elapsed = Date.now() - shownAt;

            const wait = Math.max(0, MIN_VISIBLE_MS - elapsed);

            setTimeout(function () {
                overlay.classList.add('is-hidden');
            }, wait);
        }

        /*
        |--------------------------------------------------------------------------
        | Sengaja DOMContentLoaded, BUKAN window 'load'.
        |--------------------------------------------------------------------------
        |
        | window 'load' baru nyala setelah SEMUA resource kelar -- termasuk
        | font dari Google Fonts, gambar avatar dari luar (ui-avatars.com),
        | dsb. Kalau salah satu lambat/lemot, overlay ini ikut nyangkut
        | lama padahal kontennya sendiri udah siap. DOMContentLoaded cuma
        | nunggu HTML+CSS+script penting selesai diproses, jauh lebih
        | representatif buat "halaman udah bisa dipakai".
        |--------------------------------------------------------------------------
        */

        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            hideLoading();
        } else {
            document.addEventListener('DOMContentLoaded', hideLoading);
        }


        document.addEventListener('click', function (e) {

            const link = e.target.closest('a[href]');

            if (! link) return;
            if (link.target === '_blank') return;
            if (link.hasAttribute('data-no-loading')) return;

            const href = link.getAttribute('href');

            if (! href) return;
            if (href.startsWith('#')) return;
            if (href.startsWith('javascript:')) return;

            try {

                const url = new URL(href, window.location.href);

                if (url.origin !== window.location.origin) return;

            } catch (err) {
                return;
            }

            showLoading();
        });


        /*
        |--------------------------------------------------------------------------
        | Layar loading PENUH itu cuma buat perpindahan HALAMAN. Aksi kecil
        | dalam halaman yang sama (misal +/- qty, hapus 1 baris) dikasih
        | atribut data-no-loading di <form>-nya supaya nggak ikut nyalain
        | overlay -- tapi tombolnya TETAP dikasih spinner kecil (kecuali
        | juga dikasih data-no-spinner) biar tetap ada feedback pas diklik.
        |--------------------------------------------------------------------------
        */

        document.addEventListener('submit', function (e) {

            if (e.defaultPrevented) return;

            const form = e.target;

            if (! form.hasAttribute('data-no-loading')) {
                showLoading();
            }

            const submitter =
                e.submitter ||
                form.querySelector('button[type="submit"], input[type="submit"]');

            if (
                submitter &&
                submitter.tagName === 'BUTTON' &&
                ! submitter.hasAttribute('data-no-spinner')
            ) {

                const hasText =
                    submitter.textContent.trim().length > 0;

                submitter.dataset.originalHtml = submitter.innerHTML;

                submitter.disabled = true;

                submitter.classList.add('opacity-70', 'cursor-wait');

                submitter.innerHTML = hasText
                    ? '<span class="inline-flex items-center gap-2"><span class="btn-spinner"></span>Memproses...</span>'
                    : '<span class="btn-spinner"></span>';
            }
        });

    })();
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/layouts/app.blade.php ENDPATH**/ ?>