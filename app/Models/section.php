<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $table = 'section';
    protected $fillable = [
        'section_name',
        'class_id',
        'school_id'
    ];
}
