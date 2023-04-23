<?php

namespace App\Exports;

use App\Models\Logs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Logs::getAllUnits());
    }

    public function headings():array
    {
        return ['Name','Day','Time In','Time Out', 'PC #', 'Subject','Section','Room #', 'Instructor'];
    }
}
