<?php

namespace App\Filament\Erapor\Resources\PenilaianFormatifResource\Pages;

use App\Filament\Erapor\Resources\PenilaianFormatifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaianFormatif extends EditRecord
{
    protected static string $resource = PenilaianFormatifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
