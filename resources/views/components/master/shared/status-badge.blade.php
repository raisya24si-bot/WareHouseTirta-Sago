@props(['status'])
@php
    $value = strtoupper((string) $status);
    $classes = match ($value) {
        'AKTIF', 'ONGOING' => 'bg-blue-100 text-primary',
        'MAINTENANCE', 'SELISIH' => 'bg-orange-100 text-orange-800',
        'COMPLETED', 'SESUAI' => 'bg-green-100 text-green-800',
        default => 'bg-gray-100 text-gray-700',
    };
    $dot = match ($value) {
        'AKTIF', 'ONGOING' => 'bg-primary',
        'MAINTENANCE', 'SELISIH' => 'bg-orange-700',
        'COMPLETED', 'SESUAI' => 'bg-green-700',
        default => 'bg-gray-500',
    };
@endphp
<span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm {{ $classes }}">
    <span class="h-2 w-2 rounded-full {{ $dot }}"></span>{{ $status }}
</span>
