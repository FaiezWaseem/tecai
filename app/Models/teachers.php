<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teachers extends Model
{
    protected $table = 'teachers';
    protected $fillable = [
        'name',
        'password',
        'school_id',
    ];
    protected $hidden = [
        'password'
    ];
}
