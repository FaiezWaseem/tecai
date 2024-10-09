<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exam';
    protected $fillable = [
        'school_id',
        'ex_board_id',
        'ex_class_id',
        'ex_course_id',
        'ex_title',
        'ex_start_date',
        'ex_end_date',
        'ex_duration',
        'ex_pass_mark',
        'ex_instraction'


    ];

}
