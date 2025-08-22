<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\MasterMateriResource\Pages;
use App\Filament\Erapor\Resources\MasterMateriResource\RelationManagers\MasterUnitMaterisRelationManager;
use App\Models\MasterMateri;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Classroom;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;

class MasterMateriResource extends Resource
{
    protected static ?string $model = MasterMateri::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Master Materi';
    protected static ?string $pluralModelLabel = 'Master Materi';
    protected static ?string $navigationGroup = 'Menu Materi';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Card::make([
                    Grid::make(2)->schema([
                        TextInput::make('mata_pelajaran')
                            ->label('Mata Pelajaran')
                            ->required(),
                        Select::make('kategori_materi_id')
                            ->label('Kategori Materi')
                            ->relationship('kategori', 'nama'),
                            // ->required(),

                        // Select::make('classroom_id')
                        //     ->label('Kelas')
                        //     ->options(function () {
                        //         $user = auth()->user();

                        //         if ($user->hasRole('guru')) {
                        //             return $user->guru->classrooms->pluck('name', 'id');
                        //         }

                        //         return Classroom::pluck('name', 'id');
                        //     })
                        //     ->required()
                        //     ->reactive(),

                        Select::make('classroom_id')
                            ->label('Kelas')
                            ->options(function () {
                                $user = auth()->user();

                                if ($user->hasRole('guru') && $user->guru) {
                                    return $user->guru->classrooms->pluck('name', 'id');
                                }

                                return Classroom::pluck('name', 'id');
                            })
                            ->required()
                            ->reactive(),

                        // Select::make('academic_year_id')
                        //     ->label('Tahun Ajaran')
                        //     ->relationship('academicYear', 'tahun_ajaran')
                        //     ->required(),

                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran & Semester')
                            ->relationship(
                                name: 'academicYear',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn($query) => $query->where('is_active', true),
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->label)
                            ->required()
                    ]),
                ]),

                Toggle::make('status')
                    ->label('Status Mata Pelajaran')
                    ->inline()
                    ->onColor('success')
                    ->offColor('gray')
                    ->default(true)
                    ->helperText('Hijau = Aktif, Abu-abu = Tidak Aktif'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mata_pelajaran')->label('Mata Pelajaran')->searchable(),
                TextColumn::make('classroom.name')->label('Kelas'),
                TextColumn::make('academicYear.tahun_ajaran')->label('Tahun Ajaran'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(bool $state) => $state ? 'Active' : 'Inactive')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger'),


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
            MasterUnitMaterisRelationManager::class,
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     $query = parent::getEloquentQuery();

    //     $user = Auth::user();

    //     if ($user->hasRole('guru')) {
    //         $guru = $user->guru; // pastikan relasi `guru` ada di model User
    //         $classroomIds = $guru->classrooms->pluck('id');

    //         $query->whereIn('classroom_id', $classroomIds);
    //     }

    //     return $query;
    // }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->hasRole('guru') && $user->guru) {
            $classroomIds = $user->guru->classrooms->pluck('id');
            $query->whereIn('classroom_id', $classroomIds);
        }

        return $query;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterMateris::route('/'),
            'create' => Pages\CreateMasterMateri::route('/create'),
            'edit' => Pages\EditMasterMateri::route('/{record}/edit'),
        ];
    }
}
