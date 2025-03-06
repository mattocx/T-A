<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Models\User;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'password'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function user()
{
    return $this->belongsTo(User::class);
}


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($admin) {
            $admin->id = 'A' . strtoupper(Str::random(8)); // ID admin custom

            // Tambahkan juga ke tabel users
            User::create([
                'id' => $admin->id,
                'role' => 'admin',
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => bcrypt($admin->password),
            ]);
        });
    }
}

