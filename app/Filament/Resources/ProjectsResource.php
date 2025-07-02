<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsResource\Pages;
use App\Filament\Resources\ProjectsResource\RelationManagers;
use App\Models\CapaianFase;
use App\Models\Dimension;
use App\Models\Elements;
use App\Models\ProjectDescription;
use App\Models\ProjectDescriptionDetails;
use App\Models\Projects;
use App\Models\SubElements;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectsResource extends Resource
{
    protected static ?string $model = Projects::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationLabel = 'Project Creation';
    protected static ?string $pluralModelLabel = 'Project Creation';
    protected static ?string $navigationGroup = 'Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title_project')
                    ->label('Judul Proyek')
                    ->required(),

                TextInput::make('fase')
                    ->label('Fase')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('classroom')
                    ->label('Kelas')
                    ->disabled()
                    ->dehydrated(false),
                Select::make('project_description_detail_id')
                    ->label('Pilih Judul Proyek dari Deskripsi')
                    ->options(ProjectDescriptionDetails::all()->pluck('title', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $detail = \App\Models\ProjectDescriptionDetails::with('header.classroom')->find($state);
                
                        $set('fase', $detail?->header?->fase);
                        $set('classroom', $detail?->header?->classroom?->name);
                    })
                    ->afterStateHydrated(function (callable $get, callable $set) {
                        $state = $get('project_description_detail_id');
                
                        $detail = \App\Models\ProjectDescriptionDetails::with('header.classroom')->find($state);
                
                        $set('fase', $detail?->header?->fase);
                        $set('classroom', $detail?->header?->classroom?->name);
                    }),
                    
                    Repeater::make('projectDetails')
                        ->label('Detail Proyek')
                        ->relationship('projectDetails')
                        ->schema([
                            Grid::make(12)->schema([
                                Select::make('dimension_id')
                                    ->label('Dimensi')
                                    ->options(Dimension::all()->pluck('name', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('element_id', null))
                                    ->required()
                                    ->columnSpan(3),

                                Select::make('element_id')
                                    ->label('Elemen')
                                    ->options(fn (callable $get) =>
                                        \App\Models\Elements::where('dimension_id', $get('dimension_id'))->pluck('name', 'id')
                                    )
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('sub_element_id', null))
                                    ->required()
                                    ->columnSpan(3),

                                Select::make('sub_element_id')
                                    ->label('Sub Elemen')
                                    ->options(fn (callable $get) =>
                                        \App\Models\SubElements::where('element_id', $get('element_id'))->pluck('name', 'id')
                                    )
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('capaian_fase_id', null))
                                    ->required()
                                    ->columnSpan(3),

                                Select::make('capaian_fase_id')
                                    ->label('Capaian Fase')
                                    ->options(fn (callable $get) =>
                                        \App\Models\CapaianFase::where('sub_element_id', $get('sub_element_id'))->pluck('description', 'id')
                                    )
                                    ->required()
                                    ->columnSpan(3),
                            ]),
                        ])
                        ->columns(1)
                        ->minItems(1)
                        ->columnSpanFull()
                        ->createItemButtonLabel('Tambah Detail'),


                // Select::make('project_description_detail_id')
                //     ->label('Pilih Judul Proyek dari Deskripsi')
                //     ->options(ProjectDescriptionDetails::all()->pluck('title', 'id')) // semua data
                //     ->searchable()
                //     ->reactive()
                //     ->required()
                //     ->afterStateUpdated(function (callable $set, $state) {
                //         $detail = ProjectDescriptionDetails::find($state);
                //     }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_project')->label('Judul Proyek'),
                TextColumn::make('detail.header.fase')->label('Fase'),
                TextColumn::make('detail.header.classroom.name')->label('Kelas'),
                TextColumn::make('detail.title')->label('Judul Detail'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProjects::route('/create'),
            'edit' => Pages\EditProjects::route('/{record}/edit'),
        ];
    }
}
