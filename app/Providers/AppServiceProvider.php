<?php

namespace App\Providers;

use App\Models\User\Favorites;
use App\Observers\UserFavoritesObserver;
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
        Favorites::observe(UserFavoritesObserver::class);
    }
}
