<?php

namespace App\Filament\Erapor\Resources\PenilaianTesDetailResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TesDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'tesDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('nilai_tes')
                ->label('Nilai Tes')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('nilai_non_tes')
                ->label('Nilai Non Tes')
                ->numeric()
                ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nilai_tes')
            ->columns([
                Tables\Columns\TextColumn::make('nilai_tes')->label('Nilai Tes')->sortable(),
                Tables\Columns\TextColumn::make('nilai_non_tes')->label('Nilai Non Tes')->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Tambah Tes Detail')
                    ->modalWidth('md'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Tes Detail')
                    ->modalWidth('md'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
