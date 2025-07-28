<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\MasterExtraKurikulerResource\Pages;
use App\Filament\Erapor\Resources\MasterExtraKurikulerResource\RelationManagers;
use App\Models\ExtraKurikuler;
use App\Models\MasterExtraKurikuler;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterExtraKurikulerResource extends Resource
{
    protected static ?string $model = ExtraKurikuler::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationGroup = 'Menu Ekstra Kurikuler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Ekskul')
                    ->required()
                    ->maxLength(255),

                    Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship(
                        name: 'academicYear',
                        titleAttribute: 'id', // bisa apa saja asal kolom di tabel (akan override di getOptionLabel)
                        modifyQueryUsing: fn ($query) => $query->active() // pakai scope dari model
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->label)
                    ->required(),
                
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required()
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Ekskul')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('academicYear.tahun_ajaran')
                    ->label('Nama Ekskul')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'active',
                        'danger' => 'inactive',
                    ])
                    ->sortable(),
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
            'index' => Pages\ListMasterExtraKurikulers::route('/'),
            'create' => Pages\CreateMasterExtraKurikuler::route('/create'),
            'edit' => Pages\EditMasterExtraKurikuler::route('/{record}/edit'),
        ];
    }
}
