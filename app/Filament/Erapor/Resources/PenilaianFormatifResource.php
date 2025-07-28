<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\PenilaianFormatifDetailResource\RelationManagers\PenilaianFormatifDetailsRelationManager as RelationManagersPenilaianFormatifDetailsRelationManager;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\CreatePenilaianFormatif;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\EditPenilaianFormatif;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\InputNilai;
use App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages\ListPenilaianFormatifs;
use App\Models\MasterMateri;
use App\Models\PenilaianFormatif;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PenilaianFormatifResource extends Resource
{
    protected static ?string $model = PenilaianFormatif::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

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
                        $guru = \App\Models\Guru::where('user_id', $user->id)->first();

                        // Ambil semua classroom ID yang diajar guru tsb
                        $classroomIds = $guru?->classrooms->pluck('id');

                        return MasterMateri::whereHas('classroom', function ($query) use ($classroomIds) {
                            $query->whereIn('id', $classroomIds);
                        })->pluck('mata_pelajaran', 'id');
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

                // ->searchable(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('masterMateri.mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                Tables\Columns\TextColumn::make('masterMateri.classroom.name') // akses nama kelas
                    ->label('Kelas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('academicYear.label')
                    ->label('Tahun Ajaran & Semester')

            ])
            ->filters([
                Tables\Filters\Filter::make('Tahun Ajaran')
                    ->form([
                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran & Semester')
                            ->options(
                                \App\Models\AcademicYear::all()->pluck('label', 'id')
                            )
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['academic_year_id'], fn($q, $id) => $q->where('academic_year_id', $id));
                    }),
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
