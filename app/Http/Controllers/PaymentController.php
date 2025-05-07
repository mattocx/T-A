<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    // Membuat transaksi pembayaran baru
    public function createPayment(Request $request)
    {
        $customer = auth('customer')->user();
        
        if (!$customer) {
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu');
        }
        
        $package = $customer->package;
        
        if (!$package) {
            return redirect()->back()->with('error', 'Paket tidak ditemukan');
        }
        
        // Cek jika sudah ada pembayaran yang aktif (belum jatuh tempo dan sukses)
        $activePayment = $customer->payments()
            ->where('status', 'success')
            ->where('due_date', '>=', now())
            ->first();
            
        if ($activePayment) {
            return redirect()->back()->with('info', 'Anda masih memiliki langganan aktif hingga ' . $activePayment->due_date->format('d M Y'));
        }
        
        // Buat ID order unik
        $orderId = 'ORD-' . strtoupper(Str::random(6)) . '-' . time();
        
        // Hitung tanggal jatuh tempo (30 hari dari sekarang)
        $dueDate = Carbon::now()->addDays($package->duration);
        
        // Simpan data pembayaran ke database
        $payment = Payment::create([
            'customer_id' => $customer->id,
            'order_id' => $orderId,
            'amount' => $package->price,
            'status' => 'pending',
            'due_date' => $dueDate,
        ]);
        
        // Set parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => (int)$payment->amount,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
            'item_details' => [
                [
                    'id' => $package->id,
                    'price' => (int)$package->price,
                    'quantity' => 1,
                    'name' => 'Perpanjangan Paket ' . $package->name,
                ]
            ],
        ];
        
        // Dapatkan token snap dari Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Update payment dengan snap token
            $payment->update([
                'snap_token' => $snapToken,
            ]);
            
            return view('customer.payment', compact('payment', 'snapToken'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    // Callback dari Midtrans setelah pembayaran selesai
    public function callback(Request $request)
    {
        // Log data callback untuk debugging
        Log::info('Midtrans Callback Received', $request->all());
        
        try {
            // Verifikasi signature key jika ada
            $isValid = true;
            $serverKey = config('midtrans.server_key');
            
            if ($request->has('signature_key') && $request->has('order_id') && 
                $request->has('status_code') && $request->has('gross_amount')) {
                
                $orderId = $request->order_id;
                $statusCode = $request->status_code;
                $grossAmount = $request->gross_amount;
                
                // Buat signature key untuk verifikasi
                $mySignatureKey = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
                
                // Bandingkan signature key
                if ($mySignatureKey != $request->signature_key) {
                    $isValid = false;
                    Log::warning('Invalid Midtrans Signature Key', [
                        'received' => $request->signature_key,
                        'calculated' => $mySignatureKey
                    ]);
                }
            } else if ($request->has('client_status')) {
                // Data dari frontend, tidak perlu verifikasi signature
                Log::info('Callback from client side', ['status' => $request->client_status]);
            } else {
                // Direct notification from Midtrans doesn't have client_status
                Log::info('Direct notification from Midtrans');
            }
            
            if ($isValid) {
                $payment = Payment::where('order_id', $request->order_id)->first();
                
                if ($payment) {
                    // Update status payment sesuai callback
                    $payment->update([
                        'transaction_id' => $request->transaction_id,
                        'payment_method' => $request->payment_type,
                        'status' => $this->mapPaymentStatus($request->transaction_status),
                        'payment_date' => now(),
                        'payment_details' => json_encode($request->all()),
                    ]);
                    
                    // Jika pembayaran berhasil, aktifkan kembali status customer
                    if ($payment->isSuccess()) {
                        $customer = $payment->customer;
                        
                        if ($customer) {
                            // Update status customer menjadi aktif
                            $customer->update([
                                'status' => 'active',
                            ]);
                            
                            // Update tanggal installasi jika status sebelumnya tidak aktif
                            if (!$customer->isActive()) {
                                $customer->update([
                                    'installation_date' => now(),
                                ]);
                            }
                            
                            Log::info('Customer status updated to active', [
                                'customer_id' => $customer->id,
                                'payment_id' => $payment->id
                            ]);
                        }
                    }
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Payment status updated successfully',
                        'payment_status' => $payment->status
                    ]);
                } else {
                    Log::warning('Payment not found', ['order_id' => $request->order_id]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Payment not found'
                    ], 404);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid signature key'
                ], 403);
            }
        } catch (\Exception $e) {
            Log::error('Error processing payment callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error processing payment: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Tampilkan halaman status pembayaran
    public function paymentStatus($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->firstOrFail();
        return view('customer.payment-status', compact('payment'));
    }
    
    // Fungsi untuk memetakan status transaksi dari Midtrans ke status internal aplikasi
    private function mapPaymentStatus($midtransStatus)
    {
        $statusMap = [
            'capture' => 'success',
            'settlement' => 'success',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'failed',
        ];
        
        return $statusMap[$midtransStatus] ?? 'pending';
    }
}
