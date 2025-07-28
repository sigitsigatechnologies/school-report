@props(['name', 'value', 'options'])

<div class="flex justify-center items-center gap-4 text-xs">
    @foreach ($options as $key => $label)
        <label class="flex flex-col items-center gap-1 cursor-pointer">
            <input
                type="radio"
                name="{{ $name }}"
                value="{{ $key }}"
                wire:model.defer="data.{{ $name }}"
                class="text-orange-500"
            >
            <span class="mt-1">{{ $label }}</span>
        </label>
    @endforeach
</div>

{{-- @props(['name', 'value' => null, 'options' => [], 'readonly' => false]) --}}

{{-- <div class="flex gap-1 justify-center"> --}}
    {{-- @foreach ($options as $optionValue => $label) --}}
        {{-- <label class="flex items-center space-x-1"> --}}
            {{-- <input 
                type="radio"
                name="{{ $name }}"
                wire:model.defer="data.{{ $name }}" {{-- PENTING --}}
                {{-- value="{{ $optionValue }}" --}}
                {{-- @if($readonly) disabled @endif --}}
            {{-- >
            <span class="text-xs">{{ $label }}</span>
        </label> --}}
    {{-- @endforeach --}}
{{-- </div> --}}
