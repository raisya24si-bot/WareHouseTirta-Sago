@extends('layouts.app')

@section('title', 'Notifikasi - Warehouse Tirta Sago')
@section('breadcrumb', 'Notifikasi')

@section('content')
<x-master.shared.page-header
    title="Notifikasi"
    description="Riwayat kejadian penting: stok habis, selisih opname, dan barang masuk."
    icon="notifications"
/>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-master.shared.stat-card label="Total Notifikasi" :value="$summary['total']" icon="notifications" color="primary" />
    <x-master.shared.stat-card label="Belum Dibaca" :value="$summary['belum_dibaca']" icon="mark_email_unread" color="amber" />
    <x-master.shared.stat-card label="Stok Habis" :value="$summary['stok_habis']" icon="production_quantity_limits" color="red" />
    <x-master.shared.stat-card label="Opname Selisih" :value="$summary['opname_selisih']" icon="warning" color="amber" />
</div>

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant p-4">

        <div class="flex flex-wrap items-center gap-2">

            <a
                href="{{ route('notifikasi.index') }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ ! request('tipe') && ! request('unread_only') ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}"
            >
                Semua
            </a>

            <a
                href="{{ route('notifikasi.index', ['unread_only' => 1]) }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ request('unread_only') ? 'bg-primary text-on-primary' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' }}"
            >
                Belum Dibaca
            </a>

            <a
                href="{{ route('notifikasi.index', ['tipe' => 'STOK_HABIS']) }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ request('tipe') === 'STOK_HABIS' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}"
            >
                Stok Habis
            </a>

            <a
                href="{{ route('notifikasi.index', ['tipe' => 'OPNAME_SELISIH']) }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ request('tipe') === 'OPNAME_SELISIH' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}"
            >
                Opname Selisih
            </a>

            <a
                href="{{ route('notifikasi.index', ['tipe' => 'BARANG_MASUK']) }}"
                class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ request('tipe') === 'BARANG_MASUK' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
            >
                Barang Masuk
            </a>

        </div>

        <form method="POST" action="{{ route('notifikasi.mark-all-read') }}">
            @csrf
            <button
                type="submit"
                class="inline-flex items-center gap-1.5 rounded-md border border-outline-variant px-3 py-1.5 text-xs font-semibold text-on-surface-variant transition hover:border-primary/40 hover:bg-primary/5 hover:text-primary"
            >
                <span class="material-symbols-outlined text-[16px]">done_all</span>
                Tandai semua sudah dibaca
            </button>
        </form>

    </div>

    <div class="divide-y divide-outline-variant/60">

        @forelse($notifikasis as $notif)

            @php
                $colorMap = [
                    'red' => ['bg' => 'bg-red-50', 'icon' => 'bg-red-100 text-red-700', 'border' => 'border-l-red-400'],
                    'amber' => ['bg' => 'bg-amber-50', 'icon' => 'bg-amber-100 text-amber-700', 'border' => 'border-l-amber-400'],
                    'green' => ['bg' => 'bg-green-50', 'icon' => 'bg-green-100 text-green-700', 'border' => 'border-l-green-400'],
                    'primary' => ['bg' => 'bg-blue-50', 'icon' => 'bg-primary/10 text-primary', 'border' => 'border-l-primary'],
                ];
                $palette = $colorMap[$notif->color] ?? $colorMap['primary'];
            @endphp

            <a
                href="{{ route('notifikasi.open', $notif) }}"
                class="flex items-start gap-4 border-l-[3px] px-5 py-4 transition hover:bg-surface-container-low/60 {{ $notif->isRead() ? 'border-l-transparent' : $palette['border'] . ' ' . $palette['bg'] . '/40' }}"
            >
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $palette['icon'] }}">
                    <span class="material-symbols-outlined text-[20px]">{{ $notif->icon }}</span>
                </span>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-bold text-on-surface">{{ $notif->judul }}</p>
                        @unless($notif->isRead())
                            <span class="h-2 w-2 shrink-0 rounded-full bg-primary"></span>
                        @endunless
                    </div>
                    <p class="mt-1 text-sm text-on-surface-variant">{{ $notif->pesan }}</p>
                    <p class="mt-2 flex items-center gap-1.5 text-xs text-outline">
                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                        {{ $notif->created_at->translatedFormat('d F Y, H:i') }}
                        ({{ $notif->created_at->diffForHumans() }})
                    </p>
                </div>

                <span class="material-symbols-outlined shrink-0 text-[18px] text-outline-variant">chevron_right</span>
            </a>

        @empty

            <div class="px-5 py-16 text-center">
                <span class="material-symbols-outlined text-[40px] text-outline-variant">notifications_off</span>
                <p class="mt-3 text-sm text-on-surface-variant">Belum ada notifikasi.</p>
            </div>

        @endforelse

    </div>

    <x-master.shared.pagination :items="$notifikasis" label="notifikasi" :perPage="$perPage" />

</div>
@endsection