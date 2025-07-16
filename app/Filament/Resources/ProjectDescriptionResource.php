<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDescriptionResource\Pages;
use App\Filament\Resources\ProjectDescriptionResource\RelationManagers;
use App\Models\ProjectDescription;
use App\Models\ProjectDescriptions;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProjectDescriptionResource extends Resource
{
    protected static ?string $model = ProjectDescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Project Description';
    protected static ?string $pluralModelLabel = 'Project Description';
    protected static ?string $navigationGroup = 'Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('classroom_id')
                    ->label('Kelas')
                    ->required()
                    ->options(function () {
                        $user = auth()->user();

                        if ($user->hasRole('guru')) {
                            return $user->guru->classrooms->pluck('name', 'id');
                        }

                        return \App\Models\Classroom::pluck('name', 'id');
                    }),


                TextInput::make('header_name_project')
                    ->label('Judul Proyek Utama')
                    ->required(),

                Select::make('fase')
                    ->options([
                        'A' => 'Fase A',
                        'B' => 'Fase B',
                        'C' => 'Fase C',
                        'D' => 'Fase D',
                        'E' => 'Fase E',
                    ])
                    ->required(),

                TextInput::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->required(),

                // Detail repeater
                Repeater::make('details')
                    ->relationship('details')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('description')->required(),
                    ])
                    ->minItems(1)
                    ->columns(1)
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classroom.name')->label('Kelas'),
                TextColumn::make('header_name_project')->label('Deskripsi Proyek'),
                TextColumn::make('fase')->label('Fase'),
                TextColumn::make('tahun_ajaran')->label('Tahun Ajaran'),
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
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->hasRole('guru')) {
            $guru = $user->guru;
            $classroomIds = $guru->classrooms->pluck('id');

            $query->whereIn('classroom_id', $classroomIds);
        }

        return $query;
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
            'index' => Pages\ListProjectDescriptions::route('/'),
            'create' => Pages\CreateProjectDescription::route('/create'),
            'edit' => Pages\EditProjectDescription::route('/{record}/edit'),
        ];
    }
}
