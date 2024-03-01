<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tchapters extends Model
{
    use HasFactory;
    protected $table = 'tchapters';
    protected $fillable = [
        'chapter_title',
        'tcourse_id',
        'tclass_id',
    ];
}
