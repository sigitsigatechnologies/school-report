<?php

namespace App\Filament\Resources\SubElementResource\Pages;

use App\Filament\Resources\SubElementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubElement extends EditRecord
{
    protected static string $resource = SubElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
