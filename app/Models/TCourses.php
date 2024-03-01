<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCourses extends Model
{
    use HasFactory;
    protected $table = 'tcourse';
    protected $fillable = [
        'course_name',
        'thumbnail'
    ];
}

