<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;
    protected $table = 'exam_answer';
    protected $fillable = [
        'exam_id',
        'student_id',
        'q_id',
        'answer',
        'start_time',
        'end_time',
        'time_taken',
        'created_at',
        'updated_at'
    ];

}
