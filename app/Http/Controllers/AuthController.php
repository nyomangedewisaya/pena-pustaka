<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('pages.auth.login');
    }

    public function showRegister() {
        return view('pages.auth.register');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $role = auth()->user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/book_catalog');
        }

        return back()->with('error', 'Username atau password anda salah!')->onlyInput('username');
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'username' => 'required|string|min:8|alpha_dash|unique:users,username',
            'password' => 'required|string|min:8',
            'nisn' => 'required|string|unique:users,nisn',
            'class' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => 'student'
        ]);

        return redirect()->route('login')->with('success', 'Berhasil mendaftar! Silakan login kembali.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
