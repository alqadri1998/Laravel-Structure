<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\newNotifications;

//\Artisan::call('clear:all');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::group(['as' => 'auth.'], function () {
        Route::get('/fileupload', ['uses' => 'HomeController@file']);
        Route::get('/', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login.show-login-form']);
        Route::post('login', ['uses' => 'Auth\LoginController@login', 'as' => 'login.login']);
        Route::post('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'login.logout']);
        Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'login.logout']);
        Route::post('password/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'forgot-password.send-reset-link-email']);
        Route::get('password/reset', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'forgot-password.show-link-request-form']);
        Route::get('password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm', 'as' => 'forgot-password.show-reset-form']);
        Route::post('password/reset', ['uses' => 'Auth\ResetPasswordController@reset', 'as' => 'forgot-password.reset']);
    });

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('home', ['uses' => 'HomeController@index', 'as' => 'home.index']);
        Route::post('list/orders/{status}', ['uses' => 'OrdersController@all', 'as' => 'orders.ajax.list']);
        Route::post('list/orders-detail/{id}', ['uses' => 'OrdersController@ordersDetailAll', 'as' => 'orders.detail.ajax.list']);
        Route::get('order-detail/{id}/status/{status}', ['uses' => 'OrdersController@changeStatus', 'as' => 'orders.detail.change.status']);
        Route::get('orders/{status}', ['uses' => 'OrdersController@order', 'as' => 'orders.order']);
        Route::post('list/users', ['uses' => 'UsersController@all', 'as' => 'users.ajax.list']);
        Route::get('site-settings/{id}', ['uses' => 'SiteSettingsController@delete', 'as' => 'site-settings.delete']);
        Route::get('translations/export-csv/{id}', ['uses' => 'TranslationsController@exportCsv', 'as' => 'translations.export-csv']);
        Route::post('translations/import-csv', ['uses' => 'TranslationsController@importExcel', 'as' => 'translations.import-csv']);
        Route::get('categories/{id}', ['uses' => 'CategoryController@destroy', 'as' => 'category.destory']);
        route::get('/import-excel', ['uses' => 'ExcelController@importExcelData', 'as' => 'importExcelData']);
        route::post('/import-excel', ['uses' => 'ExcelController@importExcelData', 'as' => 'importExcelData']);
//        route::get('/import/excel/file', ['uses' => 'ExcelController@importExcelData', 'as' => 'importExcelData']);


        Route::resources([
            'roles' => 'RolesController',
            'users' => 'UsersController',
            'administrators' => 'AdministratorsController',
            'pages' => 'PagesController',
            'site-settings' => 'SiteSettingsController',
            'translations' => 'TranslationsController',
            'notifications' => 'NotificationController',
            'templates' => 'TemplatesController',
            'products' => 'ProductsController',
//            'cart' => 'CartController',
            'orders' => 'OrdersController',
//            'complete-orders' => 'CompleteOrdersController',
            'categories' => 'CategoryController',
            'events' => 'EventController',
            'products.product-images' => 'ProductImagesController',
            'slider' => 'SliderController',
            'partners' => 'LogosController',
            'attributes' => 'AttributeController',
            'attributes.sub-attributes' => 'SubAttributesController',
            'categories.sub-categories' => 'SubCategoriesController',
            'coupons' => 'CouponController',
            'catalogues' => 'CataloguesController',
            'branches' => 'BranchController',
            'brands' => 'BrandController',
            'origins' => 'OriginController',
            'packages' => 'ServicePackageController',
            'services' => 'ServiceController',
            'repairs' => 'RepairController',
            'promotions' => 'PromotionController',
            'subscriptions' => 'SubscriptionController',



        ]);

        Route::get('product-detail/{id}', ['uses' => 'ProductsController@productDetail', 'as' => 'product.product-detail']);
        //detail
        //details detail
        Route::get('orders/{id}/order-detail', ['uses' => 'OrdersController@orderDetail', 'as' => 'orders.order-detail']);
        Route::get('admin/notifications', ['uses' => 'NotificationController@index', 'as' => 'notification.index']);

