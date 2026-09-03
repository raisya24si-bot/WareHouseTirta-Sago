@extends('layouts.app')

@section('title', 'Pengaturan - Warehouse Tirta Sago')
@section('breadcrumb', 'Pengaturan')

@section('content')
<x-master.shared.page-header
    title="Pengaturan"
    description="Kelola password dan preferensi notifikasi akun kamu."
    icon="settings"
/>

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

        <form method="POST" action="{{ route('settings.update-password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1.5 block text-sm font-medium">Password Saat Ini</label>
                <input
                    type="password"
                    name="current_password"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                @error('current_password')
                    <p class="mt-1 text-xs text-error">{{ $message }}</p>
                @enderror
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
                @error('password')
                    <p class="mt-1 text-xs text-error">{{ $message }}</p>
                @enderror
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

        <form method="POST" action="{{ route('settings.update-preferences') }}" class="space-y-1">
            @csrf
            @method('PUT')

            @php
                $toggles = [
                    ['key' => 'notif_stok_menipis', 'label' => 'Stok Menipis / Habis', 'desc' => 'Notifikasi kalau ada barang yang stoknya di bawah minimum.'],
                    ['key' => 'notif_opname_selisih', 'label' => 'Selisih Stock Opname', 'desc' => 'Notifikasi kalau ada opname yang hasilnya selisih dari sistem.'],
                    ['key' => 'email_ringkasan_mingguan', 'label' => 'Ringkasan Mingguan (Email)', 'desc' => 'Rekap aktivitas gudang dikirim ke email tiap minggu.'],
                ];
            @endphp

            @foreach($toggles as $toggle)
                <label class="flex items-center justify-between gap-4 rounded-lg px-2 py-3 transition hover:bg-surface-container-low cursor-pointer">
                    <div>
                        <p class="text-sm font-medium text-on-surface">{{ $toggle['label'] }}</p>
                        <p class="text-xs text-on-surface-variant">{{ $toggle['desc'] }}</p>
                    </div>

                    <input
                        type="checkbox"
                        name="{{ $toggle['key'] }}"
                        value="1"
                        {{ $user->getPreference($toggle['key'], true) ? 'checked' : '' }}
                        class="peer sr-only"
                    >
                    <div
                        class="relative h-6 w-11 shrink-0 rounded-full bg-outline-variant transition-colors peer-checked:bg-primary"
                    ></div>
                </label>
            @endforeach

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
@endsection