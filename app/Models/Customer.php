<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Package;


class Customer extends Authenticatable
{
    use HasFactory;

    public function package()
{
    return $this->belongsTo(Package::class);
}

    protected $fillable = ['id', 'name', 'email', 'password','nik', 'photo','address','phone','installation_date', 'network_type', 'package-id'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            do {
                $id = 'C' . strtoupper(Str::random(8));
            } while (Customer::where('id', $id)->exists());

            $customer->id = $id;

            // Tambahkan juga ke tabel users
            User::create([
                'id' => $customer->id,
                'role' => 'customer',
                'name' => $customer->name,
                'email' => $customer->email,
                'password' => bcrypt($customer->password),
            ]);
        });
    }
}

