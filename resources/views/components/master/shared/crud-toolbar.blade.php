@props([
    'action',
    'placeholder' => 'Cari...',
    'addAction' => null,
    'addText' => 'Tambah Data',
    'filterName' => null,
    'filterOptions' => [],
    'filterLabel' => 'Filter',
    'extraHidden' => [],
])

<div class="flex flex-wrap items-center justify-between gap-3 border-b border-outline-variant bg-surface-container-low/50 p-4">
    <div class="flex flex-wrap items-center gap-2">
        <form method="GET" action="{{ $action }}" class="flex items-center">
            @foreach($extraHidden as $name => $value)
                @if($value !== null && $value !== '')
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endif
            @endforeach
            @if($filterName && request($filterName) !== null && request($filterName) !== '')
                <input type="hidden" name="{{ $filterName }}" value="{{ request($filterName) }}">
            @endif
            <div class="flex items-center overflow-hidden rounded-md border border-outline-variant bg-white">
                <span class="material-symbols-outlined px-3 text-outline text-[20px]">search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ $placeholder }}"
                    class="w-64 border-none bg-transparent py-2 pl-0 pr-3 text-body-sm focus:ring-0"
                >
            </div>
        </form>

        @if($filterName)
            <button
                type="button"
                onclick="document.getElementById('{{ $filterName }}-filter').classList.toggle('hidden')"
                class="inline-flex items-center gap-2 rounded-md border border-outline-variant bg-white px-4 py-2 text-body-sm hover:bg-surface-container-low"
            >
                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                {{ $filterLabel }}
            </button>

            <form method="GET" action="{{ $action }}" id="{{ $filterName }}-filter" class="{{ request($filterName) ? '' : 'hidden' }} flex items-center gap-2">
                @foreach($extraHidden as $name => $value)
                    @if($value !== null && $value !== '')
                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                    @endif
                @endforeach
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="{{ $filterName }}" onchange="this.form.submit()" class="rounded-md border border-outline-variant bg-white px-3 py-2 text-body-sm">
                    <option value="">Semua {{ $filterLabel }}</option>
                    @foreach($filterOptions as $option)
                        <option value="{{ $option['value'] }}" @selected((string) request($filterName) === (string) $option['value'])>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

    @if($addAction)
        <button
            type="button"
            onclick="{{ $addAction }}"
            class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-body-sm font-label-bold text-on-primary shadow-sm hover:bg-primary-container"
        >
            <span class="material-symbols-outlined text-[19px]">add</span>
            {{ $addText }}
        </button>
    @endif
</div>
