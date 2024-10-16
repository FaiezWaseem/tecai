<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamChapter extends Model
{
    use HasFactory;
    protected $table = 'exam_chapter';
    protected $fillable = [
        'chapter_id',
        'exam_id',
        'course_id',
        

    ];

}
