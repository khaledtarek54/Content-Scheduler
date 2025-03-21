<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Exceptions\UnauthenticatedException;
use Illuminate\Auth\Middleware\Authenticate;

class AuthServiceProvider extends ServiceProvider
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
        Authenticate::redirectUsing(function ($request) {
            throw new UnauthenticatedException();
        });
    }
}
