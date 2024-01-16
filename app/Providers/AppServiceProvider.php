<?php

namespace App\Providers;

use App\Http\Middleware\TerminatingMiddleware;
use App\Http\Middleware\TrimStrings;
use Illuminate\Support\ServiceProvider;
use App\Providers\SimpleProvider;
use App\Providers\HardProvider;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadesResponse;
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
        $this->app->singleton(TerminatingMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('view', function() {});

        TrimStrings::skipWhen(function(Request $request) {
            return $request->is('admin/*');
        });
        ConvertEmptyStringsToNull::skipWhen(function(Request $request) {
            // ...
        });

        Response::macro('caps', function(string $s) {
            return FacadesResponse::make(strtoupper($s));
        });
    }
}
