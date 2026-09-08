<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\KontakController;
use App\Http\Controllers\Public\DonasiController;
use App\Http\Controllers\Public\KegiatanController;
use App\Http\Controllers\Public\GaleriController;
use App\Http\Controllers\Public\VideoController;
use App\Http\Controllers\Public\TentangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ShalatController;
use App\Http\Controllers\Admin\TvController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Jamaah\DashboardController as JamaahDashboardController;
use App\Http\Controllers\Jamaah\RegisterController as JamaahRegisterController;
use App\Http\Controllers\Jamaah\LoginController as JamaahLoginController;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────────────

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

// Berita
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{berita:slug}', [BeritaController::class, 'show'])->name('show');
});

// Kegiatan & Event
Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
    Route::get('/', [KegiatanController::class, 'index'])->name('index');
    Route::get('/{kegiatan:slug}', [KegiatanController::class, 'show'])->name('show');
});

Route::prefix('event')->name('event.')->group(function () {
    Route::get('/', [KegiatanController::class, 'eventIndex'])->name('index');
    Route::get('/{event:slug}', [KegiatanController::class, 'eventShow'])->name('show');
});

// Galeri & Video
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
});

Route::prefix('video')->name('video.')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/{video:slug}', [VideoController::class, 'show'])->name('show');
});

// Donasi
Route::prefix('donasi')->name('donasi.')->group(function () {
    Route::get('/', [DonasiController::class, 'index'])->name('index');
    Route::post('/', [DonasiController::class, 'store'])->name('store')->middleware('throttle:5,1');
    // Route literal harus SEBELUM wildcard slug agar tidak ter-intercept
    Route::get('/konfirmasi/{donasi}', [DonasiController::class, 'konfirmasi'])->name('konfirmasi');
    Route::get('/{program:slug}', [DonasiController::class, 'show'])->name('show');
});

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'kirim'])->name('kontak.kirim')->middleware('throttle:10,1');

// Newsletter
Route::post('/newsletter', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    \App\Models\NewsletterSubscriber::firstOrCreate(['email' => $request->email]);
    return back()->with('success', 'Terima kasih telah mendaftar newsletter kami.');
})->name('newsletter.subscribe');

// ─── TV DISPLAY ───────────────────────────────────────────────────────────────

Route::get('/tv', [TvController::class, 'display'])->name('tv.display');

// ─── STREAM ENDPOINTS ─────────────────────────────────────────────────────────
// Token-based, rate-limited — URL RTSP tidak pernah terekspose ke client

Route::prefix('stream')->name('stream.')->group(function () {
    Route::get('/token', [\App\Http\Controllers\StreamController::class, 'token'])->name('token');
    Route::get('/info',  [\App\Http\Controllers\StreamController::class, 'info'])->name('info');
    Route::get('/hls/{path}', [\App\Http\Controllers\StreamController::class, 'hlsProxy'])
        ->where('path', '[\w\-\/\.]+')
        ->name('hls');
});

// ─── AUTH ROUTES ──────────────────────────────────────────────────────────────
// URL login dibaca dari .env (LOGIN_PATH) agar tidak mudah ditebak bot
// Default: 'login' — ubah di .env: LOGIN_PATH=masuk-panel

