@extends('layouts.app')

@section('title', 'Approval Kasubag - BPB - Warehouse Tirta Sago')
@section('breadcrumb', 'Approval Kasubag BPB')

@section('content')

@php
    $prioritasBadge = [
        'DARURAT' => 'bg-error-container text-on-error-container',
        'TINGGI' => 'bg-primary-fixed text-on-primary-fixed',
        'NORMAL' => 'bg-surface-container-high text-on-surface-variant',
    ];
@endphp

<div class="flex flex-col w-full pb-container-padding gap-stack-md">

    @if(session('success'))
        <div class="px-container-padding py-stack-sm rounded-xl bg-green-100 text-green-800 text-body-sm font-label-bold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="px-container-padding py-stack-sm rounded-xl bg-error-container text-on-error-container text-body-sm font-label-bold">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- ================= BREADCRUMB ================= --}}
    <nav class="flex items-center gap-stack-sm text-sidebar-nav text-on-surface-variant">
        <a href="{{ route('permintaan-barang.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">assignment</span>
            Permintaan Barang
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Approval Kasubag</span>
    </nav>

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-gutter">
        <div class="flex flex-col">
            <h1 class="font-headline-md text-headline-md text-on-surface tracking-tight">
                Approval Kasubag &mdash; Permintaan Barang (BPB)
            </h1>
            <p class="text-body-sm text-on-surface-variant mt-1">
                Tinjau dan setujui BPB yang sudah diajukan sebelum diteruskan ke Gudang untuk disiapkan.
                Catatan: untuk saat ini approval baru 1 tingkat (Kasubag).
            </p>
        </div>

        <div class="flex items-center gap-stack-sm self-start md:self-center px-stack-md py-stack-sm rounded-xl bg-amber-100 text-amber-800">
            <span class="material-symbols-outlined text-[20px]">hourglass_top</span>
            <span class="font-label-bold text-body-sm">{{ $totalMenunggu }} BPB menunggu approval</span>
        </div>
    </div>

    {{-- ================= FILTER ================= --}}
    <form method="GET" action="{{ route('approval-bpb.index') }}" class="p-stack-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-stack-sm">
        <div class="relative w-full md:w-64">
            <span class="material-symbols-outlined absolute left-stack-sm top-2 text-outline text-[18px]">warehouse</span>
            <select name="gudang" onchange="this.form.submit()" class="w-full pl-8 pr-stack-sm py-base rounded-lg bg-surface-container-low text-on-surface text-[13px] focus:outline-none">
                <option value="">Semua Gudang Tujuan</option>
                @foreach($gudangList as $gudang)
                    <option value="{{ $gudang->id_gudang }}" {{ (string) request('gudang') === (string) $gudang->id_gudang ? 'selected' : '' }}>{{ $gudang->nm_gudang }}</option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- ================= TABLE ================= --}}
    <div class="w-full rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px] text-left text-body-sm border-collapse">

                <thead>
                    <tr class="bg-surface-container text-on-surface-variant font-label-bold text-[12px] uppercase tracking-wider">
                        <th class="px-container-padding py-stack-md">No Permintaan Barang</th>
                        <th class="px-stack-md py-stack-md">Pemohon &amp; Gudang</th>
                        <th class="px-stack-md py-stack-md">Diajukan</th>
                        <th class="px-stack-md py-stack-md">Prioritas</th>
                        <th class="px-stack-md py-stack-md">Item</th>
                        <th class="px-container-padding py-stack-md text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-outline-variant/60">

                    @forelse($antrean as $bpb)
                        @php
                            $prioritasKode = strtoupper($bpb->urgensi->kd_urgensi_bpb ?? 'NORMAL');
                        @endphp

                        <tr class="hover:bg-surface-container-low/60 transition-colors">

                            <td class="px-container-padding py-stack-md">
                                <a href="{{ route('permintaan-barang.show', $bpb->kd_bpb) }}" class="font-label-bold text-primary hover:underline">
                                    {{ $bpb->kd_bpb }}
                                </a>
                                <span class="block text-[13px] text-on-surface mt-0.5">{{ $bpb->desc_bpb ?? '-' }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md">
                                <span class="block font-label-bold text-on-surface">{{ $bpb->createdBy->name ?? '-' }}</span>
                                <span class="block text-[12px] text-on-surface-variant">{{ $bpb->gudang->nm_gudang ?? '-' }}</span>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <span class="block font-label-bold text-on-surface">{{ $bpb->submit_at?->translatedFormat('d M Y') }}</span>
                                <span class="block text-[12px] text-outline">{{ $bpb->submit_at?->format('H:i') }} WIB</span>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-label-bold {{ $prioritasBadge[$prioritasKode] ?? $prioritasBadge['NORMAL'] }}">
                                    {{ $bpb->urgensi->nm_urgensi_bpb ?? 'Normal' }}
                                </span>
                            </td>

                            <td class="px-stack-md py-stack-md whitespace-nowrap">
                                {{ $bpb->total_jenis_barang }} jenis &bull; {{ $bpb->total_kuantitas }} pcs
                            </td>

                            <td class="px-container-padding py-stack-md text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">

                                    <a href="{{ route('permintaan-barang.show', $bpb->kd_bpb) }}" class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>

                                    <button type="button" onclick="bukaTolak('{{ route('approval-bpb.reject', $bpb->kd_bpb) }}', '{{ $bpb->kd_bpb }}')" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-error-container text-error hover:bg-error hover:text-on-error text-[12px] font-label-bold transition-colors" title="Tolak">
                                        <span class="material-symbols-outlined text-[15px]">close</span>
                                        Tolak
                                    </button>

                                    <form method="POST" action="{{ route('approval-bpb.approve', $bpb->kd_bpb) }}" onsubmit="return confirm('Setujui BPB {{ $bpb->kd_bpb }}? Status akan pindah ke Diproses Gudang.');" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-primary text-on-primary hover:bg-primary-container text-[12px] font-label-bold transition-colors" title="Setujui">
                                            <span class="material-symbols-outlined text-[15px]">check</span>
                                            Setujui
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-container-padding py-12 text-center text-on-surface-variant">
                                Tidak ada BPB yang menunggu approval Kasubag saat ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-stack-sm px-container-padding py-stack-md border-t border-outline-variant text-[13px] text-on-surface-variant">
            <span>Menampilkan {{ $antrean->firstItem() ?? 0 }}-{{ $antrean->lastItem() ?? 0 }} dari {{ $antrean->total() }} antrean</span>
            <div>
                {{ $antrean->links() }}
            </div>
        </div>

    </div>

</div>

{{-- ================= MODAL: TOLAK BPB ================= --}}
<div id="modal-tolak-bpb" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-stack-md">
    <form method="POST" id="form-tolak-bpb" action="" class="w-full max-w-md bg-surface-container-lowest rounded-xl shadow-2xl overflow-hidden flex flex-col">
        @csrf

        <div class="px-container-padding py-stack-md flex items-start justify-between shrink-0 border-b border-outline-variant">
            <div>
                <h2 class="text-body-lg font-label-bold text-on-surface">Tolak Permintaan <span id="tolak-kode-bpb"></span></h2>
                <span class="text-[12px] text-on-surface-variant">Alasan penolakan akan tercatat pada dokumen BPB ini</span>
            </div>
            <button type="button" onclick="document.getElementById('modal-tolak-bpb').classList.add('hidden')" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-container-padding flex flex-col gap-stack-md">
            <div class="flex flex-col gap-1">
                <label class="font-label-bold text-[12px] text-on-surface uppercase tracking-wider">Alasan Penolakan</label>
                <textarea name="alasan_tolak" rows="3" placeholder="Contoh: Belum sesuai kuota gudang bulan ini, silakan ajukan ulang bulan depan." class="w-full px-stack-md py-base rounded-lg bg-surface-container-lowest text-on-surface text-body-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none border border-outline-variant"></textarea>
            </div>
        </div>

        <div class="px-container-padding py-stack-md bg-surface-container flex items-center justify-end gap-stack-sm shrink-0">
            <button type="button" onclick="document.getElementById('modal-tolak-bpb').classList.add('hidden')" class="px-container-padding py-2 rounded-lg bg-surface-container-highest text-on-surface font-label-bold text-body-sm hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <button type="submit" class="inline-flex items-center gap-stack-sm px-container-padding py-2 rounded-lg bg-error text-on-error font-label-bold text-body-sm shadow-sm hover:bg-error-container hover:text-error transition-colors">
                <span class="material-symbols-outlined text-[18px]">close</span>
                Tolak Permintaan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    function bukaTolak(actionUrl, kode) {
        document.getElementById('form-tolak-bpb').action = actionUrl;
        document.getElementById('tolak-kode-bpb').textContent = kode;
        document.getElementById('modal-tolak-bpb').classList.remove('hidden');
    }
</script>
@endpush

@endsection