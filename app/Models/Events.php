<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'fecha',
        'description',
        'user_id',
    ];
}
