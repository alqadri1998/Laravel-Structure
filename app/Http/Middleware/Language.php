<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Language as Lang;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Foundation\Application;

class Language {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

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
