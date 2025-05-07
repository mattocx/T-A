<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'payment_date',
        'due_date',
        'payment_method',
        'snap_token',
        'payment_url',
        'payment_details',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'due_date' => 'datetime',
        'payment_details' => 'json',
    ];

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    // Cek apakah pembayaran telah berhasil
    public function isSuccess()
    {
        return $this->status === 'success';
    }
    
    // Cek apakah pembayaran masih pending
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    // Cek apakah pembayaran sudah jatuh tempo
    public function isOverdue()
    {
        return Carbon::now()->gt($this->due_date) && !$this->isSuccess();
    }
}
