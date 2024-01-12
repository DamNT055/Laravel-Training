<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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