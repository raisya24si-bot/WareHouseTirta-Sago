@props(['title', 'description', 'actionText' => null, 'action' => null, 'icon' => null])
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div class="flex items-start gap-4">
        @if($icon)
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-sm">
                <span class="material-symbols-outlined text-[26px]">{{ $icon }}</span>
            </div>
        @endif
        <div>
            <h1 class="text-display-lg font-display-lg text-on-surface leading-tight">{{ $title }}</h1>
            <p class="mt-1 text-body-lg text-on-surface-variant">{{ $description }}</p>
        </div>
    </div>
    @if($actionText && $action)
        <button type="button" onclick="{{ $action }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 font-label-bold text-on-primary shadow-sm transition hover:bg-primary-container hover:shadow-md active:scale-[0.98]">
            <span class="material-symbols-outlined text-[20px]">add</span>{{ $actionText }}
        </button>
    @endif
</div>