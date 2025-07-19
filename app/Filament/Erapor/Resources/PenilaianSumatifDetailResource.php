<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\PenilaianSumatifDetailResource\Pages;
use App\Filament\Erapor\Resources\PenilaianSumatifDetailResource\RelationManagers;
use App\Filament\Erapor\Resources\PenilaianTesDetailResource\RelationManagers\TesDetailRelationManager;
use App\Models\PenilaianSumatifDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianSumatifDetailResource extends Resource
{
    protected static ?string $model = PenilaianSumatifDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Menu Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'nama')
                    ->label('Siswa')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('master_unit_materi_id')
                    ->relationship('masterUnitMateri', 'unit_materi')
                    ->label('Unit Materi')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nilai')
                    ->label('Nilai')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.nama')
                    ->label('Siswa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('masterUnitMateri.unit_materi')
                    ->label('Unit Materi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable(),

                TextColumn::make('nilai_tes')
                    ->label('Nilai Tes')
                    ->getStateUsing(function ($record) {
                        return $record->tesDetails->first()->nilai_tes ?? '-';
                    }),
                TextColumn::make('nilai_non_tes')
                    ->label('Nilai Non Tes')
                    ->getStateUsing(function ($record) {
                        return $record->tesDetails->first()->nilai_tes ?? '-';
                    }),
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
            TesDetailRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenilaianSumatifDetails::route('/'),
            'create' => Pages\CreatePenilaianSumatifDetail::route('/create'),
            'edit' => Pages\EditPenilaianSumatifDetail::route('/{record}/edit'),
        ];
    }
}
