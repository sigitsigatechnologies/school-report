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
