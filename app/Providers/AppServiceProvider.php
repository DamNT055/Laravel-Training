<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\SimpleProvider;
use App\Providers\HardProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        SimpleProvider::class => HardProvider::class
    ];
    
    public $singletons = [
        HardProvider::class => SimpleProvider::class
    ];

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
        View::composer('view', function() {});
    }
}
