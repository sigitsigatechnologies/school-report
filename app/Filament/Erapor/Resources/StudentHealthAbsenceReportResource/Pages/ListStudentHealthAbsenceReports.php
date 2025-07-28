<?php

namespace App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource\Pages;

use App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentHealthAbsenceReports extends ListRecords
{
    protected static string $resource = StudentHealthAbsenceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
