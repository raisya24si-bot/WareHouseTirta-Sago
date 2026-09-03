<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['breadcrumb' => 'Data Barang']));

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

foreach (array_filter((['breadcrumb' => 'Data Barang']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $navUser = auth()->user();
    $navAvatar = $navUser->photo_url ? asset($navUser->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($navUser->name) . '&background=0059bb&color=fff&size=64';

    $navNotifikasis = \App\Models\Notifikasi::latest('id_notifikasi')->limit(5)->get();
    $navUnreadCount = \App\Models\Notifikasi::unread()->count();

    $navNotifColor = [
        'red' => 'text-red-700',
        'amber' => 'text-amber-600',
        'green' => 'text-green-700',
        'primary' => 'text-primary',
    ];
?>

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
            <?php echo $breadcrumb; ?>

        </span>

    </div>

    <!-- Search (live search beneran, bukan dekorasi doang) -->
    <div id="navbar-search-wrapper" class="relative ml-8 hidden md:block">

        <div
            class="flex items-center bg-surface w-96 rounded-full border border-outline-variant focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15 transition-all overflow-hidden shadow-sm">

            <div class="pl-4 pr-2 py-2 flex items-center justify-center text-outline">
                <span class="material-symbols-outlined text-[20px]">
                    search
                </span>
            </div>

            <input
                id="navbar-search-input"
                class="w-full border-none bg-transparent py-2 pl-0 pr-2 text-body-sm font-body-sm text-on-surface focus:ring-0 placeholder:text-outline-variant"
                placeholder="Cari SKU, Nama Barang, Kode Opname, Gudang..."
                type="text"
                autocomplete="off"
            >

            <kbd class="hidden lg:inline-flex mr-3 items-center gap-0.5 rounded border border-outline-variant bg-surface-container-low px-1.5 py-0.5 text-[10px] font-semibold text-outline">
                /
            </kbd>

        </div>

        <!-- Hasil pencarian -->
        <div
            id="search-results-dropdown"
            class="hidden absolute left-0 right-0 mt-2 max-h-96 overflow-y-auto custom-scrollbar rounded-xl border border-outline-variant bg-white shadow-xl z-50"
        >
            <div id="search-results-body"></div>
        </div>

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

                <?php if($navUnreadCount > 0): ?>
                    <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-error opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-error border-2 border-surface-container-low"></span>
                    </span>
                <?php endif; ?>

            </button>

            <div
                id="notif-dropdown"
                class="hidden absolute right-0 mt-2 w-80 rounded-xl border border-outline-variant bg-white shadow-xl overflow-hidden z-50"
            >
                <div class="px-4 py-3 border-b border-outline-variant flex items-center justify-between">
                    <p class="font-label-bold text-on-surface">Notifikasi</p>
                    <?php if($navUnreadCount > 0): ?>
                        <span class="text-xs rounded-full bg-error/10 text-error px-2 py-0.5 font-semibold"><?php echo e($navUnreadCount); ?> baru</span>
                    <?php endif; ?>
                </div>

                <div class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-outline-variant/60">

                    <?php $__empty_1 = true; $__currentLoopData = $navNotifikasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a
                            href="<?php echo e(route('notifikasi.open', $notif)); ?>"
                            class="flex items-start gap-3 px-4 py-3 transition-colors hover:bg-surface-container-low <?php echo e($notif->isRead() ? '' : 'bg-primary/5'); ?>"
                        >
                            <span class="material-symbols-outlined mt-0.5 text-[20px] <?php echo e($navNotifColor[$notif->color] ?? 'text-primary'); ?>">
                                <?php echo e($notif->icon); ?>

                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-on-surface leading-snug line-clamp-2"><?php echo e($notif->judul); ?></p>
                                <p class="text-xs text-on-surface-variant mt-0.5"><?php echo e($notif->created_at->diffForHumans()); ?></p>
                            </div>
                            <?php if (! ($notif->isRead())): ?>
                                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-primary"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center text-sm text-on-surface-variant">
                            Belum ada notifikasi.
                        </div>
                    <?php endif; ?>

                </div>

                <div class="px-4 py-2.5 text-center border-t border-outline-variant">
                    <a href="<?php echo e(route('notifikasi.index')); ?>" class="text-xs font-label-bold text-primary hover:underline">
                        Lihat semua notifikasi
                    </a>
                </div>
            </div>

        </div>


        <button
            onclick="window.location.href='<?php echo e(route('settings.show')); ?>'"
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
                class="flex items-center gap-2.5 rounded-full border border-outline-variant bg-white py-1 pl-1 pr-3 shadow-sm transition-all duration-150 hover:border-primary/30 hover:shadow-md"
            >
                <img
                    alt="<?php echo e($navUser->name); ?>"
                    class="h-9 w-9 rounded-full object-cover border border-outline-variant"
                    src="<?php echo e($navAvatar); ?>"
                >

                <div class="hidden text-left sm:block">
                    <p class="text-sm font-bold leading-tight text-on-surface"><?php echo e($navUser->name); ?></p>
                    <p class="text-[11px] leading-tight text-on-surface-variant">Administrator</p>
                </div>

                <span class="material-symbols-outlined text-[18px] text-on-surface-variant hidden sm:block">
                    expand_more
                </span>
            </button>

            <div
                id="profile-dropdown"
                class="hidden absolute right-0 mt-2 w-56 rounded-xl border border-outline-variant bg-white shadow-xl overflow-hidden z-50"
            >
                <div class="flex items-center gap-3 px-4 py-3 border-b border-outline-variant">
                    <img
                        alt="<?php echo e($navUser->name); ?>"
                        class="h-9 w-9 rounded-full object-cover border border-outline-variant"
                        src="<?php echo e($navAvatar); ?>"
                    >
                    <div class="min-w-0">
                        <p class="text-sm font-label-bold text-on-surface truncate"><?php echo e($navUser->name); ?></p>
                        <p class="text-xs text-on-surface-variant truncate"><?php echo e($navUser->email); ?></p>
                    </div>
                </div>

                <div class="py-1">
                    <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[19px]">person</span>
                        Profil Saya
                    </a>
                    <a href="<?php echo e(route('settings.show')); ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[19px]">settings</span>
                        Pengaturan
                    </a>
                </div>

                <div class="border-t border-outline-variant py-1">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-error hover:bg-error/5 transition-colors">
                            <span class="material-symbols-outlined text-[19px]">logout</span>
                            Keluar
                        </button>
                    </form>
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

    document.addEventListener('click', function (event) {

        const isToggleButton = event.target.closest('[onclick^="toggleDropdown"]');
        const isDropdownPanel = event.target.closest('[id$="-dropdown"]');
        const isSearchArea = event.target.closest('#navbar-search-wrapper');

        if (!isToggleButton && !isDropdownPanel && !isSearchArea) {
            document.querySelectorAll('[id$="-dropdown"]').forEach(function (d) {
                d.classList.add('hidden');
            });
        }
    });

    (function () {

        const input = document.getElementById('navbar-search-input');
        const panel = document.getElementById('search-results-dropdown');
        const body = document.getElementById('search-results-body');

        if (! input) return;

        let debounceTimer = null;
        let activeRequest = null;

        function renderMessage(message) {
            body.innerHTML =
                '<div class="px-4 py-6 text-center text-sm text-on-surface-variant">' +
                message +
                '</div>';
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function renderSection(title, icon, items) {

            if (! items || items.length === 0) return '';

            let html =
                '<div class="px-4 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wide text-outline">' +
                title +
                '</div>';

            items.forEach(function (item) {
                html +=
                    '<a href="' + item.url + '" class="flex items-center gap-3 px-4 py-2.5 transition-colors hover:bg-surface-container-low">' +
                    '<span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">' +
                    '<span class="material-symbols-outlined text-[17px]">' + icon + '</span>' +
                    '</span>' +
                    '<span class="min-w-0">' +
                    '<span class="block truncate text-sm font-medium text-on-surface">' + escapeHtml(item.label) + '</span>' +
                    '<span class="block truncate text-xs text-on-surface-variant">' + escapeHtml(item.sub) + '</span>' +
                    '</span>' +
                    '</a>';
            });

            return html;
        }

        function runSearch(q) {

            if (activeRequest) {
                activeRequest.abort();
            }

            activeRequest = new AbortController();

            panel.classList.remove('hidden');
            renderMessage('Mencari...');

            fetch('<?php echo e(route('search')); ?>?q=' + encodeURIComponent(q), {
                signal: activeRequest.signal,
                headers: { 'Accept': 'application/json' },
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {

                    const total =
                        (data.barang?.length || 0) +
                        (data.opname?.length || 0) +
                        (data.gudang?.length || 0);

                    if (total === 0) {
                        renderMessage('Tidak ada hasil untuk "' + escapeHtml(q) + '"');
                        return;
                    }

                    body.innerHTML =
                        renderSection('Barang', 'inventory_2', data.barang) +
                        renderSection('Stock Opname', 'fact_check', data.opname) +
                        renderSection('Gudang', 'warehouse', data.gudang);
                })
                .catch(function (err) {
                    if (err.name === 'AbortError') return;
                    renderMessage('Gagal memuat hasil pencarian.');
                });
        }

        input.addEventListener('input', function () {

            const q = input.value.trim();

            clearTimeout(debounceTimer);

            if (q.length < 2) {
                panel.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(function () {
                runSearch(q);
            }, 300);
        });

        input.addEventListener('focus', function () {
            if (input.value.trim().length >= 2) {
                panel.classList.remove('hidden');
            }
        });

        document.addEventListener('keydown', function (e) {

            if (e.key !== '/') return;

            const tag = document.activeElement?.tagName;

            if (tag === 'INPUT' || tag === 'TEXTAREA') return;

            e.preventDefault();
            input.focus();
        });

    })();
</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/layout/navbar.blade.php ENDPATH**/ ?>