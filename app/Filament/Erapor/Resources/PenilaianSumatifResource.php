<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\PenilaianSumatifResource\Pages;
use App\Filament\Erapor\Resources\PenilaianSumatifResource\RelationManagers;
use App\Filament\Erapor\Resources\PenilaianSumatifResource\RelationManagers\DetailsRelationManager;
use App\Models\Guru;
use App\Models\MasterMateri;
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

    protected static ?string $navigationGroup = 'Penilaian';

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
                            return MasterMateri::pluck('mata_pelajaran', 'id');
                        }

                        // Ambil guru berdasarkan user_id
                        $guru = Guru::where('user_id', $user->id)->first();

                        // Ambil semua classroom ID yang diajar guru tsb
                        $classroomIds = $guru?->classrooms->pluck('id');

                        return MasterMateri::whereIn('classroom_id', $classroomIds)
                            ->pluck('mata_pelajaran', 'id');
                    })
                    ->searchable()
                    ->required(),
                    Select::make('academic_year_id')
                    ->label('Tahun Ajaran & Semester')
                    ->relationship(
                        name: 'academicYear',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn($query) => $query->where('is_active', true),
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->label)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('masterMateri.mata_pelajaran')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('masterMateri.classroom.name') // akses nama kelas
                    ->label('Kelas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('academicYear.label')
                    ->label('Tahun Ajaran & Semester')
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
