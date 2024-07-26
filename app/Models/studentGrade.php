<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentGrade extends Model
{
    use HasFactory;

    protected $table = 'student_grade';

    protected $fillable = [
        'student_id',
        'course_id',
        'academic_id',
        'term_id',
        'total',
    ];
}
