<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource\Pages;
use App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource\RelationManagers;
use App\Models\StudentClassroom;
use App\Models\StudentHealthAbsenceReport;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class StudentHealthAbsenceReportResource extends Resource
{
    protected static ?string $model = StudentHealthAbsenceReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationGroup = 'Menu Absensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('student_classroom_id')
                    ->label('Siswa')
                    ->options(function () {
                        $user = auth()->user();

                        if ($user->hasRole('guru')) {
                            $guru = $user->guru;
                            $classroomIds = $guru->classrooms->pluck('id');

                            return \App\Models\StudentClassroom::with('student')
                                ->whereIn('classroom_id', $classroomIds)
                                ->get()
                                ->filter(fn($sc) => $sc->student && $sc->student->nama)
                                ->mapWithKeys(fn($sc) => [$sc->id => $sc->student->nama])
                                ->toArray();
                        }

                        return [];
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $studentClassroom = \App\Models\StudentClassroom::with('academicYear')->find($state);
                        $semester = $studentClassroom?->academicYear?->semester;

                        $set('semester', $semester);
                    })

                    ->required(),

                TextInput::make('semester')
                    ->label('Semester')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(), // tambahkan ini jika field 'semester' wajib diisi secara otomatis



                TextInput::make('sakit')->numeric()->default(0),
                TextInput::make('ijin')->numeric()->default(0),
                TextInput::make('tanpa_keterangan')->numeric()->default(0),

                TextInput::make('tinggi_badan')
                    ->label('Tinggi Badan')
                    ->suffix('cm'),

                TextInput::make('berat_badan')
                    ->label('Berat Badan')
                    ->suffix('kg'),

                Textarea::make('saran')->label('Saran Untuk Peserta Didik'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('studentClassroom.student.nama')->label('Nama Siswa')->searchable(),
                TextColumn::make('semester')->label('Semester'),
                TextColumn::make('sakit')->label('Sakit')->sortable(),
                TextColumn::make('ijin')->label('Izin')->sortable(),
                TextColumn::make('tanpa_keterangan')->label('Tanpa Keterangan')->sortable(),
                TextColumn::make('tinggi_badan')->label('Tinggi')->suffix(' cm'),
                TextColumn::make('berat_badan')->label('Berat')->suffix(' kg'),
                TextColumn::make('saran')->limit(30)->wrap()->label('Saran'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function modifyQueryUsing(Builder $query): Builder
{
    $user = auth()->user();

    if ($user->hasRole('guru')) {
        $guru = $user->guru;
        $classroomIds = $guru->classrooms->pluck('id')->toArray();

        // Ambil tahun ajaran aktif
        $activeAcademicYear = \App\Models\AcademicYear::where('is_active', true)->first();

        if ($activeAcademicYear) {
            // Join ke student_classrooms
            return $query->whereHas('studentClassroom', function ($q) use ($classroomIds, $activeAcademicYear) {
                $q->whereIn('classroom_id', $classroomIds)
                  ->where('academic_year_id', $activeAcademicYear->id);
            });
        }
    }

    return $query;
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentHealthAbsenceReports::route('/'),
            'create' => Pages\CreateStudentHealthAbsenceReport::route('/create'),
            'edit' => Pages\EditStudentHealthAbsenceReport::route('/{record}/edit'),
        ];
    }
}
