<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    protected $guard = 'admin';
    protected $fillable = ['id', 'name', 'email', 'password', 'role', 'phone', 'photo'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            if (!$admin->id) {
                $admin->id = 'A' . strtoupper(Str::random(8));
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
