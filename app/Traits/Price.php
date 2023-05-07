<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

trait Price
{
    /**
     * @param $price
     * @return \stdClass
     */
    public function getPriceObject($price , $rate = 0)
    {
        $priceObject = new \stdClass();
        $priceObject->usd = new \stdClass();
        $priceObject->aed = new \stdClass();
//        $rate = getConversionRate();
        $priceObject->usd->price = $price;
        $priceObject->usd->symbol = '$';
        $priceObject->aed->price = round($price * $rate, 2);
        $priceObject->aed->symbol = 'AED';
        return $priceObject;
    }
}