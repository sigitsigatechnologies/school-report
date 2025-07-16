<?php

namespace App\Filament\Erapor\Resources\MasterMateriResource\Pages;

use App\Filament\Erapor\Resources\MasterMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterMateris extends ListRecords
{
    protected static string $resource = MasterMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
