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
                Select::make('student_id')
                    ->label('Student')
                    ->relationship('student', 'nama')
                    ->required(),

                Select::make('classroom_id')
                    ->label('Classroom')
                    ->relationship('classroom', 'name')
                    ->required(),

                Select::make('academic_year_id')
                    ->label('Academic Year')
                    ->relationship('academicYear', 'tahun_ajaran') // pastikan 'name' adalah field labelnya
                    ->required(),
                Select::make('wali_id')
                    ->label('Wali')
                    ->relationship('wali', 'name')
                    ->default(fn () => auth()->user()?->guru?->id)
                    ->disabled()
                    ->dehydrated(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.nama')->label('Nama Siswa'),
                TextColumn::make('classroom.name')->label('Kelas'),
                TextColumn::make('academicYear.tahun_ajaran')->label('Tahun Ajaran'),
                TextColumn::make('wali.name')->label('Wali Kelas'),
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
