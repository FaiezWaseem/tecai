<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherContent extends Model
{
    use HasFactory;

    protected $table = 'teacher_content';

    protected $fillable = [
        'content_type',
        'content_link',
        'course_id',
        'class_id',
        'teacher_id',
        'school_id',
    ];
}
