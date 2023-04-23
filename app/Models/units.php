<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class units extends Model
{
    use HasFactory;

    protected $fillable = ['pc_number', 'status', 'issue', 'room_id'];

    public static function getAllUnits()
    {
        $result = DB::table('units')
                ->select('pc_number','status','issue','room_id')
                ->get()->toArray();
        return $result;

    }
}
