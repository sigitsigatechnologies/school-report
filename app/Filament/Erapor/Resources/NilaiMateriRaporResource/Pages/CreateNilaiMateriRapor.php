<?php

namespace App\Filament\Erapor\Resources\NilaiMateriRaporResource\Pages;

use App\Filament\Erapor\Resources\NilaiMateriRaporResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNilaiMateriRapor extends CreateRecord
{
    protected static string $resource = NilaiMateriRaporResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }


    public function afterCreate(): void
    {
        $formData = $this->form->getState();
        $nilaiMateriRapor = $this->record;

        $studentClassroomId = $formData['student_classroom_id'];
        $classroomId = \App\Models\StudentClassroom::find($studentClassroomId)?->classroom_id;

        $materis = \App\Models\MasterMateri::where('classroom_id', $classroomId)->get();

        foreach ($materis as $materi) {
            $nilai = $formData["nilai_{$materi->id}"] ?? null;

            if (!is_null($nilai)) {
                \App\Models\NilaiMateriRaporDetail::create([
                    'nilai_materi_rapor_id' => $nilaiMateriRapor->id,
                    'master_materi_id' => $materi->id,
                    'nilai' => $nilai,
                    'capaian_kompetensi' => $formData["capaian_kompetensi_{$materi->id}"] ?? '', // gunakan empty string kalau belum diisi
                ]);
            }
        }
    }
}
