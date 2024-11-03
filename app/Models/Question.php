<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questionbank';
    protected $fillable = [
        'cboard_id',
        'cclass_id',
        'school_id',
        'ccourse_id',
        'cchapter_id',
     


    ];

}
