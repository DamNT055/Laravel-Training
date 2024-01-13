<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Psr\Container\ContainerInterface;

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

Route::get('/', function () {
    return view('welcome');
});

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

Route::post();
Route::put();
Route::patch();
Route::delete();
Route::options();

Route::match(['get', 'post'], '/', function() {});
Route::any('/', function() {});

Route::redirect('/', 301);
Route::permanentRedirect('/');
Route::view('view', 'welcome', ['name'=> 'TDam']);
Route::get('/{meo}', function($meo) {});
Route::get('/{optionnal?}', function(?string $optional) {});
Route::get('/{regex}', function(string $name) {})->where('name', '[A-Za-z]+')->whereNumber('name');

Route::controller(['controller'])->group(function() {});
Route::middleware(['middleware'])->group(function() {});
Route::domain('example.com.vn')->group(function() {});
Route::prefix('prefix')->name('');