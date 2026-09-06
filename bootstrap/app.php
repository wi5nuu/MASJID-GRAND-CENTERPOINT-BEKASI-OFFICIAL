<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Pengguna yang sudah login dan membuka halaman login diarahkan
        // ke dashboard sesuai perannya (bukan ke beranda).
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if ($user && $user->hasRole('jamaah')) {
                return route('jamaah.dashboard');
            }
            if ($user && method_exists($user, 'isAdmin') && ($user->isAdmin() || $user->hasRole('editor'))) {
                return route('admin.dashboard');
            }
            return route('home');
        });

        // Alias middleware keamanan login
        $middleware->alias([
            'honeypot'    => \App\Http\Middleware\HoneypotCheck::class,
            'login.limit' => \App\Http\Middleware\LoginRateLimit::class,
            'role'        => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
