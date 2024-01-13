<?php 

namespace App\Service;

use App\Contracts\EventPusher;

class RedisEventPusher {
    public function __construct(
        protected EventPusher $eventPusher
    ){}
};