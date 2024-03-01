<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class teacher_course extends Model
{
    protected $table = 'teacher_courses';
    protected $fillable = [
        'teacher_id',
        'course_id',
        'added_on',
    ];
}
