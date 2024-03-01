<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $table = 'admin';
    protected $fillable = [
        'name',
        'school_id',
        'super_admin',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
