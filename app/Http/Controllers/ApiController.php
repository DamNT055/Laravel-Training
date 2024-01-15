<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        #http://example.com/foo/bar

        $uri = $request->path(); # -> foo/bar
        $url = $request->url(); # -> no params
        $urlWithQueryString = $request->fullUrl(); # -> with params
        if ($request->is('admin/*')) {};
        if ($request->routeIs('admin.*')) {};

        $request->fullUrlWithQuery(['type' => 'phone']);
        $request->fullUrlWithoutQuery(['type']);

        $request->host();               # yourapp.com
        $request->httpHost();           # yourapp.com
        $request->schemeAndHttpHost();  # http://yourapp.com

        $request->isMethod('POST');
        $request->method();

        $value = $request->header('X-Header-Name');
        $value = $request->header('X-Header-Name', 'default');
        if ($request->hasHeader('X-Header-Name')) {};

        $token = $request->bearerToken(); # auth token

        $ip = $request->ip();
        $ips = $request->ips();

        $contentType = $request->getAcceptableContentTypes();
        if ($request->accepts(['text/html', 'application/json'])) {};
        $preferd = $request->prefers(['application/json']);
        if ($request->expectsJson()) {};
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $input = $request->collect();
        $request->collect('users')->each(function(string $user) {});
        $name = $request->input('name');
        $name = $request->input('name', 'Sallu');
        $names = $request->input('products.0.name');
        $name = $request->input('products.*.name');
        $input = $request->input();

        $name=  $request->query('name');
        $name = $request->query('name', 'Halley');

        $request->string('name')->trim();
        
        $archived = $request->boolean('archived');
        $birthday = $request->date('birthday');
        $status = $request->enum('status', Status::class);
        $name = $request->name;

        $input = $request->only(['username', 'password']);
        $input = $request->except(['credit_card']);

        if ($request->has('name')) {};
        if ($request->hasAny(['name','email'])) {};
        $request->whenHas('name', function() {
            // function name exist
        }, function() {
            // function name not exist
        });

        if ($request->filled('name')) {};
        if ($request->anyFilled(['name', 'email'])) {};
        $request->whenFilled('name', function() {
            // yes
        }, function() {
            // no 
        });
        if ($request->missing('password')) {};
        $request->whenMissing('password', function() {}, function() {});

        $request->merge(['votes' => 0]);
        $request->mergeIfMissing(['votes' => 0]);

        $request->flash();
        $request->flashOnly([]);
        $request->flashExcept([]);
        
        #return
         redirect('form')->withInput();
         redirect()->route('user.create')->withInput();
         redirect('form')->withInput($request->except(['password']));

        #old 
        $old = $request->old('username');

        #cookie
        $value = $request->cookie('name');
        
        #file 
        $file = $request->file('photo');
        $file = $request->photo;
        if ($request->hasFile('photo')) {};
        if ($request->file('photo')->isValid()) {};
        $path = $request->photo->path();
        $extension = $request->photo->extension();

        #store path 
        $path = $request->photo->store('images');
        $path = $request->photo->store('images', 's3');

        $path = $request->photo->storeAs('images', 'filename.jpg', 's3');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
