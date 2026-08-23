<div
    id="import-barang-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>
    <div class="absolute inset-0" onclick="closeImportBarangModal()"></div>

    <div class="relative w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                    <span class="material-symbols-outlined text-[20px]">upload_file</span>
                </div>
                <h2 class="text-xl font-semibold">Import Barang dari CSV</h2>
            </div>
            <button type="button" onclick="closeImportBarangModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form
            method="POST"
            action="<?php echo e(route('barang.import')); ?>"
            enctype="multipart/form-data"
            class="space-y-4 p-6"
        >
            <?php echo csrf_field(); ?>

            <div class="rounded-lg border border-primary/20 bg-primary/5 p-3 text-sm text-on-surface-variant">
                Kolom minimal: <strong>Kode Barang</strong> (opsional, buat update data lama),
                <strong>Nama Barang</strong>, <strong>Kategori</strong>, <strong>Satuan</strong>.
                Kategori & Satuan harus sudah ada di Master Kategori / Master Satuan
                (dicocokkan berdasarkan nama).
                <a
                    href="<?php echo e(route('barang.import-template')); ?>"
                    class="mt-2 inline-flex items-center gap-1 font-semibold text-primary hover:underline"
                >
                    <span class="material-symbols-outlined text-[16px]">download</span>
                    Download template CSV
                </a>
            </div>

            <div>
                <label class="mb-1 block font-semibold">
                    File CSV *
                </label>

                <input
                    type="file"
                    name="file"
                    accept=".csv,.txt"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-primary/10 file:px-3 file:py-1.5 file:text-primary file:font-semibold"
                >

                <p class="mt-1 text-xs text-on-surface-variant">
                    Saat ini cuma format .csv yang didukung. Kalau punya file Excel,
                    buka lalu "Save As" &rarr; CSV (Comma delimited) dulu.
                </p>
            </div>

            <?php if(session('import_errors')): ?>
                <div class="max-h-40 overflow-auto rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-800">
                    <p class="mb-1 font-semibold">
                        <?php echo e(count(session('import_errors'))); ?> baris dilewati:
                    </p>
                    <ul class="list-disc space-y-0.5 pl-4">
                        <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($err); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">
                <button
                    type="button"
                    onclick="closeImportBarangModal()"
                    class="rounded-md border border-outline-variant px-4 py-2 transition hover:bg-surface-container-low"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary transition hover:bg-primary-container"
                >
                    <span class="material-symbols-outlined text-[18px]">upload</span>
                    Import
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    function openImportBarangModal() {
        const modal = document.getElementById('import-barang-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImportBarangModal() {
        const modal = document.getElementById('import-barang-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    <?php if(session('import_errors')): ?>
        // Otomatis buka modal lagi kalau baru selesai import & ada baris yang dilewati.
        openImportBarangModal();
    <?php endif; ?>
</script><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData\resources\views/components/master/barang/import-modal.blade.php ENDPATH**/ ?>