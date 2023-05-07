<?php

namespace App\Http\Libraries;

use \Illuminate\Contracts\Support\Arrayable;

class DefaultObject implements Arrayable {

    public function toArray() {
        return new \stdClass();
    }

}