<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['rows']));

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

foreach (array_filter((['rows']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div id="lokasi-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"><div class="absolute inset-0" onclick="closeLokasiModal()"></div><div class="relative w-full max-w-xl rounded-xl bg-white shadow-2xl"><div class="flex items-center justify-between border-b border-outline-variant px-6 py-4"><h2 id="lokasi-title" class="text-xl font-semibold">Tambah Struktur Lokasi</h2><button type="button" onclick="closeLokasiModal()"><span class="material-symbols-outlined">close</span></button></div><form id="lokasi-form" method="POST" action="<?php echo e(route('struktur-lokasi.store')); ?>" class="space-y-4 p-6"><?php echo csrf_field(); ?>

<div id="lokasi-kode-wrap" class="hidden"><label class="mb-1 block font-semibold">Kode Lokasi</label><input id="lokasi-kode" readonly class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"></div>

<div id="lokasi-create-fields" class="space-y-4">
<div><label class="mb-1 block font-semibold">Row *</label><select id="lokasi-row" name="fk_row" required class="w-full rounded-md border border-outline-variant px-3 py-2"><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->id_row); ?>"><?php echo e($r->kd_row); ?> (<?php echo e($r->rak?->kd_rak ?? '-'); ?> / <?php echo e($r->rak?->gudang?->nm_gudang ?? '-'); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
<div><label class="mb-1 block font-semibold">Jumlah Bin *</label><input id="lokasi-jumlah" type="number" name="jumlah" min="1" max="100" value="1" required class="w-full rounded-md border border-outline-variant px-3 py-2"><p class="mt-1 text-xs text-on-surface-variant">Nomor bin dibuat otomatis (01, 02, 03, ...), lanjut dari nomor terakhir di row ini — tidak pernah diulang dari awal.</p></div>
</div>

<div><label class="mb-1 block font-semibold">Status *</label><select id="lokasi-status" name="status_lokasi" required class="w-full rounded-md border border-outline-variant px-3 py-2"><option>AKTIF</option><option>MAINTENANCE</option><option>TIDAK AKTIF</option></select></div>
<div class="flex justify-end gap-2 border-t border-outline-variant pt-4"><button type="button" onclick="closeLokasiModal()" class="rounded-md border px-4 py-2">Batal</button><button class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary">Simpan</button></div>
</form></div></div>
<script>
function openLokasiModal(){
    const m=document.getElementById('lokasi-modal');
    m.classList.remove('hidden');m.classList.add('flex');
    document.getElementById('lokasi-title').textContent='Tambah Struktur Lokasi';
    document.getElementById('lokasi-form').action='<?php echo e(route('struktur-lokasi.store')); ?>';
    document.getElementById('lokasi-form').querySelector('[name="_method"]')?.remove();
    document.getElementById('lokasi-kode-wrap').classList.add('hidden');
    document.getElementById('lokasi-create-fields').classList.remove('hidden');
    document.getElementById('lokasi-row').required = true;
    document.getElementById('lokasi-jumlah').required = true;
    document.getElementById('lokasi-jumlah').value = 1;
}
function closeLokasiModal(){const m=document.getElementById('lokasi-modal');m.classList.add('hidden');m.classList.remove('flex')}
function editLokasi(id,status){
    openLokasiModal();
    document.getElementById('lokasi-title').textContent='Edit Status Struktur Lokasi';
    document.getElementById('lokasi-form').action='<?php echo e(url('/struktur-lokasi')); ?>/'+id;
    let m=document.getElementById('lokasi-form').querySelector('[name="_method"]');
    if(!m){m=document.createElement('input');m.type='hidden';m.name='_method';document.getElementById('lokasi-form').prepend(m)}
    m.value='PUT';
    document.getElementById('lokasi-kode-wrap').classList.remove('hidden');
    document.getElementById('lokasi-kode').value='Kode tidak dapat diubah';
    document.getElementById('lokasi-create-fields').classList.add('hidden');
    document.getElementById('lokasi-row').required = false;
    document.getElementById('lokasi-jumlah').required = false;
    document.getElementById('lokasi-status').value=status;
}
</script>
<?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData (1)\resources\views/components/master/gudang/lokasi-modal.blade.php ENDPATH**/ ?>