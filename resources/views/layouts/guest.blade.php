<!DOCTYPE html>
<html class="light" lang="id">

<head>
    @include('layouts.partials.head')
</head>

<body class="bg-background min-h-screen flex items-center justify-center p-6">

    @if(session('success'))
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flash-message flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 shadow-lg">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flash-message flex items-center gap-2 rounded-lg bg-blue-50 border border-blue-200 text-primary px-4 py-3 shadow-lg">
            <span class="material-symbols-outlined text-[20px]">info</span>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    @yield('content')

</body>

</html>