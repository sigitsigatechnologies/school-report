@props(['keterangan'])

@php
    $value = strtoupper(trim($keterangan)); // normalisasi input biar aman

    $map = [
        'SB' => 'bg-green-500 text-white',
        'SANGAT BERKEMBANG' => 'bg-green-500 text-white',

        'BSH' => 'bg-blue-500 text-white',
        'BERKEMBANG SESUAI HARAPAN' => 'bg-blue-500 text-white',

        'MB' => 'bg-orange-400 text-black',
        'MULAI BERKEMBANG' => 'bg-orange-400 text-black',

        'BB' => 'bg-red-500 text-white',
        'BELUM BERKEMBANG' => 'bg-red-500 text-white',
    ];

    $warna = $map[$value] ?? 'bg-gray-300 text-black';
@endphp

<span class="px-2 py-1 rounded text-sm font-medium {{ $warna }}">
    {{ $keterangan ?? '-' }}
</span>
