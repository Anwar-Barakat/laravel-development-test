<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'price', 'products'];

    protected $casts = [
        'created_at'    => 'date:Y-m-d',
        'products'      => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}