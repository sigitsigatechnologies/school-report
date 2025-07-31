<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubElementResource\Pages;
use App\Filament\Resources\SubElementResource\RelationManagers;
use App\Models\SubElement;
use App\Models\SubElements;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubElementResource extends Resource
{
    protected static ?string $model = SubElements::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationLabel = 'Parameter Sub Element';
    protected static ?string $pluralModelLabel = 'Parameter Sub Element';
    protected static ?string $navigationGroup = 'Parameter';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('element_id')
                ->label('Elemen')
                ->relationship('element', 'name')
                ->required(),
    
            Forms\Components\TextInput::make('name')
                ->label('Nama Sub Elemen')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Sub Element'),
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
            'index' => Pages\ListSubElements::route('/'),
            'create' => Pages\CreateSubElement::route('/create'),
            'edit' => Pages\EditSubElement::route('/{record}/edit'),
        ];
    }
}
