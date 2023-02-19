<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class objectsSceneEvent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'events_id',
        'objects_scenes_id',
        'buy',

    ];
}
