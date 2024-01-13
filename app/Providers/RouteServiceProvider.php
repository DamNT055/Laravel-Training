<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('global', function(Request $request) {
            return Limit::perHour(100)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('global', function(Request $request) {
            return Limit::perMinute(1000)->response(function(Request $request, array $header) {
                return response('Custom response...', 429, headers: $header);
            });
        });

        RateLimiter::for('uploads', function(Request $request) {
            return $request->user()->vipCustomer() ? Limit::none() : Limit::perMinute(100);
        });
        
        RateLimiter::for('uploads', function(Request $request) {
            return $request->user() ? Limit::perMinute(100)->by($request->user()->id) : Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('login', function(Request $request) {
            return [
                Limit::perMinute(500),
                Limit::perMinute(5)->by($request->input('mail'))
            ];
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::pattern('id','[0-9]+');

    }
}
