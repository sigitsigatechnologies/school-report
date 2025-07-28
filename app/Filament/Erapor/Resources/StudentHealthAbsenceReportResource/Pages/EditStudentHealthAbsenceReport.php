<?php

namespace App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource\Pages;

use App\Filament\Erapor\Resources\StudentHealthAbsenceReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentHealthAbsenceReport extends EditRecord
{
    protected static string $resource = StudentHealthAbsenceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
