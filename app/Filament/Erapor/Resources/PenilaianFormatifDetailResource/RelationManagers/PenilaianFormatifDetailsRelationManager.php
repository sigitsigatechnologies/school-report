<?php

namespace App\Filament\Erapor\Resources\PenilaianFormatifDetailResource\RelationManagers;

use App\Models\MasterTp;
use App\Models\PenilaianFormatifDetail;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PenilaianFormatifDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'penilaianFormatifDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nilai')->numeric(),
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'nama')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('master_tp_id')
                    ->relationship('masterTp', 'nama') // sesuaikan dengan relasi
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        $record = $this->getOwnerRecord();
        $students = $this->getRelatedStudents($record);
        $tps = $this->getRelatedTps($record);

        return $table
            ->query(fn() => $this->getRelatedStudents($this->getOwnerRecord())->toQuery()) // ❗ override query siswa saja
            ->columns([
                TextColumn::make('id')->label('No')->rowIndex(),
                TextColumn::make('name')->label('Nama Siswa')->getStateUsing(fn($record) => $record->nama),
                ...collect($tps)->map(function ($tp) {
                    return TextColumn::make("nilai_tp_{$tp->id}")
                        ->label($tp->tp_name)
                        ->getStateUsing(function ($record) use ($tp) {
                            $nilai = $record->penilaianFormatifDetails
                                ->firstWhere('master_tp_id', $tp->id)?->nilai;
                            return $nilai ?? '-';
                        })
                        ->wrap() // biar gak terlalu lebar
                        ->limit(10)
                        ->size('sm') // ukuran font kecil
                        ->grow(false)
                        ->sortable(false)
                        ->searchable(false)
                        ->toggleable(false)
                        ->extraAttributes([
                            'style' => 'width: 5rem; max-width: 6rem;',
                        ]); // batasi karakter judul kolom
                })->toArray()
            ])
            ->actions([
                Action::make('input_nilai')
                    ->label('Input Nilai')
                    ->icon('heroicon-o-pencil-square')
                    ->modalHeading(fn($record) => 'Input Nilai: ' . $record->nama)
                    ->record(fn($record) => $record) // Pastikan 'record' ini adalah student
                    ->form(function (Action $action) use ($tps, $record) {
                        $student = $action->getRecord(); // Ambil student dari record action
                        return $this->buildInputFieldsForStudent($student, $tps, $record);
                    })
                    ->action(function (array $data, Action $action) use ($record) {
                        $student = $action->getRecord(); // Ambil student dari action
                        $this->handleInputNilaiPerSiswa($data, $student, $record);

                        Notification::make()
                            ->title("Nilai berhasil disimpan!")
                            ->success()
                            ->send();
                    }),
            ])

            ->emptyStateHeading('Belum ada siswa')
            ->bulkActions([]);
    }


    protected function getRelatedStudents($record)
    {
        // Ambil classroom_id dari master materi
        $classroomId = $record->masterMateri->classroom_id;

        // Ambil semua siswa yang tergabung dalam kelas tersebut
        return \App\Models\Student::whereHas('studentClassrooms', function ($query) use ($classroomId) {
            $query->where('classroom_id', $classroomId);
        })->with('penilaianFormatifDetails')->get();
    }


    protected function getRelatedTps($record)
    {
        return MasterTp::whereHas('masterUnitMateri.masterMateri', function ($q) use ($record) {
            $q->where('id', $record->master_materi_id);
        })->get();
    }

    protected function buildInputFields($students, $tps, $record): array
    {
        $fields = [];

        foreach ($students as $student) {
            $fieldset = Fieldset::make($student->nama)
                ->columns(count($tps))
                ->schema(
                    $tps->map(function ($tp) use ($student, $record) {
                        $existingNilai = $record->penilaianFormatifDetails()
                            ->where('student_id', $student->id)
                            ->where('master_tp_id', $tp->id)
                            ->value('nilai');

                        return TextInput::make("nilai_{$student->id}_{$tp->id}")
                            ->label($tp->tp_name)
                            ->numeric()
                            ->default($existingNilai);
                    })->toArray()
                );

            $fields[] = $fieldset;
        }

        return $fields;
    }

    protected function handleInputNilai(array $data, $record, $livewire): void
    {
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'nilai_')) {
                [$_, $studentId, $tpId] = explode('_', $key);

                if ($value !== null) {
                    $record->penilaianFormatifDetails()->updateOrCreate([
                        'student_id' => $studentId,
                        'master_tp_id' => $tpId,
                    ], [
                        'nilai' => $value,
                    ]);
                }
            }
        }

        Notification::make()
            ->title('Nilai berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function buildInputFieldsForStudent($student, $tps, $record): array
    {
        return $tps->map(function ($tp) use ($student, $record) {
            $existingNilai = $record->penilaianFormatifDetails()
                ->where('student_id', $student->id)
                ->where('master_tp_id', $tp->id)
                ->value('nilai');

            return TextInput::make("nilai_{$tp->id}")
                ->label($tp->tp_name)
                ->numeric()
                ->default($existingNilai);
        })->toArray();
    }

    protected function handleInputNilaiPerSiswa(array $data, $student, $record): void
    {
        foreach ($data as $key => $value) {
            if (preg_match('/nilai_(\d+)/', $key, $matches)) {
                $tpId = $matches[1];

                if ($value !== null) {
                    $record->penilaianFormatifDetails()->updateOrCreate([
                        'student_id' => $student->id,
                        'master_tp_id' => $tpId,
                    ], [
                        'nilai' => $value,
                    ]);
                }
            }
        }
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('penilaianFormatifDetails.masterTp');
    }
}
