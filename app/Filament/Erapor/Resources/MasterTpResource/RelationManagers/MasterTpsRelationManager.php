<?php

namespace App\Filament\Erapor\Resources\MasterTpResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterTpsRelationManager extends RelationManager
{
    protected static string $relationship = 'masterTps';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tp_name')
                    ->label('Tujuan Pembelajaran')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tp_name')
            ->columns([
                Tables\Columns\TextColumn::make('tp_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                    Tables\Actions\CreateAction::make()
                        ->label('Tambah TP'),
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
