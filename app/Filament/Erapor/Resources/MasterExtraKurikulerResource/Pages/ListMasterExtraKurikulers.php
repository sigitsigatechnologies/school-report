<?php

namespace App\Filament\Erapor\Resources\MasterExtraKurikulerResource\Pages;

use App\Filament\Erapor\Resources\MasterExtraKurikulerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterExtraKurikulers extends ListRecords
{
    protected static string $resource = MasterExtraKurikulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
