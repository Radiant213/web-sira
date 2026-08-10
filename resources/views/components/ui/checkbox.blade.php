@props([
    'id' => null,
    'name',
    'value' => 1,
    'checked' => false,
])

@php
    $id = $id ?? $name . '_' . Str::random(4);
@endphp

<label class="relative flex cursor-pointer items-start gap-3 group" for="{{ $id }}">
    <div class="relative flex h-5 w-5 items-center justify-center">
        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}
               class="peer sr-only" {{ $attributes }} />
        
        <div class="h-5 w-5 rounded border border-gray-300 bg-white transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-600 peer-focus-visible:ring-2 peer-focus-visible:ring-primary-500/30 group-hover:border-primary-400"></div>
        
        <svg class="pointer-events-none absolute h-3.5 w-3.5 text-white opacity-0 transition-opacity duration-200 peer-checked:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    
    <div class="text-sm font-medium text-gray-700 select-none group-hover:text-gray-900 transition-colors pt-0.5">
        {{ $slot }}
    </div>
</label>
