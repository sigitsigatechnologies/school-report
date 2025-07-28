<table class="table-auto w-full text-sm border border-gray-300">
    <thead class="bg-blue-100 text-left">
        <tr>
            <th class="border p-1">No</th>
            <th class="border p-1">Nama</th>
            @foreach ($mapels as $mapel)
                <th class="border p-1">{{ $mapel }}</th>
            @endforeach
            <th class="border p-1">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                <td class="border p-1">{{ $row['no'] }}</td>
                <td class="border p-1">{{ $row['nama'] }}</td>
                @foreach ($mapels as $mapel)
                    <td class="border p-1 text-center">
                        {{ $row['nilai'][$mapel] ?? '-' }}
                    </td>
                @endforeach
                <td class="border p-1 text-center">{{ $row['jumlah'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot class="bg-blue-100">
        <tr>
            <td colspan="2" class="border p-1 font-semibold">Nilai Rata-Rata</td>
            @foreach ($mapels as $mapel)
                <td class="border p-1 text-center">{{ $footer[$mapel]['rata'] ?? '-' }}</td>
            @endforeach
            <td class="border p-1 text-center">{{ round($rows->avg('jumlah'), 2) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="border p-1 font-semibold">Nilai Tertinggi</td>
            @foreach ($mapels as $mapel)
                <td class="border p-1 text-center">{{ $footer[$mapel]['max'] ?? '-' }}</td>
            @endforeach
            <td class="border p-1 text-center">{{ $rows->max('jumlah') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="border p-1 font-semibold">Nilai Terendah</td>
            @foreach ($mapels as $mapel)
                <td class="border p-1 text-center">{{ $footer[$mapel]['min'] ?? '-' }}</td>
            @endforeach
            <td class="border p-1 text-center">{{ $rows->min('jumlah') }}</td>
        </tr>
    </tfoot>
</table>
