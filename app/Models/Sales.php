<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Models\User;

class Sales extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'email', 'password','role','phone','photo'];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sales) {
            $sales->id = 'S' . strtoupper(Str::random(8)); // ID sales custom

        });
    }
}

