<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gunakan tampilan pagination kustom (tidak bergantung Tailwind/Vite)
        Paginator::defaultView('vendor.pagination.benih');
        Paginator::defaultSimpleView('vendor.pagination.benih');
    }
}
