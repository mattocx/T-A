<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesAuthController extends Controller
{
    public function login()
    {
        return view('auth.sales.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'id' => ['required'],
            'password' => ['required'],
        ], [
            'id' => [
                'required' => __('User ID tidak boleh kosong'),
                'string' => __('User ID harus dalam bentuk string'),
            ],
            'password' => [
                'required' => __('Password tidak boleh kosong'),
            ],
        ]);

        if (Auth::guard('sales')->attempt([
            'id' => $credentials['id'],
            'password' => $credentials['password'],
        ], $credentials['remember'] ?? false)) {
            Auth::shouldUse('sales');
            $request->session()->regenerate();

            return redirect('/sales');
        }

        return back()->withErrors([
            'id' => __('User ID atau Password tidak valid.'),
        ])->onlyInput('id');
    }
}
