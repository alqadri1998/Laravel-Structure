<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $locale = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Request $request) {
        // get locale at segment # 1
//        $this->locale = $request->segment(1);
        $this->locale = null;
        if ($this->locale) {
            $locales = config('app.locales');
            if (array_key_exists($this->locale, $locales)) {
                $this->app->setLocale($this->locale);
            }
        }
        
        $this->mapApiRoutes();
        
        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        if ($this->locale) {
            Route::middleware('web')
                    ->namespace($this->namespace)
                    ->prefix($this->locale)
                    ->group(base_path('routes/web.php'));
        }
        else {
            Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        if ($this->locale) {
            Route::prefix('api')
                    ->middleware('api')
                    ->prefix($this->locale)
                    ->namespace($this->namespace)
                    ->group(base_path('routes/api.php'));
        }
        else {
            Route::prefix('api')
                    ->middleware('api')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/api.php'));
        }
    }

}
