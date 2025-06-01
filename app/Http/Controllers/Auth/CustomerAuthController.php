<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('auth.customer.login');
    }

   public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'id' => ['required'],
        'password' => ['required'],
    ], [
        'id.required' => 'User ID tidak boleh kosong',
        'password.required' => 'Password tidak boleh kosong',
    ]);

    // Ambil data customer berdasarkan ID
    $customer = Customer::where('id', $credentials['id'])->first();

    if (!$customer) {
        return back()->withErrors([
            'id' => 'User ID atau Password tidak valid.',
        ])->onlyInput('id');
    }

    // Cek jika user tidak aktif
//     if ($customer->status !== 'active') {
//         // Cek apakah karena belum bayar
//         $dueDate = $customer->dueDate();
//         $latestPayment = $customer->latestPayment();

//         if ($dueDate && now()->gt($dueDate)) {
//             // Jika jatuh tempo sudah lewat
//             $payment = $latestPayment;

//     return back()->withErrors([
//         'id' => 'Anda harus melakukan pembayaran. <a href="' . route('payment.create') . '" class="underline text-blue-600 hover:text-blue-800">Bayar sekarang</a>'
//     ])->onlyInput('id')->with('html_error', true);
// }

//         // Jika tidak karena jatuh tempo, berarti dinonaktifkan manual
//         return back()->withErrors([
//             'id' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'
//         ])->onlyInput('id');
//     }

    // Cek kredensial
    if (Auth::guard('customer')->attempt([
        'id' => $credentials['id'],
        'password' => $credentials['password'],
    ], $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect('/customer');
    }

    return back()->withErrors([
        'id' => 'User ID atau Password tidak valid.',
    ])->onlyInput('id');
}
}
