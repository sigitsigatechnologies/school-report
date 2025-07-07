<div class="flex items-center gap-2">
    <span class="text-xs font-semibold">{{ $student->nama }}</span>

    <button
        type="button"
        class="text-xs text-gray-500 underline"
        x-on:click="$wire.emit('openNoteModal', {{ $projectScoreId }}, {{ $student->id }}, null)"
    >
        Catatan
    </button>
</div>
