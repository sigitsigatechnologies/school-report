<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\MasterTpResource\RelationManagers\MasterTpsRelationManager;
use App\Filament\Erapor\Resources\MasterUnitMateriResource\Pages;
use App\Filament\Erapor\Resources\MasterUnitMateriResource\RelationManagers;
use App\Models\MasterUnitMateri;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MasterUnitMateriResource extends Resource
{
    protected static ?string $model = MasterUnitMateri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Menu Materi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('master_materi_id')
                ->label('Mata Pelajaran')
                ->options(function () {
                    $user = auth()->user();
            
                    if ($user->hasRole('guru') && $guru = $user->guru) {
                        $classroomIds = $guru->classrooms->pluck('id');
                        
                        return \App\Models\MasterMateri::whereIn('classroom_id', $classroomIds)
                            ->pluck('mata_pelajaran', 'id');
                    }
            
                    // Untuk admin atau role lain
                    return \App\Models\MasterMateri::pluck('mata_pelajaran', 'id');
                })
                ->required()
                ->searchable(),
            
                TextInput::make('unit_materi')
                ->label('Unit Materi')
                ->required()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('masterMateri.mata_pelajaran')->label('Mata Pelajaran'),
                TextColumn::make('unit_materi')->label('Unit Materi'),
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
            MasterTpsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    $user = Auth::user();

    if ($user->hasRole('guru')) {
        $guru = $user->guru;
        $classroomIds = $guru->classrooms->pluck('id');

        // filter lewat relasi masterMateri
        $query->whereHas('masterMateri', function ($q) use ($classroomIds) {
            $q->whereIn('classroom_id', $classroomIds);
        });
    }

    return $query;
}



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMasterUnitMateris::route('/'),
            'create' => Pages\CreateMasterUnitMateri::route('/create'),
            'edit' => Pages\EditMasterUnitMateri::route('/{record}/edit'),
        ];
    }
}
