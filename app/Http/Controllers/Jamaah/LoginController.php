<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('jamaah.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'unit_no'  => 'required|string|max:10',
            'password' => 'required|string|min:6|max:128',
        ]);

        $unitNo = strtoupper(trim($request->input('unit_no')));
        $ip = $request->ip();
        $throttleKey = 'jamaah.login.' . sha1($ip . '|' . $unitNo);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withErrors(['unit_no' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."])
                ->withInput($request->only('unit_no'));
        }

        $users = \App\Models\User::where('unit_no', $unitNo)
            ->whereHas('role', fn($q) => $q->where('name', 'jamaah'))
            ->get();

        $remember = $request->boolean('remember');
        $matchedUser = null;

        foreach ($users as $user) {
            if (\Illuminate\Support\Facades\Hash::check($request->input('password'), $user->password)) {
                $matchedUser = $user;
                break;
            }
        }

        if ($matchedUser) {
            if (!$matchedUser->approved_at) {
                RateLimiter::hit($throttleKey, 60);
                return back()
                    ->withErrors(['unit_no' => 'Akun Anda masih menunggu persetujuan pengurus.'])
                    ->withInput($request->only('unit_no'));
            }

            if (!$matchedUser->is_active) {
                RateLimiter::hit($throttleKey, 60);
                return back()
                    ->withErrors(['unit_no' => 'Akun Anda telah dinonaktifkan.'])
                    ->withInput($request->only('unit_no'));
            }

            Auth::login($matchedUser, $remember);
            RateLimiter::clear($throttleKey);
            \App\Http\Middleware\LoginRateLimit::clear($ip);
            $request->session()->regenerate();

            // Hanya ikuti intended URL jika masih di area jamaah.
            // Intended basi (mis. /admin) harus diabaikan agar tidak 403.
            $intendedPath = parse_url((string) session('url.intended', ''), PHP_URL_PATH);
            if ($intendedPath && str_starts_with($intendedPath, '/jamaah')) {
                return redirect()->intended(route('jamaah.dashboard'));
            }
            session()->forget('url.intended');

            return redirect()->route('jamaah.dashboard');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withErrors(['unit_no' => 'Nomor unit atau kata sandi tidak sesuai.'])
            ->withInput($request->only('unit_no'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('jamaah.login');
    }

    private function redirectByRole()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('jamaah.dashboard');
    }
}
