<?php

namespace App\Filament\Erapor\Resources\PenilaianSumatifResource\RelationManagers;

use App\Models\MasterUnitMateri;
use App\Models\PenilaianSumatifDetail;
use App\Models\Student;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->options(function () {
                        $guruId = auth()->id();
                        $penilaian = $this->getOwnerRecord(); // PenilaianSumatif

                        if (!$penilaian || !$penilaian->masterMateri) {
                            return [];
                        }

                        $classroomId = $penilaian->masterMateri->classroom_id;

                        // Pastikan guru hanya melihat siswa dari kelas yg dia ampu
                        $allowedClassroomIds = DB::table('classroom_guru')
                            ->where('guru_id', $guruId)
                            ->pluck('classroom_id')
                            ->toArray();

                        if (!in_array($classroomId, $allowedClassroomIds)) {
                            return [];
                        }

                        return \App\Models\Student::where('classroom_id', $classroomId)
                            ->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required(),


                Forms\Components\Select::make('master_unit_materi_id')
                    ->relationship('masterUnitMateri', 'unit_materi')
                    ->required(),

                Forms\Components\TextInput::make('nilai')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {

        $penilaianSumatif = $this->getOwnerRecord();
        // $students = Student::whereHas('classroom', function ($q) use ($penilaianSumatif) {
        //     $q->where('id', $penilaianSumatif->masterMateri->classroom_id ?? null);
        // })->get();

        $units = MasterUnitMateri::where('master_materi_id', $penilaianSumatif->master_materi_id)->get();

        return $table
            ->heading("Nilai Siswa per Unit Materi")
            ->columns(array_merge(
                [
                    TextColumn::make('nama')->label('Siswa')->getStateUsing(fn($record) => $record->nama),
                ],
                $units->map(function ($unit) use ($penilaianSumatif) {
                    return TextColumn::make("unit_{$unit->id}")
                        ->label($unit->unit_materi)
                        ->getStateUsing(function ($record) use ($unit, $penilaianSumatif) {
                            return \App\Models\PenilaianSumatifDetail::where([
                                'penilaian_sumatif_id' => $penilaianSumatif->id,
                                'student_id' => $record->id,
                                'master_unit_materi_id' => $unit->id,
                            ])->value('nilai') ?? '-';
                        })->extraAttributes([
                            'style' => 'background-color:rgb(180, 221, 248);', // biru muda
                        ]);
                })->toArray(),
                [
                    TextColumn::make('rata_rata_unit')
                        ->label('NA Sumatif Lingkup Materi')
                        ->getStateUsing(function ($record) use ($penilaianSumatif) {
                            $nilaiList = \App\Models\PenilaianSumatifDetail::where('penilaian_sumatif_id', $penilaianSumatif->id)
                                ->where('student_id', $record->id)
                                ->whereNotNull('nilai') // hanya ambil nilai yang ada
                                ->pluck('nilai')
                                ->toArray();

                            if (count($nilaiList) === 0) return '-';

                            $avg = array_sum($nilaiList) / count($nilaiList);
                            return number_format($avg, 2);
                        })->extraAttributes([
                            'style' => 'background-color:rgb(124, 196, 244);', // biru muda
                        ]),

                    TextColumn::make('nilai_tes')
                        ->label('Tes')
                        ->getStateUsing(function ($record) use ($penilaianSumatif) {
                            $detail = \App\Models\PenilaianSumatifDetail::where([
                                'penilaian_sumatif_id' => $penilaianSumatif->id,
                                'student_id' => $record->id,
                            ])->first();

                            return $detail?->tesDetails->first()?->nilai_tes ?? '-';
                        })->extraAttributes([
                            'style' => 'background-color: rgb(131, 247, 168);', // biru muda
                        ]),

                    TextColumn::make('nilai_non_tes')
                        ->label('Non Tes')
                        ->getStateUsing(function ($record) use ($penilaianSumatif) {
                            $detail = \App\Models\PenilaianSumatifDetail::where([
                                'penilaian_sumatif_id' => $penilaianSumatif->id,
                                'student_id' => $record->id,
                            ])->first();

                            return $detail?->tesDetails->first()?->nilai_non_tes ?? '-';
                        })->extraAttributes([
                            'style' => 'background-color:rgb(131, 247, 168);', // biru muda
                        ]),
                    TextColumn::make('summary')
                        ->label('NA Sumatif Akhir Semester')
                        ->getStateUsing(function ($record) use ($penilaianSumatif) {
                            $tes = \App\Models\PenilaianTesDetail::whereHas('detail', function ($q) use ($penilaianSumatif, $record) {
                                $q->where('penilaian_sumatif_id', $penilaianSumatif->id)
                                    ->where('student_id', $record->id);
                            })->first();

                            $nilaiTes = $tes?->nilai_tes;
                            $nilaiNonTes = $tes?->nilai_non_tes;

                            $allScores = [];

                            if (!is_null($nilaiTes)) $allScores[] = $nilaiTes;
                            if (!is_null($nilaiNonTes)) $allScores[] = $nilaiNonTes;

                            if (count($allScores) === 0) return '-';

                            $avg = array_sum($allScores) / count($allScores);
                            return number_format($avg, 2);
                        })->extraAttributes([
                            'style' => 'background-color:rgb(170, 254, 153);', // biru muda
                        ]),
                        TextColumn::make('nilai_rapor')
                        ->label('Nilai Rapor')
                        ->getStateUsing(function ($record) use ($penilaianSumatif) {
                            // Ambil rata-rata unit
                            $nilaiUnit = \App\Models\PenilaianSumatifDetail::where('penilaian_sumatif_id', $penilaianSumatif->id)
                                ->where('student_id', $record->id)
                                ->whereNotNull('nilai')
                                ->pluck('nilai')
                                ->toArray();
                    
                            $avgUnit = count($nilaiUnit) > 0 ? array_sum($nilaiUnit) / count($nilaiUnit) : null;
                    
                            // Ambil tes dan non-tes untuk summary
                            $tes = \App\Models\PenilaianTesDetail::whereHas('detail', function ($q) use ($penilaianSumatif, $record) {
                                $q->where('penilaian_sumatif_id', $penilaianSumatif->id)
                                    ->where('student_id', $record->id);
                            })->first();
                    
                            $nilaiTes = $tes?->nilai_tes;
                            $nilaiNonTes = $tes?->nilai_non_tes;
                    
                            $summaryScores = [];
                            if (!is_null($nilaiTes)) $summaryScores[] = $nilaiTes;
                            if (!is_null($nilaiNonTes)) $summaryScores[] = $nilaiNonTes;
                    
                            $avgSummary = count($summaryScores) > 0 ? array_sum($summaryScores) / count($summaryScores) : null;
                    
                            // Hitung nilai rapor
                            if (!is_null($avgUnit) && !is_null($avgSummary)) {
                                return number_format(($avgUnit + $avgSummary) / 2, 2);
                            }
                    
                            return '-';
                        })->extraAttributes([
                            'style' => 'background-color:rgb(255, 255, 160); font-weight: bold;', // kuning muda
                        ]),

                ]
            ))

            ->query(
                Student::whereHas('studentClassrooms.classroom', function ($q) use ($penilaianSumatif) {
                    $q->where('id', $penilaianSumatif->masterMateri->classroom_id ?? null);
                })
            )

            ->actions([
                // ACTION INPUT NILAI
                Action::make('Input Nilai')
                    ->label('Input Nilai')
                    ->icon('heroicon-m-pencil-square')
                    ->form(fn($record) => $this->buildInputFieldsForStudent(
                        $record,
                        MasterUnitMateri::where('master_materi_id', $this->getOwnerRecord()->master_materi_id)->get()
                    ))

                    ->action(function (array $data, $record) use ($penilaianSumatif, $units) {
                        foreach ($units as $unit) {
                            PenilaianSumatifDetail::updateOrCreate([
                                'penilaian_sumatif_id' => $penilaianSumatif->id,
                                'student_id' => $record->id,
                                'master_unit_materi_id' => $unit->id,
                            ], [
                                'nilai' => $data["unit_{$unit->id}"] ?? 0,
                            ]);
                        }

                        // Ambil salah satu detail (anggap ambil yang pertama)
                        $detail = PenilaianSumatifDetail::where([
                            'penilaian_sumatif_id' => $penilaianSumatif->id,
                            'student_id' => $record->id,
                        ])->first();

                        if ($detail) {
                            \App\Models\PenilaianTesDetail::updateOrCreate([
                                'penilaian_sumatif_detail_id' => $detail->id,
                            ], [
                                'nilai_tes' => $data['nilai_tes'] ?? null,
                                'nilai_non_tes' => $data['nilai_non_tes'] ?? null,
                            ]);
                        }
                    }),

                // INPUT
            ])
            ->emptyStateHeading('Belum ada data siswa atau unit materi.')
            ->paginated(false);
    }

    protected function getRelatedStudents($record)
    {
        return Student::whereHas('studentClassrooms', function ($q) use ($record) {
            $q->where('classroom_id', $record->masterMateri->classroom_id);
        })->get();
    }


    protected function getRelatedUnits($record)
    {
        return MasterUnitMateri::where('master_materi_id', $record->master_materi_id)->get();
    }

    protected function buildInputFieldsForStudent($record, $units)
    {
        $penilaian = $this->getOwnerRecord(); // ✅ ambil PenilaianSumatif
        $penilaianId = $penilaian->id;

        $fields = $units->map(function ($unit) use ($record, $penilaianId) {
            $nilai = \App\Models\PenilaianSumatifDetail::where([
                'penilaian_sumatif_id' => $penilaianId,
                'student_id' => $record->id,
                'master_unit_materi_id' => $unit->id,
            ])->value('nilai');

            return \Filament\Forms\Components\TextInput::make("unit_{$unit->id}")
                ->label("Nilai: {$unit->unit_materi}")
                ->default($nilai)
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->dehydrated(true)
                ->required(false);
        });

        // ambil data tes detail pertama (asumsi hanya 1 per siswa per penilaian_sumatif)
        $tesDetail = \App\Models\PenilaianTesDetail::whereHas('detail', function ($q) use ($penilaianId, $record) {
            $q->where('penilaian_sumatif_id', $penilaianId)
                ->where('student_id', $record->id);
        })->first();

        $fields->push(
            \Filament\Forms\Components\TextInput::make('nilai_tes')
                ->label('Nilai Tes')
                ->default($tesDetail?->nilai_tes)
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->dehydrated(true),

            \Filament\Forms\Components\TextInput::make('nilai_non_tes')
                ->label('Nilai Non Tes')
                ->default($tesDetail?->nilai_non_tes)
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->dehydrated(true),
        );

        return $fields->toArray();
    }

    public function printNilai()
    {
        $siswa = Student::with(['penilaianSumatifDetails.masterTp', 'penilaianSumatif'])->get();

        return view('exports.nilaisummarysumatif', [
            'siswa' => $siswa,
            'mapel' => 'Bahasa Indonesia',
        ]);
    }
}
