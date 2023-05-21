<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
		//Paginator::defaultView('vendor.pagination.bootstrap-4');	// - так мы делали в прошлом курсе
		Paginator::useBootstrap();
    }
}
