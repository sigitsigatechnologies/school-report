<!DOCTYPE html>
<html>
<head>
    <title>Print Nilai Proyek</title>
    <style>
        body { font-family: sans-serif; }
        .badge { padding: 4px 8px; border-radius: 8px; color: white; font-size: 12px; }
        .SB { background-color: #065f46; }
        .BSH { background-color: #1e40af; }
        .MB { background-color: #9a3412; }
        .BB { background-color: #991b1b; }
    </style>
</head>
<body onload="window.print()">
    <h2>Nilai Proyek: {{ $score->project->title_project }}</h2>
    <p>Kelas: {{ $score->project->detail->header->classroom->name ?? '-' }}</p>
    <p>Tahun Ajaran: {{ $score->project->detail->header->tahun_ajaran ?? '-' }}</p>
    <p>Fase: {{ $score->project->detail->header->fase ?? '-' }}</p>

    <hr>

    @foreach ($score->details->groupBy('student_id') as $studentId => $details)
        <h4>{{ $details->first()->student->nama }}</h4>
        <ul>
            @foreach ($details as $detail)
                <li>
                    <strong>{{ $detail->capaianFase->description }}:</strong>
                    <span class="badge {{ $detail->parameterPenilaian->bobot ?? '' }}">
                        {{ $detail->parameterPenilaian->keterangan ?? '-' }}
                    </span>
                </li>
            @endforeach
        </ul>
        @if($details->first()->note_project)
            <p><strong>Catatan:</strong> {{ $details->first()->note_project }}</p>
        @endif
        <hr>
    @endforeach
</body>
</html>
