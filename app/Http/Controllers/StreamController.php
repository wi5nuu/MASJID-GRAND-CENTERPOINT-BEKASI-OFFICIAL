<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class StreamController extends Controller
{
    /**
     * Generate signed token untuk mengakses stream.
     * Token berlaku 6 jam, di-cache per IP.
     * GET /stream/token
     */
    public function token(Request $request)
    {
        $ip  = $request->ip();
        $key = 'stream_token_' . md5($ip);

        // Rate limit: max 10 request token per jam per IP
        if (RateLimiter::tooManyAttempts('stream-token:' . $ip, 10)) {
            return response()->json(['error' => 'Too many requests.'], 429);
        }
        RateLimiter::hit('stream-token:' . $ip, 3600);

        $token = Cache::remember($key, now()->addHours(6), function () {
            return Str::random(64);
        });

        return response()->json([
            'token'      => $token,
            'expires_in' => 21600, // 6 jam
        ]);
    }

    /**
     * Validasi token dan return stream info.
     * Token dicek dari Cache — tidak disimpan di DB untuk performa.
     * GET /stream/info?token=xxx
     */
    public function info(Request $request)
    {
        if (!$this->validateToken($request)) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $streamMode = Setting::get('stream_mode', 'youtube'); // youtube | hls | webrtc

        $data = [
            'mode'        => $streamMode,
            'youtube_url' => $this->getYoutubeEmbed(),
            'hls_url'     => $streamMode === 'hls'    ? $this->getHlsUrl()    : null,
            'webrtc_url'  => $streamMode === 'webrtc' ? $this->getWebrtcUrl() : null,
            'is_live'     => (bool) Setting::get('stream_is_live', false),
            'label'       => Setting::get('stream_label', 'Live Masjid'),
        ];

        return response()->json($data);
    }

    /**
     * Proxy HLS playlist dari go2rtc/mediamtx — agar URL internal
     * server tidak terekspose ke browser client.
     * GET /stream/hls/{path}?token=xxx
     */
    public function hlsProxy(Request $request, string $path)
    {
        if (!$this->validateToken($request)) {
            abort(401, 'Unauthorized.');
        }

        // Rate limit akses HLS per IP: 300 request per menit (normal untuk HLS)
        $ip = $request->ip();
        if (RateLimiter::tooManyAttempts('stream-hls:' . $ip, 300)) {
            abort(429, 'Too many requests.');
        }
        RateLimiter::hit('stream-hls:' . $ip, 60);

        // Hanya izinkan path yang valid: alphanumeric, underscore, dash, slash, dot
        if (!preg_match('/^[\w\-\/\.]+$/', $path)) {
            abort(400, 'Invalid path.');
        }

        $go2rtcBase = rtrim(config('stream.go2rtc_url', 'http://127.0.0.1:1984'), '/');
        $url        = $go2rtcBase . '/api/stream.m3u8?src=' . urlencode($path);

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get($url);

            if (!$response->successful()) {
                abort(502, 'Stream unavailable.');
            }

            return response($response->body(), 200)
                ->header('Content-Type', 'application/vnd.apple.mpegurl')
                ->header('Cache-Control', 'no-cache, no-store')
                ->header('Access-Control-Allow-Origin', config('app.url'))
                ->header('X-Content-Type-Options', 'nosniff');

        } catch (\Exception $e) {
            abort(503, 'Stream server unreachable.');
        }
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function validateToken(Request $request): bool
    {
        $token = $request->query('token') ?? $request->bearerToken();
        if (!$token || strlen($token) !== 64) return false;

        $ip  = $request->ip();
        $key = 'stream_token_' . md5($ip);

        // Token harus cocok dengan yang di-cache untuk IP ini
        $cached = Cache::get($key);
        return $cached && hash_equals($cached, $token);
    }

    private function getYoutubeEmbed(): ?string
    {
        $url = Setting::get('tv_live_url', '');
        if (!$url) return null;

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1]
                . '?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&showinfo=0'
                . '&loop=1&playlist=' . $m[1];
        }

        if (str_contains($url, 'youtube.com/embed')) {
            return $url;
        }

        return null;
    }

    private function getHlsUrl(): ?string
    {
        $cameraName = Setting::get('stream_camera_name', '');
        if (!$cameraName) return null;

        // Return proxy URL — bukan URL go2rtc langsung
        return url('/stream/hls/' . $cameraName);
    }

    private function getWebrtcUrl(): ?string
    {
        // go2rtc WebRTC endpoint — dikembalikan hanya untuk koneksi internal LAN
        $go2rtcBase  = rtrim(config('stream.go2rtc_url', 'http://127.0.0.1:1984'), '/');
        $cameraName  = Setting::get('stream_camera_name', '');
        if (!$cameraName) return null;

        return $go2rtcBase . '/api/webrtc?src=' . urlencode($cameraName);
    }
}
