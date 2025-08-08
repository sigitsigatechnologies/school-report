<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectScoreResource\Pages;
use App\Models\ParameterPenilaian;
use App\Models\ProjectDetail;
use App\Models\Projects;
use App\Models\ProjectScore;
use App\Models\ProjectScoreDetail;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectScoreResource extends Resource
{
    protected static ?string $model = ProjectScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Select::make('project_id')
                //     ->relationship('project', 'title_project')
                //     ->searchable()
                //     ->required()
                //     ->reactive()
                //     ->afterStateHydrated(function (callable $set, $state) {
                //         // Set project_id saat edit
                //         $set('project_id', $state);
                //     }),

                Select::make('classroom_id')
                    ->label('Pilih Kelas')
                    ->options(function () {
                        $guru = auth()->user()->guru;

                        if (!$guru) {
                            return [];
                        }

                        return $guru->classrooms()
                            ->select('classrooms.id', 'classrooms.name')
                            ->pluck('classrooms.name', 'classrooms.id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateHydrated(function (callable $set, $state, $record) {
                        // Kalau record ada (edit mode), ambil classroom_id dari project
                        if ($record && $record->project) {
                            $record->loadMissing('project.studentClassroom.classroom');
                            $set('classroom_id', $record->project->studentClassroom?->classroom_id);
                        }
                    }),

                Select::make('project_id')
                    ->label('Pilih Proyek')
                    ->options(function (callable $get) {
                        $classroomId = $get('classroom_id');
                        // dd($classroomId);
                        if (!$classroomId) {
                            return [];
                        }
                        return \App\Models\Projects::whereHas('studentClassroom', function ($query) use ($classroomId) {
                            $query->where('classroom_id', $classroomId);
                        })
                            ->pluck('title_project', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateHydrated(fn(callable $set, $state) => $set('project_id', $state)),


                Section::make('Informasi Proyek')
                    ->schema(function (callable $get) {
                        $projectId = $get('project_id');
                        if (!$projectId) return [];

                        $project = Projects::with('detail.header.classroom')->find($projectId);
                        $classroom = $project?->detail?->header?->classroom;
                        $tahunAjaran = $classroom?->studentClassrooms->first()?->academicYear?->tahun_ajaran ?? '-';
                        return [
                            Placeholder::make('judul')
                                ->label('Judul ' . $project?->title_project ?? '-')
                                ->content($project?->title_project ?? '-'),


                            Placeholder::make('deskripsi')->label('Deskripsi')->content($project->detail->title ?? '-'),
                            Placeholder::make('kelas')
                                ->label('Kelas')
                                ->content($project?->detail?->header?->classroom?->name ?? '-'),

                            Placeholder::make('tahun_ajaran')
                                ->label('Tahun Ajaran')
                                ->content($tahunAjaran ?? '-'),

                            Placeholder::make('fase')
                                ->label('Fase')
                                ->content($project?->detail?->header?->fase ?? '-'),
                        ];
                    })
                    ->columns(2) // biar rapi 2 kolom
                    ->disabled(), // 👈 memastikan tidak bisa diedit


                Grid::make()
                    ->schema(function (callable $get) {
                        // Ambil record dari route
                        $record = request()->route('record');
                        if (is_string($record)) {
                            $record = \App\Models\ProjectScore::find($record);
                        }

                        $projectId = $get('project_id') ?? ($record?->project_id ?? null);

                        if (!$projectId) {
                            return [
                                Placeholder::make('info')->content('Pilih proyek terlebih dahulu.')
                            ];
                        }

                        // Load data siswa dan capaian
                        // $project = Projects::with('detail.header.classroom')->find($projectId);
                        // $project = Projects::with('detail.header.classroom')->find($projectId);

                        $guruId = auth()->user()->guru->id;

                        $project = Projects::with([
                            'detail.header.classroom.studentClassrooms.student'
                        ])->find($projectId);

                        $classroom = $project?->detail?->header?->classroom;

                        // $students = $classroom?->studentClassrooms
                        //     ->filter(fn($sc) => $sc->wali_id === $guruId)
                        //     ->map(fn($sc) => $sc->student)
                        //     ->filter();

                        $students = $classroom?->studentClassrooms
                            ->map(fn($sc) => $sc->student)
                            ->filter();




                        // dd($students);
                        // $students = Student::where('classroom_id', $classroomId)->get();
                        $details = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
                        $capaianFases = $details->pluck('capaianFase')->filter()->unique('id');
                        $parameters = ParameterPenilaian::pluck('bobot', 'id')->toArray();

                        // // Ambil nilai existing
                        $existingScores = collect();
                        if ($record) {
                            $existingScores = ProjectScoreDetail::where('project_score_id', $record->id)->get()
                                ->mapWithKeys(fn($row) => [
                                    "nilai_{$row->student_id}_{$row->capaian_fase_id}" => $row->parameter_penilaian_id
                                ]);
                        }

                        $existingNotes = ProjectScoreDetail::where('project_score_id', $record?->id)
                            ->pluck('note_project', 'student_id')
                            ->toArray();


                        return [

                            Grid::make([
                                'default' => 1,
                                'md' => $capaianFases->count() + 1,
                            ])->schema(

                                collect([
                                    Placeholder::make('')->content('Nama Siswa')->label('')
                                        ->extraAttributes([
                                            'class' => 'text-xs font-semibold text-left min-w-[120px] max-w-[160px]',
                                        ]),
                                    ...$capaianFases->map(
                                        fn($capaian, $i) =>
                                        Placeholder::make("cap_$i")
                                            ->view('components.project-score.placeholder-kolom', [
                                                'dimensi' => $capaian->subElement->element->dimension->name,
                                                'deskripsi' => $capaian->description,
                                            ])
                                            ->label('')
                                            ->extraAttributes(['style' => 'font-weight: bold; background-color:rgb(123, 162, 240)'])
                                    )
                                ])->merge(
                                    $students->flatMap(function ($student) use ($capaianFases, $parameters, $existingScores, $existingNotes, $record) {
                                        return [
                                            Placeholder::make("student_{$student->id}")
                                                ->label('')
                                                // ->content(function () use ($student, $record) {
                                                ->content(function (Get $get, $livewire) use ($student) {
                                                    $record = $livewire->record?->refresh();
                                                    $note = \App\Models\ProjectScoreDetail::where('student_id', $student->id)
                                                        ->where('project_score_id', $record?->id)
                                                        ->whereNotNull('note_project')
                                                        ->value('note_project');

                                                    $hasNote = !empty($note);

                                                    $html = '<div class="relative text-left bg-white p-2 rounded-lg">';
                                                    $html .= '<div class="font-semibold relative pr-16">'; // ruang kanan badge

                                                    // Nama siswa
                                                    $html .= '<span>' . e($student->nama) . '</span>';

                                                    // Badge "Catatan"
                                                    if ($hasNote) {
                                                        $html .= '<div style="position: absolute; top: 0; right: 0; background-color: #dc2626; color: white; font-size: 6px; padding: 1px 4px; border-radius: 10px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">Catatan</div>';
                                                    }

                                                    $html .= '</div>';

                                                    // Konten catatan
                                                    if ($note) {
                                                        $html .= '<div class="text-xs text-gray-500 italic mt-1">' . e($note) . '</div>';
                                                    } else {
                                                        $html .= '<div class="text-xs bg-red-50 p-1 italic rounded-md text-red-500 mt-1">Belum ada catatan</div>';
                                                    }

                                                    $html .= '</div>';

                                                    return new \Illuminate\Support\HtmlString($html);
                                                })
                                                ->extraAttributes([
                                                    'class' => 'text-xs text-left',
                                                ]),

                                            ...$capaianFases->map(function ($capaian) use ($student, $parameters, $existingScores, $record) {
                                                $fieldName = "nilai_{$student->id}_{$capaian->id}";
                                                $note = ProjectScoreDetail::where([
                                                    'project_score_id' => $record?->id,
                                                    'student_id' => $student->id,
                                                    'capaian_fase_id' => $capaian->id,
                                                ])->value('note_project');

                                                return Group::make([
                                                    Textarea::make("noteInputs.{$student->id}_{$capaian->id}")
                                                        ->label('')
                                                        ->visible(false)
                                                        ->dehydrated(),
                                                    Field::make($fieldName)
                                                        ->view('components.project-score.grid-radio-cell', [
                                                            'name' => $fieldName,
                                                            'value' => $existingScores[$fieldName] ?? null,
                                                            'options' => $parameters,
                                                            'readonly' => false,
                                                        ])
                                                        ->label('')
                                                        ->helperText(
                                                            fn($get) =>
                                                            $get("noteInputs.{$student->id}_{$capaian->id}")
                                                                ? "Catatan: " . $get("noteInputs.{$student->id}_{$capaian->id}")
                                                                : null
                                                        ),
                                                ]);
                                            })

                                        ];
                                    })
                                )->toArray()
                            )
                                ->afterStateHydrated(function (callable $set, $state) use ($record) {
                                    if (!$record) return;

                                    $details = \App\Models\ProjectScoreDetail::where('project_score_id', $record->id)->get();

                                    foreach ($details as $detail) {
                                        $nilaiKey = "nilai_{$detail->student_id}_{$detail->capaian_fase_id}";
                                        $noteKey = "noteInputs.{$detail->student_id}_{$detail->capaian_fase_id}";

                                        $set($nilaiKey, $detail->parameter_penilaian_id);
                                        $set($noteKey, $detail->note_project);
                                    }
                                })



                        ];
                    })

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title_project')->label('Judul Proyek')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creation at'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Updated at'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => ProjectScoreResource::getUrl('view', ['record' => $record->getKey()]))
                    ->openUrlInNewTab(), // Optional

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectScores::route('/'),
            'create' => Pages\CreateProjectScore::route('/create'),
            'edit' => Pages\EditProjectScore::route('/{record}/edit'),
            'view' => Pages\ViewProjectScore::route('/{record}/view'),

        ];
    }
}
