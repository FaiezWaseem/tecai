<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttopics extends Model
{
    use HasFactory;
    protected $table = 'ttopics';

    protected $fillable = [
        'topic_title',
        'tcourse_id',
        'tclass_id',
        'tchapter_id',
    ];
}
