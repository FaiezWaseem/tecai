<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCourses extends Model
{
    use HasFactory;
    protected $table = 'class_courses';

    protected $fillable = [
        'class_id',
        'course_id',
    ];
}
