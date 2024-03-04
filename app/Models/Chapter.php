<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapter';
    protected $fillable = [
        'school_id',
        'course_id',
        'teacher_id',
        'class_id',
        'chapter_title',
    ];
}
