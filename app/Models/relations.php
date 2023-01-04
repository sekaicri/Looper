<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class relations extends Authenticatable
{
    public $timestamps = false;

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'me',
        'other',
        'friends',
    ];
}
