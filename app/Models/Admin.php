<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'password', 'role', 'phone', 'photo'];
    protected $keyType = 'string';
    public $incrementing = false;

    // Supaya password tidak terlihat di query result
    protected $hidden = ['password'];

    // Supaya password otomatis di-hash
    protected $casts = [
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            if (!$admin->id) { // Pastikan ID tidak ditimpa jika sudah ada
                $admin->id = 'A' . strtoupper(Str::random(8));
            }
        });
    }
}

