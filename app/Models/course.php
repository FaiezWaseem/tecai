<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    protected $table = 'course';
    protected $fillable = [
        'course_name',
        'school_id',
        'added_on'
    ];
}
