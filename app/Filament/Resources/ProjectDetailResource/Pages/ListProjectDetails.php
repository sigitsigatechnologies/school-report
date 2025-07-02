<?php

namespace App\Filament\Resources\ProjectDetailResource\Pages;

use App\Filament\Resources\ProjectDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectDetails extends ListRecords
{
    protected static string $resource = ProjectDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
