<?php

namespace App\Providers;

use App\Http\Libraries\SDTyresTranslator;
use Illuminate\Translation\TranslationServiceProvider;

class SDTyresTranslationServiceProvider extends TranslationServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->registerLoader();
        $this->app->singleton('translator', function($app){
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $sdTyresTranslator = new SDTyresTranslator($loader, $locale);
            $sdTyresTranslator->setFallback($app['config']['app.fallback_locale']);
            return $sdTyresTranslator;
        });
    }

}
