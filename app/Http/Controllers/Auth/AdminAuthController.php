<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('auth.dashboard.login');
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

        if (Auth::guard('admin')->attempt([
            'id' => $credentials['id'],
            'password' => $credentials['password'],
        ], $credentials['remember'] ?? false)) {
            Auth::shouldUse('admin');
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'id' => __('User ID atau Password tidak valid.'),
        ])->onlyInput('id');
    }
}
