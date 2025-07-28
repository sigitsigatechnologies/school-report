<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Ringkasan Nilai per Mapel</h2>

        <table class="w-full text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1 text-left">Mapel</th>
                    <th class="border px-2 py-1 text-center">Rata-rata</th>
                    <th class="border px-2 py-1 text-center">Tertinggi</th>
                    <th class="border px-2 py-1 text-center">Terendah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $item)
                    <tr>
                        <td class="border px-2 py-1">{{ $item['mapel'] }}</td>
                        <td class="border px-2 py-1 text-center">{{ $item['rata'] }}</td>
                        <td class="border px-2 py-1 text-center">{{ $item['max'] }}</td>
                        <td class="border px-2 py-1 text-center">{{ $item['min'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::card>
</x-filament::widget>
