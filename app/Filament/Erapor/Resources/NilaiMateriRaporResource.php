<?php

namespace App\Filament\Erapor\Resources;

use App\Filament\Erapor\Resources\NilaiMateriRaporResource\Pages;
use App\Models\Guru;
use App\Models\MasterMateri;
use App\Models\NilaiMateriRapor;
use App\Models\StudentClassroom;
use Filament\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class NilaiMateriRaporResource extends Resource
{
    protected static ?string $model = NilaiMateriRapor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?string $label = 'Legal Rapor';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Select::make('student_classroom_id')
                    ->label('Siswa')
                    ->required()
                    ->reactive()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->student->nama)
                    ->options(function (callable $get) {
                        $user = auth()->user();
                        $guruId = optional($user->guru)->id;

                        if (!$guruId) {
                            return [];
                        }

                        // Ambil classroom_id yang diampu guru
                        $classroomIds = \App\Models\Classroom::whereHas('gurus', function ($q) use ($guruId) {
                            $q->where('guru_id', $guruId);
                        })->pluck('id');

                        // Ambil semua student_classroom dari kelas yang diampu guru tsb
                        $query = \App\Models\StudentClassroom::whereIn('classroom_id', $classroomIds)
                            ->with(['student', 'classroom']);

                        // Cek siswa yang sudah pernah dipakai
                        $usedIds = \App\Models\NilaiMateriRapor::pluck('student_classroom_id')->toArray();

                        $currentId = $get('student_classroom_id');
                        if ($currentId) {
                            $usedIds = array_diff($usedIds, [$currentId]);
                        }

                        $query->whereNotIn('id', $usedIds);

                        return $query->get()->mapWithKeys(fn($sc) => [
                            $sc->id => "{$sc->student->nama} - kelas {$sc->classroom->name}"
                        ]);
                    })
                    ->placeholder('Pilih siswa')
                    ->searchable()
                    ->disablePlaceholderSelection()
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('semester', optional(\App\Models\StudentClassroom::find($state)?->academicYear)->semester)
                    ),

                // ->disabled(fn(?string $context) => $context === 'edit'),


                Select::make('naik_kelas')
                    ->label('Naik Kelas')
                    ->options(function (callable $get) {
                        $studentClassroomId = $get('student_classroom_id');

                        if (!$studentClassroomId) {
                            return [];
                        }

                        $studentClassroom = \App\Models\StudentClassroom::with('classroom')->find($studentClassroomId);

                        if (!$studentClassroom || !$studentClassroom->classroom) {
                            return [];
                        }

                        $currentLevel = (int) $studentClassroom->classroom->name; // misalnya 1 s/d 6

                        // Jika sudah kelas 6 → Lulus (kode 0 misalnya)
                        if ($currentLevel >= 6) {
                            return [
                                0 => 'Lulus',
                            ];
                        }

                        return [
                            $currentLevel + 1 => 'Naik ke Kelas ' . ($currentLevel + 1),
                            $currentLevel => 'Tetap di Kelas ' . $currentLevel,
                        ];
                    })
                    ->required()
                    ->reactive()
                    ->placeholder('Pilih status kenaikan')
                    ->nullable(),



                TextInput::make('semester')
                    ->label('Semester')
                    ->disabled()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (TextInput $component, $state, callable $get) {
                        $studentClassroomId = $get('student_classroom_id');
                        $semester = optional(
                            \App\Models\StudentClassroom::find($studentClassroomId)?->academicYear
                        )->semester;

                        $component->state($semester);
                    }),

            ]),

            // ✅ Bungkus dalam Closure melalui `->components()` atau `->schema()`
            Forms\Components\Fieldset::make('Input Nilai per Mata Pelajaran')
                ->schema(function (callable $get, callable $set, ?NilaiMateriRapor $record) {
                    $studentClassroomId = $get('student_classroom_id') ?? $record?->student_classroom_id;
                    if (!$studentClassroomId) return [];

                    $classroomId = StudentClassroom::find($studentClassroomId)?->classroom_id;
                    $materiList = MasterMateri::where('classroom_id', $classroomId)->get();

                    return $materiList->map(function ($materi) use ($record) {
                        $existingDetail = $record?->details
                            ?->firstWhere('master_materi_id', $materi->id);

                        return Forms\Components\Section::make($materi->mata_pelajaran) // ✅ Judul section
                            ->schema([
                                TextInput::make("nilai_{$materi->id}")
                                    ->label("Nilai")
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->default($existingDetail?->nilai)
                                    ->required(),

                                Textarea::make("capaian_kompetensi_{$materi->id}")
                                    ->label("Capaian Kompetensi")
                                    ->default($existingDetail?->capaian_kompetensi)
                                    ->autosize()
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->collapsible(); // opsional: biar bisa dibuka/tutup
                    })->toArray();
                })


        ]);
    }


    public static function table(Table $table): Table
    {
        // Ambil semua mapel (misalnya berdasarkan kelas atau global)
        // $mapels = MasterMateri::pluck('mata_pelajaran', 'id');

        // $mapels = MasterMateri::whereHas('classroom', function ($query) {
        //     $query->whereHas('gurus', function ($q) {
        //         $q->where('guru_id', auth()->id());
        //     });
        // })->pluck('mata_pelajaran', 'id');


        $guru = Guru::where('user_id', auth()->id())->with('classrooms')->first();

        $mapels = MasterMateri::whereIn('classroom_id', $guru?->classrooms->pluck('id') ?? [])
            ->pluck('mata_pelajaran', 'id');


        // dd($guruId);

        Log::info('Mapels found:', $mapels->toArray());

        return $table
            ->columns(array_merge(
                [
                    TextColumn::make('studentClassroom.student.nama')->label('Nama Siswa'),
                    TextColumn::make('semester')->label('Semester'),
                ],
                collect($mapels)->map(function ($namaMapel, $id) {
                    return TextColumn::make("mapel_{$id}")
                        ->label($namaMapel)
                        ->state(function ($record) use ($id) {
                            return optional(
                                $record->details->firstWhere('master_materi_id', $id)
                            )?->nilai ?? '-';
                        });
                })->values()->all(),
                [
                    TextColumn::make('jumlah_nilai')
                        ->label('Jumlah')
                        ->state(function ($record) {
                            return $record->details->sum('nilai');
                        }),
                ]

            ))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Print')
                    ->label('Cetak Rapor Pdf')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn($record) => route('print.nilai-materi-rapor.show', ['id' => $record->id]))
                    ->openUrlInNewTab(),
                // Tables\Actions\Action::make('Print')
                //     ->label('Cetak Rapor Excel')
                //     ->icon('heroicon-o-printer')
                //     ->color('success')
                //     ->url(fn($record) => route('print.nilai-materi-rapor.excel', ['id' => $record->id]))
                //     ->openUrlInNewTab(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['studentClassroom.student', 'details']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNilaiMateriRapors::route('/'),
            'create' => Pages\CreateNilaiMateriRapor::route('/create'),
            'edit' => Pages\EditNilaiMateriRapor::route('/{record}/edit'),
        ];
    }

    function convertToRoman($number)
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI'
        ];

        return $map[$number] ?? $number;
    }
}
