<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDetailResource\Pages;
use App\Filament\Resources\ProjectDetailResource\RelationManagers;
use App\Models\ProjectDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectDetailResource extends Resource
{
    protected static ?string $model = ProjectDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationLabel = 'Project Details';
    protected static ?string $pluralModelLabel = 'Project Details';
    protected static ?string $navigationGroup = 'Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.title_project')->label('Judul Proyek'),
                TextColumn::make('dimension.name')->label('Dimensi'),
                TextColumn::make('element.name')->label('Elemen'),
                TextColumn::make('subElement.name')->label('Sub Elemen'),
                TextColumn::make('capaianFase.fase')->label('Fase'),
                TextColumn::make('capaianFase.description')->label('Deskripsi')->wrap(),
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
            'index' => Pages\ListProjectDetails::route('/'),
            'create' => Pages\CreateProjectDetail::route('/create'),
            'edit' => Pages\EditProjectDetail::route('/{record}/edit'),
        ];
    }
}
