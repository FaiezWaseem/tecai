<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWork extends Model
{
    use HasFactory;

    protected $table = 'homework';

    protected $fillable = [
        'school_id',
        'teacher_id',
        'class_id',
        'date',
        'image',
        'content',
    ];
}
