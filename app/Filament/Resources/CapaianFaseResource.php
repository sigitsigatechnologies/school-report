<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapaianFaseResource\Pages;
use App\Filament\Resources\CapaianFaseResource\RelationManagers;
use App\Models\CapaianFase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapaianFaseResource extends Resource
{
    protected static ?string $model = CapaianFase::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationLabel = 'Parameter Capaian Fase';
    protected static ?string $pluralModelLabel = 'Parameter Capaian Fase';
    protected static ?string $navigationGroup = 'Parameter';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('sub_element_id')
                ->label('Sub Elemen')
                ->relationship('subElement', 'name')
                ->required(),
    
            Forms\Components\Select::make('fase')
                ->label('Fase')
                ->options([
                    'A' => 'Fase A',
                    'B' => 'Fase B',
                    'C' => 'Fase C',
                    'D' => 'Fase D',
                    'E' => 'Fase E',
                ])
                ->required(),
    
            Forms\Components\Textarea::make('description')
                ->label('Deskripsi Capaian')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fase')->label('Fase')->wrap(),
                TextColumn::make('subElement.name')->label('sub element')->wrap(),
                TextColumn::make('description')->label('Deskripsi capian'),
                TextColumn::make('created_at')->label('Created at'),
                TextColumn::make('updated_at')->label('Updated at'),
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
            'index' => Pages\ListCapaianFases::route('/'),
            'create' => Pages\CreateCapaianFase::route('/create'),
            'edit' => Pages\EditCapaianFase::route('/{record}/edit'),
        ];
    }
}
