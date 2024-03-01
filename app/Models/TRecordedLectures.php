<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TRecordedLectures extends Model
{
    use HasFactory;
    protected $table = 'trecorded_lectures';
    protected $fillable = [
        'rec_title',
        'rec_link',
        'rec_thumbnail',
        'rec_subtitle',
    ];
}
