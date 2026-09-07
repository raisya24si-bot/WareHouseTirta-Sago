
<?php
    $dummyPoOptions = [
        'PO-2026-0139' => [
            'supplier' => 'UD Meter Air Sejahtera',
            'items' => [
                ['nama' => 'Meter Air 1/2" Multi Jet', 'satuan' => 'Unit', 'qty_pesan' => 50],
                ['nama' => 'Segel Meter Air', 'satuan' => 'Pcs', 'qty_pesan' => 100],
            ],
        ],
        'PO-2026-0135' => [
            'supplier' => 'PT Aksesoris Distribusi Air',
            'items' => [
                ['nama' => 'Pipa PVC 3" AW', 'satuan' => 'Batang', 'qty_pesan' => 120],
                ['nama' => 'Sambungan Pipa Knee 3"', 'satuan' => 'Pcs', 'qty_pesan' => 60],
                ['nama' => 'Lem Pipa PVC', 'satuan' => 'Kaleng', 'qty_pesan' => 24],
            ],
        ],
    ];
?>

<div
    id="penerimaan-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>

    <div class="absolute inset-0" onclick="closePenerimaanModal()"></div>

    <div class="relative max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-xl bg-white shadow-2xl custom-scrollbar">

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">

            <div>
                <h2 class="text-xl font-semibold text-on-surface">
                    Terima Barang dari PO
                </h2>
                <p class="mt-0.5 text-sm text-on-surface-variant">
                    Pilih Purchase Order yang barangnya baru datang, lalu isi jumlah yang diterima.
                </p>
            </div>

            <button type="button" onclick="closePenerimaanModal()">
                <span class="material-symbols-outlined">close</span>
            </button>

        </div>


        <form id="penerimaan-form" method="POST" action="" class="space-y-5 p-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>
                    <label class="mb-1 block font-semibold text-on-surface">
                        Purchase Order *
                    </label>

                    <select
                        id="penerimaan-po"
                        name="kd_po"
                        required
                        onchange="renderPenerimaanItems()"
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                        <option value="">-- Pilih PO --</option>
                        <?php $__currentLoopData = $dummyPoOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kdPo => $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kdPo); ?>"><?php echo e($kdPo); ?> &mdash; <?php echo e($po['supplier']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block font-semibold text-on-surface">
                        Supplier
                    </label>

                    <input
                        id="penerimaan-supplier"
                        readonly
                        placeholder="Otomatis terisi setelah pilih PO"
                        class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"
                    >
                </div>

                <div>
                    <label class="mb-1 block font-semibold text-on-surface">
                        Tanggal Terima *
                    </label>

                    <input
                        type="date"
                        name="tanggal_terima"
                        required
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                </div>

                <div>
                    <label class="mb-1 block font-semibold text-on-surface">
                        No. Surat Jalan
                    </label>

                    <input
                        name="no_surat_jalan"
                        placeholder="Contoh: SJ/2026/09/0182"
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                </div>

            </div>


            <div>

                <label class="mb-2 block font-semibold text-on-surface">
                    Detail Barang Diterima
                </label>

                <div class="overflow-hidden rounded-lg border border-outline-variant">

                    <table class="w-full min-w-[650px] text-left text-sm">

                        <thead class="bg-surface-container-low">
                            <tr>
                                <th class="px-3 py-2 text-label-bold text-on-surface-variant">Nama Barang</th>
                                <th class="px-3 py-2 text-label-bold text-on-surface-variant">Qty Dipesan</th>
                                <th class="px-3 py-2 text-label-bold text-on-surface-variant">Qty Diterima</th>
                                <th class="px-3 py-2 text-label-bold text-on-surface-variant">Kondisi</th>
                            </tr>
                        </thead>

                        <tbody id="penerimaan-items-body" class="divide-y divide-outline-variant/60">
                            <tr id="penerimaan-items-placeholder">
                                <td colspan="4" class="px-3 py-6 text-center text-on-surface-variant">
                                    Pilih PO dulu buat nampilin daftar barangnya.
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </div>


            <div>
                <label class="mb-1 block font-semibold text-on-surface">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    rows="2"
                    placeholder="Catatan tambahan (opsional), misal kondisi kemasan, kekurangan, dsb."
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                ></textarea>
            </div>


            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closePenerimaanModal()"
                    class="rounded-md border border-outline-variant px-4 py-2 text-on-surface-variant transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container"
                >
                    Simpan Penerimaan
                </button>

            </div>

        </form>

    </div>

</div>


<script>
    // Data dummy PO -> item, dipakai buat preview tabel item di modal.
    // Ganti/hapus ini kalau datanya udah dikirim beneran dari controller.
    const PENERIMAAN_DUMMY_PO = <?php echo json_encode($dummyPoOptions, 15, 512) ?>;

    function openPenerimaanModal() {
        const modal = document.getElementById('penerimaan-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePenerimaanModal() {
        const modal = document.getElementById('penerimaan-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function renderPenerimaanItems() {
        const kdPo = document.getElementById('penerimaan-po').value;
        const supplierInput = document.getElementById('penerimaan-supplier');
        const tbody = document.getElementById('penerimaan-items-body');

        const po = PENERIMAAN_DUMMY_PO[kdPo];

        if (! po) {
            supplierInput.value = '';
            tbody.innerHTML = `
                <tr id="penerimaan-items-placeholder">
                    <td colspan="4" class="px-3 py-6 text-center text-on-surface-variant">
                        Pilih PO dulu buat nampilin daftar barangnya.
                    </td>
                </tr>
            `;
            return;
        }

        supplierInput.value = po.supplier;

        tbody.innerHTML = po.items.map(function (item, index) {
            return `
                <tr>
                    <td class="px-3 py-2">${item.nama}</td>
                    <td class="px-3 py-2 text-on-surface-variant">${item.qty_pesan} ${item.satuan}</td>
                    <td class="px-3 py-2">
                        <input
                            type="number"
                            name="items[${index}][qty_diterima]"
                            min="0"
                            max="${item.qty_pesan}"
                            value="${item.qty_pesan}"
                            class="w-24 rounded-md border border-outline-variant px-2 py-1.5"
                        >
                    </td>
                    <td class="px-3 py-2">
                        <select name="items[${index}][kondisi]" class="rounded-md border border-outline-variant px-2 py-1.5">
                            <option value="BAIK">Baik</option>
                            <option value="RUSAK">Rusak</option>
                            <option value="KURANG">Kurang dari PO</option>
                        </select>
                    </td>
                </tr>
            `;
        }).join('');
    }
</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\WareHouse\resources\views/components/penerimaan/modal.blade.php ENDPATH**/ ?>