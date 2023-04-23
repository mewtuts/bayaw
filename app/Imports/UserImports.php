<?php

namespace App\Imports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserImports implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Users([
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'id_number' => $row['id_number'],
            'usertype_id' => $row['usertype_id'],
            'section_id' => $row['section_id']
        ]);
    }
}
