<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Cek apakah user sudah melebihi batas login
        $this->checkRateLimit($request);

        // Validasi input termasuk Google reCAPTCHA
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
            'g-recaptcha-response.captcha' => 'Captcha tidak valid, silakan coba lagi.',
        ]);

        // Coba login
        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            // Jika berhasil login → reset percobaan
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            return redirect()->route('tasks.index');
        }

        // Jika login gagal → tambah hitungan percobaan
        RateLimiter::hit($this->throttleKey($request), 60); // 60 detik blokir

        return back()->withErrors([
            'email' => 'Login gagal! Email atau password salah.'
        ]);
    }

    protected function checkRateLimit(Request $request)
    {
        $maxAttempts = 1; // Maksimal percobaan login
        $decaySeconds = 60; // Lama blokir dalam detik

        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), $maxAttempts)) {
            return;
        }

        // Reset hitungan supaya mulai blokir dari sekarang
        RateLimiter::clear($this->throttleKey($request));
        RateLimiter::hit($this->throttleKey($request), $decaySeconds);

        $seconds = $decaySeconds;

        throw ValidationException::withMessages([
            'email' => ["Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."]
        ]);
    }

    protected function throttleKey(Request $request)
    {
        // Kombinasi email dan IP agar unik
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
