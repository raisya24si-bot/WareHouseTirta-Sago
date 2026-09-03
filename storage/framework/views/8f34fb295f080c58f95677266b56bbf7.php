<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['opname', 'bins', 'allBarangs', 'rows' => []]));

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

foreach (array_filter((['opname', 'bins', 'allBarangs', 'rows' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="add-item-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">

    <div
        class="absolute inset-0"
        onclick="closeAddItemModal()">
    </div>

    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <h2 class="text-xl font-semibold">
                Tambah Barang ke Opname
            </h2>

            <button
                type="button"
                onclick="closeAddItemModal()">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        <form
            method="POST"
            action="<?php echo e(route('opname.add-item', $opname)); ?>"
            class="space-y-4 p-6"
        >
            <?php echo csrf_field(); ?>

            
            <div>
                <label class="mb-1 block font-semibold">
                    Bin *
                </label>

                <div class="mb-2 flex gap-4 text-sm">

                    <label class="inline-flex items-center gap-1.5">
                        <input
                            type="radio"
                            name="bin_mode"
                            value="existing"
                            checked
                            onchange="toggleAddItemBinMode()"
                        >
                        Bin yang sudah ada
                    </label>

                    <label class="inline-flex items-center gap-1.5">
                        <input
                            type="radio"
                            name="bin_mode"
                            value="new"
                            onchange="toggleAddItemBinMode()"
                        >
                        Bin baru
                    </label>

                </div>

                
                <div id="add-item-existing-bin-wrapper">

                    <select
                        id="add-item-bin"
                        name="fk_lokasi"
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                        <option value="">
                            Pilih bin...
                        </option>

                        <?php $__currentLoopData = $bins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id_lokasi); ?>">
                                <?php echo e($b->bin); ?>

                                (<?php echo e($b->kd_lokasi); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                </div>

                
                <div id="add-item-new-bin-wrapper" class="hidden">

                    <select
                        id="add-item-row"
                        name="fk_row"
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                        <option value="">
                            Pilih row...
                        </option>

                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id_row); ?>">
                                <?php echo e($r->kd_row); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <p class="mt-1 text-xs text-on-surface-variant">
                        Nomor bin (2 digit) di-generate otomatis,
                        lanjutan dari bin terakhir pada row ini.
                    </p>

                    <input type="hidden" name="new_bin" id="add-item-new-bin-flag" value="0">

                </div>

            </div>

            
            <div>
                <label class="mb-1 block font-semibold">
                    Barang *
                </label>

                <select
                    name="fk_barang"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                    <option value="">
                        Pilih barang...
                    </option>

                    <?php $__currentLoopData = $allBarangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id_master_barang); ?>">
                            <?php echo e($b->kd_master_barang); ?>

                            -
                            <?php echo e($b->nm_master_barang); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-primary">
                        info
                    </span>

                    <div class="text-sm">

                        <p class="font-semibold text-primary">
                            System Qty otomatis
                        </p>

                        <p class="mt-1 text-on-surface-variant">
                            System Qty akan diambil dari
                            <strong>tbl_stok_lokasi</strong>.
                            Jika barang belum memiliki stok pada
                            bin tersebut, System Qty dianggap
                            <strong>0</strong>.
                        </p>

                        <p class="mt-2 text-on-surface-variant">
                            Menambahkan barang di sini hanya
                            menyimpan data ke opname.
                            <strong>
                                Stok resmi belum berubah
                                sampai Submit Adjustment.
                            </strong>
                        </p>

                        <p class="mt-2 text-on-surface-variant">
                            Kalau pilih <strong>Bin baru</strong>,
                            bin-nya langsung dibuat permanen di
                            master lokasi (bukan cuma di opname
                            ini) begitu tombol Tambahkan diklik.
                        </p>

                    </div>

                </div>

            </div>

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeAddItemModal()"
                    class="rounded-md border border-outline-variant px-4 py-2"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary"
                >
                    Tambahkan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function openAddItemModal(binId) {

        const modal =
            document.getElementById('add-item-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        /*
        | Selalu buka modal dalam mode "bin yang sudah ada"
        | dulu, biar konsisten.
        */
        document.querySelector(
            'input[name="bin_mode"][value="existing"]'
        ).checked = true;

        toggleAddItemBinMode();

        const binSelect =
            document.getElementById('add-item-bin');

        if (binId) {
            binSelect.value = String(binId);
        } else {
            binSelect.value = '';
        }
    }

    function closeAddItemModal() {

        const modal =
            document.getElementById('add-item-modal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE BIN YANG SUDAH ADA / BIN BARU
    |--------------------------------------------------------------------------
    |
    | "required" dipasang manual di sini (bukan di HTML langsung)
    | supaya field yang lagi disembunyikan nggak ikut divalidasi
    | browser (kalau nggak, form nggak bisa disubmit gara-gara
    | field hidden yang required tapi kosong).
    |--------------------------------------------------------------------------
    */
    function toggleAddItemBinMode() {

        const mode =
            document.querySelector(
                'input[name="bin_mode"]:checked'
            ).value;

        const existingWrapper =
            document.getElementById('add-item-existing-bin-wrapper');

        const newWrapper =
            document.getElementById('add-item-new-bin-wrapper');

        const binSelect =
            document.getElementById('add-item-bin');

        const rowSelect =
            document.getElementById('add-item-row');

        const newBinFlag =
            document.getElementById('add-item-new-bin-flag');

        if (mode === 'new') {

            existingWrapper.classList.add('hidden');
            newWrapper.classList.remove('hidden');

            binSelect.required = false;
            binSelect.value = '';

            rowSelect.required = true;

            newBinFlag.value = '1';

        } else {

            newWrapper.classList.add('hidden');
            existingWrapper.classList.remove('hidden');

            binSelect.required = true;

            rowSelect.required = false;
            rowSelect.value = '';

            newBinFlag.value = '0';
        }
    }
</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/components/opname/add-item-modal.blade.php ENDPATH**/ ?>