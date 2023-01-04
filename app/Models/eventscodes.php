<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventscodes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'event_id',
    ];
}
