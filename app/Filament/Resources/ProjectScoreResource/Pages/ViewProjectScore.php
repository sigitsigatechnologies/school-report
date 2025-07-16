<?php

namespace App\Filament\Resources\ProjectScoreResource\Pages;


use App\Filament\Resources\ProjectScoreResource;
use App\Models\ProjectScoreDetail;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;
use Filament\Actions\Action as HeaderAction;

class ViewProjectScore extends EditRecord
{
    protected static string $resource = ProjectScoreResource::class;

    public ?array $noteInputs = [];
    public ?string $editingNote = null;
    public string $search = '';


    public function mount($record): void
    {
        parent::mount($record);
    }

    public function form(Form $form): Form
    {
        $project = $this->record->project;
        $record = $this->getRecord()->fresh(); // ini penting!
        $details = $record->details()->with(['student', 'capaianFase', 'parameterPenilaian'])->get();
        $groupedDetails = $details->groupBy('student_id');



        return $form->schema([
            Section::make('Informasi Proyek')
                ->schema([
                    Placeholder::make('judul')->label('Judul Proyek')->content($project->title_project ?? '-'),
                    Placeholder::make('deskripsi')->label('Deskripsi')->content($project->detail->title ?? '-'),
                    Placeholder::make('kelas')->label('Kelas')->content($project->detail?->header?->classroom?->name ?? '-'),
                    Placeholder::make('tahun')->label('Tahun Ajaran')->content($project->detail?->header?->tahun_ajaran ?? '-'),
                    Placeholder::make('fase')->label('Fase')->content($project->detail?->header?->fase ?? '-'),
                ])
                ->columns(2),

            Section::make('Detail Nilai Siswa')
                ->schema(
                    $groupedDetails->map(function ($studentDetails, $studentId) {
                        $student = $studentDetails->first()->student;
                        $firstDetail = $studentDetails->first();

                        $capaianLabels = $studentDetails->map(function ($detail) {
                            $bobot = $detail->parameterPenilaian->bobot ?? '-';
                            $keterangan = $detail->parameterPenilaian->keterangan ?? '-';
                            $deskripsi = $detail->capaianFase->description ?? '-';

                            $style = match ($bobot) {
                                'SB' => "background-color: #d1fae5; color: #065f46;",
                                'BSH' => "background-color: #bfdbfe; color: #1e40af;",
                                'MB' => "background-color: #fed7aa; color: #9a3412;",
                                'BB' => "background-color: #fecaca; color: #991b1b;",
                                default => "background-color: #e5e7eb; color: #374151;",
                            };

                            return "<li style='margin-bottom: 6px;'>
                                <div style='margin-bottom: 2px; font-weight: 600;'>{$deskripsi}</div>
                                <span style='padding: 4px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; {$style}'>
                                    {$keterangan}
                                </span>
                            </li>";
                        })->implode('');

                        $capaianLabels = "<ul style='padding-left: 16px; margin: 0;'>{$capaianLabels}</ul>";

                        return Section::make("Data Siswa: {$student->nama}")
                            ->description("Berikut detail capaian dan catatan untuk {$student->nama}")
                            ->schema([
                                Grid::make(6)->schema([
                                    Placeholder::make("student_{$studentId}")
                                        ->label('Nama Siswa')
                                        ->content($student->nama),

                                    Placeholder::make("capaian_list_{$studentId}")
                                        ->label('Capaian + Nilai')
                                        ->content(new \Illuminate\Support\HtmlString($capaianLabels))
                                        ->columnSpan(3),

                                    Placeholder::make("note_{$studentId}")
                                        ->label('Catatan')
                                        ->content($firstDetail->note_project ?? '-')
                                        ->columnSpan(2),

                                    Actions::make([
                                        Action::make("edit_note_{$studentId}")
                                            ->icon('heroicon-o-pencil-square')
                                            ->label('Edit Catatan')
                                            ->form([
                                                Textarea::make('noteValue')
                                                    ->label('Catatan')
                                                    ->rows(4)
                                                    ->default($firstDetail->note_project),
                                            ])
                                            ->modalSubmitActionLabel('Simpan')
                                            ->action(function (array $data) use ($studentId, $studentDetails) {
                                                $projectScoreId = $studentDetails->first()->project_score_id;

                                                \App\Models\ProjectScoreDetail::where('project_score_id', $projectScoreId)
                                                    ->where('student_id', $studentId)
                                                    ->update([
                                                        'note_project' => $data['noteValue'],
                                                    ]);

                                                \Filament\Notifications\Notification::make()
                                                    ->title('Catatan berhasil diperbarui untuk semua capaian siswa ini.')
                                                    ->success()
                                                    ->send();
                                            }),
                                        Action::make("print_student_{$studentId}")
                                            ->label('Print Rapor')
                                            ->icon('heroicon-o-printer')
                                            ->url(fn() => route('print.project-score.studentOne', [
                                                'project_score_id' => $studentDetails->first()->project_score_id,
                                                'student_id' => $studentId,
                                            ]))
                                            ->openUrlInNewTab()
                                            ->extraAttributes([
                                                'style' => 'background-color: rgb(0, 200, 83); color: white;',
                                            ])
                                    ])->alignEnd()->columnSpanFull(),
                                ]),
                            ]);
                    })->values()->toArray()
                )

        ]);
    }

    public function fillEditModal(string $key, ?string $note)
    {
        $this->editingNote = $key;
        $this->noteInputs = $note;
    }

    public function saveNote(string $key, string $note)
    {
        [$studentId, $capaianId] = explode('_', $key);

        ProjectScoreDetail::updateOrCreate([
            'project_score_id' => $this->record->id,
            'student_id' => $studentId,
            'capaian_fase_id' => $capaianId,
        ], [
            'note_project' => $note,
        ]);

        // Refresh data agar Placeholder ikut update
        $this->record->refresh();

        Notification::make()
            ->title('Catatan berhasil disimpan.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return []; // Tidak ada tombol Save di bawah form
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         HeaderAction::make('print')
    //             ->label('Print')
    //             ->icon('heroicon-o-printer')
    //             ->color('gray')
    //             ->url(fn() => route('print.project-score', ['id' => $this->record->id]))
    //             ->openUrlInNewTab(), // Agar tidak menutup halaman ini
    //     ];
    // }

    public function getTitle(): string
    {
        return 'Lihat Detail Project Penilaian dan Tambahkan Catatan.';
    }
}
