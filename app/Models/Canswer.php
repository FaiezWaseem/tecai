<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canswer extends Model
{
    use HasFactory;
    protected $table = 'c_answer';
    protected $fillable = [
        'q_Id',
        'answer',
        'is_coorect',
    ];
    public $timestamps = false; // Disable timestamps

}
