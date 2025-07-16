<?php

namespace App\Filament\Erapor\Resources\MasterUnitMateriResource\Pages;

use App\Filament\Erapor\Resources\MasterUnitMateriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterUnitMateri extends EditRecord
{
    protected static string $resource = MasterUnitMateriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
