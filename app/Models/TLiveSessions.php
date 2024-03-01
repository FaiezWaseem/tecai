<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TLiveSessions extends Model
{
    use HasFactory;
    protected $table = 'tlive_sessions';
    protected $fillable = [
        'live_title',
        'live_link',
        'live_thumbnail',
        'live_subtitle',
    ];
}
