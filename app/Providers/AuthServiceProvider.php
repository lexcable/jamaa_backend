<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        // Tokens expire in 5 minutes
        Passport::tokensExpireIn(Carbon::now()->addMinutes(5));

        //refresh tokens expire in 10 minutes
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(10));
    }
}
