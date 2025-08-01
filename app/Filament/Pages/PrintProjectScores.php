<?php

namespace App\Filament\Pages;

use App\Models\Classroom;
use App\Models\ProjectScoreDetail;
use App\Models\Student;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrintProjectScores extends Page implements HasForms, HasTable
{
    use Forms\Concerns\InteractsWithForms;
    use \Filament\Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static string $view = 'filament.pages.print-project-scores';
    protected static ?string $navigationGroup = 'Printer';

    public ?int $selectedClassroom = null;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('selectedClassroom')
                    ->label('Pilih Kelas')
                    ->options(function () {
                        $user = auth()->user();

                        // Jika guru, tampilkan hanya kelas yang dia ampu
                        if ($user->hasRole('guru')) {
                            return $user->guru
                                ? $user->guru->classrooms->pluck('name', 'id')
                                : [];
                        }

                        // Jika admin/operator, tampilkan semua kelas
                        return Classroom::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn() => $this->resetTable()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->query(Student::query()->where('classroom_id', $this->selectedClassroom))
            ->query(function () {
                $guruId = auth()->user()?->guru?->id;
                $selectedClassroom = $this->selectedClassroom;
        
                return Student::withExists(['projectScoreDetails']) // Efisien untuk cek exists
                    ->whereHas('studentClassrooms', function ($query) use ($guruId, $selectedClassroom) {
                        $query->where('classroom_id', $selectedClassroom)
                            ->where('wali_id', $guruId);
                    });
            })
            
            ->columns([
                TextColumn::make('nama')->label('Nama Siswa'),
                TextColumn::make('nisn')->label('NISN'),
            ])
            ->actions([
                Action::make('cetak')
                    ->label(function ($record) {
                        return ProjectScoreDetail::where('student_id', $record->id)->exists()
                            ? 'Cetak PDF'
                            : 'Belum Ada Penilaian';
                    })
                    ->url(function ($record) {
                        return ProjectScoreDetail::where('student_id', $record->id)->exists()
                            ? route('print.project.score.student', $record->id)
                            : null;
                    })
                    ->openUrlInNewTab(
                        fn($record) =>
                        ProjectScoreDetail::where('student_id', $record->id)->exists()
                    )
                    ->disabled(
                        fn($record) =>
                        !ProjectScoreDetail::where('student_id', $record->id)->exists()
                    )
                    ->color(
                        fn($record) =>
                        ProjectScoreDetail::where('student_id', $record->id)->exists()
                            ? 'primary'
                            : 'gray'
                    )
                    ->icon(
                        fn($record) =>
                        ProjectScoreDetail::where('student_id', $record->id)->exists()
                            ? 'heroicon-o-printer'
                            : 'heroicon-o-x-circle'
                    ),
            ]);
    }
}
