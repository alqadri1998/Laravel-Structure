<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\ConversionRate;

class CurrencyConversion {
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        return $next($request);
    }

}
