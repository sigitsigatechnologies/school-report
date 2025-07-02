<?php

namespace App\Filament\Resources\ProjectScoreResource\Pages;

use App\Filament\Resources\ProjectScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectScores extends ListRecords
{
    protected static string $resource = ProjectScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
