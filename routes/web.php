<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HardController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
class Service {

}


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
});



//////////////// ANCHOR - 

Route::get('/demo', function(Service $service) {
    exit($service::class);
});

Route::get('/facade', function() { 
    return Cache::get('key');
});

Route::get('response', function() {
    Response::json([]);
});

Route::get('response', function() {
    response()->json([]);
});

Route::get('facade_helper', function() {
    return \Illuminate\Support\Facades\View::make('index');
    return view('index');
});

Route::get('cache', function() {
    return cache('key');
});

Route::get('psr', function(ContainerInterface $container) {
    $service = $container->get(PhotoController::class);
    // 
});

// Route::post();
// Route::put();
// Route::patch();
// Route::delete();
// Route::options();

// Route::match(['get', 'post'], '/', function() {});
// Route::any('/', function() {});

// Route::redirect('/', 301);
// Route::permanentRedirect('/');
Route::view('view', 'welcome', ['name'=> 'TDam']);
Route::get('/{meo}', function($meo) {});
Route::get('/{optionnal?}', function(?string $optional) {});
Route::get('/{regex}', function(string $name) {})->where('name', '[A-Za-z]+')->whereNumber('name');

Route::controller(['controller'])->group(function() {});
Route::middleware(['middleware'])->group(function() {});
Route::domain('example.com.vn')->group(function() {});
Route::prefix('prefix')->name('');

Route::fallback(function() {
    //
});

Route::middleware(['throttle:uploads'])->group(function() {
    Route::post('/video', function() {

        $route = Route::current();
        $name = Route::currentRouteName();
        $action = Route::currentRouteAction();

    });
});

Route::get('check_token', function() {})->middleware('token');
Route::middleware('token')->group(function() {  
    Route::get('/', function() {});
    Route::get('/profile', function() {})->withoutMiddleware('token');
});

Route::put('/post/{id}', function(string $id) {})->middleware('role:editor,publisher');


Route::get('crsf_token_request', function(Request $request) {
    $token = $request->session->token();
    $token = csrf_token();
});

Route::get('invoke', HardController::class);

Route::resource('resource', ResourceController::class);

Route::resources([
    'post' => ResourceController::class,
    'source' => HardController::class
]);

Route::resource('resource2', ResourceController::class)->missing(function (Request $request) {
    return Redirect::route('home.index'); 
});

#index, create, store, show, edit, update, destroy 
Route::resource('soft-delete', ResourceController::class)->withTrashed();
Route::resource('soft-delete-show', ResourceController::class)->withTrashed(['show']);

Route::resource('photos', ResourceController::class)->only(['index', 'show']);
Route::resource('photos', ResourceController::class)->except(['create', 'store', 'update', 'destroy']);

Route::apiResource('photos', ResourceController::class);
Route::apiResources([
    'photos' => ResourceController::class,
    'video' => ResourceController::class
]);


// photos/{photo}/comments/{comment}
Route::resource('photos.comments', ApiController::class);
Route::resource('photos.comments', ApiController::class)->shallow();

Route::resource('photo', ApiController::class)->names([
    'create' => 'photo.create'
]);

# photos/{one_img}
Route::resource('photos', ApiController::class)->parameters([
    'photos' => 'one_img'
]);

# photos/{photo}/comments/{comment:slug}
Route::resource('photos.comments', ApiController::class)->scoped([
    'comment' => 'slug'
]);


Route::get('photos/popular', [ApiController::class, 'popular']);
Route::resource('photos', ApiController::class);

Route::singleton('photos.thumbnail', ApiController::class);
Route::singleton('photos', ApiController::class)->creatable();
Route::singleton('photos', ApiController::class)->destroyable();

Route::apiSingleton('photos', ApiController::class);
Route::apiSingleton('photos', ApiController::class)->creatable();

Route::get('resp', function() {
    $type = 'application/json';
    response('Success', 200)->header('Content-type', 'application/json');
    response('Ok', 200)->withHeaders([
        'Content-type' => $type,
        'X-Header-One' => 'one'
    ]);
});

Route::middleware('cache.headers:public;max_age=262800;etag')->group(function() {
    Route::get('privacy', function() {});
    Route::get('cert', function() {
    });
});

Route::get('cookies', function() {
    $minutes = 10;
    return response('OK', 200)->cookie('name', 'value', $minutes);
    Cookie::queue('name', 'value', $minutes);

    $cookie = cookie('name', 'value', $minutes);
    return response('Respon')->withoutCookie('name');
    Cookie::expire('name');
});

Route::get('back', function() {
    return back()->withInput();
    redirect()->route('home.index', ['name'=>'LiLy']);
    redirect()->action([UserController::class, 'index'], ['user_1' => 'Mike']);
    redirect()->away('www.google.com');
});

Route::post('flash', function() {
    return redirect()->route('dashboard')->with('status', 'Profile Update');
    
    return back()->withInput();
});