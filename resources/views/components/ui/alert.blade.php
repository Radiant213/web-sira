@props([
    'type' => 'info', // info, success, warning, error
    'dismissible' => true,
])

@php
    $typeClasses = [
        'info' => 'bg-primary-50 border-primary-200 text-primary-800',
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
    ][$type] ?? 'bg-gray-50 border-gray-200 text-gray-800';

    $iconClasses = [
        'info' => 'text-primary-500',
        'success' => 'text-emerald-500',
        'warning' => 'text-amber-500',
        'error' => 'text-red-500',
    ][$type] ?? 'text-gray-500';
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:leave="transition ease-in duration-300" 
     x-transition:leave-start="opacity-100 translate-x-0" 
     x-transition:leave-end="opacity-0 translate-x-full"
     {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-xl border p-4 shadow-sm $typeClasses relative overflow-hidden"]) }}>
    
    {{-- Left Accent Line --}}
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-current opacity-30"></div>

    {{-- Icon --}}
    <div class="shrink-0 pt-0.5 {{ $iconClasses }}">
        @if($type === 'info')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @elseif($type === 'success')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @elseif($type === 'warning')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
        @elseif($type === 'error')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @else
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 text-sm font-medium">
        {{ $slot }}
    </div>

    {{-- Close Button --}}
    @if($dismissible)
        <button type="button" @click="show = false" class="shrink-0 rounded-lg p-1 opacity-70 transition-opacity hover:bg-black/5 hover:opacity-100" style="cursor: pointer;">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    @endif
</div>
