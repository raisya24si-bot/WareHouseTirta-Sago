@extends('layouts.app')

@section('title', 'Edit Retur '.$retur->kd_retur.' - Warehouse Tirta Sago')
@section('breadcrumb', 'Edit Retur Barang')

@section('content')

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    <nav class="flex items-center gap-stack-sm font-sidebar-nav text-sidebar-nav text-on-surface-variant py-stack-md">
        <a class="hover:text-primary transition-colors" href="{{ route('retur.index') }}">Retur Barang Masuk</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('retur.show', $retur) }}">{{ $retur->kd_retur }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Edit</span>
    </nav>

    @if($errors->any())
        <div class="p-stack-md rounded-lg bg-error-container text-on-error-container text-[13px]">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('retur.update', $retur) }}" enctype="multipart/form-data" id="formEditRetur">
        @csrf
        @method('PUT')
        <input type="hidden" name="mode" id="inputMode" value="draft">

        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-container-high overflow-hidden flex flex-col">

            <div class="bg-inverse-surface text-inverse-on-surface p-container-padding flex flex-col gap-1">
                <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-bold text-[10px] uppercase tracking-widest w-fit">Edit Draf Retur</span>
                <h1 class="font-headline-md text-headline-md text-inverse-on-surface leading-tight mt-1">{{ $retur->kd_retur }}</h1>
                <p class="font-body-sm text-[12px] text-inverse-on-surface/80">
                    Dari GRN <strong class="font-mono">{{ $retur->penerimaanBarang?->kd_penerimaan }}</strong>
                    — Supplier <strong>{{ $retur->supplier?->nm_master_supplier ?? '-' }}</strong>
                    <span class="inline-flex items-center gap-1 ml-2 text-inverse-on-surface/70"><span class="material-symbols-outlined text-[12px]">lock</span> GRN sumber tidak bisa diubah</span>
                </p>
            </div>

            <div class="p-container-padding flex flex-col gap-stack-md">

                <div class="flex flex-col gap-1">
                    <label class="font-label-bold text-body-sm text-on-surface">Catatan Retur <span class="text-outline font-normal">(Opsional)</span></label>
                    <textarea name="catatan_retur" rows="2" class="bg-surface-container-low px-stack-md py-2 rounded-lg font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none resize-none">{{ $retur->catatan_retur }}</textarea>
                </div>

                <div class="flex flex-col gap-stack-sm" id="itemCardsContainer">
                    @foreach($retur->details as $index => $detail)
                        <div class="bg-surface-container-low p-stack-md rounded-xl border-2 border-primary/40 shadow-sm flex flex-col gap-stack-sm item-card">

                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 pb-2 border-b">
                                <div class="flex items-start gap-stack-sm">
                                    <input type="checkbox" checked class="rounded w-4 h-4 text-primary focus:ring-0 cursor-pointer mt-1 include-checkbox">
                                    <input type="hidden" name="items[{{ $index }}][id_retur_detail]" value="{{ $detail->id_retur_detail }}" class="disableable">
                                    <div class="flex flex-col">
                                        <span class="font-label-bold text-body-sm text-on-surface">{{ $detail->barang?->nm_master_barang }}</span>
                                        <span class="text-[11px] text-outline">Qty Reject QC: <strong class="text-error">{{ $detail->qty_reject_qc }} Unit</strong></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-stack-sm self-end sm:self-auto">
                                    <span class="text-[12px] text-outline font-label-bold">Qty yang Diretur:</span>
                                    <input type="number" min="1" max="{{ $detail->qty_reject_qc }}" value="{{ $detail->qty_diretur }}"
                                        name="items[{{ $index }}][qty_diretur]"
                                        class="w-14 text-center bg-surface-container-lowest font-label-bold text-[13px] py-1 focus:outline-none text-on-surface border rounded-lg disableable">
                                    <span class="text-[12px] font-bold text-on-surface">Unit</span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-1.5 pt-1">
                                <label class="font-label-bold text-[12px] text-on-surface flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-error">emergency</span>
                                    Kategori &amp; Alasan Kerusakan (Bisa Pilih Lebih Dari Satu):
                                </label>
                                <div class="flex flex-wrap gap-1.5">
                                    @php $chosenAlasan = $detail->alasan->pluck('id_alasan_retur')->all(); @endphp
                                    @foreach($alasanList as $alasan)
                                        @php $checked = in_array($alasan->id_alasan_retur, $chosenAlasan, true); @endphp
                                        <label class="alasan-chip inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[11px] cursor-pointer transition-colors {{ $checked ? 'bg-error-container text-on-error-container shadow-sm' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
                                            <input type="checkbox" class="sr-only alasan-checkbox disableable" name="items[{{ $index }}][alasan_ids][]" value="{{ $alasan->id_alasan_retur }}" {{ $checked ? 'checked' : '' }}>
                                            <span class="material-symbols-outlined text-[13px] {{ $checked ? '' : 'text-outline' }}">{{ $checked ? 'check_circle' : 'add' }}</span>
                                            {{ $alasan->nm_alasan_retur }}
                                        </label>
                                    @endforeach
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-sm mt-2">
                                    <input type="text" name="items[{{ $index }}][catatan_detail]" value="{{ $detail->catatan_detail }}"
                                        placeholder="Keterangan detail kerusakan fisik (opsional)..."
                                        class="disableable w-full bg-surface-container-lowest border border-surface-container-highest rounded-lg px-3 py-1.5 font-body-sm text-[12px] text-on-surface placeholder:text-outline focus:outline-none md:col-span-2">

                                    <div class="flex flex-col gap-1.5">
                                        @if($detail->fotos->isNotEmpty())
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($detail->fotos as $foto)
                                                    <a href="{{ $foto->url }}" target="_blank" class="block w-12 h-12 rounded-lg overflow-hidden border border-surface-container-high shrink-0">
                                                        <img src="{{ $foto->url }}" class="w-full h-full object-cover">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        <label class="disableable inline-flex items-center gap-1 px-2 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-[11px] font-label-bold transition-colors w-full justify-center cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px] text-primary">add_photo_alternate</span> + Tambah Foto Bukti
                                            <input type="file" name="items[{{ $index }}][fotos][]" multiple accept="image/*" class="hidden">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-[11px] text-outline">Hilangkan centang di kiri atas item untuk mengeluarkannya dari dokumen retur ini.</p>
            </div>

            <div class="bg-surface-container-low p-container-padding flex flex-col sm:flex-row items-center justify-between gap-stack-md border-t border-surface-container-high">
                <div class="flex items-center gap-2 text-[12px] text-on-surface-variant">
                    <span class="material-symbols-outlined text-[18px] text-primary">info</span>
                    <span>"Terbitkan" akan mengunci dokumen ini dan mengirimkannya sebagai BAP resmi ke vendor.</span>
                </div>
                <div class="flex items-center gap-stack-sm w-full sm:w-auto justify-end">
                    <a href="{{ route('retur.show', $retur) }}" class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-bold text-body-sm transition-colors">
                        Batal
                    </a>
                    <button class="px-container-padding py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-bold text-body-sm transition-colors" type="submit" onclick="document.getElementById('inputMode').value='draft'">
                        Simpan Draf
                    </button>
                    <button class="px-container-padding py-2 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-bold text-body-sm transition-all shadow-md flex items-center gap-1.5" type="submit" onclick="document.getElementById('inputMode').value='submit'">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Terbitkan &amp; Kirim BAP Retur
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.querySelectorAll('.item-card').forEach(function (card) {
    var includeCheckbox = card.querySelector('.include-checkbox');
    var disableables = card.querySelectorAll('.disableable');

    includeCheckbox.addEventListener('change', function () {
        disableables.forEach(function (el) { el.disabled = !includeCheckbox.checked; });
        card.classList.toggle('opacity-50', !includeCheckbox.checked);
    });

    card.querySelectorAll('.alasan-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var label = checkbox.closest('.alasan-chip');
            var icon = label.querySelector('.material-symbols-outlined');
            if (checkbox.checked) {
                label.className = 'alasan-chip inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[11px] cursor-pointer bg-error-container text-on-error-container shadow-sm';
                icon.textContent = 'check_circle';
                icon.className = 'material-symbols-outlined text-[13px]';
            } else {
                label.className = 'alasan-chip inline-flex items-center gap-1 px-2.5 py-1 rounded-full font-label-bold text-[11px] cursor-pointer bg-surface-container text-on-surface-variant hover:bg-surface-container-high';
                icon.textContent = 'add';
                icon.className = 'material-symbols-outlined text-[13px] text-outline';
            }
        });
    });
});
</script>
@endpush

@endsection