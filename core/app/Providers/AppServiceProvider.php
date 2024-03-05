<?php

namespace App\Providers;

use App\Models\MainService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        $main_service = MainService::orderBy('created_at', 'desc')->limit(6)->get();
        view()->share('main_services', $main_service);

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

    }
}
