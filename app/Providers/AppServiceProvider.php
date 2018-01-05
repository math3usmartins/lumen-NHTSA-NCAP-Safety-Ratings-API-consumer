<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\NHTSA\WebApi\SafetyRatings;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('App\NHTSA\WebApi\SafetyRatings', function() {
            return new SafetyRatings(env('NHTSA_WEBAPI_BASE_URL'));
        });
    }
}
