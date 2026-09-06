@props(['items', 'label' => 'data', 'perPage' => null])
<div class="flex flex-wrap items-center justify-between gap-3 border-t border-outline-variant bg-surface-container-low px-4 py-3 text-sm text-on-surface-variant">
    <div class="flex flex-wrap items-center gap-4">
        <span>Menampilkan {{ $items->total() > 0 ? $items->firstItem() : 0 }} - {{ $items->total() > 0 ? $items->lastItem() : 0 }} dari {{ $items->total() }} {{ $label }}</span>

        @if($perPage !== null)
        <form method="GET" class="flex items-center gap-2">
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $v)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                    @endforeach
                @elseif(is_scalar($value) && $value !== '')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <label class="text-xs">Tampilkan</label>
            <select name="per_page" onchange="this.form.submit()" class="rounded-md border border-outline-variant bg-white px-2 py-1 text-xs">
                @foreach(['10', '20', '30', '50'] as $opt)
                    <option value="{{ $opt }}" @selected((string) $perPage === $opt)>{{ $opt }}</option>
                @endforeach
                <option value="all" @selected($perPage === 'all')>Semua</option>
            </select>
        </form>
        @endif
    </div>

    @if($items->hasPages())
    <div class="flex items-center gap-1">
        @if($items->onFirstPage())<span class="flex h-8 w-8 items-center justify-center opacity-40"><span class="material-symbols-outlined">chevron_left</span></span>@else<a href="{{ $items->previousPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant"><span class="material-symbols-outlined">chevron_left</span></a>@endif
        @foreach($items->getUrlRange(max(1,$items->currentPage()-2),min($items->lastPage(),$items->currentPage()+2)) as $page=>$url)
            @if($page==$items->currentPage())<span class="flex h-8 w-8 items-center justify-center rounded bg-primary text-on-primary">{{ $page }}</span>@else<a href="{{ $url }}" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant">{{ $page }}</a>@endif
        @endforeach
        @if($items->hasMorePages())<a href="{{ $items->nextPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded hover:bg-surface-variant"><span class="material-symbols-outlined">chevron_right</span></a>@else<span class="flex h-8 w-8 items-center justify-center opacity-40"><span class="material-symbols-outlined">chevron_right</span></span>@endif
    </div>
    @endif
</div>
