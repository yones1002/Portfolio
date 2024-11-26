<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    use HasFactory;

    protected $table = 'cryptocurrencies';
    protected $fillable = [
        'id', 'fa_name', 'name', 'symbol', 'current_price', 'rank', 'status', 'description', 'image', 'created_at', 'updated_at'
    ];
}
