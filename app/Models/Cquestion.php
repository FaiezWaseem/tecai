<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cquestion extends Model
{
    use HasFactory;
    protected $table = 'c_questionbank';
    protected $fillable = [
        'cboard_id',
        'cclass_id',
        'school_id',
        'ccourse_id',
        'cchapter_id',
        'cquestion',
        'cqtype',
        'mark',
        'image',
        'bank_id',


    ];

}
