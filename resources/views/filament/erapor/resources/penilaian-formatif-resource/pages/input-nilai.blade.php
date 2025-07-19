<x-filament::page>
    {{-- Informasi Umum --}}
    <div class="mb-6">
        <x-filament::card>
            <div class="text-sm text-gray-700 space-y-1">
                <div><strong>Kelas:</strong> {{ $record->masterMateri->classroom->name }}</div>
                <div><strong>Mata Pelajaran:</strong> {{ $record->masterMateri->mata_pelajaran }}</div>
                <div><strong>Semester:</strong> {{ $record->semester }}</div>
            </div>
        </x-filament::card>
    </div>

    {{-- Form Input Nilai --}}
    <form wire:submit.prevent="save">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <x-heroicon-m-academic-cap class="w-6 h-6 text-primary-600" />
            Penilaian Formatif
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="border px-4 py-2 text-center w-10">No</th>
                        <th class="border px-4 py-2 text-left w-40">Siswa</th>
                        @foreach ($tps as $tp)
                            <th class="border px-4 py-2 text-center whitespace-normal break-words max-w-[180px]">
                                {{ $tp->tp_name }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center text-gray-600">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 font-medium text-gray-800">
                                {{ $student->nama }}
                            </td>
                            @foreach ($tps as $tp)
                                <td class="border px-2 py-1 text-center">
                                    <input
                                        type="number"
                                        wire:model.defer="nilai.{{ $student->id }}.{{ $tp->id }}"
                                        class="w-full border-gray-300 rounded-md text-center text-sm focus:border-primary-500 focus:ring-primary-500"
                                        step="0.01"
                                    />
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        
        
        <div class="mt-6">
            <x-filament::button type="submit" icon="heroicon-m-check-circle">
                Simpan Nilai
            </x-filament::button>
        </div>
        
    </form>
</x-filament::page>
