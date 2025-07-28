<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\StudentExtracurricularResource\Pages;
use App\Filament\Erapor\Resources\StudentExtracurricularResource\RelationManagers;
use App\Models\StudentExtracurricular;
use App\Models\StudentExtracurriculars;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentExtracurricularResource extends Resource
{
    protected static ?string $model = StudentExtracurriculars::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Menu Ekstra Kurikuler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_classroom_id')
                    ->label('Siswa (Tahun Ajaran & Kelas)')
                    ->options(function () {
                        return \App\Models\StudentClassroom::with(['student', 'classroom', 'academicYear'])
                            ->get()
                            ->mapWithKeys(fn($sc) => [$sc->id => $sc->label]);
                    })
                    ->searchable()
                    ->required(),


                Select::make('extracurricular_id')
                    ->label('Ekstrakurikuler')
                    ->relationship('extracurricular', 'name', modifyQueryUsing: fn ($query) => $query)
                    ->required(),
                

                Forms\Components\TextInput::make('urutan')
                    ->numeric()
                    ->label('Urutan')
                    ->default(1),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi Kegiatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('studentClassroom.student.nama')->label('Nama Siswa')->searchable(),
                Tables\Columns\TextColumn::make('studentClassroom.classroom.name')->label('Kelas'),
                Tables\Columns\TextColumn::make('studentClassroom.academicYear.label')->label('Tahun Ajaran'),
                Tables\Columns\TextColumn::make('extracurricular.name')->label('Ekskul'),
                Tables\Columns\TextColumn::make('urutan')->label('Pilihan'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentExtracurriculars::route('/'),
            'create' => Pages\CreateStudentExtracurricular::route('/create'),
            'edit' => Pages\EditStudentExtracurricular::route('/{record}/edit'),
        ];
    }
}
