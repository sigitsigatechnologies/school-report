<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class NilaiMateriExport implements FromView
{
    protected $rapor;
    protected $ekstrakurikuler;
    protected $kesehatanAbsensi;

    public function __construct($rapor, $ekstrakurikuler, $kesehatanAbsensi)
    {
        $this->rapor = $rapor;
        $this->ekstrakurikuler = $ekstrakurikuler;
        $this->kesehatanAbsensi = $kesehatanAbsensi;
    }
    public function view(): View
    {
       
        return view('print.nilai-materi-excel', [
            'rapor' => $this->rapor,
            'ekstrakurikuler' => $this->ekstrakurikuler,
            'kesehatanAbsensi' => $this->kesehatanAbsensi,
        ]);
    }

}
