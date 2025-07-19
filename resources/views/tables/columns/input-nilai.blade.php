@php
    $recordId = $getRecord()->id;
@endphp

<input 
    type="number" 
    class="w-full text-sm border-gray-300 rounded"
    wire:model.defer="nilai.{{ $recordId }}.{{ $tp_id }}"
    step="0.01"
/>
