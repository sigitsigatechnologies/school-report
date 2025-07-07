<div class="flex flex-col items-start gap-1">
    @include('components.project-score.grid-radio-cell', [
        'name' => $name,
        'value' => $value,
        'options' => $options,
        'readonly' => $readonly,
    ])

    <button
        type="button"
        class="text-[10px] text-blue-600 underline"
        x-on:click="$wire.emit('openNoteModal', {{ $projectScoreId }}, {{ $studentId }}, {{ $capaianId }})"
    >
        Catatan
    </button>
</div>
