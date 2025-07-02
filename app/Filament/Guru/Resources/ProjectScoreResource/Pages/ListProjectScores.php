<?php

namespace App\Filament\Guru\Resources\ProjectScoreResource\Pages;

use App\Filament\Guru\Resources\ProjectScoreResource;
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
