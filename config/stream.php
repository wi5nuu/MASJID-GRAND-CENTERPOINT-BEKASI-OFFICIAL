<?php

return [
    /*
    |--------------------------------------------------------------------------
    | go2rtc Server URL
    |--------------------------------------------------------------------------
    | go2rtc adalah software converter RTSP → HLS/WebRTC yang berjalan
    | di server/PC lokal masjid. Download: https://github.com/AlexxIT/go2rtc
    |
    | Default: localhost port 1984 (tidak terekspose ke internet)
    | JANGAN ubah ke IP publik — akses dari luar harus lewat proxy Laravel.
    */
    'go2rtc_url' => env('GO2RTC_URL', 'http://127.0.0.1:1984'),

    /*
    |--------------------------------------------------------------------------
    | Stream Token Secret
    |--------------------------------------------------------------------------
    | Digunakan untuk signing token akses stream.
    | Generate ulang dengan: php artisan key:generate --show
    */
    'token_secret' => env('STREAM_TOKEN_SECRET', env('APP_KEY')),

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins untuk stream
    |--------------------------------------------------------------------------
    | Hanya domain ini yang boleh akses endpoint stream.
    */
    'allowed_origins' => [
        env('APP_URL', 'http://localhost'),
    ],
];
