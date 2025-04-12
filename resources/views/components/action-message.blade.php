{{-- @props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;"
    {{ $attributes->merge(['class' => 'text-sm text-gray-600 dark:text-gray-400']) }}>
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div> --}}

@props(['on'])

<div 
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 3000); })"
    x-show.transition.out.opacity.duration.1000ms="shown"
    x-transition:leave.opacity.duration.1000ms
    style="display: none;"
    {{ $attributes->merge(['class' => 'flex items-center gap-3 px-4 py-3 rounded-md bg-green-100 border border-green-300 text-green-800 shadow-lg']) }}
>
    {{-- Ícone --}}
    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>

    {{-- Mensagem --}}
    <span class="text-sm font-medium">
        {{ $slot->isEmpty() ? __('Saved.') : $slot }}
    </span>
</div>