<aside
    class="fixed left-0 top-0 h-full w-[250px] bg-white border-r border-outline-variant shadow-sm z-50 flex flex-col py-4 transition-transform duration-300 md:translate-x-0 -translate-x-full"
    id="mobile-sidebar">

    <!-- Header / Brand -->
    <div class="px-5 mb-6 flex items-center gap-3">
        <div class="relative w-11 h-11 shrink-0 rounded-xl bg-gradient-to-br from-primary to-primary-container flex items-center justify-center text-on-primary shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">
                warehouse
            </span>
        </div>

        <div class="min-w-0">
            <h1 class="text-headline-md font-headline-md font-bold text-on-surface m-0 leading-tight truncate">
                Warehouse
            </h1>

            <p class="text-[11px] text-primary font-bold uppercase tracking-wider mt-0.5 truncate">
                Tirta Sago
            </p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 space-y-5 custom-scrollbar">

        <!-- ==================== UTAMA ==================== -->
        <div>
            <p class="px-4 mb-1.5 text-[11px] font-bold uppercase tracking-wider text-outline">
                Utama
            </p>

            <div class="space-y-0.5">

                <!-- Dashboard -->
                <a href="#"
                class="text-on-surface-variant hover:text-primary mx-2 flex items-center px-4 py-2.5 rounded-xl hover:bg-surface-container-low transition-all duration-150 group hover:pl-5">
                    <span class="material-symbols-outlined mr-3 text-[20px] text-outline group-hover:text-primary transition-colors">
                        dashboard
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Dashboard
                    </span>
                </a>

                <!-- Monitoring -->
                <a href="#"
                class="text-on-surface-variant hover:text-primary mx-2 flex items-center px-4 py-2.5 rounded-xl hover:bg-surface-container-low transition-all duration-150 group hover:pl-5">
                    <span class="material-symbols-outlined mr-3 text-[20px] text-outline group-hover:text-primary transition-colors">
                        monitor_heart
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Monitoring
                    </span>
                </a>

            </div>
        </div>


        <!-- ==================== MASTER DATA ==================== -->
        <div>
            <p class="px-4 mb-1.5 text-[11px] font-bold uppercase tracking-wider text-outline">
                Master Data
            </p>

            <div class="mx-2">

                @php
                    $isMasterActive = request()->routeIs([
                        'barang.*',
                        'master-supplier.*',
                        'master-kategori.*',
                        'master-satuan.*',
                        'master-gudang.*',
                    ]);
                @endphp

                <!-- Master Header -->
                <button
                    type="button"
                    onclick="toggleMasterMenu()"
                    class="w-full text-on-surface-variant hover:text-primary flex items-center px-4 py-2.5 rounded-xl hover:bg-surface-container-low transition-all duration-150 group">

                    <span class="material-symbols-outlined mr-3 text-[20px] text-outline group-hover:text-primary transition-colors">
                        database
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav font-bold flex-1 text-left">
                        Data Master
                    </span>

                    <span
                        id="master-chevron"
                        class="material-symbols-outlined text-[20px] transition-transform duration-200 {{ $isMasterActive ? 'rotate-180' : '' }}">
                        expand_more
                    </span>
                </button>

                <!-- Master Submenu -->
                <div
                    id="master-menu"
                    class="ml-4 mt-1 space-y-0.5 border-l-2 border-outline-variant pl-2 overflow-hidden transition-all duration-200 {{ $isMasterActive ? '' : 'hidden' }}">

                    <a href="{{ route('barang.index') }}"
                    class="{{ request()->routeIs('barang.*')
                            ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                            flex items-center px-4 py-2.5 rounded-lg transition-all duration-150">

                        <span class="material-symbols-outlined mr-3 text-[19px]" @if(request()->routeIs('barang.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                            inventory_2
                        </span>

                        <span class="text-sidebar-nav font-sidebar-nav">
                            Barang
                        </span>
                    </a>

                    <a href="{{ route('master-supplier.index') }}"
                    class="{{ request()->routeIs('master-supplier.*')
                            ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                            flex items-center px-4 py-2.5 rounded-lg transition-all duration-150">

                        <span class="material-symbols-outlined mr-3 text-[19px]" @if(request()->routeIs('master-supplier.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                            local_shipping
                        </span>

                        <span class="text-sidebar-nav font-sidebar-nav">
                            Supplier
                        </span>
                    </a>

                    <a href="{{ route('master-kategori.index') }}"
                    class="{{ request()->routeIs('master-kategori.*')
                            ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                            flex items-center px-4 py-2.5 rounded-lg transition-all duration-150">

                        <span class="material-symbols-outlined mr-3 text-[19px]" @if(request()->routeIs('master-kategori.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                            category
                        </span>

                        <span class="text-sidebar-nav font-sidebar-nav">
                            Kategori
                        </span>
                    </a>

                    <a href="{{ route('master-satuan.index') }}"
                    class="{{ request()->routeIs('master-satuan.*')
                            ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                            flex items-center px-4 py-2.5 rounded-lg transition-all duration-150">

                        <span class="material-symbols-outlined mr-3 text-[19px]" @if(request()->routeIs('master-satuan.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                            straighten
                        </span>

                        <span class="text-sidebar-nav font-sidebar-nav">
                            Satuan
                        </span>
                    </a>

                    <a href="{{ route('master-gudang.index') }}"
                    class="{{ request()->routeIs('master-gudang.*')
                            ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                            flex items-center px-4 py-2.5 rounded-lg transition-all duration-150">

                        <span class="material-symbols-outlined mr-3 text-[19px]" @if(request()->routeIs('master-gudang.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                            warehouse
                        </span>

                        <span class="text-sidebar-nav font-sidebar-nav">
                            Gudang
                        </span>
                    </a>

                </div>

            </div>
        </div>


        <!-- ==================== OPERASIONAL ==================== -->
        <div>
            <p class="px-4 mb-1.5 text-[11px] font-bold uppercase tracking-wider text-outline">
                Operasional
            </p>

            <div class="space-y-0.5">

                <a href="{{ route('opname.index') }}"
                class="{{ request()->routeIs('opname.*')
                        ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        mx-2 flex items-center px-4 py-2.5 rounded-xl transition-all duration-150 group {{ request()->routeIs('opname.*') ? '' : 'hover:pl-5' }}">

                    <span class="material-symbols-outlined mr-3 text-[20px] {{ request()->routeIs('opname.*') ? '' : 'text-outline group-hover:text-primary transition-colors' }}" @if(request()->routeIs('opname.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                        fact_check
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Stock Opname
                    </span>
                </a>

                <a
                    href="{{ route('manajemen-stok.index') }}"
                    class="{{ request()->routeIs('manajemen-stok.*')
                        ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        mx-2 flex items-center px-4 py-2.5 rounded-xl transition-all duration-150 group {{ request()->routeIs('manajemen-stok.*') ? '' : 'hover:pl-5' }}"
                >
                    <span class="material-symbols-outlined mr-3 text-[20px] {{ request()->routeIs('manajemen-stok.*') ? '' : 'text-outline group-hover:text-primary transition-colors' }}" @if(request()->routeIs('manajemen-stok.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                        inventory
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Manajemen Stok Barang
                    </span>
                </a>

                <a
                    href="{{ route('procurement.index') }}"
                    class="{{ request()->routeIs('procurement.*')
                        ? 'bg-primary text-on-primary shadow-sm shadow-primary/30'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        mx-2 flex items-center px-4 py-2.5 rounded-xl transition-all duration-150 group {{ request()->routeIs('procurement.*') ? '' : 'hover:pl-5' }}"
                >
                    <span class="material-symbols-outlined mr-3 text-[20px] {{ request()->routeIs('procurement.*') ? '' : 'text-outline group-hover:text-primary transition-colors' }}" @if(request()->routeIs('procurement.*')) style="font-variation-settings: 'FILL' 1;" @endif>
                        shopping_cart
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Stock Monitoring & Procurement
                    </span>
                </a>

            </div>
        </div>


        <!-- ==================== LAINNYA ==================== -->
        <div>
            <p class="px-4 mb-1.5 text-[11px] font-bold uppercase tracking-wider text-outline">
                Lainnya
            </p>

            <div class="space-y-0.5">

                <a href="#"
                class="text-on-surface-variant hover:text-primary mx-2 flex items-center px-4 py-2.5 rounded-xl hover:bg-surface-container-low transition-all duration-150 group hover:pl-5">
                    <span class="material-symbols-outlined mr-3 text-[20px] text-outline group-hover:text-primary transition-colors">
                        assignment
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Material Requests
                    </span>
                </a>

                <a href="#"
                class="text-on-surface-variant hover:text-primary mx-2 flex items-center px-4 py-2.5 rounded-xl hover:bg-surface-container-low transition-all duration-150 group hover:pl-5">
                    <span class="material-symbols-outlined mr-3 text-[20px] text-outline group-hover:text-primary transition-colors">
                        assessment
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Reports
                    </span>
                </a>

            </div>
        </div>

    </nav>


    <script>
        function toggleMasterMenu() {
            const menu = document.getElementById('master-menu');
            const chevron = document.getElementById('master-chevron');

            menu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>

    <!-- Footer -->
    <div class="px-4 mt-4 pt-4 border-t border-outline-variant">

        <button
            class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary rounded-xl py-3 px-4 mb-4 flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-primary/30 active:scale-[0.98] transition-all duration-150 shadow-sm font-label-bold text-label-bold">

            <span class="material-symbols-outlined text-[18px]">
                add
            </span>

            New Material Request
        </button>

        <div class="space-y-0.5">

            <a href="{{ route('settings.show') }}"
               class="{{ request()->routeIs('settings.*') ? 'text-primary bg-primary/5' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }} mx-2 flex items-center px-3 py-2 rounded-lg transition-all duration-150 group">

                <span class="material-symbols-outlined mr-3 text-[20px] transition-colors {{ request()->routeIs('settings.*') ? 'text-primary' : 'text-outline group-hover:text-primary' }}">
                    settings
                </span>

                <span class="text-sidebar-nav font-sidebar-nav text-sm">
                    Settings
                </span>
            </a>

            <a href="#"
               class="text-on-surface-variant hover:text-primary mx-2 flex items-center px-3 py-2 rounded-lg hover:bg-surface-container-low transition-all duration-150 group">

                <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary text-[20px] transition-colors">
                    help
                </span>

                <span class="text-sidebar-nav font-sidebar-nav text-sm">
                    Support
                </span>
            </a>

        </div>

        @php
            $sidebarUser = auth()->user();
            $sidebarAvatar = $sidebarUser->photo_url ? asset($sidebarUser->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($sidebarUser->name) . '&background=0059bb&color=fff&size=64';
        @endphp

        <!-- Profile -->
        <a
            href="{{ route('profile.show') }}"
            class="mt-3 flex items-center gap-3 px-3 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant transition hover:border-primary/30 hover:shadow-sm"
        >

            <img
                class="w-8 h-8 rounded-full object-cover border border-outline-variant"
                alt="{{ $sidebarUser->name }}"
                src="{{ $sidebarAvatar }}"
            >

            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-label-bold text-on-surface truncate">
                    {{ $sidebarUser->name }}
                </p>

                <p class="text-xs text-on-surface-variant truncate">
                    {{ $sidebarUser->email }}
                </p>
            </div>

            <span class="w-2 h-2 rounded-full bg-green-500 shrink-0" title="Online"></span>

        </a>

    </div>

</aside>