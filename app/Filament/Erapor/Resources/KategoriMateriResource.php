<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\KategoriMateriResource\Pages;
use App\Filament\Erapor\Resources\KategoriMateriResource\RelationManagers;
use App\Models\KategoriMateri;
use App\Models\KategoriMateris;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriMateriResource extends Resource
{
    protected static ?string $model = KategoriMateris::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationLabel = 'Kategori Materi';
    protected static ?string $pluralModelLabel = 'Master Materi';
    protected static ?string $navigationGroup = 'Menu Materi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
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
            'index' => Pages\ListKategoriMateris::route('/'),
            'create' => Pages\CreateKategoriMateri::route('/create'),
            'edit' => Pages\EditKategoriMateri::route('/{record}/edit'),
        ];
    }
}
