<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class demostudents extends Model
{
    protected $table = 'democbts';
    protected $fillable = [
        'class',
        'class_id',
        'user_name',
        'password',
        'board_id',
    ];

    protected $hidden = [
        'password'
    ];
}
