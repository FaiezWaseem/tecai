<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
    protected $table = 'exam_taken_exams';
    protected $fillable = [
        
        'school_id',
        'student_id',	
        'exam_id',
        'class_id',	
        'section_id',
        'subject_id',	
        'total_question',	
        'total_answer',	
        'total_mark'	,
        'total_correct_answer',
        'total_incorrect_answer',	
        'total_obtain_mark',
        'obtain_mark_percent',
        'result_status',	
        'created_at'	,
        'updated_at'
    ];

}
