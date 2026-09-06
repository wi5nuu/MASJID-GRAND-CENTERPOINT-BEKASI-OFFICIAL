<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('jamaah')) {
                return redirect()->route('jamaah.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }
        // Generate timestamp honeypot
        $hpTime = base64_encode((string) time());
        return view('auth.login', compact('hpTime'));
    }

    public function login(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6|max:128',
        ]);

        $ip        = $request->ip();
        $userAgent = $request->userAgent();
        $email     = $request->input('email');

        // Throttle key gabungan IP + email
        $throttleKey = 'login.' . sha1($ip . '|' . Str::lower($email));

        // Cek apakah sedang di-throttle (RateLimiter Laravel built-in)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            Log::warning('[LOGIN] Rate limited', [
                'ip'    => $ip,
                'email' => $email,
                'ua'    => $userAgent,
            ]);
            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."])
                ->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Cek is_active SEBELUM session regenerate untuk keamanan
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                Log::warning('[LOGIN] Inactive user attempted login', [
                    'ip'    => $ip,
                    'email' => $email,
                ]);
                return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan.'])->withInput($request->only('email'));
            }

            // Reset rate limiter saat login berhasil
            RateLimiter::clear($throttleKey);
            \App\Http\Middleware\LoginRateLimit::clear($ip);
            $request->session()->regenerate();

            Log::info('[LOGIN] Successful login', [
                'ip'      => $ip,
                'user_id' => $user->id,
                'email'   => $user->email,
                'ua'      => $userAgent,
            ]);

            // Halaman login admin hanya untuk superadmin/admin/editor.
            // Tolak akun jamaah dengan pesan yang jelas (jangan lempar ke dashboard jamaah).
            if ($user->hasRole('jamaah') || !$user->isAdmin() && !$user->hasRole('editor')) {
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'Akun ini terdaftar sebagai jamaah, bukan pengelola. Silakan masuk melalui halaman Login Jamaah.'])
                    ->withInput($request->only('email'));
            }

            // Hanya ikuti intended URL jika masih di area admin.
            // Intended basi (mis. /jamaah) harus diabaikan agar tidak 403.
            $intendedPath = parse_url((string) session('url.intended', ''), PHP_URL_PATH);
            if ($intendedPath && str_starts_with($intendedPath, '/admin')) {
                return redirect()->intended(route('admin.dashboard'));
            }
            session()->forget('url.intended');

            return redirect()->route('admin.dashboard');
        }

        // Gagal — increment rate limiter (decay 60 detik)
        RateLimiter::hit($throttleKey, 60);

        Log::warning('[LOGIN] Failed attempt', [
            'ip'         => $ip,
            'email'      => $email,
            'ua'         => $userAgent,
            'attempts'   => RateLimiter::attempts($throttleKey),
        ]);

        // Pesan generik — jangan bedakan "email tidak ada" vs "password salah"
        return back()
            ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Log::info('[LOGIN] User logged out', [
            'ip'      => $request->ip(),
            'user_id' => Auth::id(),
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
