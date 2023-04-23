<?php

namespace App\Imports;

use App\Models\units;
use App\Models\UnitsImports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new units([
            'pc_number' => $row['pc_number'],
            'status' => $row['status'],
            'issue' => $row['issue'],
            'room_id' => $row['room_id']
        ]);
    }
}
