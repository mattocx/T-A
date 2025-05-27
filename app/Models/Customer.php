<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Models\Package;
use App\Models\Payment;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Carbon\Carbon;
use Exception;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id', 'name', 'username', 'password', 'nik', 'photo', 'address', 'phone',
        'installation_date', 'network_type', 'package_id', 'role', 'status'
    ];

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
            $customer->id = 'C' . strtoupper(Str::random(8)); // ID custom
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id', 'id');
    }

    public function hasActivePayment()
    {
        return $this->payments()
            ->where('status', 'success')
            ->where('due_date', '>=', now())
            ->exists();
    }

    public function latestPayment()
    {
        return $this->payments()
            ->where('status', 'success')
            ->latest('payment_date') // pastikan kamu punya field ini, kalau tidak ganti dengan created_at
            ->first();
    }

    /**
     * Menghitung tanggal jatuh tempo dari pembayaran terakhir
     */
    public function dueDate()
    {
        $latestPayment = $this->latestPayment();

        if ($latestPayment && $this->package) {
            return Carbon::parse($latestPayment->payment_date)->addDays($this->package->duration);
        }

        if (empty($latestPayment)) {
            return Carbon::parse($this->installation_date)->addDays($this->package->duration);
        }

        throw new Exception("Something wrong with due date calculation", 500);
    }

    /**
     * Menghitung sisa hari sebelum jatuh tempo
     */
    public function daysLeft()
    {
        $dueDate = $this->dueDate();
        return $dueDate ? now()->diffInDays($dueDate, false) : null;
    }

    /**
     * Cek & update status pelanggan secara otomatis
     */
    public function checkAndUpdateStatus()
    {
        if ($this->dueDate() && now()->gt($this->dueDate())) {
            if ($this->status !== 'inactive') {
                $this->update(['status' => 'inactive']);
            }
        } else {
            if ($this->status !== 'active') {
                $this->update(['status' => 'active']);
            }
        }
    }
}
