@props(['status'])
@php
    $value = strtoupper((string) $status);
    $classes = match (true) {
        in_array($value, ['AKTIF', 'ONGOING']) => 'bg-blue-100 text-primary',
        in_array($value, ['MAINTENANCE', 'SELISIH']) => 'bg-orange-100 text-orange-800',
        in_array($value, ['COMPLETED', 'SESUAI', 'APPROVED']) => 'bg-green-100 text-green-800',
        str_starts_with($value, 'PENDING') => 'bg-amber-100 text-amber-800',
        $value === 'REJECTED' => 'bg-red-100 text-red-700',
        $value === 'DRAFT' => 'bg-gray-100 text-gray-700',
        default => 'bg-gray-100 text-gray-700',
    };
    $dot = match (true) {
        in_array($value, ['AKTIF', 'ONGOING']) => 'bg-primary',
        in_array($value, ['MAINTENANCE', 'SELISIH']) => 'bg-orange-700',
        in_array($value, ['COMPLETED', 'SESUAI', 'APPROVED']) => 'bg-green-700',
        str_starts_with($value, 'PENDING') => 'bg-amber-600',
        $value === 'REJECTED' => 'bg-red-600',
        default => 'bg-gray-500',
    };
    $label = match ($value) {
        'PENDING_KASUBAG' => 'Pending Kasubag',
        'PENDING_KABAG' => 'Pending Kabag',
        'PENDING_DIREKTUR' => 'Pending Direktur',
        default => $status,
    };
@endphp
<span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm {{ $classes }}">
    <span class="h-2 w-2 rounded-full {{ $dot }}"></span>{{ $label }}
</span>