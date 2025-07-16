<?php

namespace App\Filament\Erapor\Resources\MasterMateriResource\RelationManagers;

use App\Filament\Erapor\Resources\MasterTpResource\RelationManagers\MasterTpsRelationManager;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterUnitMaterisRelationManager extends RelationManager
{
    protected static string $relationship = 'masterUnitMateris';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('unit_materi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('unit_materi')
            ->columns([
                Tables\Columns\TextColumn::make('unit_materi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
