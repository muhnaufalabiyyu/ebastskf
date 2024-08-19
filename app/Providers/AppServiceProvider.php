<?php

namespace App\Providers;

use App\SymfonyMailerService;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (env('FORCE_HTTPS', false)) {
        //     URL::forceScheme('https');
        // }
    }
}
