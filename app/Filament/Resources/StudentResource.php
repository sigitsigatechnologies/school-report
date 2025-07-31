<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Student';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('nis')->label('NIS'),
                        TextInput::make('nisn')->label('NISN'),
                        TextInput::make('nama')->label('Nama Peserta Didik'),
                        Select::make('jenis_kelamin')
                            ->label('L/P')
                            ->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
                        TextInput::make('tempat_lahir')->label('Tempat Lahir'),
                        DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->maxDate(now()),
                        Select::make('agama')
                            ->label('Agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                            ])
                            ->required()
                            ->searchable(),
                        TextInput::make('pendidikan_sebelumnya')->label('Pendidikan Sebelumnya'),
                        Textarea::make('alamat')->label('Alamat Peserta Didik')->columnSpanFull(),
                    ]),

                Section::make('Orang Tua')
                    ->schema([
                        TextInput::make('nama_ayah')->label('Nama Ayah'),
                        TextInput::make('pekerjaan_ayah')->label('Pekerjaan Ayah'),
                        TextInput::make('nama_ibu')->label('Nama Ibu'),
                        TextInput::make('pekerjaan_ibu')->label('Pekerjaan Ibu'),

                        Textarea::make('jalan')->label('Jalan'),
                        TextInput::make('kelurahan')->label('Kelurahan / Desa'),
                        TextInput::make('kapanewon'),
                        TextInput::make('kota')->label('Kab/Kota'),
                        TextInput::make('provinsi'),
                    ])->columns(2),
                    // Section::make('Wali Peserta Didik')
                    //     ->schema([
                    //         Hidden::make('wali_id')
                    //             ->default(fn () => auth()->user()?->guru?->id),
                    
                    //         TextInput::make('pekerjaan_wali')
                    //             ->label('Pekerjaan Wali')
                    //             ->default(fn () => auth()->user()?->guru?->pekerjaan)
                    //             ->disabled(), // hapus kalau mau bisa diubah
                    
                    //         Textarea::make('alamat_wali')
                    //             ->label('Alamat Wali')
                    //             ->default(fn () => auth()->user()?->guru?->alamat)
                    //             ->disabled(),
                    
                            Toggle::make('status')
                                ->label('Status Murid')
                                ->default(true)
                                ->helperText('Hijau = Aktif, Abu-abu = Tidak Aktif'),
                    //     ]),
                    
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
                TextColumn::make('nama')->label('Nama')->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('classroom.name')
                    ->label('Kelas')
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
                    ->options(fn() => Student::query()
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
