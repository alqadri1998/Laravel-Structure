'use strict';
app.service('$common', function ($http, $window) {

    var headers = {}, sidebar, timer;
    headers.authorization = 'Bearer ' + $window.Laravel.jwtToken;
    headers.accept = 'application/json';
    /*
     * LOGIN SERVICES
     */
    this.login = function (data) {
        return $http.post($window.Laravel.baseUrl + 'login', data);
    };

    this.uploadImage = function (data) {
        return $http.post($window.Laravel.baseUrl + 'upload-image', data, {"Content-Type": "application/x-www-form-urlencoded"});
    };

    this.categories = function () {
        return $http.get($window.Laravel.apiUrl + 'categories');
    };

    this.brands = function () {
        return $http.get($window.Laravel.apiUrl + 'brands');
    };

    this.origin = function () {
        return $http.get($window.Laravel.apiUrl + 'origin');
    };

    this.promotions = function () {
        return $http.get($window.Laravel.apiUrl + 'promotions');
    };

    this.saveProduct = function (data) {
        return $http.post($window.Laravel.apiUrl + 'save-product', data);
    };

    this.editProduct = function (data) {
        return $http.post($window.Laravel.apiUrl + 'edit-product', data);
    };


});
