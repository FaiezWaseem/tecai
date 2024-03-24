<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecoaching extends Model
{
    use HasFactory;
    protected $table = 'ecoaching';
    protected $fillable = [
        'school_id',
    ];
}
