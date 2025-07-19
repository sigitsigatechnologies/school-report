<?php

namespace App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages;

use App\Filament\Erapor\Resources\PenilaianFormatifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenilaianFormatifs extends ListRecords
{
    protected static string $resource = PenilaianFormatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