Route::prefix('admin')->name('admin.')->group(function () {
    $loginPath = config('app.login_path', 'login');

    Route::get('/' . $loginPath,  [LoginController::class, 'showLoginForm'])
        ->name('login')
        ->middleware('guest');

    Route::post('/' . $loginPath, [LoginController::class, 'login'])
        ->name('login.post')
        ->middleware(['guest', 'honeypot', 'login.limit']);

    // Jika LOGIN_PATH beda dari 'login', redirect /admin/login ke path baru
    if ($loginPath !== 'login') {
        Route::get('/login', fn () => redirect()->route('admin.login'))
            ->middleware('guest');
    }

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Password reset placeholder
    Route::get('/password/reset', fn() => view('auth.forgot-password'))->name('password.request');

    // ─── PROTECTED ADMIN ROUTES ───────────────────────────────────────────────
    // Hanya superadmin/admin/editor. Akun jamaah yang membuka /admin mendapat 403.
    Route::middleware(['auth', 'role:superadmin,admin,editor'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Profile
        Route::get('/profile', fn() => view('admin.profile'))->name('profile');
        Route::put('/profile', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            ]);
            auth()->user()->update($request->only('name', 'email'));
            return back()->with('success', 'Profil berhasil diperbarui.');
        })->name('profile.update');
        Route::put('/profile/password', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password'         => 'required|string|min:8|confirmed',
            ]);
            auth()->user()->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
            return back()->with('success', 'Password berhasil diubah.');
        })->name('profile.password');

        // Berita
        Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita'])->names([
            'index'   => 'berita.index',
            'create'  => 'berita.create',
            'store'   => 'berita.store',
            'show'    => 'berita.show',
            'edit'    => 'berita.edit',
            'update'  => 'berita.update',
            'destroy' => 'berita.destroy',
        ]);

        // Kegiatan
        Route::resource('kegiatan', AdminKegiatanController::class)->names([
            'index'   => 'kegiatan.index',
            'create'  => 'kegiatan.create',
            'store'   => 'kegiatan.store',
            'show'    => 'kegiatan.show',
            'edit'    => 'kegiatan.edit',
            'update'  => 'kegiatan.update',
            'destroy' => 'kegiatan.destroy',
        ]);

        // Event
        Route::resource('event', AdminEventController::class)->names([
            'index'   => 'event.index',
            'create'  => 'event.create',
            'store'   => 'event.store',
            'show'    => 'event.show',
            'edit'    => 'event.edit',
            'update'  => 'event.update',
            'destroy' => 'event.destroy',
        ]);

        // Galeri
        Route::resource('galeri', AdminGaleriController::class)->names([
            'index'   => 'galeri.index',
            'create'  => 'galeri.create',
            'store'   => 'galeri.store',
            'show'    => 'galeri.show',
            'edit'    => 'galeri.edit',
            'update'  => 'galeri.update',
            'destroy' => 'galeri.destroy',
        ]);

        // Video
        Route::resource('video', AdminVideoController::class)->names([
            'index'   => 'video.index',
            'create'  => 'video.create',
            'store'   => 'video.store',
            'show'    => 'video.show',
            'edit'    => 'video.edit',
            'update'  => 'video.update',
            'destroy' => 'video.destroy',
        ]);

        // Donasi
        Route::resource('donasi', AdminDonasiController::class)->names([
            'index'   => 'donasi.index',
            'create'  => 'donasi.create',
            'store'   => 'donasi.store',
            'show'    => 'donasi.show',
            'edit'    => 'donasi.edit',
            'update'  => 'donasi.update',
            'destroy' => 'donasi.destroy',
        ]);
        Route::post('donasi/{donasi}/konfirmasi', [AdminDonasiController::class, 'konfirmasi'])->name('donasi.konfirmasi');

        // Pengurus
        Route::resource('pengurus', PengurusController::class)->parameters(['pengurus' => 'pengurus'])->names([
            'index'   => 'pengurus.index',
            'create'  => 'pengurus.create',
            'store'   => 'pengurus.store',
            'show'    => 'pengurus.show',
            'edit'    => 'pengurus.edit',
            'update'  => 'pengurus.update',
            'destroy' => 'pengurus.destroy',
        ]);

        // Jadwal Shalat
        Route::get('shalat', [ShalatController::class, 'index'])->name('shalat.index');
        Route::post('shalat', [ShalatController::class, 'store'])->name('shalat.store');
        Route::put('shalat/{jadwal}', [ShalatController::class, 'update'])->name('shalat.update');
        Route::post('shalat/fetch-api', [ShalatController::class, 'fetchFromApi'])->name('shalat.fetch');

        // TV Display
        Route::resource('tv', TvController::class)->names([
            'index'   => 'tv.index',
            'create'  => 'tv.create',
            'store'   => 'tv.store',
            'show'    => 'tv.show',
            'edit'    => 'tv.edit',
            'update'  => 'tv.update',
            'destroy' => 'tv.destroy',
        ]);
        Route::get('tv-layout', [TvController::class, 'layout'])->name('tv.layout');
        Route::post('tv-layout', [TvController::class, 'layoutUpdate'])->name('tv.layout.update');

        // Users
        Route::post('users/bulk-destroy', [UserController::class, 'destroyBulk'])->name('users.bulk-destroy');
        Route::resource('users', UserController::class)->names([
            'index'   => 'users.index',
            'create'  => 'users.create',
            'store'   => 'users.store',
            'show'    => 'users.show',
            'edit'    => 'users.edit',
            'update'  => 'users.update',
            'destroy' => 'users.destroy',
        ]);
        Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');

        // SEO
        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('seo/{page}', [SeoController::class, 'update'])->name('seo.update');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

        // Media
        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        // Kontak inbox
        Route::get('kontak', fn() => view('admin.kontak.index', [
            'kontaks' => \App\Models\Kontak::orderByDesc('created_at')->paginate(20)
        ]))->name('kontak.index');
        Route::get('kontak/{kontak}', function (\App\Models\Kontak $kontak) {
            if (!$kontak->is_read) $kontak->update(['is_read' => true, 'read_at' => now()]);
            return view('admin.kontak.show', compact('kontak'));
        })->name('kontak.show');
        Route::post('kontak/{kontak}/read', function (\App\Models\Kontak $kontak) {
            $kontak->update(['is_read' => true, 'read_at' => now()]);
            return back();
        })->name('kontak.read');
        Route::delete('kontak/{kontak}', function (\App\Models\Kontak $kontak) {
            $kontak->delete();
            return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus.');
        })->name('kontak.destroy');

        // Notifikasi realtime (badge sidebar + dropdown topbar)
        Route::get('notifications/feed', [NotificationController::class, 'feed'])->name('notifications.feed');
        Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    });
});

// ─── JAMAAH ROUTES ──────────────────────────────────────────────────────────
Route::prefix('jamaah')->name('jamaah.')->group(function () {
    // Public routes (guest)
    Route::middleware('guest')->group(function () {
        Route::get('/register', [JamaahRegisterController::class, 'showForm'])->name('register');
        Route::post('/register', [JamaahRegisterController::class, 'register'])->name('register.post');

        $loginPath = config('app.jamaah_login_path', 'masuk');
        Route::get('/' . $loginPath, [JamaahLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/' . $loginPath, [JamaahLoginController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [JamaahLoginController::class, 'logout'])->name('logout');

    // Protected jamaah routes
    Route::middleware(['auth', 'role:jamaah'])->group(function () {
        Route::get('/', [JamaahDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [JamaahDashboardController::class, 'index']);
    });
});
