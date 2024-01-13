<?php 

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use App\Service\SimpleServices;
use App\Service\HardService;
use Illuminate\Support\Facades\App;

use App\Contracts\EventPusher;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use App\Service\RedisEventPusher;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class DeferredProvider extends ServiceProvider implements DeferrableProvider {
    public function register(): void
    {
        $this->app->singleton(SimpleServices::class, function(Application $app) {
            return new SimpleServices();
        });

        $this->app->singletonIf(SimpleServices::class, function(Application $app) {
            return new SimpleServices(App::make(HardService::class));
        });

        $this->app->bind(SimpleServices::class, function(Application $app) {
            return new SimpleServices($this->app->make(HardService::class));
        });

        App::bind(SimpleServices::class, fn(Application $app) => new SimpleServices());

        $this->app->bindIf(SimpleServices::class, function(Application $app) {
            return new SimpleServices($this->app->make(HardService::class));
        });

        $this->app->scoped(SimpleServices::class, function(Application $app) {
            return new SimpleServices($app->make(HardService::class));
        });

        $service = new HardService();
        $this->app->instance(SimpleServices::class, $service);   

        $this->app->bind(EventPusher::class, RedisEventPusher::class);

        $this->app->when(PhotoController::class)->needs(Filesystem::class)->give(function() { return Storage::disk('local'); });
        $this->app->when([VideoController::class, SimpleController::class])->give(function() { return Storage::disk('s3'); });

        $value = 5;
        $this->app->when(SimpleController::class)->needs('$variableName')->give($value);

        $this->app->when(SimpleController::class)->needs('$variableName')->giveTagged('tags');

        $this->app->when(SimpleController::class)->needs('$timezone')->giveConfig('app.timezone');

        $this->app->when(SimpleController::class)->needs(SimpleServices::class)->give(function(Application $app) {
            return [
                $app->make(HardService::class),
                $app->make(PhotoController::class)
            ];
        });

        $this->app->when(SimpleController::class)->needs(SimpleServices::class)
        ->give([HardProvider::class, PhotoController::class]);

        $this->app->when(SimpleController::class)->needs(SimpleServices::class)->giveTagged('tag');

        $this->app->bind(SimpleServices::class, function() {});
        $this->app->bind(HardService::class, function() {});
        $this->app->tag([SimpleServices::class, HardService::class], 'taged');  

        $this->app->bind(SimpleServices::class, function(Application $app) {
            return new SimpleServices($app->tagged('taged'));
        });
        
        $photoController = $this->app->make(PhotoController::class);
        $photoController = $this->app->makeWith(PhotoController::class, ['id' => 1]);

        if($this->app->bound(SimpleController::class)) {
            // Service 'serviceName' is bound in the container.
        } else {
            // Service 'serviceName' is not bound in the container.
        }

        $photoController = App::make(PhotoController::class);
        $photoController = app(PhotoController::class);
        
        $report = App::call([new User(), 'generate']);

        $this->app->resolving(SimpleServices::class, function(SimpleServices $simpleServices, Application $app) {});

    }
    public function provides():array {
        return [SimpleServices::class];
    }
    public function boot() {}
    
}