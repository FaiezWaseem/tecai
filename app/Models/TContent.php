<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TContent extends Model
{
    use HasFactory;
    protected $table = 'tcontent';
    protected $fillable = [
        'content_type',
        'content_link',
        'tcourse_id',
        'tclass_id',
        'tboard_id',
        'tchapter_id',
        'tslo_id',
        'thumbnail',
    ];
}
