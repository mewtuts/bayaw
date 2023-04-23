<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'email', 'password','fname','mname','lname','id_number','usertype_id','section_id'];

    public static function ImportUsers()
    {
        $result = DB::table('users')
                ->select('fname','mname','lname','id_number','usertype_id','section_id')
                ->get()->toArray();
        return $result;

    }
}
