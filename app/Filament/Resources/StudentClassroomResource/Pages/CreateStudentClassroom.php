<?php

namespace App\Filament\Resources\StudentClassroomResource\Pages;

use App\Filament\Resources\StudentClassroomResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentClassroom extends CreateRecord
{
    protected static string $resource = StudentClassroomResource::class;

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Data berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        // paksa selalu redirect ke table
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return Notification::make()
            ->title('Data Berhasil di Simpan')
            ->body('Jika Naik kelas silahkan check kepada Guru yang di Pengampu Kelas
            ! </br> Di kelas ini Murid tidak tersedia')
            ->success()->duration(10000);;
    }
}
