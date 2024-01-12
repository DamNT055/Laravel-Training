<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class UserController {
    public function showProfile(string $id): View {
        $user = Cache::get('user', $id);
        return view('index', ['user' => $user]);
    }
}