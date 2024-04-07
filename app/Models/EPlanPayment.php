<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EPlanPayment extends Model
{
    use HasFactory;

    protected $table = 'e_payment_plan';
    protected $fillable = [
        'plan_id',
        'student_id',
        'isApproved',
        'start_time',
        'end_time',
        'payment_screenshot',
    ];
}
