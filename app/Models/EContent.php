<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EContent extends Model
{
    use HasFactory;

    protected $table = 'e_content';
    protected $fillable = [
        'board_id',
        'course_id',
        'type',
        'thumbnail',
        'content_link',
        'content_type',
    ];
}
