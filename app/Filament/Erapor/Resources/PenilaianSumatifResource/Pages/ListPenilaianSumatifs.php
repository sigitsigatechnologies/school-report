<?php

namespace App\Filament\Erapor\Resources\PenilaianSumatifResource\Pages;

use App\Filament\Erapor\Resources\PenilaianSumatifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenilaianSumatifs extends ListRecords
{
    protected static string $resource = PenilaianSumatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
