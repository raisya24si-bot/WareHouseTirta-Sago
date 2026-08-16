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
            inventory_2
        </span>

        <span class="text-headline-md font-headline-md font-bold text-on-surface truncate">
            Material Master MDM
        </span>

    </div>

    <!-- Breadcrumb -->
    <div class="hidden md:flex items-center gap-2 text-body-sm font-body-sm text-on-surface-variant">

        <span class="hover:text-primary cursor-pointer transition-colors">
            Master Data
        </span>

        <span class="material-symbols-outlined text-[16px]">
            chevron_right
        </span>

        <span class="font-semibold text-on-surface">
            <?php echo e($breadcrumb); ?>

        </span>

    </div>

    <!-- Search -->
    <div
        class="hidden md:flex items-center bg-surface w-96 rounded-full border border-outline-variant focus-within:border-primary focus-within:ring-1 focus-within:ring-primary overflow-hidden ml-8 shadow-sm">

        <div class="pl-4 pr-2 py-2 flex items-center justify-center text-outline">
            <span class="material-symbols-outlined text-[20px]">
                search
            </span>
        </div>

        <input
            class="w-full border-none bg-transparent py-2 pl-0 pr-4 text-body-sm font-body-sm text-on-surface focus:ring-0 placeholder:text-outline-variant"
            placeholder="Cari SKU, Nama Barang..."
            type="text"
        >

    </div>

    <!-- Actions -->
    <div class="flex items-center gap-2 ml-auto">

        <button
            class="p-2 rounded-full text-on-surface-variant hover:bg-surface-variant transition-all duration-150 relative">

            <span class="material-symbols-outlined">
                notifications
            </span>

            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-error rounded-full border-2 border-surface-container-low"></span>

        </button>

        <button
            class="p-2 rounded-full text-on-surface-variant hover:bg-surface-variant transition-all duration-150 hidden sm:block">

            <span class="material-symbols-outlined">
                settings
            </span>

        </button>

        <div class="h-8 w-px bg-outline-variant mx-2 hidden sm:block"></div>

        <button class="hover:scale-105 transition-transform duration-150 rounded-full">

            <img
                alt="Administrator Profile"
                class="w-9 h-9 rounded-full object-cover"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuACaksQcvurtqmgB5UPqDTUI32i2tWQknR7jLenZlBlXyOPj6CR6LtS91l2oXha21OBffMuBEUBTMWzedthQKsB2_01WPN-Yo2oCVRKafQvfJdmEeFlC94l_ytewtGD5I7KybDCgKz_OeAWmGbrpgl9AbFecrDnHUyqQg5UOhbQfjDK9byAHgnrucipDbrN1zjlT2Mp78O6XvGu5dpRF7Ure7iJ4wH6ko70AL0OC6rIrGUJ-P9-a3JUZQ"
            >

        </button>

    </div>

</header><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/layout/navbar.blade.php ENDPATH**/ ?>