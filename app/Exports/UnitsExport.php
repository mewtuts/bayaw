<?php

namespace App\Exports;

use App\Models\units;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UnitsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return units::all();
        return collect(units::getAllUnits());
    }

    public function headings():array
    {
        return ['PC Number','Status','Issue','Lab Number'];
    }
}
