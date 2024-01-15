<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function __invoke($param1, $param2){
        return $param1 + $param2;
    }
}

$obj = new HardController();
$result = $obj(1,2);

echo $result;