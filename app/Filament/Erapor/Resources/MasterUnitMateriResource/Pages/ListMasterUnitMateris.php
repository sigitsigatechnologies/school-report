<?php

namespace App\Filament\Erapor\Resources\MasterUnitMateriResource\Pages;

use App\Filament\Erapor\Resources\MasterUnitMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterUnitMateris extends ListRecords
{
    protected static string $resource = MasterUnitMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