//        Route::get('delivered-orders/{orderId}/order-detail/{orderDetailId}/details', ['uses' => 'DeliveriesController@OrderDetailData', 'as' => 'deliveries.order-detail-data']);
//        Route::get('complete-orders/{orderId}/order-detail/{orderDetailId}/details', ['uses' => 'CompleteOrdersController@OrderDetailData', 'as' => 'complete-orders.order-detail-data']);
//        Route::get('outstanding-deliveries/{orderId}/order-detail/{orderDetailId}/details', ['uses' => 'OutstandingDeliveriesController@OrderDetailData', 'as' => 'outstanding-deliveries.order-detail-data']);

        /*
         * HOME CONTROLLER - CUSTOM ROUTE
         */
//        Route::get('orders', ['uses' => 'OrdersController@changeStatus', 'as' => 'order.change-status']);
        Route::get('edit-profile', ['uses' => 'HomeController@editProfile', 'as' => 'home.edit-profile']);
        Route::put('update-profile', ['uses' => 'HomeController@updateProfile', 'as' => 'home.update-profile']);
        Route::get('maintenance-mode/on', ['uses' => 'HomeController@activateMaintenanceMode', 'as' => 'home.maintenance-mode.on']);
        Route::get('maintenance-mode/off', ['uses' => 'HomeController@activateLiveMode', 'as' => 'home.maintenance-mode.off']);
        Route::post('save-image', ['uses' => 'HomeController@saveImage', 'as' => 'home.save-image']);
        Route::get('get-public-images', ['uses' => 'HomeController@getPublicImages', 'as' => 'public-images']);
        Route::get('delete-public-image', ['uses' => 'HomeController@deletePublicImage', 'as' => 'delete-public-images']);
        Route::post('upload-image', ['uses' => 'HomeController@uploadImage', 'as' => 'upload-image']);
        /*
         * ADMINISTRATORS CONTROLLER - CUSTOM ROUTES
         */
        Route::post('list/administrators', ['uses' => 'AdministratorsController@all', 'as' => 'administrators.ajax.list']);
        Route::put('toggle-status/administrators/{id}', ['uses' => 'AdministratorsController@toggleStatus', 'as' => 'administrators.toggle-status']);
        Route::get('/administrators/restore/{id}', ['uses' => 'AdministratorsController@restore', 'as' => 'administrators.restore']);
        Route::get('/bulk-delete/administrators/{id}', ['uses' => 'AdministratorsController@bulkDelete', 'as' => 'administrators.ajax.bulk-delete']);
        Route::get('/bulk-restore/administrators/{id}', ['uses' => 'AdministratorsController@bulkRestore', 'as' => 'administrators.ajax.bulk-restore']);
        /*
         * USERS CONTROLLER - CUSTOM ROUTES
         */
        Route::post('list/users', ['uses' => 'UsersController@all', 'as' => 'users.ajax.list']);
        Route::put('toggle-status/users/{id}', ['uses' => 'UsersController@toggleStatus', 'as' => 'users.toggle-status']);
        Route::get('bulk-delete/users/{id}', ['uses' => 'UsersController@bulkDelete', 'as' => 'users.ajax.bulk-delete']);
        Route::get('bulk-restore/users/{id}', ['uses' => 'UsersController@bulkRestore', 'as' => 'users.ajax.bulk-restore']);
        Route::get('/users/restore/{id}', ['uses' => 'UsersController@restore', 'as' => 'users.restore']);
        /*
         * COMPANY CONTROLLER - CUSTOM ROUTES
         */
