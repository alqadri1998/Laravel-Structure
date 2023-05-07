<?php



namespace App\Providers;



use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Broadcast;



class BroadcastServiceProvider extends ServiceProvider

{

    /**

     * Bootstrap any application services.

     *

     * @return void

     */

    public function boot()

    {

        $calledFrom = \Request::header('calledFrom');

        $adminPath = strpos(\Request::path(), 'admin');

        if($adminPath === true || $calledFrom == 'admin'){

            Broadcast::routes(['prefix' => 'en', 'middleware' => ['assign.guard:admin','jwt.verify']]);

        }else{

//            logger('1');

            Broadcast::routes(['prefix' => 'en', 'middleware' => ['api','jwt.verify']]);

        }

        require base_path('routes/channels.php');

    }

}

