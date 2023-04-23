<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsImports extends Model
{
    use HasFactory;

    protected $fillable = ['pc_number', 'status', 'issue', 'room_id'];
}
