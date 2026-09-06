@props(['label', 'value', 'icon' => 'insights', 'color' => 'primary'])

@php
    $palette = match ($color) {
        'red' => [
            'bg' => 'bg-red-50',
            'ring' => 'ring-red-100',
            'icon' => 'bg-red-100 text-red-700',
            'value' => 'text-red-700',
        ],
        'amber' => [
            'bg' => 'bg-amber-50',
            'ring' => 'ring-amber-100',
            'icon' => 'bg-amber-100 text-amber-700',
            'value' => 'text-amber-700',
        ],
        'green' => [
            'bg' => 'bg-green-50',
            'ring' => 'ring-green-100',
            'icon' => 'bg-green-100 text-green-700',
            'value' => 'text-green-700',
        ],
        default => [
            'bg' => 'bg-blue-50',
            'ring' => 'ring-blue-100',
            'icon' => 'bg-primary/10 text-primary',
            'value' => 'text-primary',
        ],
    };
@endphp

<div class="group flex items-center gap-4 rounded-xl border border-outline-variant {{ $palette['bg'] }} p-4 shadow-sm ring-1 {{ $palette['ring'] }} transition duration-150 hover:-translate-y-0.5 hover:shadow-md">

    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $palette['icon'] }} transition group-hover:scale-105">
        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
    </div>

    <div class="min-w-0">
        <p class="text-xs font-medium text-on-surface-variant">{{ $label }}</p>
        <p class="text-2xl font-bold tabular-nums {{ $palette['value'] }}">{{ $value }}</p>
    </div>

</div>