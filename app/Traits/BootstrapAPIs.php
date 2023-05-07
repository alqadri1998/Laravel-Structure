<?php

namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait BootstrapAPIs {
    
    public function __construct() {
        $token = JWTAuth::getToken();
        $this->user = JWTAuth::toUser($token);
    }
    
}
