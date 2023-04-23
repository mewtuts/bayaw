<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Logs extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'day', 'start_time', 'end_time','pcnum','subject','section','room','instructor'];

    public static function getAllUnits()
    {
        $result = DB::table('logs')
                ->select('user_id', 'day', 'start_time', 'end_time','pcnum','subject','section','room','instructor')
                ->get()->toArray();
        return $result;

    }
}
