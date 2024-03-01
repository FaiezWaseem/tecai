<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tboards extends Model
{
    use HasFactory;
    protected $table = 'tboards';
    protected $fillable = [
        'board_name',
    ];
}
