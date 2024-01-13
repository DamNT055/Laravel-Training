<?php 

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Log\Logger;

class PhotoController {
    protected $filter;
    public function __construct(
        protected Logger $logger,
        User ...$filter
    ){
        $this->filter = $filter;   
    }
}