<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolContentPermission extends Model
{
    use HasFactory;
    protected $table = 'school_content_permission';
    protected $fillable = [
        'school_id',
        'board_id',
    ];
}
