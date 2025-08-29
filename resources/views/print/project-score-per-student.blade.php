<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rapor Projek P5</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            font-size: 12px;
        }

        th {
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 2px;
        }

        .catatan-box {
            border: 1px solid #000;
            padding: 6px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .signature {
            text-align: center;
            margin-top: 50px;
        }

        .nilai-table td {
            font-size: 12px;
        }

        .nilai-table td.center {
            text-align: center;
        }

        .info-table td {
            padding: 2px 4px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <img src="{{ public_path('images/logo_bopkri.png') }}"
        style="position: fixed; top: 50%; left: 50%; transform: translate(-60%, -50%);
           opacity: 0.5; width: 470px; z-index: -1;">

    <div class="judul">
        {{ $score->project->detail->header->header_name_project }}
    </div>

    {{-- Header Siswa --}}
    <table class="info-table">
        <tr>
            <td>Nama Peserta Didik</td>
            <td>: {{ $student->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $score->project->detail->header->classroom->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $student->nisn }}</td>
            <td>Fase</td>
            <td>: {{ $score->project->detail->header->fase ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>: {{ $schoolProfile->nama_sekolah }}</td>
            <td>TA</td>
            <td>: {{ $score->project->academicYear->tahun_ajaran ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td colspan="3">: {{ $schoolProfile->alamat }}</td>
        </tr>
    </table>

    {{-- LOOP PROJECT DESKRIPSI --}}

    {{-- Debug Mode untuk melihat isi groupedDetails --}}

    @foreach ($groupedDetails as $projectTitle => $details)
        <br>
        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-bottom: 6px;">
            <tr>
                <td style="font-weight: bold; border: 1px solid #000; padding: 4px;">
                    PROJEK {{ $loop->iteration }} :
                </td>
                <td style="font-weight: bold; border: 1px solid #000; padding: 4px;">
                    {{ $score->project->detail->title }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; margin-bottom: 12px;">
            <tr>
                <td style="padding: 6px; border: 1px solid #000;">
                    {{ $score->project->detail->description ?? 'Deskripsi projek belum tersedia.' }}
                </td>
            </tr>
        </table>
    @endforeach


    {{-- Loop Projek --}}
    @foreach ($groupedDetails as $projectTitle => $projectDetails)
        <strong>Projek {{ $loop->iteration }}:</strong>
        {{-- <u>{{ $student }}</u> --}}
        <p>{{ $score->project->detail->title ?? 'Deskripsi projek belum tersedia.' }}</p>

        <table class="nilai-table">
            <thead>
                <tr>
                    <th>Dimensi</th>
                    <th>Elemen</th>
                    <th>Sub Elemen / Capaian</th>
                    <th>BB</th>
                    <th>MB</th>
                    <th>BSH</th>
                    <th>SB</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectDetails as $detail)
                    @php
                        $bobot = $detail->parameterPenilaian->bobot ?? '';
                    @endphp
                    <tr>
                        <td style="text-align:justify;  vertical-align:middle;">{{ $detail->capaianFase->subElement->element->dimension->name ?? '-' }}</td>
                        <td style="text-align:justify;  vertical-align:middle;">{{ $detail->capaianFase->subElement->element->name ?? '-' }}</td>
                        <td style="text-align:justify;  vertical-align:middle;">{{ $detail->capaianFase->description ?? '-' }}</td>
                        <td style="text-align:center;  vertical-align:middle;" class="center">{{ $bobot === 'BB' ? 'V' : '' }}</td>
                        <td style="text-align:center;  vertical-align:middle;" class="center">{{ $bobot === 'MB' ? 'V' : '' }}</td>
                        <td style="text-align:center;  vertical-align:middle;" class="center">{{ $bobot === 'BSH' ? 'V' : '' }}</td>
                        <td style="text-align:center;  vertical-align:middle;" class="center">{{ $bobot === 'SB' ? 'V' : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Catatan Proses --}}
        @php $catatan = $projectDetails->first()?->note_project ?? '-'; @endphp
        @if ($catatan)
            <div class="catatan-box">
                <strong>Catatan Proses:</strong>
                <p>{{ $catatan }}</p>
            </div>
        @endif

        {{-- Break page jika bukan terakhir --}}
        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach

    {{-- Keterangan BB MB BSH SB --}}
    <br>
    <strong>KETERANGAN TINGKAT PENCAPAIAN SISWA</strong>
    <table>
        <thead>
            <tr>
                <th>BB</th>
                <th>MB</th>
                <th>BSH</th>
                <th>SB</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Belum Berkembang</td>
                <td>Mulai Berkembang</td>
                <td>Berkembang Sesuai Harapan</td>
                <td>Sangat Berkembang</td>
            </tr>
            <tr>
                <td>Siswa masih membutuhkan bimbingan</td>
                <td>Siswa mulai mengembangkan kemampuan</td>
                <td>Siswa berkembang sesuai harapan</td>
                <td>Siswa melebihi harapan</td>
            </tr>
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <table class="signature" width="100%">
        <tr>
            <td>Mengetahui,<br>Orang Tua</td>
            <td>Bantul, {{ now()->translatedFormat('d F Y') }}<br>Wali Kelas</td>
            <td>Mengetahui,<br>Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="padding-top: 60px;">{{ $student->nama_ayah ?? '-' }}</td>
            <td style="padding-top: 60px;">
                {{ $wali->name ?? '-' }}<br>
                NIY {{ $wali->nip ?? '-' }}<br>
            </td>
            <td style="padding-top: 60px;">
                {{ $schoolProfile->kepala_sekolah }}<br>
                NIY {{ $schoolProfile->nip_kepala_sekolah }}
            </td>
        </tr>
    </table>
</body>

</html>
