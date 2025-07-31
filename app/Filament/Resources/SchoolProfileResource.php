<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolProfileResource\Pages;
use App\Filament\Resources\SchoolProfileResource\RelationManagers;
use App\Models\SchoolProfile;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolProfileResource extends Resource
{
    protected static ?string $model = SchoolProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Tentang Sekolah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_sekolah')->label('Nama Sekolah')->required(),
                TextInput::make('npsn')->label('NPSN')->required(),
                TextInput::make('nss')->label('NSS'),
                Textarea::make('alamat')->label('Alamat')->rows(2)->required(),
                TextInput::make('kode_pos')->label('Kode Pos'),
                TextInput::make('kalurahan')->label('Kalurahan'),
                TextInput::make('kapanewon')->label('Kapanewon'),
                TextInput::make('kabupaten')->label('Kabupaten'),
                TextInput::make('provinsi')->label('Provinsi'),
                TextInput::make('website')->label('Website'),
                TextInput::make('email')->label('Email')->email(),
                TextInput::make('kepala_sekolah')->label('Kepala Sekolah'),
                TextInput::make('nip_kepala_sekolah')->label('NIP Kepala Sekolah'),
                TextInput::make('wali_kelas')->label('Wali Kelas'),
                TextInput::make('nip_wali_kelas')->label('NIP Wali Kelas'),
                TextInput::make('kelas')->label('Kelas'),
                TextInput::make('fase')->label('Fase'),
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'tahun_ajaran')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $academicYear = \App\Models\AcademicYear::find($state);
                        if ($academicYear) {
                            $set('semester', $academicYear->semester);
                        }
                    }),
                TextInput::make('semester')
                    ->label('Semester')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('tempat_tanggal_rapor')
                    ->label('Tempat, Tanggal Rapor')
                    ->default('Yogyakarta, ' . Carbon::now()->translatedFormat('d F Y'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_sekolah')->label('Nama Sekolah')->searchable(),
                TextColumn::make('npsn'),
                TextColumn::make('alamat')->limit(30),
                TextColumn::make('kepala_sekolah'),
                TextColumn::make('kelas'),
                TextColumn::make('fase'),
                TextColumn::make('semester'),
                TextColumn::make('tahun_ajaran'),
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
            'index' => Pages\ListSchoolProfiles::route('/'),
            'create' => Pages\CreateSchoolProfile::route('/create'),
            'edit' => Pages\EditSchoolProfile::route('/{record}/edit'),
        ];
    }
}
