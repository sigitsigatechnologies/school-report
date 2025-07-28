<?php

namespace App\Filament\Erapor\Resources\StudentExtracurricularResource\Pages;

use App\Filament\Erapor\Resources\StudentExtracurricularResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentExtracurriculars extends ListRecords
{
    protected static string $resource = StudentExtracurricularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
