<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;
    protected $table = 'exam_question';
    protected $fillable = [
        'examid',
        'q_id',
    ];
    public $timestamps = false; // Disable timestamps

}
