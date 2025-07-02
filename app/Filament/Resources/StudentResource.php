<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('nis')->label('NIS'),
                        Forms\Components\TextInput::make('nisn')->label('NISN'),
                        Forms\Components\TextInput::make('nama')->label('Nama Peserta Didik'),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('L/P')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
                        Forms\Components\TextInput::make('tempat_lahir')->label('Tempat Lahir'),
                        Forms\Components\DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),
                        Forms\Components\TextInput::make('agama'),
                        Forms\Components\TextInput::make('pendidikan_sebelumnya')->label('Pendidikan Sebelumnya'),
                        Forms\Components\Textarea::make('alamat')->label('Alamat Peserta Didik')->columnSpanFull(),
                        Forms\Components\Select::make('classroom_id')
                        ->label('Kelas')
                        ->relationship('classroom', 'name') // pastikan relasinya sesuai
                        ->required(),
                    ]),

                Forms\Components\Section::make('Orang Tua')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')->label('Nama Ayah'),
                        Forms\Components\TextInput::make('pekerjaan_ayah')->label('Pekerjaan Ayah'),
                        Forms\Components\TextInput::make('nama_ibu')->label('Nama Ibu'),
                        Forms\Components\TextInput::make('pekerjaan_ibu')->label('Pekerjaan Ibu'),

                        Forms\Components\Textarea::make('jalan')->label('Jalan'),
                        Forms\Components\TextInput::make('kelurahan')->label('Kelurahan / Desa'),
                        Forms\Components\TextInput::make('kapanewon'),
                        Forms\Components\TextInput::make('kota')->label('Kab/Kota'),
                        Forms\Components\TextInput::make('provinsi'),
                    ])->columns(2),

                Forms\Components\Section::make('Wali Peserta Didik')
                    ->schema([
                        Forms\Components\TextInput::make('nama_wali')->label('Nama Wali'),
                        Forms\Components\TextInput::make('pekerjaan_wali')->label('Pekerjaan Wali'),
                        Forms\Components\Textarea::make('alamat_wali')->label('Alamat Wali'),
                        Toggle::make('status')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')->label('NIS')
                    ->label('NIS')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nisn')->label('NISN'),
                TextColumn::make('nama')->label('Nama') ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jenis_kelamin')->label('L/P'),
                TextColumn::make('tempat_lahir')->label('Tempat Lahir'),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date(),
                TextColumn::make('agama')->label('Agama'),
                TextColumn::make('pendidikan_sebelumnya')->label('Pendidikan Sebelumnya'),
                TextColumn::make('alamat')->label('Alamat')->limit(30),
                
                TextColumn::make('nama_ayah')->label('Nama Ayah'),
                TextColumn::make('pekerjaan_ayah')->label('Pekerjaan Ayah'),
                TextColumn::make('nama_ibu')->label('Nama Ibu'),
                TextColumn::make('pekerjaan_ibu')->label('Pekerjaan Ibu'),
                TextColumn::make('jalan')->label('Jalan')->limit(30),
                TextColumn::make('kelurahan')->label('Kelurahan/Desa'),
                TextColumn::make('kapanewon')->label('Kapanewon'),
                TextColumn::make('kota')->label('Kab/Kota'),
                TextColumn::make('provinsi')->label('Provinsi'),
                
                TextColumn::make('nama_wali')->label('Nama Wali'),
                TextColumn::make('pekerjaan_wali')->label('Pekerjaan Wali'),
                TextColumn::make('alamat_wali')->label('Alamat Wali')->limit(30),
                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ]),

                Tables\Filters\SelectFilter::make('agama')
                    ->label('Agama')
                    ->options(fn () => Student::query()
                        ->distinct()
                        ->pluck('agama', 'agama')
                        ->filter()),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                ]),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
