@props(['breadcrumb' => 'Data Barang'])

<header
    class="bg-surface-container-low dark:bg-surface-container-lowest top-0 sticky z-40 border-b border-outline-variant flex justify-between items-center px-gutter py-2 w-full h-[64px]">

    <!-- Mobile Menu -->
    <button
        class="md:hidden p-2 rounded-full text-on-surface-variant hover:bg-surface-variant transition-colors mr-2"
        id="mobile-menu-btn">

        <span class="material-symbols-outlined">
            menu
        </span>

    </button>

    <!-- Mobile Brand -->
    <div class="flex items-center gap-2 md:hidden">

        <span
            class="material-symbols-outlined text-primary"
            style="font-variation-settings: 'FILL' 1;">
            warehouse
        </span>

        <span class="text-headline-md font-headline-md font-bold text-on-surface truncate">
            Warehouse Tirta Sago
        </span>

    </div>

    <!-- Breadcrumb -->
    <div class="hidden md:flex items-center gap-2 text-body-sm font-body-sm text-on-surface-variant">

        <span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors">
            <span class="material-symbols-outlined text-[16px]">home</span>
            Warehouse Tirta Sago
        </span>

        <span class="material-symbols-outlined text-[16px] text-outline-variant">
            chevron_right
        </span>

        <span class="font-semibold text-on-surface">
            {{ $breadcrumb }}
        </span>

    </div>

    <!-- Search -->
    <div
        class="hidden md:flex items-center bg-surface w-96 rounded-full border border-outline-variant focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15 transition-all overflow-hidden ml-8 shadow-sm">

        <div class="pl-4 pr-2 py-2 flex items-center justify-center text-outline">
            <span class="material-symbols-outlined text-[20px]">
                search
            </span>
        </div>

        <input
            class="w-full border-none bg-transparent py-2 pl-0 pr-2 text-body-sm font-body-sm text-on-surface focus:ring-0 placeholder:text-outline-variant"
            placeholder="Cari SKU, Nama Barang..."
            type="text"
        >

        <kbd class="hidden lg:inline-flex mr-3 items-center gap-0.5 rounded border border-outline-variant bg-surface-container-low px-1.5 py-0.5 text-[10px] font-semibold text-outline">
            /
        </kbd>

    </div>

    <!-- Actions -->
    <div class="flex items-center gap-1 ml-auto">

        <!-- Notifications -->
        <div class="relative">

            <button
                type="button"
                onclick="toggleDropdown('notif-dropdown')"
                class="p-2 rounded-full text-on-surface-variant hover:bg-surface-variant transition-all duration-150 relative">

                <span class="material-symbols-outlined">
                    notifications
                </span>

                <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-error border-2 border-surface-container-low"></span>
                </span>

            </button>

            <div
                id="notif-dropdown"
                class="hidden absolute right-0 mt-2 w-80 rounded-xl border border-outline-variant bg-white shadow-xl overflow-hidden z-50"
            >
                <div class="px-4 py-3 border-b border-outline-variant flex items-center justify-between">
                    <p class="font-label-bold text-on-surface">Notifikasi</p>
                    <span class="text-xs rounded-full bg-error/10 text-error px-2 py-0.5 font-semibold">1 baru</span>
                </div>

                <div class="max-h-72 overflow-y-auto custom-scrollbar divide-y divide-outline-variant/60">
                    <div class="px-4 py-3 hover:bg-surface-container-low transition-colors cursor-pointer">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-600 mt-0.5 text-[20px]">trending_down</span>
                            <div class="min-w-0">
                                <p class="text-sm text-on-surface leading-snug">Ada barang dengan stok menipis / habis di Master Barang.</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">Baru saja</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-2.5 text-center border-t border-outline-variant">
                    <a href="{{ route('barang.index') }}" class="text-xs font-label-bold text-primary hover:underline">
                        Lihat Master Barang
                    </a>
                </div>
            </div>

        </div>

        <button
            class="p-2 rounded-full text-on-surface-variant hover:bg-surface-variant transition-all duration-150 hidden sm:block">

            <span class="material-symbols-outlined">
                settings
            </span>

        </button>

        <div class="h-8 w-px bg-outline-variant mx-2 hidden sm:block"></div>

        <!-- Profile -->
        <div class="relative">

            <button
                type="button"
                onclick="toggleDropdown('profile-dropdown')"
                class="flex items-center gap-2 hover:bg-surface-variant rounded-full pr-2 py-1 pl-1 transition-all duration-150"
            >
                <img
                    alt="Administrator Profile"
                    class="w-9 h-9 rounded-full object-cover"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuACaksQcvurtqmgB5UPqDTUI32i2tWQknR7jLenZlBlXyOPj6CR6LtS91l2oXha21OBffMuBEUBTMWzedthQKsB2_01WPN-Yo2oCVRKafQvfJdmEeFlC94l_ytewtGD5I7KybDCgKz_OeAWmGbrpgl9AbFecrDnHUyqQg5UOhbQfjDK9byAHgnrucipDbrN1zjlT2Mp78O6XvGu5dpRF7Ure7iJ4wH6ko70AL0OC6rIrGUJ-P9-a3JUZQ"
                >
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant hidden sm:block">
                    expand_more
                </span>
            </button>

            <div
                id="profile-dropdown"
                class="hidden absolute right-0 mt-2 w-56 rounded-xl border border-outline-variant bg-white shadow-xl overflow-hidden z-50"
            >
                <div class="px-4 py-3 border-b border-outline-variant">
                    <p class="text-sm font-label-bold text-on-surface truncate">Administrator</p>
                    <p class="text-xs text-on-surface-variant truncate">admin@tirtasago.id</p>
                </div>

                <div class="py-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[19px]">person</span>
                        Profil Saya
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[19px]">settings</span>
                        Pengaturan
                    </a>
                </div>

                <div class="border-t border-outline-variant py-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-error hover:bg-error/5 transition-colors">
                        <span class="material-symbols-outlined text-[19px]">logout</span>
                        Keluar
                    </a>
                </div>
            </div>

        </div>

    </div>

</header>

<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isOpen = !el.classList.contains('hidden');

        // Tutup semua dropdown navbar dulu.
        document.querySelectorAll('[id$="-dropdown"]').forEach(function (d) {
            d.classList.add('hidden');
        });

        if (!isOpen) {
            el.classList.remove('hidden');
        }
    }

    // Klik di luar dropdown -> otomatis tertutup.
    document.addEventListener('click', function (event) {

        const isToggleButton = event.target.closest('[onclick^="toggleDropdown"]');
        const isDropdownPanel = event.target.closest('[id$="-dropdown"]');

        if (!isToggleButton && !isDropdownPanel) {
            document.querySelectorAll('[id$="-dropdown"]').forEach(function (d) {
                d.classList.add('hidden');
            });
        }
    });
</script>