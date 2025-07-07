<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament::page>
