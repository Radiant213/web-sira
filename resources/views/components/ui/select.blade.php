@props([
    'id' => null,
    'name',
    'options' => [], // array of ['value' => '', 'label' => ''] or just key-value pairs
    'value' => '',
    'placeholder' => 'Pilih...',
    'searchable' => false,
])

@php
    $id = $id ?? $name . '_' . Str::random(4);
    
    // Normalize options
    $normalizedOptions = [];
    foreach ($options as $key => $opt) {
        if (is_array($opt)) {
            $normalizedOptions[] = ['value' => $opt['value'], 'label' => $opt['label']];
        } else {
            $normalizedOptions[] = ['value' => $key, 'label' => $opt];
        }
    }
    
    $optionsJson = json_encode($normalizedOptions);
@endphp

<div x-data="{
        open: false,
        selected: '{{ old($name, $value) }}',
        options: {{ $optionsJson }},
        search: '',
        get filteredOptions() {
            if (!this.search) return this.options;
            const lowerSearch = this.search.toLowerCase();
            return this.options.filter(opt => opt.label.toLowerCase().includes(lowerSearch));
        },
        get selectedLabel() {
            const opt = this.options.find(o => o.value == this.selected);
            return opt ? opt.label : '{{ $placeholder }}';
        },
        select(val) {
            this.selected = val;
            this.open = false;
            this.search = '';
            @if(isset($submitOnChange) && $submitOnChange)
                this.$nextTick(() => { this.$el.closest('form').submit(); });
            @endif
        }
    }" 
    @click.away="open = false"
    class="relative w-full">
    
    <input type="hidden" name="{{ $name }}" :value="selected" id="{{ $id }}">

    <button type="button" @click="open = !open" 
            class="flex w-full items-center justify-between rounded-xl border border-border bg-white px-4 py-3 text-sm text-left outline-none transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
            :class="{ 'text-gray-400': !selected, 'text-gray-800 font-medium': selected, 'border-primary-500 ring-2 ring-primary-500/20': open }" style="cursor: pointer;">
        <span x-text="selectedLabel" class="truncate"></span>
        <svg class="h-4 w-4 shrink-0 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-xl border border-border bg-white py-1 shadow-lg"
         style="display: none;">
         
        @if($searchable)
            <div class="sticky top-0 z-10 bg-white p-2">
                <input type="text" x-model="search" placeholder="Cari..." 
                       class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs outline-none focus:border-primary-500 focus:bg-white"
                       @click.stop>
            </div>
        @endif

        <template x-for="option in filteredOptions" :key="option.value">
            <button type="button" @click="select(option.value)" 
                    class="flex w-full items-center justify-between px-4 py-2 text-sm text-left transition-colors hover:bg-primary-50 hover:text-primary-700"
                    :class="{ 'bg-primary-50 font-semibold text-primary-700': selected == option.value, 'text-gray-700': selected != option.value }" style="cursor: pointer;">
                <span x-text="option.label"></span>
                <svg x-show="selected == option.value" class="h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        </template>
        
        <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-center text-sm text-gray-500">
            Tidak ditemukan
        </div>
    </div>
</div>