//        Route::post('list/companies', ['uses' => 'CompaniesController@all', 'as' => 'companies.ajax.list']);

        Route::post('list/roles', ['uses' => 'RolesController@all', 'as' => 'roles.ajax.list']);
        Route::put('toggle-status/roles/{id}', ['uses' => 'RolesController@toggleStatus', 'as' => 'roles.toggle-status']);
        Route::get('/roles/restore/{id}', ['uses' => 'RolesController@restore', 'as' => 'roles.restore']);
        Route::get('bulk-delete/roles/{id}', ['uses' => 'RolesController@bulkDelete', 'as' => 'roles.ajax.bulk-delete']);
        Route::get('bulk-restore/roles/{id}', ['uses' => 'RolesController@bulkRestore', 'as' => 'roles.ajax.bulk-restore']);
        /*
         * PAGES CONTROLLER - CUSTOM ROUTES
         */

        Route::post('list/pages', ['uses' => 'PagesController@all', 'as' => 'pages.ajax.list']);
        Route::put('toggle-status/pages/{id}', ['uses' => 'PagesController@toggleStatus', 'as' => 'pages.toggle-status']);
        Route::get('about-us-page', ['uses' => 'PagesController@aboutUs', 'as' => 'pages.about-us']);
        Route::get('/pages/restore/{id}', ['uses' => 'PagesController@restore', 'as' => 'pages.restore']);
        Route::get('bulk-delete/pages/{id}', ['uses' => 'PagesController@bulkDelete', 'as' => 'pages.ajax.bulk-delete']);
        Route::get('bulk-restore/pages/{id}', ['uses' => 'PagesController@bulkRestore', 'as' => 'pages.ajax.bulk-restore']);

        /*
         * Attributes CONTROLLER - CUSTOM ROUTES
         */
        Route::get('sub-attributes/{id}', ['uses' => 'AttributeController@subAttribute', 'as' => 'attributes.subAttribute']);
        Route::post('list/attributes', ['uses' => 'AttributeController@all', 'as' => 'attributes.ajax.list']);
        Route::post('list/subAttributes/{id}', ['uses' => 'SubAttributesController@all', 'as' => 'attributes.subattributes.ajax.list']);


        //        Category Controller
        Route::get('categories', ['uses' => 'CategoryController@index', 'as' => 'category.index']);
        Route::post('list/categories', ['uses' => 'CategoryController@all', 'as' => 'category.ajax.list']);
        Route::get('category/{id}/edit', ['uses' => 'CategoryController@edit', 'as' => 'category.edit']);
        Route::put('save-category/{id}', ['uses' => 'CategoryController@save', 'as' => 'category.save']);
        Route::get('sub-categories/{id}', ['uses' => 'SubCategoriesController@show', 'as' => 'sub-categories.show']);
        Route::post('list/sub-categories/{id}', ['uses' => 'SubCategoriesController@all', 'as' => 'sub-categories.ajax.list']);
        Route::get('list/category-attributes/{id}', ['uses' => 'CategoryController@categoryAttributes', 'as' => 'categoryAttribute.ajax.list']);


