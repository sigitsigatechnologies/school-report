<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\PenilaianSumatifResource\Pages;
use App\Filament\Erapor\Resources\PenilaianSumatifResource\RelationManagers;
use App\Filament\Erapor\Resources\PenilaianSumatifResource\RelationManagers\DetailsRelationManager;
use App\Models\PenilaianSumatif;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianSumatifResource extends Resource
{
    protected static ?string $model = PenilaianSumatif::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Menu Penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('master_materi_id')
                    ->label('Mata Pelajaran')
                    ->options(function () {
                        $user = auth()->user();

                        // Kalau bukan guru (misalnya admin/operator), tampilkan semua
                        if (! $user->hasRole('guru')) {
                            return \App\Models\MasterMateri::pluck('mata_pelajaran', 'id');
                        }

                        // Ambil guru berdasarkan user_id
                        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

                        // Ambil semua classroom ID yang diajar guru tsb
                        $classroomIds = $guru?->classrooms->pluck('id');

                        return \App\Models\MasterMateri::whereIn('classroom_id', $classroomIds)
                            ->pluck('mata_pelajaran', 'id');
                    })
                    ->searchable()
                    ->required(),
                Select::make('semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('masterMateri.mata_pelajaran')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('semester')->label('Semester'),
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
            DetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenilaianSumatifs::route('/'),
            'create' => Pages\CreatePenilaianSumatif::route('/create'),
            'edit' => Pages\EditPenilaianSumatif::route('/{record}/edit'),
        ];
    }
}
