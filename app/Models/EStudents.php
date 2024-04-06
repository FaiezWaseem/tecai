<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EStudents extends Model
{
    use HasFactory;

    protected $table = 'e_students';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
