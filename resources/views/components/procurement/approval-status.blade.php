@props([
    'po',
    'compact' => false,
    'withDetails' => false,
])

@php
    $currentOrder = $po->currentLevelOrder();
    $rejectedLevel = $po->isRejected() ? strtolower($po->reject_level ?? '') : null;
    $circleSize = $compact ? 'h-7 w-7 text-[11px]' : 'h-11 w-11 text-sm';
    $labelSize = $compact ? 'text-[10px]' : 'text-xs';

    $actorMap = [
        'kasubag' => $po->kasubagBy?->name,
        'kabag' => $po->kabagBy?->name,
        'direktur' => $po->direkturBy?->name,
    ];

    $atMap = [
        'kasubag' => $po->approve_kasubag_at,
        'kabag' => $po->apporve_kabag_at,
        'direktur' => $po->approve_direktur_at,
    ];
@endphp

<div {{ $attributes->class(['approval-status-widget']) }}>

    @unless($compact)

        <p class="mb-5 text-xs font-extrabold uppercase tracking-wider text-on-surface">
            Approval Status
        </p>

    @endunless


    <div class="flex items-start">

        @foreach(\App\Models\Po::LEVELS as $slug => $stepConfig)

            @php
                $order = $stepConfig['order'];

                $isRejectedHere = $rejectedLevel === $slug;
                $isDone = $po->hasPassedLevel($slug) && ! $isRejectedHere;
                $isCurrent = ! $isRejectedHere && ! $isDone && $currentOrder === $order;
            @endphp


            <div class="flex flex-1 flex-col items-center text-center">

                <div
                    class="flex {{ $circleSize }} shrink-0 items-center justify-center rounded-full font-bold transition-all
                    {{
                        $isRejectedHere
                            ? 'bg-error text-white ring-8 ring-error/15'
                            : ($isDone
                                ? 'bg-green-600 text-white'
                                : ($isCurrent
                                    ? 'bg-primary text-on-primary ring-8 ring-primary/15'
                                    : 'bg-surface-container-high text-on-surface-variant'))
                    }}"
                >

                    @if($isRejectedHere)

                        <span class="material-symbols-outlined {{ $compact ? 'text-[14px]' : 'text-[18px]' }}">
                            close
                        </span>

                    @elseif($isDone)

                        <span class="material-symbols-outlined {{ $compact ? 'text-[14px]' : 'text-[18px]' }}">
                            check
                        </span>

                    @else

                        {{ $order }}

                    @endif

                </div>


                <span
                    class="mt-2 {{ $labelSize }} font-bold
                    {{
                        $isRejectedHere
                            ? 'text-error'
                            : ($isDone
                                ? 'text-green-700'
                                : ($isCurrent ? 'text-primary' : 'text-on-surface-variant'))
                    }}"
                >
                    {{ $stepConfig['label'] }}
                </span>


                @if($withDetails && $isDone && $actorMap[$slug])

                    <span class="text-[11px] text-on-surface-variant">
                        {{ $actorMap[$slug] }}
                    </span>

                    <span class="text-[11px] text-outline">
                        {{ $atMap[$slug]?->translatedFormat('d M Y, H:i') }}
                    </span>

                @endif

            </div>


            @if($order < count(\App\Models\Po::LEVELS))

                <div
                    class="{{ $compact ? 'mt-3.5' : 'mt-5' }} h-0.5 flex-1 rounded-full
                    {{ $isDone && ! $isRejectedHere ? 'bg-green-600' : 'bg-outline-variant' }}"
                ></div>

            @endif

        @endforeach

    </div>


    @if($withDetails && $po->isRejected() && $po->reject_note)

        <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-4">

            <div class="flex items-center gap-2 text-red-700">

                <span class="material-symbols-outlined text-[18px]">
                    report
                </span>

                <span class="font-bold">
                    Ditolak oleh {{ $po->reject_level ? ucfirst(strtolower($po->reject_level)) : 'approver' }}
                    @if($po->rejectedBy)
                        ({{ $po->rejectedBy->name }})
                    @endif
                </span>

            </div>

            <p class="mt-1 text-xs text-red-600">
                {{ $po->reject_at?->translatedFormat('d M Y, H:i') }}
            </p>

            <p class="mt-2 rounded-md bg-white/60 p-3 text-sm text-red-700">
                {{ $po->reject_note }}
            </p>

        </div>

    @endif

</div>
