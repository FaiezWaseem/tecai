<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teacher_classes extends Model
{
    protected $table = 'teacher_classes';
    protected $fillable = [
        'teacher_id',
        'school_id',
        'section_id',
        'course_id'
    ];
}
