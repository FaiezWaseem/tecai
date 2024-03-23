<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherContentPermission extends Model
{
    use HasFactory;
    protected $table = 'teacher_content_permission';
    protected $fillable = [
        'teacher_id',
        'board_id',
        'class_id',
        'course_id',
    ];
}
