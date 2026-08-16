<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['gudangs', 'lokasis']));

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

foreach (array_filter((['gudangs', 'lokasis']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $lokasiPayload = $lokasis->map(function ($l) {
        return [
            'id' => $l->id_lokasi,
            'bin' => $l->bin,
            'kd_lokasi' => $l->kd_lokasi,
            'rak_id' => $l->row?->rak?->id_rak,
            'rak_nama' => $l->row?->rak?->kd_rak ?? '-',
            'row_id' => $l->row?->id_row,
            'row_nama' => $l->row?->kd_row ?? '-',
            'gudang_id' => $l->row?->rak?->gudang?->id_gudang,
        ];
    })->values();
?>

<div id="opname-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div class="absolute inset-0" onclick="closeOpnameModal()"></div>

    <div class="relative flex max-h-[90vh] w-full max-w-3xl flex-col rounded-xl bg-white shadow-2xl">

        <div class="flex items-start justify-between border-b border-outline-variant px-6 py-4">
            <div>
                <h2 class="text-xl font-semibold">Create New Stock Opname</h2>
                <p class="mt-1 text-sm text-on-surface-variant">Inisialisasi sesi hitung fisik dengan memilih gudang dan bin target.</p>
            </div>
            <button type="button" onclick="closeOpnameModal()"><span class="material-symbols-outlined">close</span></button>
        </div>

        <form id="opname-form" method="POST" action="<?php echo e(route('opname.store')); ?>" class="flex flex-1 flex-col overflow-hidden">
            <?php echo csrf_field(); ?>

            <div class="flex-1 space-y-6 overflow-y-auto p-6 custom-scrollbar">

                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary text-xs font-bold text-on-primary">1</span>
                        <h3 class="text-lg font-semibold">Select Warehouse</h3>
                    </div>
                    <label class="mb-1 block text-sm font-semibold">Target Facility *</label>
                    <select id="opname-gudang" name="fk_gudang" required onchange="opnameOnGudangChange()"
                        class="w-full rounded-md border border-outline-variant px-3 py-2">
                        <option value="">Choose a warehouse...</option>
                        <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g->id_gudang); ?>"><?php echo e($g->kd_gudang); ?> - <?php echo e($g->nm_gudang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full border-2 border-primary text-xs font-bold text-primary">2</span>
                        <h3 class="text-lg font-semibold">Select Bins</h3>
                    </div>

                    <p class="mb-3 text-sm text-on-surface-variant">Pilih rak atau bin tertentu untuk sesi hitung ini.</p>

                    <div class="mb-3 flex flex-wrap items-center gap-2">
                        <div class="flex flex-1 min-w-[200px] items-center overflow-hidden rounded-md border border-outline-variant bg-white">
                            <span class="material-symbols-outlined px-3 text-outline text-[20px]">search</span>
                            <input type="text" id="opname-bin-search" oninput="opnameRenderBinList()" placeholder="Search bin code or rack..."
                                class="w-full border-none bg-transparent py-2 pl-0 pr-3 text-body-sm focus:ring-0">
                        </div>
                        <select id="opname-filter-rak" onchange="opnameRenderBinList()" class="rounded-md border border-outline-variant bg-white px-3 py-2 text-body-sm">
                            <option value="">All Racks</option>
                        </select>
                        <select id="opname-filter-row" onchange="opnameRenderBinList()" class="rounded-md border border-outline-variant bg-white px-3 py-2 text-body-sm">
                            <option value="">All Rows</option>
                        </select>
                    </div>

                    <div id="opname-bin-list" class="max-h-64 divide-y divide-outline-variant/60 overflow-y-auto rounded-lg border border-outline-variant bg-surface-container-low custom-scrollbar">
                        <!-- diisi via JS -->
                    </div>

                    <div class="mt-2 flex items-center justify-between text-sm">
                        <span id="opname-bin-count" class="text-on-surface-variant">0 bins selected</span>
                        <button type="button" onclick="opnameSelectAllInView()" class="font-label-bold text-primary hover:underline">Select All In View</button>
                    </div>

                    <div id="opname-hidden-inputs"></div>
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-outline-variant px-6 py-4">
                <button type="button" onclick="closeOpnameModal()" class="rounded-md border border-outline-variant px-4 py-2">Cancel</button>
                <button id="opname-submit-btn" type="submit" disabled
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm hover:bg-primary-container disabled:opacity-40 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[19px]">play_arrow</span>
                    Start Opname
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const opnameLokasiData = <?php echo json_encode($lokasiPayload, 15, 512) ?>;
    let opnameSelectedIds = new Set();

    function openOpnameModal() {
        opnameSelectedIds = new Set();
        document.getElementById('opname-gudang').value = '';
        document.getElementById('opname-bin-search').value = '';
        document.getElementById('opname-filter-rak').innerHTML = '<option value="">All Racks</option>';
        document.getElementById('opname-filter-row').innerHTML = '<option value="">All Rows</option>';
        document.getElementById('opname-bin-list').innerHTML = '<p class="p-4 text-center text-sm text-on-surface-variant">Pilih warehouse terlebih dahulu.</p>';
        opnameUpdateSubmitState();

        const m = document.getElementById('opname-modal');
        m.classList.remove('hidden');
        m.classList.add('flex');
    }

    function closeOpnameModal() {
        const m = document.getElementById('opname-modal');
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    function opnameCurrentGudangId() {
        return document.getElementById('opname-gudang').value;
    }

    function opnameFilteredByGudang() {
        const gudangId = opnameCurrentGudangId();
        if (!gudangId) return [];
        return opnameLokasiData.filter(l => String(l.gudang_id) === String(gudangId));
    }

    // Dipanggil saat warehouse berubah: rebuild pilihan Rak/Row
    // supaya hanya menampilkan rak/row milik gudang terpilih.
    function opnameOnGudangChange() {
        opnameSelectedIds.clear();

        const rakSelect = document.getElementById('opname-filter-rak');
        const rowSelect = document.getElementById('opname-filter-row');
        rakSelect.innerHTML = '<option value="">All Racks</option>';
        rowSelect.innerHTML = '<option value="">All Rows</option>';

        const scoped = opnameFilteredByGudang();

        const raks = [...new Map(scoped.map(l => [l.rak_id, l.rak_nama])).entries()];
        raks.forEach(([id, nama]) => {
            const opt = document.createElement('option');
            opt.value = id; opt.textContent = nama;
            rakSelect.appendChild(opt);
        });

        const rows = [...new Map(scoped.map(l => [l.row_id, l.row_nama])).entries()];
        rows.forEach(([id, nama]) => {
            const opt = document.createElement('option');
            opt.value = id; opt.textContent = nama;
            rowSelect.appendChild(opt);
        });

        document.getElementById('opname-bin-search').value = '';
        opnameRenderBinList();
    }

    // Render daftar bin sesuai gudang + search + filter rak/row yang aktif saat ini.
    function opnameRenderBinList() {
        const list = document.getElementById('opname-bin-list');
        const gudangId = opnameCurrentGudangId();
        const search = document.getElementById('opname-bin-search').value.trim().toLowerCase();
        const rakFilter = document.getElementById('opname-filter-rak').value;
        const rowFilter = document.getElementById('opname-filter-row').value;

        list.innerHTML = '';

        if (!gudangId) {
            list.innerHTML = '<p class="p-4 text-center text-sm text-on-surface-variant">Pilih warehouse terlebih dahulu.</p>';
            opnameUpdateSubmitState();
            return;
        }

        const items = opnameFilteredByGudang().filter(l => {
            if (rakFilter && String(l.rak_id) !== String(rakFilter)) return false;
            if (rowFilter && String(l.row_id) !== String(rowFilter)) return false;
            if (search) {
                const haystack = (l.bin + ' ' + l.rak_nama + ' ' + l.row_nama + ' ' + l.kd_lokasi).toLowerCase();
                if (!haystack.includes(search)) return false;
            }
            return true;
        });

        if (items.length === 0) {
            list.innerHTML = '<p class="p-4 text-center text-sm text-on-surface-variant">Tidak ada bin yang cocok.</p>';
            opnameUpdateSubmitState();
            return;
        }

        items.forEach(l => {
            const row = document.createElement('label');
            row.className = 'flex items-center justify-between gap-3 bg-white px-4 py-3 cursor-pointer hover:bg-surface-container-low';
            row.dataset.lokasiId = l.id;

            const checked = opnameSelectedIds.has(l.id) ? 'checked' : '';

            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <input type="checkbox" value="${l.id}" ${checked} onchange="opnameToggleBin(${l.id}, this.checked)"
                        class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary">
                    <div>
                        <p class="font-label-bold">${l.bin}</p>
                        <p class="text-xs text-on-surface-variant">Rak ${l.rak_nama} &middot; Row ${l.row_nama}</p>
                    </div>
                </div>
                <span class="rounded-md bg-surface-container-high px-2 py-1 text-xs text-on-surface-variant">${l.kd_lokasi}</span>
            `;

            list.appendChild(row);
        });

        opnameUpdateSubmitState();
    }

    function opnameToggleBin(id, isChecked) {
        if (isChecked) {
            opnameSelectedIds.add(id);
        } else {
            opnameSelectedIds.delete(id);
        }
        opnameUpdateSubmitState();
    }

    // "Select All In View" -> select SEMUA bin yang sedang tampil
    // sesuai search/filter aktif saat ini (bukan cuma yang kelihatan di layar).
    function opnameSelectAllInView() {
        const list = document.getElementById('opname-bin-list');
        const rows = list.querySelectorAll('[data-lokasi-id]');

        rows.forEach(row => {
            const id = Number(row.dataset.lokasiId);
            opnameSelectedIds.add(id);
            const checkbox = row.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = true;
        });

        opnameUpdateSubmitState();
    }

    function opnameUpdateSubmitState() {
        const count = opnameSelectedIds.size;
        document.getElementById('opname-bin-count').textContent = count + ' bin' + (count === 1 ? '' : 's') + ' selected';

        const submitBtn = document.getElementById('opname-submit-btn');
        submitBtn.disabled = !(opnameCurrentGudangId() && count > 0);
    }

    // Sebelum submit, tuliskan lokasi_ids[] terpilih sebagai hidden input.
    document.getElementById('opname-form').addEventListener('submit', function () {
        const container = document.getElementById('opname-hidden-inputs');
        container.innerHTML = '';
        opnameSelectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'lokasi_ids[]';
            input.value = id;
            container.appendChild(input);
        });
    });

    // Reset form tiap kali modal dibuka ulang
    document.getElementById('opname-modal').addEventListener('transitionstart', function () {});
</script>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/opname/create-modal.blade.php ENDPATH**/ ?>