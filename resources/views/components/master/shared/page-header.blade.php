@props(['title', 'description', 'actionText' => null, 'action' => null])
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-display-lg font-display-lg text-on-surface leading-tight">{{ $title }}</h1>
        <p class="mt-1 text-body-lg text-on-surface-variant">{{ $description }}</p>
    </div>
    @if($actionText && $action)
        <button type="button" onclick="{{ $action }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm hover:bg-primary-container">
            <span class="material-symbols-outlined text-[20px]">add</span>{{ $actionText }}
        </button>
    @endif
</div>
