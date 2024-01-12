<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SimpleController extends Controller {
    public function __construct(protected User $user)
    {}

    public function show(string $id):View {
        return view();
    }

    public function test_basic_example():void {
        Cache::shouldReceive('get')->with('key')->andReturn('value');
        $response = $this->get('/');
        $response->assertSee('value');
    }
}