<?php

namespace App\Filament\Erapor\Resources\NilaiMateriRaporResource\Pages;

use App\Filament\Erapor\Resources\NilaiMateriRaporResource;
use App\Filament\Widgets\RaporSummaryTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNilaiMateriRapors extends ListRecords
{
    protected static string $resource = NilaiMateriRaporResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         RaporSummaryTable::class,
    //     ];
    // }


    public function getFooterWidgets(): array
    {
        return [
            RaporSummaryTable::class,
        ];
    }
    
    
}
