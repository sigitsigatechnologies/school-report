{{-- <table class="w-full text-sm border border-black mt-4">
    <thead>
        <tr>
            <th class="p-2 border text-left">Kategori</th>
            @foreach ($mapels as $nama)
                <th class="p-2 border text-center">{{ $nama }}</th>
            @endforeach
            <th class="p-2 border text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach (['rata' => 'Rata-Rata', 'max' => 'Tertinggi', 'min' => 'Terendah'] as $key => $label)
            <tr>
                <td class="p-2 border">{{ $label }}</td>
                @php $rowTotal = 0; @endphp
                @foreach ($mapels as $id => $nama)
                    @php
                        $val = $summary[$id][$key] ?? 0;
                        $rowTotal += $val;
                    @endphp
                    <td class="p-2 border text-center">{{ $val }}</td>
                @endforeach
                <td class="p-2 border text-center font-semibold">{{ $rowTotal }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="w-full overflow-x-auto mt-6">
    <table class="w-full min-w-full table-fixed border border-gray-300 rounded-xl shadow-sm text-sm text-gray-700">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left font-semibold text-gray-900 w-48">Kategori</th>
                @foreach ($mapels as $nama)
                    <th class="px-4 py-2 text-center font-semibold text-gray-900 w-32">{{ $nama }}</th>
                @endforeach
                <th class="px-4 py-2 text-center font-semibold text-gray-900 w-32">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach (['rata' => 'Rata-Rata', 'max' => 'Tertinggi', 'min' => 'Terendah'] as $key => $label)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 font-medium text-left">{{ $label }}</td>
                    @php $rowTotal = 0; @endphp
                    @foreach ($mapels as $id => $nama)
                        @php
                            $val = $summary[$id][$key] ?? 0;
                            $rowTotal += $val;
                        @endphp
                        <td class="px-4 py-2 text-center">{{ $val }}</td>
                    @endforeach
                    <td class="px-4 py-2 text-center font-semibold text-blue-700">{{ $rowTotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
