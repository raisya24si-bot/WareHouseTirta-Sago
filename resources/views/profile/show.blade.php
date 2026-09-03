@extends('layouts.app')

@section('title', 'Profil Saya - Warehouse Tirta Sago')
@section('breadcrumb', 'Profil Saya')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary">
            Edit Profil
        </span>
        <h1 class="mt-3 text-2xl font-bold text-on-surface">Kelola Profil Kamu</h1>
        <p class="mt-1 text-sm text-on-surface-variant">
            Perbarui biodata dan foto profil akun Warehouse Tirta Sago kamu.
        </p>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-0 lg:grid-cols-[280px_1fr]">
        @csrf
        @method('PUT')

        <!-- Kartu Foto Profil -->
        <div class="border-b border-outline-variant p-6 lg:border-b-0 lg:border-r">

            <p class="mb-4 text-sm font-bold text-on-surface">Foto Profil</p>

            <div class="flex flex-col items-center">

                <div class="relative">
                    <img
                        id="profile-avatar-preview"
                        src="{{ $user->photo_url ? asset($user->photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0059bb&color=fff&size=160' }}"
                        alt="{{ $user->name }}"
                        class="h-36 w-36 rounded-full object-cover border-4 border-primary/10 shadow-md"
                    >

                    <button
                        type="button"
                        onclick="document.getElementById('profile-photo-input').click()"
                        class="absolute bottom-1 right-1 flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-lg transition hover:scale-105 active:scale-95"
                        title="Ganti foto profil"
                    >
                        <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                    </button>
                </div>

                <input
                    type="file"
                    id="profile-photo-input"
                    name="photo"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="hidden"
                    onchange="previewProfilePhoto(this)"
                >

                <p class="mt-4 text-center text-xs text-on-surface-variant">
                    Klik icon kamera untuk mengganti foto profil.
                </p>

                <p id="profile-photo-filename" class="mt-1 hidden text-center text-xs font-semibold text-primary"></p>

            </div>

            <div class="mt-6 rounded-lg bg-surface-container-low p-3">
                <p class="mb-2 text-xs font-bold uppercase tracking-wide text-on-surface-variant">
                    Ketentuan Gambar
                </p>
                <ul class="space-y-1.5 text-xs text-on-surface-variant">
                    <li class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-green-600">check_circle</span>
                        Format JPG, PNG, atau WEBP
                    </li>
                    <li class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-green-600">check_circle</span>
                        Maksimal 2MB
                    </li>
                    <li class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-green-600">check_circle</span>
                        Disarankan foto persegi (square)
                    </li>
                </ul>
            </div>

            @error('photo')
                <p class="mt-2 text-xs text-error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Form Biodata -->
        <div class="p-6">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">person</span>
                        </span>
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-lg border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">mail</span>
                        </span>
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-lg border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">call</span>
                        </span>
                        Nomor Telepon
                    </label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+62 812 3456 7890"
                        class="w-full rounded-lg border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">location_on</span>
                        </span>
                        Alamat
                    </label>
                    <input
                        type="text"
                        name="address"
                        value="{{ old('address', $user->address) }}"
                        placeholder="Bukittinggi, Sumatera Barat"
                        class="w-full rounded-lg border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">badge</span>
                        </span>
                        Role
                    </label>
                    <input
                        type="text"
                        value="Administrator"
                        disabled
                        class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-3 py-2.5 text-sm text-on-surface-variant"
                    >
                </div>

                <div>
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">lock</span>
                        </span>
                        Password
                    </label>
                    <a
                        href="{{ route('settings.show') }}"
                        class="flex items-center justify-between rounded-lg border border-outline-variant px-3 py-2.5 text-sm text-on-surface-variant transition hover:border-primary/40 hover:bg-primary/5 hover:text-primary"
                    >
                        Ganti password di halaman Pengaturan
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 flex items-center gap-2 text-sm font-semibold text-on-surface">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-primary">
                            <span class="material-symbols-outlined text-[15px]">edit_note</span>
                        </span>
                        Bio
                    </label>
                    <textarea
                        name="bio"
                        rows="3"
                        maxlength="500"
                        placeholder="Ceritain dikit tentang tugas/peran kamu di sini..."
                        class="w-full rounded-lg border border-outline-variant px-3 py-2.5 text-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >{{ old('bio', $user->bio) }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2 border-t border-outline-variant pt-5">
                <a
                    href="{{ route('barang.index') }}"
                    class="rounded-lg border border-outline-variant px-5 py-2.5 text-sm font-label-bold text-on-surface-variant transition hover:bg-surface-container-low"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-primary to-primary-container px-6 py-2.5 text-sm font-label-bold text-on-primary shadow-sm transition hover:shadow-md active:scale-[0.98]"
                >
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Save Changes
                </button>
            </div>

        </div>

    </form>

</div>

<!-- Account Summary -->
<div class="mt-6 flex flex-col gap-3 rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-sm font-bold text-on-surface">Account Summary</p>
        <p class="text-xs text-on-surface-variant">
            Role: Administrator &bull; Bergabung: {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
        </p>
    </div>
    <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700">
        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
        Akun Aktif
    </span>
</div>

<script>
    function previewProfilePhoto(input) {

        const filenameEl = document.getElementById('profile-photo-filename');

        if (! input.files || ! input.files[0]) {
            return;
        }

        const file = input.files[0];

        filenameEl.textContent = file.name;
        filenameEl.classList.remove('hidden');

        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('profile-avatar-preview').src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
</script>

@endsection