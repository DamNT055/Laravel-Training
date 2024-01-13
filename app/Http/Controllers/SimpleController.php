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

    public function named_argument($var1, $var2):void {
        echo $var1, $var2;
    }

    public function test_named_arg():User {
        $this->named_argument(var1: 5, var2: 7);

        return new User();
    }    

    public function route() {
        $route = route('/');
        redirect()->route('demo');
        to_route('demo');
        route('variable', ['id' => 1]);
    }
}