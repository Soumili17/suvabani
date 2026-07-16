<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notice;

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
        // Share the latest notices with the frontend navbar partial on every page load.
        View::composer('frontend.partials.navbar', function ($view) {
            $view->with('navbarNotices', Notice::latest()->get());
        });
    }
}
