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
            font-size: 14px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        tr,
        td,
        th {
            page-break-inside: avoid;
            /* cegah baris pecah */
            page-break-after: auto;
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
        style="position: fixed; top: 50%; left: 50%; transform: translate(-60%, -50%); opacity: 0.2; width: 470px; z-index: -1;">
    {{-- HEADER --}}
    <div class="judul">
        {{ $header->header_name_project ?? 'Judul Projek Tidak Ditemukan' }}
    </div>

    <table class="info-table">
        <tr>
            <td>Nama Peserta Didik</td>
            <td>: {{ $student->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $studentClassroom->classroom->name?? '-' }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $student->nisn }}</td>
            <td>Fase</td>
            <td>: {{$firstDetail->projectDetail->project->detail->header->fase ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td>
            <td>: {{ $schoolProfile->nama_sekolah }}</td>
            <td>TA</td>
            <td>: {{ $academicYear ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat Sekolah</td>
            <td colspan="3">{{ $schoolProfile->alamat }}</td>
        </tr>
    </table>

    @foreach ($groupedDetails as $projectDetailId => $projectDetails)
        @php
            $firstDetail = $projectDetails->first();
            $projectDetail = $firstDetail->projectDetail;
            $project = $projectDetail?->project;
            $header = $project?->detail?->header ?? null;
        @endphp

        @if (!$projectDetail || !$project)
            <p style="color: red;">Data project tidak lengkap untuk project_detail_id: {{ $projectDetailId }}</p>
            @continue
        @endif

        {{-- JUDUL + DESKRIPSI --}}
        {{-- <pre style="font-size:10px; white-space: pre-wrap; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc;">
        {{ json_encode($project->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
    </pre> --}}
        <table>
            <tr>
                <td><strong>PROJEK {{ $loop->iteration }}:</strong></td>
                <td><strong>{{ $project->detail->title ?? '-' }}</strong></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="text-align:justify;  vertical-align:middle;">
                    {{ $project->detail->description ?? 'Deskripsi belum tersedia' }}</td>
            </tr>
        </table>

        {{-- TABEL NILAI --}}
        <div class="keep-together">
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
                        @php $bobot = $detail->parameterPenilaian->bobot ?? ''; @endphp
                        <tr>
                            <td style="text-align:justify;  vertical-align:middle;">
                                {{ $detail->capaianFase->subElement->element->dimension->name ?? '-' }}</td>
                            <td style="text-align:justify;  vertical-align:middle;">
                                {{ $detail->capaianFase->subElement->element->name ?? '-' }}</td>
                            <td style="text-align:justify;  vertical-align:middle;">
                                {{ $detail->capaianFase->description ?? '-' }}</td>
                            <td style="text-align:center;  vertical-align:middle;" class="center">
                                {{ $bobot === 'BB' ? 'V' : '' }}</td>
                            <td style="text-align:center;  vertical-align:middle;" class="center">
                                {{ $bobot === 'MB' ? 'V' : '' }}</td>
                            <td style="text-align:center;  vertical-align:middle;" class="center">
                                {{ $bobot === 'BSH' ? 'V' : '' }}</td>
                            <td style="text-align:center;  vertical-align:middle;" class="center">
                                {{ $bobot === 'SB' ? 'V' : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- CATATAN --}}
        @php $catatan = $projectDetails->first()?->note_project ?? "-"; @endphp
        @if ($catatan)
            <div class="catatan-box" style="text-align:justify;  vertical-align:middle;">
                <strong>Catatan Proses:</strong>
                <p>{{ $catatan }}</p>
            </div>
        @endif

        {{-- @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif --}}

        {{-- @if (!$loop->last && $projectDetails->count() > 3)
            <div style="page-break-after: always;"></div>
        @endif --}}
    @endforeach


    {{-- Keterangan --}}
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
                <td style="text-align:justify;  vertical-align:middle;">Belum Berkembang</td>
                <td style="text-align:justify;  vertical-align:middle;">Mulai Berkembang</td>
                <td style="text-align:justify;  vertical-align:middle;">Berkembang Sesuai Harapan</td>
                <td style="text-align:justify;  vertical-align:middle;">Sangat Berkembang</td>
            </tr>
            <tr>
                <td style="text-align:justify;  vertical-align:middle;">Siswa masih membutuhkan bimbingan</td>
                <td style="text-align:justify;  vertical-align:middle;">Siswa mulai mengembangkan kemampuan</td>
                <td style="text-align:justify;  vertical-align:middle;">Siswa berkembang sesuai harapan</td>
                <td style="text-align:justify;  vertical-align:middle;">Siswa melebihi harapan</td>
            </tr>
        </tbody>
    </table>

    {{-- <pre style="font-size:10px; white-space: pre-wrap; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc;">
    {{ json_encode($student->wali->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
</pre> --}}

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
