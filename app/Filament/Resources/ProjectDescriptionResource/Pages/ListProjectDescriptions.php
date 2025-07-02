<?php

namespace App\Filament\Resources\ProjectDescriptionResource\Pages;

use App\Filament\Resources\ProjectDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectDescriptions extends ListRecords
{
    protected static string $resource = ProjectDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
