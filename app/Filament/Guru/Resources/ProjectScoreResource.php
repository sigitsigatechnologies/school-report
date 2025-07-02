<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\ProjectScoreResource\Pages;
use App\Filament\Guru\Resources\ProjectScoreResource\RelationManagers;
use App\Models\CapaianFase;
use App\Models\ParameterPenilaian;
use App\Models\ProjectDescriptionDetails;
use App\Models\ProjectDetail;
use App\Models\Projects;
use App\Models\ProjectScore;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectScoreResource extends Resource
{
    protected static ?string $model = ProjectScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('project_id')
                    ->relationship('project', 'title_project')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateHydrated(function (callable $set, $state) {
                        // Set project_id saat edit
                        $set('project_id', $state);
                    }),
                    Section::make('Informasi Proyek')
                    ->schema(function (callable $get) {
                        $projectId = $get('project_id');
                        if (!$projectId) return [];
                
                        $project = \App\Models\Projects::with('detail.header.classroom')->find($projectId);
                
                        return [
                            Placeholder::make('judul')
                                ->label('Judul Proyek')
                                ->content($project?->title_project ?? '-'),
                
                            Placeholder::make('kelas')
                                ->label('Kelas')
                                ->content($project?->detail?->header?->classroom?->name ?? '-'),
                
                            Placeholder::make('tahun_ajaran')
                                ->label('Tahun Ajaran')
                                ->content($project?->detail?->header?->tahun_ajaran ?? '-'),
                
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
                        $project = Projects::with('detail.header.classroom')->find($projectId);
                        $classroomId = $project?->detail?->header?->classroom_id;
                        $students = Student::where('classroom_id', $classroomId)->get();
                        $details = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
                        $capaianFases = $details->pluck('capaianFase')->filter()->unique('id');
                        $parameters = ParameterPenilaian::pluck('bobot', 'id')->toArray();

                        // Ambil nilai existing
                        $existingScores = collect();
                        if ($record) {
                            $existingScores = ProjectScoreDetail::where('project_score_id', $record->id)->get()
                                ->mapWithKeys(fn($row) => [
                                    "nilai_{$row->student_id}_{$row->capaian_fase_id}" => $row->parameter_penilaian_id
                                ]);
                        }

                        return [
                            Grid::make([
                                'default' => 1,
                                'md' => $capaianFases->count() + 1,
                            ])->schema(
                                collect([
                                    Placeholder::make('')->content('Nama Siswa')->label(''),
                                    ...$capaianFases->map(fn($capaian, $i) =>
                                        Placeholder::make("cap_$i")
                                            ->content("{$capaian->subElement->element->dimension->name} – {$capaian->description}")
                                            ->label('')
                                            ->extraAttributes(['style' => 'font-weight: bold; background-color: #f3f4f6'])
                                    )
                                ])->merge(
                                    $students->flatMap(function ($student) use ($capaianFases, $parameters, $existingScores) {
                                        return [
                                            Placeholder::make("student_{$student->id}")
                                                ->content($student->nama)
                                                ->label(''),
                                            ...$capaianFases->map(function ($capaian) use ($student, $parameters, $existingScores) {
                                                $fieldName = "nilai_{$student->id}_{$capaian->id}";
                                                return Radio::make($fieldName)
                                                ->options($parameters)
                                                ->inline()
                                                ->label('')
                                                ->default($existingScores[$fieldName] ?? null)
                                                ->statePath($fieldName); 
                                            })
                                        ];
                                    })
                                )->toArray()
                            )
                            ->afterStateHydrated(function (callable $set, $state) use ($record) {
                                if (!$record) return;
                        
                                $details = \App\Models\ProjectScoreDetail::where('project_score_id', $record->id)->get();
                        
                                foreach ($details as $detail) {
                                    $fieldKey = "nilai_{$detail->student_id}_{$detail->capaian_fase_id}";
                                    $set($fieldKey, $detail->parameter_penilaian_id);
                                }
                            })
                        ];
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title_project')->label('Judul Proyek'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        ];
    }
}
