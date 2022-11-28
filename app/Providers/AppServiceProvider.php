<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

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
        Http::macro('punkapi', function () {
           return Http::acceptJson()
               ->retry(3, 100)
               ->baseUrl(config('punkapi.url'));
        });

        Model::shouldBeStrict(
            ! app()->isProduction() // Only outside of production.
        );
    }
}
