<!DOCTYPE html>
<html class="light" lang="id">

<head>
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

        /*
        |--------------------------------------------------------------------------
        | FULL PAGE LOADING SCREEN
        |--------------------------------------------------------------------------
        |
        | Defaultnya KELIHATAN (bukan disembunyikan pakai JS) supaya begitu
        | HTML halaman mulai di-parse browser, loading screen ini LANGSUNG
        | nutup layar tanpa nunggu JS jalan dulu -- jadi transisi antar
        | halaman kerasa nyambung, nggak ada kedip konten mentah.
        | JS di bawah cuma tugasnya nyembunyiin pas halaman udah siap.
        |--------------------------------------------------------------------------
        */

        #page-loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f9f9ff;
            opacity: 1;
            transition: opacity 0.3s ease-out;
        }

        #page-loading-overlay.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loading-ring {
            width: 64px;
            height: 64px;
            border-radius: 9999px;
            border: 4px solid rgba(0, 89, 187, 0.15);
            border-top-color: #0059bb;
            animation: loading-ring-spin 0.8s linear infinite;
        }

        @keyframes loading-ring-spin {
            to { transform: rotate(360deg); }
        }

        .loading-badge {
            animation: loading-badge-pulse 1.4s ease-in-out infinite;
        }

        @keyframes loading-badge-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(0.9); }
        }

        .loading-dot {
            animation: loading-dot-bounce 1s ease-in-out infinite;
        }

        @keyframes loading-dot-bounce {
            0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
            40% { transform: translateY(-5px); opacity: 1; }
        }

        /*
        |--------------------------------------------------------------------------
        | FLASH MESSAGE MASUK DENGAN ANIMASI
        |--------------------------------------------------------------------------
        */

        @keyframes flash-slide-in {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .flash-message {
            animation: flash-slide-in 0.3s ease-out;
        }

        /*
        |--------------------------------------------------------------------------
        | SPINNER KECIL UNTUK TOMBOL YANG LAGI PROSES
        |--------------------------------------------------------------------------
        */

        .btn-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: btn-spinner-spin 0.6s linear infinite;
        }

        @keyframes btn-spinner-spin {
            to { transform: rotate(360deg); }
        }

        /*
        |--------------------------------------------------------------------------
        | KONTEN HALAMAN FADE-IN HALUS SETIAP KALI SELESAI DIMUAT
        |--------------------------------------------------------------------------
        */

        @keyframes page-fade-in {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-fade-in {
            animation: page-fade-in 0.25s ease-out;
        }
    </style>

    @stack('head')
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
    <x-layout.sidebar />


    <!-- MAIN CONTENT -->
    <main
        class="flex-1 flex flex-col md:ml-[250px] w-full md:w-[calc(100%-250px)] h-screen overflow-hidden bg-background"
    >

        <!-- NAVBAR (satu komponen, breadcrumb bisa diganti per halaman) -->
        <x-layout.navbar :breadcrumb="$__env->yieldContent('breadcrumb', 'Data Barang')" />


        <!-- PAGE CONTENT -->
        <div class="flex-1 overflow-y-auto p-container-padding custom-scrollbar relative page-fade-in">

            @if(session('success'))
                <div class="flash-message mb-4 flex items-start gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="flash-message mb-4 flex items-start gap-2 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    <ul class="list-disc ml-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')

        </div>

    </main>


    <!-- MODAL(S) khusus per halaman -->
    @yield('modals')


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


    <!--
        FULL PAGE LOADING SCREEN + TOMBOL SPINNER (satu-satunya, dipakai semua halaman)
        =====================================================================
        - Loading screen ini defaultnya udah KELIHATAN dari HTML (lihat CSS
          di atas), jadi begitu halaman baru mulai di-render browser, layar
          loading langsung nutup konten -- nggak nunggu JS ini jalan dulu.
          JS di sini cuma tugasnya SEMBUNYIIN pas halaman udah siap, dan
          MEMUNCULKAN lagi pas user klik link / submit form (biar dapat
          feedback instan sebelum browser beneran pindah halaman).
        - Tombol submit: otomatis di-disable + diganti jadi spinner +
          "Memproses..." pas form-nya beneran ke-submit (bukan pas
          dibatalkan lewat confirm()).
        - Nggak perlu ubah apapun di halaman lain -- ini nempel otomatis
          ke SEMUA <a> dan <form> di seluruh aplikasi.
        - Opt-out per elemen kalau memang nggak mau: kasih atribut
          data-no-loading di <a>/<form>, atau data-no-spinner di tombolnya.
    -->
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
        | Halaman ini sendiri baru selesai dimuat -> sembunyikan
        | loading screen-nya (dengan jeda minimum biar animasinya
        | kelihatan, nggak cuma numpang lewat sepersekian detik).
        */

        if (document.readyState === 'complete') {
            hideLoading();
        } else {
            window.addEventListener('load', hideLoading);
        }

        /*
        | Klik link internal (bukan #, javascript:, target=_blank,
        | atau link ke domain lain) -> tampilkan lagi loading screen-nya.
        */

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
        | Submit form -> tampilkan loading screen + ubah tombolnya jadi
        | spinner. Kalau submit-nya dibatalkan (misal user klik "Batal"
        | di confirm()), e.defaultPrevented sudah true duluan di titik
        | ini, jadi kita skip -- nggak jadi nampilin loading buat apa-apa.
        */

        document.addEventListener('submit', function (e) {

            if (e.defaultPrevented) return;

            const form = e.target;

            if (form.hasAttribute('data-no-loading')) return;

            showLoading();

            const submitter =
                e.submitter ||
                form.querySelector('button[type="submit"], input[type="submit"]');

            if (
                submitter &&
                submitter.tagName === 'BUTTON' &&
                ! submitter.hasAttribute('data-no-spinner')
            ) {

                /*
                | Tombol icon-only (kayak tombol Delete di tabel) cuma
                | diganti spinner-nya doang, tanpa teks -- biar nggak
                | melebar aneh di dalam baris tabel yang sempit. Tombol
                | yang emang ada tulisannya ("Submit Adjustment", "Import",
                | dst) tetap dikasih teks "Memproses..." biar jelas.
                */

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

    @stack('scripts')

</body>

</html>