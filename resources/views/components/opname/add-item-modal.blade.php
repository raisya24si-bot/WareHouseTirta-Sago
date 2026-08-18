@props(['opname', 'bins', 'allBarangs'])

<div id="add-item-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">

    <div
        class="absolute inset-0"
        onclick="closeAddItemModal()">
    </div>

    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-outline-variant px-6 py-4">
            <h2 class="text-xl font-semibold">
                Tambah Barang ke Opname
            </h2>

            <button
                type="button"
                onclick="closeAddItemModal()">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        <form
            method="POST"
            action="{{ route('opname.add-item', $opname) }}"
            class="space-y-4 p-6"
        >
            @csrf

            {{-- BIN --}}
            <div>
                <label class="mb-1 block font-semibold">
                    Bin *
                </label>

                <select
                    id="add-item-bin"
                    name="fk_lokasi"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                    <option value="">
                        Pilih bin...
                    </option>

                    @foreach($bins as $b)
                        <option value="{{ $b->id_lokasi }}">
                            {{ $b->bin }}
                            ({{ $b->kd_lokasi }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BARANG --}}
            <div>
                <label class="mb-1 block font-semibold">
                    Barang *
                </label>

                <select
                    name="fk_barang"
                    required
                    class="w-full rounded-md border border-outline-variant px-3 py-2"
                >
                    <option value="">
                        Pilih barang...
                    </option>

                    @foreach($allBarangs as $b)
                        <option value="{{ $b->id_master_barang }}">
                            {{ $b->kd_master_barang }}
                            -
                            {{ $b->nm_master_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- INFO --}}
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">

                <div class="flex gap-3">

                    <span class="material-symbols-outlined text-primary">
                        info
                    </span>

                    <div class="text-sm">

                        <p class="font-semibold text-primary">
                            System Qty otomatis
                        </p>

                        <p class="mt-1 text-on-surface-variant">
                            System Qty akan diambil dari
                            <strong>tbl_stok_lokasi</strong>.
                            Jika barang belum memiliki stok pada
                            bin tersebut, System Qty dianggap
                            <strong>0</strong>.
                        </p>

                        <p class="mt-2 text-on-surface-variant">
                            Menambahkan barang di sini hanya
                            menyimpan data ke opname.
                            <strong>
                                Stok resmi belum berubah
                                sampai Submit Adjustment.
                            </strong>
                        </p>

                    </div>

                </div>

            </div>

            <div class="flex justify-end gap-2 border-t border-outline-variant pt-4">

                <button
                    type="button"
                    onclick="closeAddItemModal()"
                    class="rounded-md border border-outline-variant px-4 py-2"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-md bg-primary px-5 py-2 font-label-bold text-on-primary"
                >
                    Tambahkan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function openAddItemModal(binId) {

        const modal =
            document.getElementById('add-item-modal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        const binSelect =
            document.getElementById('add-item-bin');

        if (binId) {
            binSelect.value = String(binId);
        } else {
            binSelect.value = '';
        }
    }

    function closeAddItemModal() {

        const modal =
            document.getElementById('add-item-modal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>