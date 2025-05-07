<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Package;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relasi dengan model Payment
    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }
    
    // Cek apakah customer memiliki pembayaran aktif
    public function hasActivePayment()
    {
        return $this->payments()->where('status', 'success')
            ->where('due_date', '>=', now())
            ->exists();
    }
    
    // Mendapatkan pembayaran terakhir
    public function latestPayment()
    {
        return $this->payments()->latest()->first();
    }

    protected $fillable = ['id', 'name', 'email', 'password','nik', 'photo','address','phone','installation_date', 'network_type', 'package_id', 'role', 'status'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->id = 'S' . strtoupper(Str::random(8)); // ID sales custom

        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function dueDate()
    {
        if ($this->installation_date && $this->package) {
            return Carbon::parse($this->installation_date)->addDays($this->package->duration);
        }
        return null;
    }

    public function daysLeft()
    {
        $dueDate = $this->dueDate();
        return $dueDate ? now()->diffInDays($dueDate, false) : null;
    }

    public function checkAndUpdateStatus()
    {
        if ($this->dueDate() && now()->gt($this->dueDate())) {
            // Update status jika lewat jatuh tempo
            if ($this->status !== 'inactive') {
                $this->update(['status' => 'inactive']);
            }
        }
    }


}


