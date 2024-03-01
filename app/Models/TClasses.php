<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TClasses extends Model
{
    use HasFactory;
    protected $table = 'tclasses';
    protected $fillable = [
        'class_name',
        'thumbnail'
    ];

}
