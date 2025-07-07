<x-filament::page>
    <div 
        x-data="{
            showNoteModal: false,
            selectedNote: '',
            selectedStudentId: null,
            selectedCapaianId: null,
            saving: false,
            async saveNote() {
                this.saving = true;
                await $wire.saveNote(this.selectedStudentId, this.selectedCapaianId, this.selectedNote);
                this.saving = false;
                this.showNoteModal = false;
            }
        }"
    >
        {{-- Info Proyek --}}
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Informasi Proyek</h2>
            <dl class="divide-y divide-gray-100 text-sm">
                <div class="flex justify-between py-2">
                    <dt class="text-gray-500">Judul Proyek:</dt>
                    <dd>{{ $record->project->title_project }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-gray-500">Sub Judul:</dt>
                    <dd>{{ $record->project->detail->title }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-gray-500">Kelas:</dt>
                    <dd>{{ $record->project->detail?->header?->classroom?->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-gray-500">Tahun Ajaran:</dt>
                    <dd>{{ $record->project->detail?->header?->tahun_ajaran ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Tabel Penilaian --}}
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Detail Penilaian</h2>

            <table class="w-full table-auto border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">Siswa</th>
                        <th class="border px-2 py-1">Capaian</th>
                        <th class="border px-2 py-1">Nilai</th>
                        <th class="border px-2 py-1">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->details as $detail)
                        <tr>
                            <td class="border px-2 py-1">{{ $detail->student->nama }}</td>
                            <td class="border px-2 py-1">{{ $detail->capaianFase->description ?? '-' }}</td>
                            <td class="border px-2 py-1">{{ $detail->parameterPenilaian->bobot ?? '-' }}</td>
                            <td class="border px-2 py-1">
                                {{ $detail->note_project ? Str::limit($detail->note_project, 25) : '-' }}

                                <x-filament::button
                                    size="xs"
                                    color="gray"
                                    class="ml-2"
                                    icon="heroicon-o-pencil"
                                    x-on:click="
                                        selectedNote = @js($detail->note_project ?? '');
                                        selectedStudentId = {{ $detail->student_id }};
                                        selectedCapaianId = {{ $detail->capaian_fase_id }};
                                        showNoteModal = true;
                                    "
                                >
                                    Catatan
                                </x-filament::button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Modal Catatan --}}
        <div 
            x-show="showNoteModal" 
            x-cloak 
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div 
                @click.away="showNoteModal = false" 
                class="bg-white rounded-xl shadow-lg max-w-md w-full p-6"
            >
                <h3 class="text-lg font-semibold mb-4">Catatan untuk Siswa</h3>

                <textarea 
                    x-model="selectedNote" 
                    class="w-full border border-gray-300 rounded-md p-2 text-sm"
                    rows="5"
                    placeholder="Tulis catatan..."
                ></textarea>

                <div class="mt-4 flex justify-end space-x-2">
                    <x-filament::button 
                        color="gray"
                        size="sm"
                        x-on:click="showNoteModal = false"
                    >
                        Batal
                    </x-filament::button>

                    <x-filament::button 
                        color="primary"
                        size="sm"
                        x-bind:disabled="saving"
                        x-on:click="saveNote()"
                    >
                        Simpan
                    </x-filament::button>

                </div>
            </div>
        </div>
    </div>
</x-filament::page>
