<?php

namespace App\Filament\Guru\Resources\ProjectScoreResource\Pages;

use App\Filament\Guru\Resources\ProjectScoreResource;
use App\Models\ParameterPenilaian;
use App\Models\ProjectDetail;
use App\Models\ProjectScore;
use App\Models\Projects;
use App\Models\Student;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;

class InputProjectScores extends Page implements HasForms
{
    use InteractsWithForms;

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('formData');
    }

    protected static string $resource = ProjectScoreResource::class;

    public ?array $formData = [];

    public function mount(): void
    {
        $this->form->fill(); // preload
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('project_id')
                ->label('Pilih Proyek')
                ->options(\App\Models\Projects::all()->pluck('title_project', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn($set, $state) => $this->formData['project_id'] = $state),

            Hidden::make('classroom_id'),

            Grid::make()
                ->schema(function (callable $get) {
                    $projectId = $get('project_id');

                    if (!$projectId) {
                        return [Placeholder::make('info')->content('Pilih proyek terlebih dahulu.')];
                    }

                    $project = \App\Models\Projects::with('detail.header.classroom')->find($projectId);
                    $classroomId = $project?->detail?->header?->classroom_id;
                    $this->formData['classroom_id'] = $classroomId;

                    $students = Student::where('classroom_id', $classroomId)->get();
                    $projectDetails = ProjectDetail::where('project_id', $projectId)->with('capaianFase')->get();
                    $parameterOptions = ParameterPenilaian::all()->pluck('keterangan', 'id')->toArray();

                    return [
                        Section::make('Input Nilai')
                            ->schema(
                                $students->flatMap(fn($student) =>
                                    $projectDetails->map(fn($detail) =>
                                        Radio::make("nilai_{$student->id}_{$detail->capaian_fase_id}")
                                            ->label("{$student->nama} - {$detail->capaianFase->description}")
                                            ->options($parameterOptions)
                                            ->inline()
                                    )
                                )->toArray()
                            )
                    ];
                }),
        ];
    }


    public function submit(): void
    {
        $data = $this->formData;
        $projectId = $data['project_id'] ?? null;
        $classroomId = $data['classroom_id'] ?? null;

        if (!$projectId || !$classroomId) return;

        $students = Student::where('classroom_id', $classroomId)->get();
        $projectDetails = ProjectDetail::where('project_id', $projectId)->get();

        foreach ($students as $student) {
            foreach ($projectDetails as $detail) {
                $key = "nilai_{$student->id}_{$detail->capaian_fase_id}";
                $parameterPenilaianId = $data[$key] ?? null;

                if ($parameterPenilaianId) {
                    ProjectScore::updateOrCreate(
                        [
                            'project_id' => $projectId,
                            'student_id' => $student->id,
                            'capaian_fase_id' => $detail->capaian_fase_id,
                        ],
                        [
                            'parameter_penilaian_id' => $parameterPenilaianId,
                        ]
                    );
                }
            }
        }

        Notification::make()
        ->title('Berhasil')
        ->body('Penilaian berhasil disimpan!')
        ->success()
        ->send();
    }

    protected static string $view = 'filament.guru.resources.project-score-resource.pages.input-project-scores';
}
