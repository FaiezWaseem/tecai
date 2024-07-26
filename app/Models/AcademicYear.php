<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;
    protected $table = 'academic_year';

    protected $fillable = [
        'year',
        'start_date',
        'end_date',
        'active',
        'school_id',
    ];
}
