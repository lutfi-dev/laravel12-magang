<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi termasuk captcha
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
            'g-recaptcha-response.captcha' => 'Captcha tidak valid, silakan coba lagi.',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            return redirect()->route('tasks.index'); // User ke /tasks
        }

        return back()->withErrors(['email' => 'Login gagal!']);
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file resources/views/auth/login.blade.php ada
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login
        return redirect('/login');
    }
}
