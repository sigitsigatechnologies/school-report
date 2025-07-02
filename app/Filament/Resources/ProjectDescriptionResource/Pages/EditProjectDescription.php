<?php

namespace App\Filament\Resources\ProjectDescriptionResource\Pages;

use App\Filament\Resources\ProjectDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectDescription extends EditRecord
{
    protected static string $resource = ProjectDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
