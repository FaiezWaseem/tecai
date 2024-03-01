<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $table = 'activity';
    protected $fillable = [
        'tid',
        'class_id',
        'section_id',
        'school_id',
        'data',
        'title',
        'topic_id',
        'deadline',
        'total_marks',
        'type'
    ];
}
