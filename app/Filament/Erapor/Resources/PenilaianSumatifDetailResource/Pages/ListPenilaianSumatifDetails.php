<?php

namespace App\Filament\Erapor\Resources\PenilaianSumatifDetailResource\Pages;

use App\Filament\Erapor\Resources\PenilaianSumatifDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenilaianSumatifDetails extends ListRecords
{
    protected static string $resource = PenilaianSumatifDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
