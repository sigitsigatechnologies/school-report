<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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

        .info-table td {
            padding: 1px;
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
            font-size: 11px;
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
        /* .info-table td {
            padding: 2px 4px;
            font-size: 11px;
        } */
    </style>

<img src="{{ public_path('images/logo_bopkri.png') }}" 
style="position: fixed; top: 30%; left: 25%; opacity: 0.1; width: 400px; z-index: -1;">
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
            <td>: SD BOPKRI Turen</td>
            <td>Tahun Ajaran</td>
            <td>: {{ $rapor->studentClassroom->academicYear->tahun_ajaran ?? '—' }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td>: Jalan Merdeka No. 17</td>
            <td>Fase</td>
            <td>: {{$rapor->project}}</td>
        </tr>
    </table>

    <table class="score-table">
        <thead>
            <tr>
                <th style="width: 3%; text-align:center">No.</th>
                <th style="width: 25%; text-align:center">Muatan Pelajaran</th>
                <th style="width: 8%; text-align:center">Nilai Akhir</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rapor->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->masterMateri->mata_pelajaran ?? '—' }}</td>
                    <td style="text-align: center">{{ $detail->nilai ?? '—' }}</td>
                    <td>{{ $detail->capaian_kompetensi ?? '—' }}</td>
                </tr>
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
        <tr>
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
        <tr>
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
        <tr>
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

        $naikKelas = $rapor->naik_kelas; // nilai: 0 (lulus) atau angka kelas
        $kelasSekarang = (int) $rapor->studentClassroom->classroom->name;

        if ($naikKelas === 0) {
            // Lulus (misalnya dari kelas 6 ke lulus)
            $status = 'Lulus';
            $output = $status;
        } else {
            $romawi = romawi($naikKelas);
            if ($naikKelas === $kelasSekarang) {
                // Tidak naik / tinggal kelas
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
        <tr>
            <td style="width: 33%;">
                Mengetahui:<br>
                Orang Tua / Wali<br><br><br><br>
                <strong>{{ $rapor->studentClassroom->student->nama_ayah }}</strong>
            </td>

            <td style="width: 33%; text-align: center;">
                Mengetahui,<br>
                Kepala Sekolah<br><br><br><br>
                <strong>Suparman, M.Pd.</strong><br>
                <strong>NIP 123456789</strong>
            </td>

            <td style="width: 33%; text-align: right;">
                Bantul, {{ $tanggalHariIni }}<br>
                Wali Kelas,<br><br><br><br>
                @if ($waliKelas)
                    <strong>{{ $waliKelas->name }}</strong><br>
                    <strong>NIP {{ $waliKelas->nip }}</strong>
                @else
                    <strong>...................</strong><br>
                    <strong>NIP ...................</strong>
                @endif
            </td>
        </tr>
    </table>



    </body>

</html>
