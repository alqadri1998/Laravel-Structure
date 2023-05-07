<?php

namespace App\Http\Middleware;

use Closure;

class EmailVerified {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = auth()->user();
        if ($user->is_verified == 0){
            return redirect(route('front.verification'));
        }
        return $next($request);
    }

}
