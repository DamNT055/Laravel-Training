<?php 

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use App\Service\SimpleServices;

class DeferredProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void
    {
        $this->app->singleton(SimpleServices::class, function(Application $app) {
            return new SimpleServices();
        });
    }
    public function provides():array {
        return [SimpleServices::class];
    }
    public function boot() {}
    
}