//         Event Controller Routes
        Route::get('events', ['uses' => 'EventController@index', 'as' => 'event.index']);
        Route::post('list/events', ['uses' => 'EventController@all', 'as' => 'event.ajax.list']);
        Route::get('event/{id}/edit', ['uses' => 'EventController@edit', 'as' => 'event.edit']);
        Route::put('save-event/{id}', ['uses' => 'EventController@store', 'as' => 'event.store']);
        Route::post('list/coupons', ['uses' => 'CouponController@all', 'as' => 'coupons.ajax.list']);


                    /*EXTRA BRANCH CONTROLLER ROUTES*/
        Route::post('list/branches', ['uses' => 'BranchController@all', 'as' => 'branch.ajax.list']);
        Route::get('branch/{id}/edit', ['uses' => 'BranchController@edit', 'as' => 'branches.edit']);
        Route::put('save-branch/{id}', ['uses' => 'BranchController@store', 'as' => 'branches.store']);

                    /*EXTRA SERVICE CONTROLLER ROUTES*/
        Route::post('list/services', ['uses' => 'ServiceController@all', 'as' => 'service.ajax.list']);
        Route::get('service/{id}/edit', ['uses' => 'ServiceController@edit', 'as' => 'services.edit']);
        Route::put('save-service/{id}', ['uses' => 'ServiceController@store', 'as' => 'services.store']);

                    /*EXTRA REPAIR CONTROLLER ROUTES*/
        Route::post('list/repairs', ['uses' => 'RepairController@all', 'as' => 'repair.ajax.list']);
        Route::get('repair/{id}/edit', ['uses' => 'RepairController@edit', 'as' => 'repairs.edit']);
        Route::put('save-repair/{id}', ['uses' => 'RepairController@store', 'as' => 'repairs.store']);

                    /*EXTRA BRAND CONTROLLER ROUTES*/
        Route::post('list/brands', ['uses' => 'BrandController@all', 'as' => 'brand.ajax.list']);
        Route::get('brand/{id}/edit', ['uses' => 'BrandController@edit', 'as' => 'brands.edit']);
        Route::put('save-brand/{id}', ['uses' => 'BrandController@store', 'as' => 'brands.store']);

            /*EXTRA PROMOTION CONTROLLER ROUTES*/
        Route::post('list/promotions', ['uses' => 'PromotionController@all', 'as' => 'promotion.ajax.list']);
        Route::get('promotion/{id}/edit', ['uses' => 'PromotionController@edit', 'as' => 'promotions.edit']);
        Route::put('save-promotion/{id}', ['uses' => 'PromotionController@store', 'as' => 'promotions.store']);

                    /*EXTRA ORIGIN CONTROLLER ROUTES*/
        Route::post('list/origins', ['uses' => 'OriginController@all', 'as' => 'origin.ajax.list']);
        Route::get('origin/{id}/edit', ['uses' => 'OriginController@edit', 'as' => 'origins.edit']);
        Route::put('save-origin/{id}', ['uses' => 'OriginController@store', 'as' => 'origins.store']);

                    /*EXTRA SERVICE PACKAGE CONTROLLER ROUTES*/
        Route::post('list/packages', ['uses' => 'ServicePackageController@all', 'as' => 'packages.ajax.list']);
        Route::get('package/{id}/edit', ['uses' => 'ServicePackageController@edit', 'as' => 'packages.edit']);
        Route::put('save-packages/{id}', ['uses' => 'ServicePackageController@store', 'as' => 'packages.store']);

        /*EXTRA SUBSCRIPTION ROUTES*/
        Route::post('list/subscriptions', ['uses' => 'SubscriptionController@all', 'as' => 'packages.ajax.list']);

        /*
        * Languages CONTROLLER - CUSTOM ROUTES
        */
        Route::post('list/languages', ['uses' => 'LanguagesController@all', 'as' => 'languages.ajax.list']);
        Route::get('jasonDecode', ['uses' => 'TranslationsController@jasonDecode', 'as' => 'translations.jasonDecode']);
        /*
         * Translations CONTROLLER - CUSTOM ROUTES
         */
        Route::post('list/translations', ['uses' => 'TranslationsController@all', 'as' => 'translations.ajax.list']);
        /*
         * SITE SETTINGS CONTROLLER - CUSTOM ROUTES
         */
        Route::post('list/site-settings', ['uses' => 'SiteSettingsController@all', 'as' => 'site-settings.ajax.list']);
        Route::get('site-settings/clear-route-cache/{id}', ['uses' => 'SiteSettingsController@clearRouteCache', 'as' => 'site-settings.clear-route-cache']);
        Route::get('site-settings/clear-storage-cache/{id}', ['uses' => 'SiteSettingsController@clearStorageCache', 'as' => 'site-settings.clear-storage-cache']);
        Route::get('site-settings/clear-config-cache/{id}', ['uses' => 'SiteSettingsController@clearConfigCache', 'as' => 'site-settings.clear-config-cache']);
        Route::get('site-settings/clear-view-cache/{id}', ['uses' => 'SiteSettingsController@clearViewCache', 'as' => 'site-settings.clear-view-cache']);

        Route::post('list/products', ['uses' => 'ProductsController@all', 'as' => 'products.ajax.list']);

    });

});

