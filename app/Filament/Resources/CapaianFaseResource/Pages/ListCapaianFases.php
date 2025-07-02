<?php

namespace App\Filament\Resources\CapaianFaseResource\Pages;

use App\Filament\Resources\CapaianFaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCapaianFases extends ListRecords
{
    protected static string $resource = CapaianFaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
