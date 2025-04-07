<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Sales extends Authenticatable implements FilamentUser
{
    use HasFactory;
    protected $guard = 'sales'; 
    protected $fillable = ['id', 'name', 'email', 'password','role','phone','photo'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sales) {
            $sales->id = 'S' . strtoupper(Str::random(8)); // ID sales custom

        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Pastikan role sesuai dengan di database
    }
}

