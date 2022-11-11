<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(UrlGenerator $urlGenerator): void
    {
        if (config('app.env') !== 'local') {
            $urlGenerator->forceScheme('https');
        }
    }
}
