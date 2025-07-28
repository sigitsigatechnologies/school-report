<table>
    <tr>
        <td colspan="6" style="font-weight: bold;">LAPORAN HASIL BELAJAR</td>
    </tr>
    <tr>
        <td>Nama Peserta Didik:</td>
        <td>{{ $rapor->studentClassroom->student->nama }}</td>
        <td>Kelas:</td>
        <td>{{ $rapor->studentClassroom->classroom->name }}</td>
    </tr>
    <tr>
        <td>NISN:</td>
        <td>{{ $rapor->studentClassroom->student->nisn }}</td>
        <td>Semester:</td>
        <td>{{ $rapor->semester }}</td>
    </tr>
    <tr>
        <td>Nama Sekolah:</td>
        <td>SD BOPKRI Turen</td>
        <td>Tahun Ajaran:</td>
        <td>{{ $rapor->studentClassroom->academicYear->name }}</td>
    </tr>
    <tr>
        <td>Alamat Sekolah:</td>
        <td>Jalan Merdeka No. 17</td>
        <td>Fase:</td>
        <td>{{ $rapor->studentClassroom->fase }}</td>
    </tr>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Muatan Pelajaran</th>
            <th>Nilai Akhir</th>
            <th>Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rapor->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->masterMateri->mata_pelajaran }}</td>
                <td>{{ $detail->nilai }}</td>
                <td>—</td> {{-- Bisa isi capaian kalau ada --}}
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th colspan="3">Ekstrakurikuler</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ekstrakurikuler as $i => $ekstra)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ekstra->nama }}</td>
                <td>{{ $ekstra->pivot->deskripsi ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th colspan="3">Tinggi dan Berat Badan</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Aspek yang diukur</th>
            <th>Semester {{ $rapor->semester }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Tinggi Badan</td>
            <td>{{ $kesehatanAbsensi->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Berat Badan</td>
            <td>{{ $kesehatanAbsensi->berat_badan }} kg</td>
        </tr>
    </tbody>
</table>

<br>

<table border="1">
    <thead>
        <tr>
            <th colspan="2">Ketidakhadiran</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tanpa Keterangan:</td>
            <td>{{ $kesehatanAbsensi->tanpa_keterangan }} hari</td>
        </tr>
        <tr>
            <td>Sakit:</td>
            <td>{{ $kesehatanAbsensi->sakit }} hari</td>
        </tr>
        <tr>
            <td>Izin:</td>
            <td>{{ $kesehatanAbsensi->izin }} hari</td>
        </tr>
    </tbody>
</table>

<br>

<table border="1">
    <tr>
        <th>Saran:</th>
    </tr>
    <tr>
        <td>{{ $kesehatanAbsensi->catatan ?? '-' }}</td>
    </tr>
</table>
