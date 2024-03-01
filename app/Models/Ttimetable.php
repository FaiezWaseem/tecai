<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttimetable extends Model
{
    use HasFactory;

    protected $table = 'ttime_table';
    protected $fillable = [
        'course_name',
        'date',
        'time',
        'course_id',
        'board_id',
        'class_id',
    ];
}
