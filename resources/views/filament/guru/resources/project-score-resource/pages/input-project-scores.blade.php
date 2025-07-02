<x-filament::page>
    {{ $this->form }}

    <x-filament::button
        wire:click="submit"
        type="button"
        class="mt-4"
    >
        Simpan Penilaian
    </x-filament::button>
</x-filament::page>
