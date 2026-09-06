<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Honeypot anti-bot:
 * - Field tersembunyi "website" harus KOSONG (manusia tidak isi, bot mengisi)
 * - Field "hp_time" harus ada dan terisi (timestamp saat form dirender)
 * - Form submit terlalu cepat (< 2 detik) dianggap bot
 */
class HoneypotCheck
{
    const MIN_FILL_SECONDS = 2;

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        $ip = $request->ip();

        // 1. Honeypot field harus kosong
        if ($request->filled('website')) {
            Log::warning('[HONEYPOT] Bot detected - honeypot field filled', [
                'ip'         => $ip,
                'user_agent' => $request->userAgent(),
            ]);
            // Pura-pura berhasil agar bot tidak tahu terdeteksi
            return $this->fakeSuccessResponse($request);
        }

        // 2. Cek timestamp form (anti-bot terlalu cepat) — skip jika field tidak ada
        $hpTime = $request->input('hp_time');
        if ($hpTime && base64_decode($hpTime, true) !== false) {
            $decoded  = (int) base64_decode($hpTime);
            $fillTime = time() - $decoded;
            if ($decoded > 0 && $fillTime < self::MIN_FILL_SECONDS) {
                Log::warning('[HONEYPOT] Bot detected - form filled too fast', [
                    'ip'        => $ip,
                    'fill_time' => $fillTime . 's',
                ]);
                return $this->fakeSuccessResponse($request);
            }
        }

        return $next($request);
    }

    private function fakeSuccessResponse(Request $request): Response
    {
        // Pura-pura berhasil — redirect kembali dengan pesan sukses
        // Bot akan mengira form berhasil dikirim dan tidak retry
        $redirectUrl = $request->headers->get('referer', route('home'));
        return redirect($redirectUrl)->with('success', 'Terima kasih, pesan Anda berhasil dikirim.');
    }
}
