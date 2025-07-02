<?php

namespace App\Filament\Resources\ProjectScoreResource\Pages;

use App\Filament\Resources\ProjectScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectScore extends EditRecord
{
    protected static string $resource = ProjectScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
