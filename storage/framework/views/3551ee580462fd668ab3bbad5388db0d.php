<meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?php echo $__env->yieldContent('title', 'Warehouse Tirta Sago'); ?></title>

    <!--
        Font (Manrope, Work Sans, Material Symbols) di-bundle lokal lewat
        Vite (lihat resources/css/app.css) -- bukan dari Google Fonts CDN
        lagi, supaya nggak ada request ke domain luar yang bisa bikin
        halaman kerasa lelet nunggu font external.
    -->

    <!--
        Tailwind CSS - dikompilasi lokal lewat Vite (bukan CDN lagi).
        Config warna/font/radius/spacing custom ada di resources/css/app.css.
    -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('head'); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/layouts/partials/head.blade.php ENDPATH**/ ?>