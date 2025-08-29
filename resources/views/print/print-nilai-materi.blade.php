<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 30px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .info-table {
            font-size: 12px;
        }

        .info-table td {
            padding: 1px;
            border: none;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        th {
            text-align: center;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .score-table th,
        .score-table td {
            border: 1px solid black;
            padding: 4px;
            vertical-align: top;
        }

        .score-table th {
            text-align: left;
        }

        .score-table td:first-child {
            text-align: left;
        }

        .score-table td:nth-child(3) {
            text-align: left;
        }

        thead th {
            background-color: #a8cef4;
        }

        /* .info-table td {
            padding: 2px 4px;
            font-size: 11px;
        } */
    </style>

    <img src="{{ public_path('images/logo_bopkri.png') }}"
        style="position: fixed; top: 50%; left: 50%; transform: translate(-60%, -50%);
           opacity: 0.1; width: 470px; z-index: -1;">
    <div class="title">LAPORAN HASIL BELAJAR</div>

    <table class="info-table">
        <tr>
            <td>Nama Peserta Didik
            <td>: {{ $rapor->studentClassroom->student->nama ?? '—' }} </td>
            <td>Kelas</td>
            <td>: {{ $rapor->studentClassroom->classroom->class_abjad ?? '—' }}</td>
        </tr>
        <tr>
            <td>NISN </td>
            <td>: {{ $rapor->studentClassroom->student->nisn }}</td>
            <td>Semester</td>
            <td>: {{ $rapor->studentClassroom->academicYear->semester ?? '—' }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>: {{ $schoolProfile->nama_sekolah }}</td>
            <td>Tahun Ajaran</td>
            <td>: {{ $rapor->studentClassroom->academicYear->tahun_ajaran ?? '—' }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td>: {{ $schoolProfile->alamat }}</td>
            <td>Fase</td>
            <td>: {{ $schoolProfile->fase }}</td>
        </tr>
    </table>

    <table class="score-table">
        <thead>
            <tr>
                <th style="width: 3%; text-align:center; vertical-align:middle;">No.</th>
                <th style="width: 25%; text-align:center;  vertical-align:middle;">Muatan Pelajaran</th>
                <th style="width: 8%; text-align:center;  vertical-align:middle;">Nilai Akhir</th>
                <th style="text-align:center;  vertical-align:middle;">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($rapor->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->masterMateri->mata_pelajaran ?? '—' }}</td>
                    <td style="text-align: center">{{ $detail->nilai ?? '—' }}</td>
                    <td>{{ $detail->capaian_kompetensi ?? '—' }}</td>
                </tr>
            @endforeach --}}

            @php
                $grouped = $rapor->details
                    // filter kategori Sains biar hanya Kimia
                    ->filter(function ($item) {
                        if ($item->masterMateri->kategori?->nama === 'Sains') {
                            return $item->masterMateri->mata_pelajaran === 'Kimia';
                        }
                        return true; // kategori lain biarin
                    })
                    ->groupBy(fn($item) => $item->masterMateri->kategori?->nama);

                $no = 1;
            @endphp

            @foreach ($grouped as $kategoriNama => $details)
                @if ($kategoriNama)
                    <tr>
                        <td colspan="4"><strong>{{ $kategoriNama }}</strong></td>
                    </tr>
                @endif

                @foreach ($details as $detail)
                    <tr>
                        <td style="text-align:center; vertical-align:middle;">{{ $no++ }}</td>
                        <td style="text-align:justify; vertical-align:middle;">
                            {{ $detail->masterMateri->mata_pelajaran }}</td>
                        <td style="text-align:center; vertical-align:middle;">{{ $detail->nilai }}</td>
                        <td style="text-align:justify; ">{{ $detail->capaian_kompetensi ?? '—' }}</td>
                    </tr>
                @endforeach
            @endforeach


        </tbody>
    </table>

    <h4>Ekstrakurikuler</h4>
    <table class="score-table">
        <thead>
            <tr>
                <th style="width: 3%;">No.</th>
                <th style="width: 25%;">Nama</th>
                <th style="width: 80%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ekstrakurikuler as $ekstra)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ekstra->extracurricular->name ?? '-' }}</td>
                    <td>{{ $ekstra->deskripsi ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada ekstrakurikuler</td>
                </tr>
            @endforelse
        </tbody>

    </table>


    <h4>Tinggi dan Berat Badan</h4>
    <table class="score-table" style="width: 60%;">
        <tr style="background-color: #a8cef4;">
            <th style="width: 3%;">No.</th>
            <th style="width: 25%;">Aspek yang diukur</th>
            <th style="width: 10%;">Semester {{ $rapor->studentClassroom->academicYear->semester ?? '—' }}</th>
        </tr>
        <tr>
            <td>1</td>
            <td><strong>Tinggi Badan:</strong></td>
            <td style="width: 10%;">{{ $kesehatanAbsensi->tinggi_badan ?? '-' }} cm</td>
        </tr>
        <tr>
            <td>2</td>
            <td><strong>Berat Badan:</strong></td>
            <td>{{ $kesehatanAbsensi->berat_badan ?? '-' }} kg</td>
        </tr>
    </table>


    <h4>Ketidakhadiran</h4>
    <table class="score-table" style="width: 40%;">
        <tr style="background-color: #a8cef4;">
            <td><strong>Tanpa Keterangan:</strong></td>
            <td style="width: 20%;">{{ $kesehatanAbsensi->tanpa_keterangan ?? 0 }} hari</td>
        </tr>
        <tr>
            <td><strong>Sakit:</strong></td>
            <td>{{ $kesehatanAbsensi->sakit ?? 0 }} hari</td>
        </tr>
        <tr>
            <td><strong>Izin:</strong></td>
            <td>{{ $kesehatanAbsensi->ijin ?? 0 }} hari</td>
        </tr>
    </table>

    <h4></h4>
    <table class="score-table">
        <tr style="background-color: #a8cef4;">
            <td style="text-align: center;"><strong>Saran:</strong></td>
        </tr>
        <tr>
            <td>{{ $kesehatanAbsensi->saran ?? '-' }}</td>
        </tr>

    </table>

    <br><br>

    @php
        function romawi($num)
        {
            $map = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI'];
            return $map[$num] ?? '';
        }

        $naikKelas = $rapor->naik_kelas; // bisa null / kosong
        $kelasSekarang = (int) ($rapor->studentClassroom->classroom->name ?? 0);
        // dd("Kelas naik :",$naikKelas);
        // dd("kelas sekarang :",$kelasSekarang);
        if (is_null($naikKelas)) {
            // Belum diisi
            $output = 'Naik/Tinggal) kelas ........';
        } elseif ($naikKelas === 0) {
            $output = 'Lulus';
        } else {
            $romawi = romawi($naikKelas);
            // dd('masok', $naikKelas, $kelasSekarang);
            if ($naikKelas == $kelasSekarang) {
                // Tinggal kelas
                $output = '<s>Naik</s>/Tinggal*) kelas ' . $naikKelas . ' (' . $romawi . ')';
            } else {
                // Naik kelas
                $output = 'Naik/<s>Tinggal</s>*) kelas ' . $naikKelas . ' (' . $romawi . ')';
            }
        }
    @endphp


    <table style="width: 100%; font-size: 12px;">
        <tr>
            <td colspan="2" style="border: 1px solid black; padding: 10px;">
                <strong>Keputusan:</strong><br>
                Berdasarkan pencapaian seluruh kompetensi, peserta didik dinyatakan:<br><br>
                {!! $output !!}<br><br>
                <small>*) Coret yang tidak perlu</small>
            </td>
        </tr>
    </table>



    <br><br><br>
    @php
        use Carbon\Carbon;
        $tanggalHariIni = Carbon::now()->locale('id')->translatedFormat('d F Y');
    @endphp
    <table style="width: 100%; font-size: 12px; margin-top: 40px;">
        <tr style="text-align:center;  vertical-align:middle;">
            <td style="width: 33%;">
                Mengetahui:<br>
                Orang Tua / Wali<br><br><br><br>
                <strong>{{ $rapor->studentClassroom->student->nama_ayah }}</strong>
            </td>

            <td style="width: 33%; text-align: center;">
                Mengetahui,<br>
                Kepala Sekolah<br><br><br><br>
                <strong>{{ $schoolProfile->kepala_sekolah ?? '-' }}</strong><br>
                <strong>{{ $schoolProfile->nip_kepala_sekolah ?? '-' }}</strong>
            </td>

            <td style="width: 33%; text-align:center;  vertical-align:middle;">
                Bantul, {{ $tanggalHariIni }}<br>
                Wali Kelas,<br><br><br><br>
                @if ($waliKelas)
                    <strong>{{ $waliKelas->name }}</strong><br>
                    <strong>NIY {{ $waliKelas->nip }}</strong>
                @else
                    <strong>...................</strong><br>
                    <strong>NIY ...................</strong>
                @endif
            </td>
        </tr>
    </table>
    </body>

</html>
