@props([
    'statuses',
    'kategoriGudangs',
])

<div
    id="gudang-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>
    <div
        class="absolute inset-0"
        onclick="closeGudangModal()"
    ></div>

    <div class="relative w-full max-w-2xl rounded-xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <h2
                id="gudang-title"
                class="text-xl font-semibold"
            >
                Tambah Gudang Baru
            </h2>

            <button
                type="button"
                onclick="closeGudangModal()"
            >
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        <form
            id="gudang-form"
            method="POST"
            action="{{ route('master-gudang.store') }}"
            class="space-y-4 p-6"
        >
            @csrf

            <div class="grid gap-4 md:grid-cols-2">

                <div>
                    <label class="mb-1 block font-semibold">
                        Kode Gudang
                    </label>

                    <input
                        id="gudang-kode"
                        value="[otomatis]"
                        readonly
                        class="w-full rounded-md border border-outline-variant bg-surface-container-low px-3 py-2 text-on-surface-variant"
                    >
                </div>

                <div>
                    <label class="mb-1 block font-semibold">
                        Nama Gudang *
                    </label>

                    <input
                        id="gudang-nama"
                        name="nm_gudang"
                        required
                        maxlength="50"
                        placeholder="Contoh: Gudang Utama"
                        class="w-full rounded-md border border-outline-variant px-3 py-2"
                    >
                </div>

            </div>

            {{-- KATEGORI GUDANG --}}
            <div>
                <label class="mb-1 block font-semibold">
                    Kategori Gudang *
                </label>

                <select
                    id="gudang-kategori"
                    name="fk_kategori_gudang"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                    <option value="">
                        Pilih kategori gudang
                    </option>

                    @foreach($kategoriGudangs as $kategori)
                        <option
                            value="{{ $kategori->id_kategori_gudang }}"
                        >
                            {{ $kategori->nm_kategori_gudang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block font-semibold">
                    Kepala Gudang
                </label>

                <input
                    id="gudang-kepala"
                    name="kepala_gudang"
                    maxlength="100"
                    placeholder="Nama Manager"
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
            </div>

            <div>
                <label class="mb-1 block font-semibold">
                    Alamat / Lokasi
                </label>

                <textarea
                    id="gudang-alamat"
                    name="alamat_gudang"
                    rows="3"
                    placeholder="Alamat lengkap gudang..."
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                ></textarea>
            </div>

            <div>
                <label class="mb-1 block font-semibold">
                    Status *
                </label>

                <select
                    id="gudang-status"
                    name="fk_status_gudang"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                    @foreach($statuses as $s)
                        <option
                            value="{{ $s->id_status_gudang }}"
                        >
                            {{ $s->nm_status_gudang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeGudangModal()"
                    class="rounded-md border border-outline-variant px-4 py-2"
                >
                    Batal
                </button>

                <button
                    class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary"
                >
                    Simpan Gudang
                </button>

            </div>

        </form>
    </div>
</div>

<script>
function openGudangModal() {
    const modal = document.getElementById('gudang-modal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('gudang-title').textContent =
        'Tambah Gudang Baru';

    document.getElementById('gudang-form').action =
        '{{ route('master-gudang.store') }}';

    document
        .getElementById('gudang-form')
        .querySelector('[name="_method"]')
        ?.remove();

    document.getElementById('gudang-kode').value =
        '[otomatis]';

    document.getElementById('gudang-nama').value = '';
    document.getElementById('gudang-kategori').value = '';
    document.getElementById('gudang-kepala').value = '';
    document.getElementById('gudang-alamat').value = '';
}

function closeGudangModal() {
    const modal = document.getElementById('gudang-modal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function editGudang(
    id,
    nama,
    kepala,
    alamat,
    status,
    kategori
) {
    openGudangModal();

    document.getElementById('gudang-title').textContent =
        'Edit Gudang';

    document.getElementById('gudang-form').action =
        '{{ url('/master-gudang') }}/' + id;

    let method =
        document
            .getElementById('gudang-form')
            .querySelector('[name="_method"]');

    if (!method) {
        method = document.createElement('input');

        method.type = 'hidden';
        method.name = '_method';

        document
            .getElementById('gudang-form')
            .prepend(method);
    }

    method.value = 'PUT';

    document.getElementById('gudang-kode').value =
        'Kode otomatis';

    document.getElementById('gudang-nama').value =
        nama || '';

    document.getElementById('gudang-kategori').value =
        kategori || '';

    document.getElementById('gudang-kepala').value =
        kepala || '';

    document.getElementById('gudang-alamat').value =
        alamat || '';

    document.getElementById('gudang-status').value =
        status;
}
</script>