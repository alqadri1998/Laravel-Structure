<?php


/*

  |--------------------------------------------------------------------------

  | API Routes

  |--------------------------------------------------------------------------

  |

  | Here is where you can register API routes for your application. These

  | routes are loaded by the RouteServiceProvider within a group which

  | is assigned the "api" middleware group. Enjoy building your API!

  |

 */


use App\Events\newNotifications;


Route::group(['namespace' => 'Admin', 'as' => 'api.'], function () {


    Route::get('sub-categories/{id}', ['uses' => 'ProductsController@getSubCategories1', 'as' => 'products.get.subCategories']);
    Route::get('sub-sub-categories/{id}', ['uses' => 'ProductsController@getSubSubCategories1', 'as' => 'products.get.subCategories1']);
    Route::post('sub-attributes', ['uses' => 'ProductsController@getSubAttributesAjax', 'as' => 'products.get.subAttributes']);
    Route::post('save-product', ['uses' => 'ProductsController@update', 'as' => 'products.save-product']);
    Route::post('edit-product', ['uses' => 'ProductsController@editProduct', 'as' => 'products.edit-product']);

});


Route::group(['namespace' => 'Front', 'as' => 'api.'], function () {

    Route::get('category/sub-categories/{id}', ['uses' => 'CategoryController@getSubCategories1', 'as' => 'categories.get.subCategories']);
});


Route::group(['namespace' => 'Api', 'as' => 'api.', 'prefix' => 'api', 'middleware' => ['assign.guard:web', 'jwt.auth']], function () {


    Route::get('notifications', ['uses' => 'NotificationController@notifications', 'as' => 'notification.all']);

    Route::get('notifications-count', ['uses' => 'NotificationController@notificationCount', 'as' => 'notification.count']);

    Route::get('notification-seen', ['uses' => 'NotificationController@isSeen', 'as' => 'notification.seen']);

    Route::get('notification-view/{notificationId}', ['uses' => 'NotificationController@isViewed', 'as' => 'notification.viewed']);

    Route::get('notification-delete/{notificationId}', ['uses' => 'NotificationController@deleteNotification', 'as' => 'notification.delete']);

    Route::get('notifications-clear', ['uses' => 'NotificationController@clearAll', 'as' => 'notification.clear.all']);

});

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::get('admin/notifications', ['uses' => 'NotificationController@notifications', 'as' => 'notification.all']);

    Route::get('admin/notifications-count', ['uses' => 'NotificationController@notificationCount', 'as' => 'notification.count']);

    Route::get('admin/notification-seen', ['uses' => 'NotificationController@isSeen', 'as' => 'notification.seen']);

    Route::get('admin/notification-view/{notificationId}', ['uses' => 'NotificationController@isViewed', 'as' => 'notification.viewed']);

    Route::get('admin/notification-delete/{notificationId}', ['uses' => 'NotificationController@deleteNotification', 'as' => 'notification.delete']);

    Route::get('admin/notifications-clear', ['uses' => 'NotificationController@clearAll', 'as' => 'notification.clear.all']);

    Route::get('categories', ['uses' => 'ProductController@categories', 'as' => 'categories.all']);

    Route::get('brands', ['uses' => 'ProductController@brands', 'as' => 'brands.all']);

    Route::get('origin', ['uses' => 'ProductController@origin', 'as' => 'origin.all']);

     Route::get('promotions', ['uses' => 'ProductController@promotions', 'as' => 'promotions.all']);

//    route::get('/search/filters/{value}/{type}/{parent}', ['uses' => 'ProductController@getFilters', 'as' => 'search.filters']);
    route::get('/search/filters', ['uses' => 'ProductController@getFilters', 'as' => 'search.filters']);

    Route::get('models/{vehicle_id}', ['uses' => 'ProductController@getVehicleModels', 'as' => 'user.checkout.vehicle.models']);

    Route::get('years/{model_id}', ['uses' => 'ProductController@getModelYears', 'as' => 'user.checkout.model.years']);

    Route::get('height/{width_id}', ['uses' => 'ProductController@getWidthHeight', 'as' => 'search.height']);

    Route::get('rim/{height_id}', ['uses' => 'ProductController@getHeightRim', 'as' => 'search.rim']);

    Route::get('user/cart-count/{id}', ['uses' => 'ProductController@cartCount', 'as' => 'cart.count']);

});


Route::get('check/auth', function (Request $request) {

    $temp = new stdClass();

    $temp->id = 73;

    broadcast(new newNotifications(new stdClass(), $temp));

//    return redirect()->back();

});