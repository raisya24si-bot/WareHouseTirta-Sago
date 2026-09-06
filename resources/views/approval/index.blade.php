@extends('layouts.app')

@section('title', 'Antrean Persetujuan - ' . $config['label'] . ' - Warehouse Tirta Sago')
@section('breadcrumb', 'Antrean Persetujuan ' . $config['label'])

@section('content')

<x-master.shared.page-header
    title="Antrean Persetujuan - Level {{ $config['label'] }}"
    description="Kelola dan tinjau permintaan material untuk operasional harian."
/>


@if(session('success'))

    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

        <div class="flex items-center gap-2">

            <span class="material-symbols-outlined text-[18px]">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    </div>

@endif


@if($errors->any())

    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>

@endif


<!-- ========================================================= -->
<!-- STATS -->
<!-- ========================================================= -->

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

    <x-master.shared.stat-card
        label="Waiting Approval"
        :value="$waitingCount"
        icon="hourglass_empty"
        color="amber"
    />

    <x-master.shared.stat-card
        label="Approved Today"
        :value="$approvedTodayCount"
        icon="check_circle"
        color="green"
    />

    <x-master.shared.stat-card
        label="Rejected"
        :value="$rejectedCount"
        icon="cancel"
        color="red"
    />

</div>


<!-- ========================================================= -->
<!-- LIST -->
<!-- ========================================================= -->

<div class="overflow-hidden rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low p-4">

        <p class="font-bold text-on-surface">
            Daftar Permintaan Material
        </p>

        <x-master.shared.search-filter
            :action="route('approval.index', $level)"
            placeholder="Cari nomor PO atau nama petugas..."
        />

    </div>


    <div class="overflow-x-auto custom-scrollbar">

        <table class="w-full min-w-[760px] text-left text-sm">

            <thead class="border-b border-outline-variant bg-surface-container-low">

                <tr>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        REQ ID
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Requester
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Date
                    </th>

                    <th class="px-4 py-3 text-label-bold text-on-surface-variant">
                        Approval Status
                    </th>

                    <th class="px-4 py-3 text-right text-label-bold text-on-surface-variant">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-outline-variant/60">

                @forelse($purchaseOrders as $po)

                    <tr class="transition hover:bg-surface-container-low/60">


                        <td class="px-4 py-3">

                            <a
                                href="{{ route('approval.review', [$level, $po]) }}"
                                class="font-bold text-primary hover:underline"
                            >
                                #{{ $po->kd_po }}
                            </a>

                            <p class="mt-0.5 text-xs text-on-surface-variant">
                                {{ $po->details->count() }} item(s)
                            </p>

                        </td>


                        <td class="px-4 py-3">

                            <p class="font-medium text-on-surface">
                                {{ $po->submittedBy?->name ?? '-' }}
                            </p>

                            <p class="text-xs text-on-surface-variant">
                                {{ $po->submittedBy?->email ?? '' }}
                            </p>

                        </td>


                        <td class="px-4 py-3 text-on-surface-variant">
                            {{ $po->submit_at?->translatedFormat('d M Y') ?? '-' }}
                        </td>


                        <td class="px-4 py-3">

                            <x-procurement.approval-status :po="$po" compact class="max-w-[200px]" />

                        </td>


                        <td class="px-4 py-3">

                            <div class="flex items-center justify-end gap-2">

                                <a
                                    href="{{ route('approval.review', [$level, $po]) }}"
                                    class="rounded-md border border-outline-variant px-4 py-2 text-xs font-label-bold text-on-surface transition hover:bg-surface-container-low"
                                >
                                    Review
                                </a>


                                @if($po->isPendingAt($level))

                                    <form
                                        method="POST"
                                        action="{{ route('approval.approve', [$level, $po]) }}"
                                        onsubmit="return confirm('Approve Purchase Order {{ $po->kd_po }} di tingkat {{ $config['label'] }}?')"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="rounded-md bg-primary px-4 py-2 text-xs font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container"
                                        >
                                            Quick Approve
                                        </button>
                                    </form>

                                @elseif($po->hasPassedLevel($level))

                                    <button
                                        type="button"
                                        disabled
                                        class="flex cursor-not-allowed items-center gap-1.5 rounded-md bg-green-600 px-4 py-2 text-xs font-label-bold text-white opacity-90"
                                    >
                                        <span class="material-symbols-outlined text-[15px]">check</span>
                                        Approved
                                    </button>

                                @elseif($po->isRejected() && $po->reject_level === strtoupper($level))

                                    <button
                                        type="button"
                                        disabled
                                        class="flex cursor-not-allowed items-center gap-1.5 rounded-md bg-error px-4 py-2 text-xs font-label-bold text-white opacity-90"
                                    >
                                        <span class="material-symbols-outlined text-[15px]">close</span>
                                        Rejected
                                    </button>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-4 py-10 text-center text-on-surface-variant"
                        >

                            Belum ada permintaan yang masuk ke tahap persetujuan {{ $config['label'] }}.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <x-master.shared.pagination
        :items="$purchaseOrders"
        label="permintaan"
        :perPage="$perPage"
    />

</div>

@endsection
