<?php

namespace App\Filament\Widgets;

use App\Models\MasterMateri;
use Filament\Widgets\Widget;
use App\Models\NilaiMateriRaporDetail;

class RaporSummaryTable extends Widget
{
    protected static string $view = 'filament.widgets.rapor-summary-table';
    protected int | string | array $columnSpan = 'full';


    // public function getViewData(): array
    // {
    //     $mapels = MasterMateri::pluck('mata_pelajaran', 'id');

    //     $summary = [];
    //     $totalPerMapel = [];
    //     $totalNilai = 0;

    //     foreach ($mapels as $id => $nama) {
    //         $nilaiList = NilaiMateriRaporDetail::where('master_materi_id', $id)->pluck('nilai');
    //         $summary[$id] = [
    //             'rata' => round($nilaiList->avg(), 0),
    //             'max' => $nilaiList->max(),
    //             'min' => $nilaiList->min(),
    //         ];

    //         $total = $nilaiList->sum();
    //         $totalPerMapel[$id] = $total;
    //         $totalNilai += $total;
    //     }

    //     return [
    //         'mapels' => $mapels,
    //         'totalPerMapel' => $totalPerMapel,
    //         'totalNilai' => $totalNilai,
    //         'summary' => $summary,
    //     ];
    // }

    public function getViewData(): array
    {
        $user = auth()->user();

        // Ambil classroom_id dari student yang login
        $classroomId = $user->guru?->classrooms?->pluck('id') ?? collect();

        // Ambil hanya mapel untuk kelas ini
        $mapels = MasterMateri::where('classroom_id', $classroomId)
            ->pluck('mata_pelajaran', 'id');

        $summary = [];
        $totalPerMapel = [];
        $totalNilai = 0;

        foreach ($mapels as $id => $nama) {
            $nilaiList = NilaiMateriRaporDetail::where('master_materi_id', $id)
                ->pluck('nilai');

            $summary[$id] = [
                'rata' => round($nilaiList->avg(), 0),
                'max' => $nilaiList->max(),
                'min' => $nilaiList->min(),
            ];

            $total = $nilaiList->sum();
            $totalPerMapel[$id] = $total;
            $totalNilai += $total;
        }

        return [
            'mapels' => $mapels,
            'totalPerMapel' => $totalPerMapel,
            'totalNilai' => $totalNilai,
            'summary' => $summary,
        ];
    }


    public static function canView(): bool
    {
        return request()->is('erapor/nilai-materi-rapor*');
    }
}
