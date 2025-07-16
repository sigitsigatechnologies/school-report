<?php

namespace App\Filament\Erapor\Resources\MasterExtraKurikulerResource\Pages;

use App\Filament\Erapor\Resources\MasterExtraKurikulerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterExtraKurikuler extends EditRecord
{
    protected static string $resource = MasterExtraKurikulerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
