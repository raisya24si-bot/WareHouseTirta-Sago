<meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'Warehouse Tirta Sago')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&family=Work+Sans:wght@400;500;700&display=swap"
        rel="stylesheet"
    >

    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0..1,0&display=swap"
        rel="stylesheet"
    >

    <!--
        Tailwind CSS - dikompilasi lokal lewat Vite (bukan CDN lagi).
        Config warna/font/radius/spacing custom ada di resources/css/app.css.
    -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')