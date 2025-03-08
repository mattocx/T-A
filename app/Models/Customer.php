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

    protected $fillable = ['id', 'name', 'email', 'password','nik', 'photo','address','phone','installation_date', 'network_type', 'package-id', 'role'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($customer) {
            $customer->id = 'S' . strtoupper(Str::random(8)); // ID sales custom

        });
    }
}

