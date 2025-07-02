<?php

namespace App\Filament\Resources\SubElementResource\Pages;

use App\Filament\Resources\SubElementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubElements extends ListRecords
{
    protected static string $resource = SubElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
