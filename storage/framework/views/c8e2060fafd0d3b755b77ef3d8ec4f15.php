

<?php $__env->startSection('title', 'Pengaturan - Warehouse Tirta Sago'); ?>
<?php $__env->startSection('breadcrumb', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.master.shared.page-header','data' => ['title' => 'Pengaturan','description' => 'Kelola password dan preferensi notifikasi akun kamu.','icon' => 'settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('master.shared.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pengaturan','description' => 'Kelola password dan preferensi notifikasi akun kamu.','icon' => 'settings']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5)): ?>
<?php $attributes = $__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5; ?>
<?php unset($__attributesOriginaleb505a29c7c6ac9c6b668e6cf9210ab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5)): ?>
<?php $component = $__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5; ?>
<?php unset($__componentOriginaleb505a29c7c6ac9c6b668e6cf9210ab5); ?>
<?php endif; ?>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    <!-- Ganti Password -->
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">

        <div class="mb-5 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined">lock</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-on-surface">Ganti Password</h2>
                <p class="text-xs text-on-surface-variant">Minimal 8 karakter.</p>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('settings.update-password')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label class="mb-1.5 block text-sm font-medium">Password Saat Ini</label>
                <input
                    type="password"
                    name="current_password"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    minlength="8"
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>

            <div class="flex justify-end border-t border-outline-variant pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]"
                >
                    <span class="material-symbols-outlined text-[18px]">key</span>
                    Update Password
                </button>
            </div>

        </form>

    </div>

    <!-- Preferensi Notifikasi -->
    <div class="rounded-xl border border-outline-variant bg-surface-container-lowest p-6 shadow-sm">

        <div class="mb-5 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined">notifications</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-on-surface">Preferensi Notifikasi</h2>
                <p class="text-xs text-on-surface-variant">Atur notifikasi apa saja yang mau kamu terima.</p>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('settings.update-preferences')); ?>" class="space-y-1">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <?php
                $toggles = [
                    ['key' => 'notif_stok_menipis', 'label' => 'Stok Menipis / Habis', 'desc' => 'Notifikasi kalau ada barang yang stoknya di bawah minimum.'],
                    ['key' => 'notif_opname_selisih', 'label' => 'Selisih Stock Opname', 'desc' => 'Notifikasi kalau ada opname yang hasilnya selisih dari sistem.'],
                    ['key' => 'email_ringkasan_mingguan', 'label' => 'Ringkasan Mingguan (Email)', 'desc' => 'Rekap aktivitas gudang dikirim ke email tiap minggu.'],
                ];
            ?>

            <?php $__currentLoopData = $toggles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toggle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center justify-between gap-4 rounded-lg px-2 py-3 transition hover:bg-surface-container-low cursor-pointer">
                    <div>
                        <p class="text-sm font-medium text-on-surface"><?php echo e($toggle['label']); ?></p>
                        <p class="text-xs text-on-surface-variant"><?php echo e($toggle['desc']); ?></p>
                    </div>

                    <input
                        type="checkbox"
                        name="<?php echo e($toggle['key']); ?>"
                        value="1"
                        <?php echo e($user->getPreference($toggle['key'], true) ? 'checked' : ''); ?>

                        class="peer sr-only"
                    >
                    <div
                        class="relative h-6 w-11 shrink-0 rounded-full bg-outline-variant transition-colors peer-checked:bg-primary"
                    ></div>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="flex justify-end border-t border-outline-variant pt-4 mt-3">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]"
                >
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Preferensi
                </button>
            </div>

        </form>

    </div>

</div>

<style>
    /* Toggle switch: lingkaran putih yang geser pas checkbox-nya checked */
    input[type="checkbox"].peer + div::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        height: 20px;
        width: 20px;
        border-radius: 9999px;
        background: white;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        transition: transform 0.2s ease;
    }
    input[type="checkbox"].peer:checked + div::after {
        transform: translateX(20px);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ProjectPDAM\laragon-6.0-minimal\www\MasterData_FULL_FIXED\MasterData\resources\views/settings/show.blade.php ENDPATH**/ ?>