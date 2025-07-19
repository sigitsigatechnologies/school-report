<?php

namespace App\Filament\Erapor\Resources\PenilaianSumatifResource\Pages;

use App\Filament\Erapor\Resources\PenilaianSumatifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaianSumatif extends EditRecord
{
    protected static string $resource = PenilaianSumatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
