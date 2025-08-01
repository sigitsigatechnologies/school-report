<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Models\Guru;
use App\Models\JobPosition;
use App\Models\User;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Data Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama Guru')->required(),
                TextInput::make('nip')->label('NIP'),
                Select::make('user_id')
                    ->label('User')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('job_id')
                    ->label('Jabatan')
                    ->options(JobPosition::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                MultiSelect::make('classrooms')
                    ->relationship('classrooms', 'name')
                    ->label('Kelas yang Diampu')
                    ->preload()
                    ->searchable(),

                // Tambahan:
                Textarea::make('alamat_wali')
                    ->label('Alamat Wali')
                    ->rows(2)
                    ->maxLength(255),

                TextInput::make('pekerjaan_wali')
                    ->label('Pekerjaan Wali')
                    ->maxLength(100),

                Toggle::make('status_wali')
                    ->label('Status Wali Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('nip'),
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('job.name')->label('Jabatan'),
                BadgeColumn::make('classrooms.name')
                    ->label('Kelas Diampu')
                    ->separator(', '),

                // Tambahan:
                TextColumn::make('pekerjaan_wali')->label('Pekerjaan Wali'),
                TextColumn::make('alamat_wali')->label('Alamat Wali')->limit(20),
                IconColumn::make('status_wali')
                    ->label('Status Wali')
                    ->boolean(),
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }

    // public static function canViewAny(): bool
    // {
    //     return auth()->user()?->can('guru.view');
    // }

    // public static function canCreate(): bool
    // {
    //     return auth()->user()?->can('guru.create');
    // }

    // public static function canEdit(Model $record): bool
    // {
    //     return auth()->user()?->can('guru.edit');
    // }

    // public static function canDelete(Model $record): bool
    // {
    //     return auth()->user()?->can('guru.delete');
    // }

}
