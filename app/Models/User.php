<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['id', 'name', 'email', 'password', 'role'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];
}
