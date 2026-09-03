@extends('layouts.guest')

@section('title', 'Masuk - Warehouse Tirta Sago')

@section('content')
<div class="w-full max-w-md">

    <!-- Brand -->
    <div class="mb-8 flex flex-col items-center text-center">

        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-lg shadow-primary/30">
            <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">
                warehouse
            </span>
        </div>

        <h1 class="text-2xl font-bold text-on-surface">Warehouse</h1>
        <p class="text-sm font-bold uppercase tracking-wider text-primary">Tirta Sago</p>

    </div>

    <!-- Card -->
    <div class="rounded-2xl border border-outline-variant bg-white p-8 shadow-xl">

        <h2 class="mb-1 text-xl font-bold text-on-surface">Masuk ke akun kamu</h2>
        <p class="mb-6 text-sm text-on-surface-variant">
            Masukkan email dan password buat lanjut.
        </p>

        @if(app()->environment('local'))
        
        @endif

        @if($errors->any())
            <div class="mb-5 flex items-start gap-2 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <span class="material-symbols-outlined text-[20px]">error</span>
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
            @csrf

            <div>
                <label class="mb-1.5 block text-sm font-medium text-on-surface">
                    Email
                </label>

                <div class="flex items-center rounded-lg border border-outline-variant bg-white transition focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15">
                    <span class="material-symbols-outlined pl-3 text-outline text-[20px]">mail</span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="nama@tirtasago.id"
                        class="w-full border-none bg-transparent px-3 py-2.5 text-sm focus:ring-0"
                    >
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-on-surface">
                    Password
                </label>

                <div class="flex items-center rounded-lg border border-outline-variant bg-white transition focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/15">
                    <span class="material-symbols-outlined pl-3 text-outline text-[20px]">lock</span>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full border-none bg-transparent px-3 py-2.5 text-sm focus:ring-0"
                    >
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2 text-on-surface-variant">
                    <input type="checkbox" name="remember" class="rounded border-outline-variant text-primary focus:ring-primary/30">
                    Ingat saya
                </label>

                <a href="#" class="font-medium text-primary hover:underline">
                    Lupa password?
                </a>
            </div>

            <button
                type="submit"
                class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]"
            >
                <span class="material-symbols-outlined text-[20px]">login</span>
                Masuk
            </button>

        </form>

    </div>

    <p class="mt-6 text-center text-xs text-on-surface-variant">
        &copy; {{ date('Y') }} Warehouse Tirta Sago. Internal system.
    </p>

</div>
@endsection