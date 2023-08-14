<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    
 

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
 public function boot(UrlGenerator $url) 
{
    if($this->app->environment('production')) {
        \URL::forceScheme('https');
    }
}
}
