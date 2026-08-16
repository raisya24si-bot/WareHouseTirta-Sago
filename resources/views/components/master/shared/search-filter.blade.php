@props(['action', 'placeholder' => 'Cari...', 'filterName' => null, 'filterOptions' => [], 'filterLabel' => 'Filter'])
<div class="flex flex-wrap items-center gap-2">
    <form method="GET" action="{{ $action }}" class="flex items-center">
        @foreach(request()->except(['search','page']) as $key => $value)
            @if(is_scalar($value) && $value !== '')<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
        @endforeach
        <div class="flex items-center overflow-hidden rounded-md border border-outline-variant bg-surface">
            <span class="material-symbols-outlined px-3 text-outline text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" class="w-64 border-none bg-transparent py-2 pl-0 pr-3 text-body-sm focus:ring-0" placeholder="{{ $placeholder }}">
        </div>
    </form>
    @if($filterName)
        <button type="button" onclick="document.getElementById('{{ $filterName }}-filter').classList.toggle('hidden')" class="inline-flex items-center gap-2 rounded-md border border-outline-variant px-4 py-2 font-label-bold hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">filter_list</span>{{ $filterLabel }}
        </button>
    @endif
</div>
@if($filterName)
<div id="{{ $filterName }}-filter" class="{{ request($filterName) ? '' : 'hidden' }} mt-3 w-full rounded-lg border border-outline-variant bg-white p-3">
    <form method="GET" action="{{ $action }}" class="flex flex-wrap items-end gap-3">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
        @foreach(request()->except(['search','page',$filterName]) as $key => $value)
            @if(is_scalar($value) && $value !== '')<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
        @endforeach
        <div><label class="mb-1 block text-sm font-semibold">{{ $filterLabel }}</label><select name="{{ $filterName }}" class="rounded-md border border-outline-variant bg-white px-3 py-2"><option value="">Semua</option>@foreach($filterOptions as $option)<option value="{{ $option['value'] }}" @selected((string)request($filterName)===(string)$option['value'])>{{ $option['label'] }}</option>@endforeach</select></div>
        <button class="rounded-md bg-primary px-4 py-2 font-label-bold text-on-primary">Terapkan</button>
        <a href="{{ $action }}" class="rounded-md border border-outline-variant px-4 py-2">Reset</a>
    </form>
</div>
@endif