/*Front-End Routes*/

Route::get('/login', function () {
})->name('auth.login.show-login-form');

Route::group(['namespace' => 'Front', 'as' => 'front.'], function () {
    Route::get('/404', ['uses' => 'IndexController@error404', 'as' => '404']);
    route::get('/', ['uses' => 'IndexController@index', 'as' => 'index']);
    route::group(['as' => 'auth.'], function () {
        route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
        route::post('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'login.submit']);
        route::get('/register', ['uses' => 'Auth\RegisterController@showRegistrationForm', 'as' => 'register.form']);
        route::post('/register', ['uses' => 'Auth\RegisterController@register', 'as' => 'register']);
        route::get('/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
        route::get('/forgot-password', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'forgot-password']);
        route::post('/forgot-password', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'forgot-password.submit']);
        route::get('password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm', 'as' => 'show.reset.form']);
        route::post('password/reset', ['uses' => 'Auth\ResetPasswordController@reset', 'as' => 'password.reset.submit']);
        Route::get('/redirect/{service}', ['uses' => 'Auth\SocialLoginController@redirect', 'as' => 'login.social']);
        Route::get('/callback/{service}', ['uses' => 'Auth\SocialLoginController@callback', 'as' => 'login.social.callback']);

    });
    /*Dashboard Route*/
    route::group(['as' => 'dashboard.', 'middleware' => ['auth', 'email_verified']], function () {
        route::get('dashboard', ['uses' => 'Dashboard\IndexController@index', 'as' => 'index']);
        route::get('/edit-profile', ['uses' => 'Dashboard\IndexController@editProfile', 'as' => 'edit-profile']);
        route::get('/subscription', ['uses' => 'Dashboard\IndexController@subscriptionPage', 'as' => 'subscription']);
        route::post('/subscription', ['uses' => 'Dashboard\IndexController@subscription', 'as' => 'subscription']);
        Route::post('user/upload-image', ['uses' => 'Dashboard\IndexController@uploadImage', 'as' => 'upload-image']);
        Route::post('user/delete-image', ['uses' => 'Dashboard\IndexController@deleteImage', 'as' => 'delete-image']);
        Route::post('update-profile', ['uses' => 'Dashboard\IndexController@updateProfile', 'as' => 'update-profile']);
        route::get('favorites/{id}', ['uses' => 'Dashboard\IndexController@addFavorites', 'as' => 'add.favorites']);
        route::get('un-favorites/{id}', ['uses' => 'Dashboard\IndexController@deleteFavorites', 'as' => 'deleteFavorites.favorites']);
        route::get('favorites', ['uses' => 'Dashboard\IndexController@favorites', 'as' => 'favorites']);
        route::get('change-password', ['uses' => 'Dashboard\IndexController@changePassword', 'as' => 'change.password']);
        route::post('update-password', ['uses' => 'Dashboard\IndexController@updatePassword', 'as' => 'password.update']);
        /*Orders Routes */
        route::get('orders/{status}', ['uses' => 'Dashboard\OrderController@index', 'as' => 'order.index']);
        route::get('order-detail/{id}', ['uses' => 'Dashboard\OrderController@OrderDetail', 'as' => 'order.detail']);
//        route::get('order-cancel/{id}',['uses' => 'Dashboard\OrderController@orderCanceled','as' => 'order.cancel']);
        route::get('payment-profile', ['uses' => 'Dashboard\IndexController@paymentProfile', 'as' => 'payment.ptofile']);
        route::get('notifications', ['uses' => 'Dashboard\NotificationController@index', 'as' => 'notification.index']);

        /*user Address crud*/
        route::get('addresses', ['uses' => 'Dashboard\IndexController@addressBook', 'as' => 'address.index']);
        route::get('address/edit/{id}', ['uses' => 'Dashboard\IndexController@editAddress', 'as' => 'address.edit']);
        route::post('address/update/{id}', ['uses' => 'Dashboard\IndexController@updateAddress', 'as' => 'address.update']);
        route::get('address/delete/{id}', ['uses' => 'Dashboard\IndexController@destroyAddress', 'as' => 'address.destroy']);

    });

    route::get('/social-register', ['uses' => 'IndexController@socialRegisterform', 'as' => 'social.register.form']);

    /*Events Route*/
    route::get('/events', ['uses' => 'EventController@index', 'as' => 'events.index']);
    route::get('/event/{slug}', ['uses' => 'EventController@detail', 'as' => 'events.detail']);
    route::get('/events/{slug}', ['uses' => 'EventController@eventDirection', 'as' => 'events.direction']);

    /*Branch Routes*/
    route::get('/branches', ['uses' => 'IndexController@branches', 'as' => 'branches.index']);

    /*Services Route*/
    route::get('/services/{type?}', ['uses' => 'ServiceController@index', 'as' => 'services.index']);
    route::get('/service/{slug}', ['uses' => 'ServiceController@detail', 'as' => 'services.detail']);

    /*Services Packages Route*/
    route::get('/packages', ['uses' => 'IndexController@servicePackages', 'as' => 'packages.index']);

    /*Services Packages Route*/
    route::get('/brands', ['uses' => 'IndexController@brands', 'as' => 'brands.index']);

    /*Promotions Route*/
    route::get('/promotions', ['uses' => 'IndexController@promotions', 'as' => 'promotions.index']);
    /*Site Map*/
    Route::get('site-map', ['uses' => 'IndexController@siteMap', 'as' => 'site.map']);

    /*Repairs Route*/
    route::get('/repairs/{type?}', ['uses' => 'RepairController@index', 'as' => 'repairs.index']);
    route::get('/repair/{slug}', ['uses' => 'RepairController@detail', 'as' => 'repairs.detail']);

    route::get('/verification', ['uses' => 'IndexController@emailVerification', 'as' => 'verification']);
    route::get('/verification-resend', ['uses' => 'IndexController@emailVerificationResend', 'as' => 'verification.code.resend']);
    route::post('/verification', ['uses' => 'IndexController@emailVerificationPost', 'as' => 'verification.submit']);

    route::get('/change-currency/{currency}', ['uses' => 'IndexController@changeCurrency', 'as' => 'change-currency']);
    route::get('/pages/{slug}', ['uses' => 'IndexController@pages', 'as' => 'pages']);
    route::get('/catalogues', ['uses' => 'IndexController@catalogues', 'as' => 'catalogues']);
    route::get('/download-catalog/{path}', ['uses' => 'IndexController@getDownload', 'as' => 'catalog.download']);

//    Product routes
    route::get('products', ['uses' => 'ProductController@index', 'as' => 'product.index']);
//    route::post('products',['uses' => 'ProductController@index','as' => 'product.index' ]);
    route::get('/product/{slug}/detail', ['uses' => 'ProductController@detail', 'as' => 'product.detail']);
    route::get('/Offer/{slug}/detail', ['uses' => 'ProductController@detail', 'as' => 'offer.detail']);


    /*  Categories Routes*/
    route::get('sub-categories/{id}', ['uses' => 'CategoryController@subCategories', 'as' => 'sub-categories']);

    route::group(['middleware' => ['auth', 'email_verified']], function () {
        /* Add to cart routes*/
        route::post('add-to-cart/{product_id?}/{quantity?}/{ajax?}', ['uses' => 'CartController@add', 'as' => 'cart.add']);
        route::get('add-to-cart/{product_id?}/{quantity?}/{ajax?}', ['uses' => 'CartController@add', 'as' => 'cart.add']);
        route::get('add-to-cart/{product_id}/{quantity}/', ['uses' => 'CartController@add', 'as' => 'cart.add.ajax']);
        route::get('cart', ['uses' => 'CartController@index', 'as' => 'cart.index']);
        route::post('update-cart', ['uses' => 'CartController@updateCart', 'as' => 'cart.update']);
        route::get('delete-cart/{id}', ['uses' => 'CartController@deleteCart', 'as' => 'cart.delete']);
        route::get('valid-coupon/{code}', ['uses' => 'CartController@validCoupon', 'as' => 'cart.valid.coupon']);
        route::post('cart/select/location', ['uses' => 'CartController@selectBranch', 'as' => 'cart.select.location']);
        route::get('cart/remove/location', ['uses' => 'CartController@removeLocation', 'as' => 'cart.remove.location']);

        /*Checkout Routes*/
        route::get('check-out', ['uses' => 'CheckOutController@index', 'as' => 'checkout.index']);
        route::post('check-out', ['uses' => 'CheckOutController@index', 'as' => 'checkout.index']);
        route::post('update-address', ['uses' => 'CheckOutController@updateAddress', 'as' => 'checkout.update.address']);
        route::post('pay-pal', ['uses' => 'CheckOutController@processPayment', 'as' => 'checkout.pay.pal']);
        Route::post('payment-response', ['uses' => 'CheckOutController@paymentResponse', 'as' => 'user.checkout.payment-response']);
        Route::get('/handle-payment/success', ['uses' => 'CheckOutController@paymentResponseTelr', 'as' => 'user.checkout.payment-success']);
        Route::get('/handle-payment/cancel', ['uses' => 'CheckOutController@paymentResponseTelr', 'as' => 'user.checkout.payment-cancel']);
        Route::get('/handle-payment/declined', ['uses' => 'CheckOutController@paymentResponseTelr', 'as' => 'user.checkout.payment-declined']);
        Route::get('/create/order/url', ['uses' => 'CheckOutController@getCreateOrderUrl', 'as' => 'user.checkout.payment-declined']);





        Route::get('models/{vehicle_id}', ['uses' => 'CheckOutController@getVehicleModels', 'as' => 'user.checkout.vehicle.models']);
        Route::get('years/{model_id}', ['uses' => 'CheckOutController@getModelYears', 'as' => 'user.checkout.model.years']);
        route::get('select/location', ['uses' => 'CheckOutController@selectLocation', 'as' => 'checkout.select.location']);

    });

    Route::get('contact-us', ['uses' => 'IndexController@contactUs', 'as' => 'contactUs']);
    Route::post('contact-us', ['uses' => 'IndexController@contactEmail', 'as' => 'contactUs.email']);

    Route::get('command', function () {

        Artisan::call('clear:all');
        dd("Done");
    });
    Route::post('appointment', ['uses' => 'IndexController@appointment', 'as' => 'appointment']);
    Route::get('appointment', ['uses' => 'IndexController@appointment', 'as' => 'appointment']);
    Route::post('make/appointment', ['uses' => 'IndexController@makeAppointment', 'as' => 'make.appointment']);
    Route::post('make/appointment/index', ['uses' => 'IndexController@makeAppointmentIndexPage', 'as' => 'make.appointment.index.page']);


});

Route::get('/clear/all', function(){
    Artisan::call('clear:all');
    dd('cleared');
});

//if (app()->isDownForMaintenance()) {
//    // MAINTENANCE MODE ROUTES
//    Route::group(['prefix' => env('UNDER_MAINTENANCE_MODE_PREFIX')], $frontendRoutes);
//} else {
//    $frontendRoutes();
//}
