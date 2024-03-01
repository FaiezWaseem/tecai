<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'activity_id',
        'std_id',
        'points_obtained',
        'points_total',
        'added_on',
    ];

}
