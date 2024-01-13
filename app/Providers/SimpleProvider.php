<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\SimpleServices;
use Illuminate\Contracts\Console\Application;
use App\Providers\HardProvider;

use Illuminate\Contracts\Routing\ResponseFactory;

class SimpleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SimpleServices::class, function(Application $app) {
            return new SimpleServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(ResponseFactory $response): void
    {
        $response->make('serialized', function(mixed $value) {});
    }
}
