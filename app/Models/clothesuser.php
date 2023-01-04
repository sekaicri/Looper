<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clothesuser extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'clothes_id',
        'buy',

    ];
}
