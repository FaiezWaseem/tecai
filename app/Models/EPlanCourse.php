<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EPlanCourse extends Model
{
    use HasFactory;

    protected $table = 'e_plan_course';
    protected $fillable = [
        'plan_id',
        'course_id',
        'board_id',
    ];
}
