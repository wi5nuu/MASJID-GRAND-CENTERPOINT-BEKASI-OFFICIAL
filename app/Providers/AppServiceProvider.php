<?php

namespace App\Providers;

use App\Services\AdminNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Badge + dropdown notifikasi panel admin (sidebar & topbar)
        View::composer(
            ['components.admin.sidebar', 'components.admin.topbar'],
            fn ($view) => $view->with('adminNotif', AdminNotification::feed(6))
        );
    }
}
