<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Proteksi brute-force login:
 * - Max 5 attempt per IP per menit
 * - Lockout 15 menit setelah 15 attempt
 * - Permanent block setelah 50 attempt (reset manual via cache)
 */
class LoginRateLimit
{
    // Batas per window
    const MAX_PER_MINUTE   = 5;
    const MAX_BEFORE_LOCK  = 15;
    const MAX_BEFORE_BLOCK = 50;

    // Durasi lockout
    const LOCKOUT_MINUTES = 15;
    const BLOCK_HOURS     = 24;

    public function handle(Request $request, Closure $next): Response
    {
        // Hanya berlaku untuk POST (submit form login)
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        $ip      = $request->ip();
        $keyBase = 'login_attempt_' . sha1($ip);

        // Cek permanent block
        if (Cache::has($keyBase . '_blocked')) {
            Log::warning('[LOGIN] IP permanently blocked', [
                'ip'         => $ip,
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
            ]);
            return $this->blockedResponse($request);
        }

        // Cek lockout aktif
        if (Cache::has($keyBase . '_locked')) {
            $remainingSec = Cache::get($keyBase . '_locked_until', 0) - time();
            $remaining    = max(1, ceil($remainingSec / 60));
            Log::warning('[LOGIN] IP locked out', [
                'ip'              => $ip,
                'remaining_min'   => $remaining,
            ]);
            return $this->lockedResponse($request, $remaining);
        }

        // Increment counter per menit
        $countMin = Cache::get($keyBase . '_min', 0) + 1;
        Cache::put($keyBase . '_min', $countMin, now()->addMinute());

        // Increment total counter
        $countTotal = Cache::get($keyBase . '_total', 0) + 1;
        Cache::put($keyBase . '_total', $countTotal, now()->addHours(self::BLOCK_HOURS));

        // Permanent block
        if ($countTotal >= self::MAX_BEFORE_BLOCK) {
            Cache::put($keyBase . '_blocked', true, now()->addHours(self::BLOCK_HOURS));
            Log::critical('[LOGIN] IP auto-blocked after ' . $countTotal . ' attempts', [
                'ip'         => $ip,
                'user_agent' => $request->userAgent(),
            ]);
            return $this->blockedResponse($request);
        }

        // Lockout 15 menit
        if ($countTotal >= self::MAX_BEFORE_LOCK) {
            $until = time() + (self::LOCKOUT_MINUTES * 60);
            Cache::put($keyBase . '_locked', true, now()->addMinutes(self::LOCKOUT_MINUTES));
            Cache::put($keyBase . '_locked_until', $until, now()->addMinutes(self::LOCKOUT_MINUTES));
            Log::warning('[LOGIN] IP locked 15 minutes', [
                'ip'           => $ip,
                'total_attempt'=> $countTotal,
            ]);
            return $this->lockedResponse($request, self::LOCKOUT_MINUTES);
        }

        // Per-menit throttle
        if ($countMin > self::MAX_PER_MINUTE) {
            return $this->throttleResponse($request);
        }

        return $next($request);
    }

    /**
     * Hapus semua counter untuk sebuah IP — dipanggil saat login berhasil
     * agar pengguna legitimate tidak terkunci/blokir karena akumulasi percobaan.
     */
    public static function clear(string $ip): void
    {
        $keyBase = 'login_attempt_' . sha1($ip);
        Cache::forget($keyBase . '_min');
        Cache::forget($keyBase . '_total');
        Cache::forget($keyBase . '_locked');
        Cache::forget($keyBase . '_locked_until');
    }

    private function throttleResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Terlalu banyak percobaan. Tunggu sebentar.'], 429);
        }
        return back()
            ->withErrors(['email' => 'Terlalu banyak percobaan login. Tunggu 1 menit.'])
            ->withInput($request->only('email'));
    }

    private function lockedResponse(Request $request, int $minutes): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => "Akun dikunci {$minutes} menit karena terlalu banyak percobaan."], 429);
        }
        return back()
            ->withErrors(['email' => "Terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit."])
            ->withInput($request->only('email'));
    }

    private function blockedResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Akses diblokir.'], 403);
        }
        // Kembalikan 403 bukan redirect agar bot tidak tahu struktur aplikasi
        abort(403, 'Akses ditolak. Hubungi administrator jika ini adalah kesalahan.');
    }
}
