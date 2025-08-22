<?php

namespace App\Filament\Resources\ProjectsResource\Pages;

use App\Filament\Resources\ProjectsResource;
use App\Models\StudentClassroom;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjects extends EditRecord
{
    protected static string $resource = ProjectsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $studentClassroom = StudentClassroom::find($data['student_classroom_id']);
        $data['academic_year_id'] = $studentClassroom?->academic_year_id;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $studentClassroom = StudentClassroom::find($data['student_classroom_id']);
        $data['academic_year_id'] = $studentClassroom?->academic_year_id;

        return $data;
    }
}
