<?php

namespace App\Filament\Erapor\Resources\NilaiMateriRaporResource\Pages;

use App\Filament\Erapor\Resources\NilaiMateriRaporResource;
use App\Models\MasterMateri;
use App\Models\NilaiMateriRaporDetail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNilaiMateriRapor extends EditRecord
{
    protected static string $resource = NilaiMateriRaporResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // public function afterSave(): void
    // {
    //     $data = $this->form->getState(); // semua data dari form

    //     $studentClassroomId = $data['student_classroom_id'] ?? null;
    //     $classroomId = \App\Models\StudentClassroom::find($studentClassroomId)?->classroom_id;
    //     $materiList = MasterMateri::where('classroom_id', $classroomId)->get();

    //     foreach ($materiList as $materi) {
    //         $field = "nilai_{$materi->id}";
    //         $nilai = $data[$field] ?? null;

    //         if ($nilai === null) continue;

    //         // update atau create
    //         NilaiMateriRaporDetail::updateOrCreate(
    //             [
    //                 'nilai_materi_rapor_id' => $this->record->id,
    //                 'master_materi_id' => $materi->id,
    //             ],
    //             [
    //                 'nilai' => $nilai,
    //                 'capaian_kompetensi' => $data["capaian_kompetensi_{$materi->id}"] ?? null, 
    //             ]
    //         );
    //     }
    // }

    // public function mutateFormDataBeforeFill(array $data): array
    // {
    //     foreach ($this->record->details as $detail) {
    //         $data["nilai_{$detail->master_materi_id}"] = $detail->nilai;
    //     }

    //     return $data;
    // }

    public function afterSave(): void
{
    $data = $this->form->getState();

    $studentClassroomId = $data['student_classroom_id'] ?? null;
    $classroomId = \App\Models\StudentClassroom::find($studentClassroomId)?->classroom_id;
    $materiList = MasterMateri::where('classroom_id', $classroomId)->get();

    foreach ($materiList as $materi) {
        $field = "nilai_{$materi->id}";
        $nilai = $data[$field] ?? null;

        if ($nilai === null) continue;

        NilaiMateriRaporDetail::updateOrCreate(
            [
                'nilai_materi_rapor_id' => $this->record->id,
                'master_materi_id' => $materi->id,
            ],
            [
                'nilai' => $nilai,
                'capaian_kompetensi' => $data["capaian_kompetensi_{$materi->id}"] ?? '',
            ]
        );
    }
}

public function mutateFormDataBeforeFill(array $data): array
{
    foreach ($this->record->details as $detail) {
        $data["nilai_{$detail->master_materi_id}"] = $detail->nilai;
        $data["capaian_kompetensi_{$detail->master_materi_id}"] = $detail->capaian_kompetensi;
    }

    return $data;
}

}
