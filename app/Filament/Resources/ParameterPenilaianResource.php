<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterPenilaianResource\Pages;
use App\Filament\Resources\ParameterPenilaianResource\RelationManagers;
use App\Models\ParameterPenilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParameterPenilaianResource extends Resource
{
    protected static ?string $model = ParameterPenilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Parameter Penilaian';
    protected static ?string $pluralModelLabel = 'Parameter Penilaian';
    protected static ?string $navigationGroup = 'Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bobot')
                    ->label('Nilai')
                    ->required(),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bobot')->label('Nilai')->badge(),
                TextColumn::make('keterangan')->label('Keterangan')->searchable(),
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
            'index' => Pages\ListParameterPenilaians::route('/'),
            'create' => Pages\CreateParameterPenilaian::route('/create'),
            'edit' => Pages\EditParameterPenilaian::route('/{record}/edit'),
        ];
    }
}
