<aside
    class="fixed left-0 top-0 h-full w-[250px] bg-white border-r border-outline-variant shadow-sm z-50 flex flex-col py-4 transition-transform duration-300 md:translate-x-0 -translate-x-full"
    id="mobile-sidebar">

    <!-- Header -->
    <div class="px-6 mb-8 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-on-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                inventory_2
            </span>
        </div>

        <div>
            <h1 class="text-headline-md font-headline-md font-bold text-on-surface m-0 leading-tight">
                Material Master
            </h1>

            <p class="text-[11px] text-on-surface-variant font-medium uppercase tracking-wider mt-1">
                Inventory Management System
            </p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 space-y-1 custom-scrollbar">

        <!-- Dashboard -->
        <a href="#"
        class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-4 py-3 rounded-xl hover:bg-surface-container-low transition-colors duration-200 group">
            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary">
                dashboard
            </span>

            <span class="text-sidebar-nav font-sidebar-nav">
                Dashboard
            </span>
        </a>


        <!-- Monitoring -->
        <a href="#"
        class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-4 py-3 rounded-xl hover:bg-surface-container-low transition-colors duration-200 group">
            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary">
                monitor_heart
            </span>

            <span class="text-sidebar-nav font-sidebar-nav">
                Monitoring
            </span>
        </a>


        <!-- MASTER MENU -->
        <div class="mx-2 my-1">

            <!-- Master Header -->
            <button
                type="button"
                onclick="toggleMasterMenu()"
                class="w-full text-on-surface-variant hover:text-primary flex items-center px-4 py-3 rounded-xl hover:bg-surface-container-low transition-colors duration-200 group">

                <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary">
                    database
                </span>

                <span class="text-sidebar-nav font-sidebar-nav font-bold flex-1 text-left">
                    Master
                </span>

                <span
                    id="master-chevron"
                    class="material-symbols-outlined text-[20px] transition-transform duration-200">
                    expand_more
                </span>
            </button>


            <!-- Master Submenu -->
            <div
                id="master-menu"
                class="ml-4 mt-1 space-y-1">

                <!-- Master Barang -->
                <a href="{{ route('barang.index') }}"
                class="{{ request()->routeIs('barang.*')
                        ? 'bg-primary text-on-primary'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        flex items-center px-4 py-2.5 rounded-lg transition-colors">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        inventory_2
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Barang
                    </span>
                </a>


                <!-- Master Supplier -->
                <a href="{{ route('master-supplier.index') }}"
                class="{{ request()->routeIs('master-supplier.*')
                        ? 'bg-primary text-on-primary'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        flex items-center px-4 py-2.5 rounded-lg transition-colors">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        local_shipping
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Supplier
                    </span>
                </a>


                <!-- Master Kategori -->
                <a href="{{ route('master-kategori.index') }}"
                class="{{ request()->routeIs('master-kategori.*')
                        ? 'bg-primary text-on-primary'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        flex items-center px-4 py-2.5 rounded-lg transition-colors">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        category
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Kategori
                    </span>
                </a>


                <!-- Master Satuan -->
                <a href="{{ route('master-satuan.index') }}"
                class="{{ request()->routeIs('master-satuan.*')
                        ? 'bg-primary text-on-primary'
                        : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                        flex items-center px-4 py-2.5 rounded-lg transition-colors">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        straighten
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Satuan
                    </span>
                </a>


                <!-- Master Gudang - belum aktif -->
                <a href="{{ route('master-gudang.index') }}"
                class="{{ request()->routeIs('master-gudang.*') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        warehouse
                    </span>

                    <span class="text-sidebar-nav font-sidebar-nav">
                        Gudang
                    </span>
                </a>

            </div>

        </div>


        <!-- Stock Opname -->
        <a href="{{ route('opname.index') }}"
        class="{{ request()->routeIs('opname.*')
                ? 'bg-primary text-on-primary'
                : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}
                mx-2 my-1 flex items-center px-4 py-3 rounded-xl transition-colors duration-200 group">

            <span class="material-symbols-outlined mr-3 {{ request()->routeIs('opname.*') ? '' : 'text-outline group-hover:text-primary' }}">
                fact_check
            </span>

            <span class="text-sidebar-nav font-sidebar-nav">
                Stock Opname
            </span>
        </a>


        <!-- Material Requests -->
        <a href="#"
        class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-4 py-3 rounded-xl hover:bg-surface-container-low transition-colors duration-200 group">

            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary">
                inventory_2
            </span>

            <span class="text-sidebar-nav font-sidebar-nav">
                Material Requests
            </span>
        </a>


        <!-- Reports -->
        <a href="#"
        class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-4 py-3 rounded-xl hover:bg-surface-container-low transition-colors duration-200 group">

            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary">
                assessment
            </span>

            <span class="text-sidebar-nav font-sidebar-nav">
                Reports
            </span>
        </a>

    </nav>


    <script>
        function toggleMasterMenu() {
            const menu = document.getElementById('master-menu');
            const chevron = document.getElementById('master-chevron');

            menu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }


        // Otomatis buka menu Master kalau sedang berada
        // di halaman Barang / Supplier / Kategori / Satuan
        document.addEventListener('DOMContentLoaded', function () {

            const masterRoutes = [
                @json(request()->routeIs('barang.*')),
                @json(request()->routeIs('master-supplier.*')),
                @json(request()->routeIs('master-kategori.*')),
                @json(request()->routeIs('master-satuan.*')),
                @json(request()->routeIs('master-gudang.*')),
            ];

            if (masterRoutes.includes(true)) {

                const menu = document.getElementById('master-menu');
                const chevron = document.getElementById('master-chevron');

                menu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }
        });
    </script>

    <!-- Footer -->
    <div class="px-4 mt-auto pt-4 border-t border-outline-variant">

        <button
            class="w-full bg-primary text-on-primary rounded-lg py-3 px-4 mb-4 flex items-center justify-center gap-2 hover:bg-primary-container transition-colors shadow-sm font-label-bold text-label-bold">

            <span class="material-symbols-outlined text-[18px]">
                add
            </span>

            New Material Request
        </button>

        <div class="space-y-1">

            <a href="#"
               class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-3 py-2 rounded-lg hover:bg-surface-container-low transition-colors group">

                <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary text-[20px]">
                    settings
                </span>

                <span class="text-sidebar-nav font-sidebar-nav text-sm">
                    Settings
                </span>
            </a>

            <a href="#"
               class="text-on-surface-variant hover:text-primary mx-2 my-1 flex items-center px-3 py-2 rounded-lg hover:bg-surface-container-low transition-colors group">

                <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary text-[20px]">
                    help
                </span>

                <span class="text-sidebar-nav font-sidebar-nav text-sm">
                    Support
                </span>
            </a>

        </div>

        <!-- Profile -->
        <div class="mt-4 flex items-center gap-3 px-3 py-2 rounded-xl bg-surface-container-low border border-outline-variant">

            <img
                class="w-8 h-8 rounded-full object-cover border border-outline-variant"
                alt="Administrator Profile"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqidWYZVLESTtnmZrZI_eBKsS-Bb9m2MOKUVikHuFf7AVmfS-HLwSK9X0zEpFT-SMzTcuFnfpejVMlgOwcf1D7vKzoaOZ7tYBjH8SS0erqjFLvl_5Ke-Dwc-iuMysUEEMN4gjrnuWS5OrnpaHOe_nEOZ0pIOTReZXb3PC7lRh1ZZw22RbzClE0oQdjn4JHOlJZSLpoboBAfBVLHD5lXVeXxBpE33H1NtjsSoTVzBb4mV6kPk7-qzGd-A"
            >

            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-label-bold text-on-surface truncate">
                    Administrator Profile
                </p>

                <p class="text-xs text-on-surface-variant truncate">
                    admin@materialmaster.sys
                </p>
            </div>

        </div>

    </div>

</aside>
