<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type', 'price'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];
}