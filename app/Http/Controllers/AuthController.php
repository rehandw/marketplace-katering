<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            'role'         => 'required|in:merchant,customer',
            'company_name' => 'required|string|max:255',
            'address'      => 'required|string',
            'phone'        => 'required|string|max:20',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            if ($request->role === 'merchant') {
                Merchant::create([
                    'user_id'      => $user->id,
                    'company_name' => $request->company_name,
                    'address'      => $request->address,
                    'phone'        => $request->phone,
                    'description'  => $request->description ?? null,
                ]);
            } else {
                Customer::create([
                    'user_id'      => $user->id,
                    'company_name' => $request->company_name,
                    'address'      => $request->address,
                    'phone'        => $request->phone,
                ]);
            }

            Auth::login($user);
        });

        if ($request->role === 'merchant') {
            return redirect()->route('merchant.dashboard')->with('success', 'Pendaftaran Merchant berhasil!');
        }

        return redirect()->route('customer.dashboard')->with('success', 'Pendaftaran Kantor Customer berhasil!');
    }

    // Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // login > masuk
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan sesuai role
            if (Auth::user()->role === 'merchant') {
                return redirect()->route('merchant.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }
    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }
}