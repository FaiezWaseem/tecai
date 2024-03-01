<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outline extends Model
{
    use HasFactory;

    protected $table = 'outline';
    protected $fillable = [
        'school_id',
        'course_id',
        'teacher_id',
        'class_id',
        'chapter',
        'title',
        'is_covered',
        'deliver_date',
    ];
}
