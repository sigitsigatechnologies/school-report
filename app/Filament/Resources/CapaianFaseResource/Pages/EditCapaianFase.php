<?php

namespace App\Filament\Resources\CapaianFaseResource\Pages;

use App\Filament\Resources\CapaianFaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCapaianFase extends EditRecord
{
    protected static string $resource = CapaianFaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
