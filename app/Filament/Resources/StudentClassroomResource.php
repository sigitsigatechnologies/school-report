<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentClassroomResource\Pages;
use App\Filament\Resources\StudentClassroomResource\RelationManagers;
use App\Models\StudentClassroom;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentClassroomResource extends Resource
{
    protected static ?string $model = StudentClassroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Student';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select::make('student_id')
                //     ->label('Siswa')
                //     ->required()
                //     ->options(function () {
                //         return \App\Models\StudentClassroom::with(['student', 'classroom'])
                //             ->get()
                //             ->mapWithKeys(fn($sc) => [
                //                 $sc->student_id => "{$sc->student->nama} - Kelas {$sc->classroom->name}"
                //             ]);
                //     })
                //     ->searchable()
                //     ->placeholder('Pilih siswa'),

                Select::make('student_id')
                    ->label('Siswa')
                    ->required()
                    ->options(function () {
                        $guru = auth()->user()?->guru;

                        if (! $guru) {
                            return [];
                        }

                        // ambil kelas yg dia jadi wali
                        $waliClassroom = $guru->classrooms()->first(); // relasi guru -> classrooms

                        if (! $waliClassroom) {
                            return [];
                        }

                        // ambil siswa hanya dari kelas tsb
                        return \App\Models\StudentClassroom::with('student')
                            ->where('classroom_id', $waliClassroom->id)
                            ->get()
                            ->mapWithKeys(fn($sc) => [
                                $sc->student_id => "{$sc->student->nama} - Kelas {$waliClassroom->name}"
                            ]);
                    })
                    ->searchable()
                    ->placeholder('Pilih siswa'),

                Select::make('classroom_id')
                    ->label('Naik Kelas / Tinggal Kelas')
                    ->relationship('classroom', 'name')
                    ->required(),

                // Select::make('academic_year_id')
                //     ->label('Academic Year')
                //     ->options(
                //         \App\Models\AcademicYear::pluck('tahun_ajaran', 'id')
                //     )
                //     ->required(),

                Select::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(
                        \App\Models\AcademicYear::where('is_active', true)
                            ->get()
                            ->mapWithKeys(fn($year) => [
                                $year->id => "{$year->tahun_ajaran} - Semester {$year->semester}"
                            ])
                    )
                    ->default(
                        \App\Models\AcademicYear::where('is_active', true)->value('id')
                    )
                    ->required(),


                Select::make('wali_id')
                    ->label('Wali')
                    ->relationship('wali', 'name')
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        $kelas = $record->classrooms()
                            ->pluck('name')
                            ->unique()
                            ->join(', ');

                        return "{$record->name} - Wali Kelas {$kelas}";
                    })
                    ->default(fn() => auth()->user()?->guru?->id)
                    ->dehydrated()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('student.nama')->label('Nama Siswa'),
                // TextColumn::make('classroom.name')->label('Kelas'),
                // TextColumn::make('academicYear.tahun_ajaran')->label('Tahun Ajaran'),
                // TextColumn::make('wali.name')->label('Wali Kelas'),

                TextColumn::make('student.nama')->label('Nama Siswa'),

                // Kelas sekarang
                TextColumn::make('classroom.name')
                    ->label('Kelas Sekarang'),

                TextColumn::make('academicYear.tahun_ajaran')->label('Tahun Ajaran'),
                TextColumn::make('academicYear.semester')->label('Semester'),
                TextColumn::make('wali.name')->label('Wali Kelas'),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'tahun_ajaran'),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('wali_id', auth()->user()->guru?->id);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentClassrooms::route('/'),
            'create' => Pages\CreateStudentClassroom::route('/create'),
            'edit' => Pages\EditStudentClassroom::route('/{record}/edit'),
        ];
    }
}
