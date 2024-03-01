<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'photo',
        'name',
        'father_name',
        'admission_no',
        'type',
        'group',
        'class',
        'section',
        'dob',
        'contact',
        'gender',
        'email',
        'school',
        'password',
        'token',
    ];

    protected $hidden = [
        'password'
    ];
}
