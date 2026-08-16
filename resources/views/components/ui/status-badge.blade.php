@props(['status'])

@php
    $statusNormalized = strtolower(trim($status ?? ''));

    $isActive = in_array($statusNormalized, [
        'active',
        'aktif',
        '1',
        'true',
        'yes',
    ]);

    if ($isActive) {
        $classes = 'bg-green-50 text-green-700 border-green-200';
        $icon = 'check_circle';
        $label = 'Aktif';
    } else {
        $classes = 'bg-red-50 text-red-700 border-red-200';
        $icon = 'cancel';
        $label = 'Non Aktif';
    }
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $classes }}">
    <span class="material-symbols-outlined text-[14px]">
        {{ $icon }}
    </span>

    {{ $label }}
</span>