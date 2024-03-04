<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolsAdmin extends Model
{
    use HasFactory;
    protected $table = 'schools_admin';
    protected $fillable = [
        'school_id',
        'admin_id',
    ];
}
