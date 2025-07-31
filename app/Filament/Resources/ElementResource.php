<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElementResource\Pages;
use App\Filament\Resources\ElementResource\RelationManagers;
use App\Models\Element;
use App\Models\Elements;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ElementResource extends Resource
{
    protected static ?string $model = Elements::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationLabel = 'Parameter Element';
    protected static ?string $pluralModelLabel = 'Parameter Element';
    protected static ?string $navigationGroup = 'Parameter';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('dimension_id')
                ->label('Dimensi')
                ->relationship('dimension', 'name')
                ->required(),
    
            Forms\Components\TextInput::make('name')
                ->label('Nama Elemen')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Element'),
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
            'index' => Pages\ListElements::route('/'),
            'create' => Pages\CreateElement::route('/create'),
            'edit' => Pages\EditElement::route('/{record}/edit'),
        ];
    }
}
