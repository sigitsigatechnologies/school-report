<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\PenilaianFormatifDetailResource\RelationManagers\PenilaianFormatifDetailsRelationManager as RelationManagersPenilaianFormatifDetailsRelationManager;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\CreatePenilaianFormatif;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\EditPenilaianFormatif;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\InputNilai;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\ListPenilaianFormatifs;
use App\Models\PenilaianFormatif;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenilaianFormatifResource extends Resource
{
    protected static ?string $model = PenilaianFormatif::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

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
                Tables\Actions\EditAction::make()
                    ->label('Edit Nilai Per Siswa')
                    ->icon('heroicon-o-user'),
            
                Tables\Actions\Action::make('Input Nilai')
                    ->label('Input Nilai')
                    ->icon('heroicon-o-user-group')
                    ->color('success')
                    ->url(fn($record) => static::getUrl('input-nilai', ['record' => $record]))
                    ->openUrlInNewTab(),
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
            RelationManagersPenilaianFormatifDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenilaianFormatifs::route('/'),
            'create' => CreatePenilaianFormatif::route('/create'),
            'edit' => EditPenilaianFormatif::route('/{record}/edit'),

            'input-nilai' => InputNilai::route('/{record}/input-nilai'),
        ];
    }
}
