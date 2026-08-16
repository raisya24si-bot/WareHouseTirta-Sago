<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?php echo $__env->yieldContent('title', 'Material Master'); ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Work+Sans:wght@400;500;700&display=swap"
        rel="stylesheet"
    >

    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!--
        Tailwind Configuration
        PENTING: ini SATU-SATUNYA config Tailwind untuk seluruh aplikasi.
        Jangan copy config ini ke file halaman lain lagi - kalau ada warna
        baru yang dibutuhkan, tambahkan di sini saja supaya semua halaman
        (termasuk sidebar & navbar) selalu konsisten.
    -->
    <script>
        tailwind.config = {
            darkMode: "class",

            theme: {
                extend: {

                    colors: {
                        background: "#f9f9ff",
                        "on-primary": "#ffffff",
                        "on-primary-fixed": "#001a41",
                        "primary": "#0059bb",
                        "primary-container": "#0070ea",
                        "surface": "#f9f9ff",
                        "surface-bright": "#f9f9ff",
                        "surface-container-low": "#f1f3fe",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e6e8f3",
                        "surface-container-highest": "#e0e2ed",
                        "surface-variant": "#e0e2ed",
                        "inverse-surface": "#2d3039",
                        "surface-dim": "#d7d9e5",
                        "surface-tint": "#005bc0",
                        "on-surface": "#181c23",
                        "on-surface-variant": "#414754",
                        "outline": "#717786",
                        "outline-variant": "#c1c6d7",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "secondary-container": "#dde3eb"
                    },

                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },

                    spacing: {
                        gutter: "16px",
                        "container-padding": "24px"
                    },

                    fontFamily: {
                        "headline-md": ["Manrope"],
                        "display-lg": ["Manrope"],
                        "body-lg": ["Work Sans"],
                        "body-sm": ["Work Sans"],
                        "label-bold": ["Work Sans"],
                        "sidebar-nav": ["Work Sans"]
                    },

                    fontSize: {
                        "headline-md": [
                            "24px",
                            {
                                lineHeight: "32px",
                                fontWeight: "600"
                            }
                        ],

                        "display-lg": [
                            "32px",
                            {
                                lineHeight: "40px",
                                fontWeight: "700"
                            }
                        ],

                        "body-lg": [
                            "16px",
                            {
                                lineHeight: "24px"
                            }
                        ],

                        "body-sm": [
                            "14px",
                            {
                                lineHeight: "20px"
                            }
                        ],

                        "label-bold": [
                            "14px",
                            {
                                lineHeight: "20px",
                                fontWeight: "700"
                            }
                        ],

                        "sidebar-nav": [
                            "13px",
                            {
                                lineHeight: "18px",
                                fontWeight: "500"
                            }
                        ]
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Work Sans', sans-serif;
            background-color: #f9f9ff;
            color: #181c23;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f3fe;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c6d7;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #717786;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="bg-background flex overflow-hidden h-screen">

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
        <div class="flex-1 overflow-y-auto p-container-padding custom-scrollbar relative">

            <?php if(session('success')): ?>
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3"><ul class="list-disc ml-5"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
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

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/layouts/app.blade.php ENDPATH**/ ?>