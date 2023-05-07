
var app = angular.module("app", [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{!');
    $interpolateProvider.endSymbol('!}');
});

// app.service('SocketService', ['socketFactory','$window' , function SocketService(socketFactory, $window) {
//     return socketFactory({
//         ioSocket: io.connect('http://myliife.com', {
//             query: { token: $window.Laravel.jwtToken},
// 			//path: '/socket.io',
// 			transports: ['websocket', 'polling']
//         })
//     });
// }]);


app.factory('beforeUnload', function ($rootScope, $window) {
        // Events are broadcast outside the Scope Lifecycle

        $window.onbeforeunload = function (e) {
            var confirmation = {};
            var event = $rootScope.$broadcast('onBeforeUnload', confirmation);
            if (event.defaultPrevented) {
                return confirmation.message;
            }
        };

        $window.onunload = function () {
            $rootScope.$broadcast('onUnload');
        };
        return {};
    })
    .run(function (beforeUnload) {
        // Must invoke the service at least once
    });
	

app.directive('scrollToItem', function() {                                                      
    return {                                                                                 
        restrict: 'A',                                                                       
        scope: {                                                                             
            scrollTo: "@"                                                                    
        },                                                                                   
        link: function(scope, $elm,attr) {                                                   

            $elm.on('click', function() {                                                    
                $('html,body').animate({scrollTop: $(scope.scrollTo).offset().top }, "slow");
            });                                                                              
        }                                                                                    
    }});     




app.directive('ngOnEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngOnEnter);
                });

                event.preventDefault();
            }
        });
    };
});


//============================ Angular http Loading request event ==================
var interceptor = function ($q, $location, $rootScope, $timeout) {
    var req_count = 0;
    return {
        request: function (config) {
            var action = config.url.split('/').pop();
            if (action=='unread-conversations' || action=='pending-requests' || action=='unread-notification-count') {
                return config;
            }
            $("#ajaxLoader").css('display', 'block');
            $timeout(function () {
                $rootScope.ngLoading = "loading";
            }, 100);
            return config;
        },

        response: function (result) {
            var action = result.config.url.split('/').pop();
            if (action=='unread-conversations' || action=='pending-requests' || action=='unread-notification-count') {
                return result;
            }
            $("#ajaxLoader").css('display', 'none');
            $timeout(function () {
                $rootScope.ngLoading = "loaded";
            }, 100);
            return result;
        },

        responseError: function (rejection) {
            $("#ajaxLoader").css('display', 'none');
            $timeout(function () {
                $rootScope.ngLoading = "loaded";
            }, 100);
            return $q.reject(rejection);
        }
    };
};

app.config(function ($httpProvider) {
    $httpProvider.interceptors.push(interceptor);
});

//============================Angular http loading end===================

//---------------Custom Directive to upload file


app.directive('fileModels', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;
                element.bind('change', function () {
                    scope.$apply(function () {
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    }]);

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var isMultiple = attrs.multiple;
            var modelSetter = model.assign;
            element.bind('change', function () {
                var values = [];
                angular.forEach(element[0].files, function (item) {
                    item.url = URL.createObjectURL(item);
                    item.file_type = item.type.split('/')[0];
                    values.push(item);
                });
                scope.$apply(function () {
                    if (isMultiple) {
                        modelSetter(scope, values);
                    } else {
                        modelSetter(scope, values[0]);
                    }
                });
            });
        }
    };
}]);
//--------------------------------------------------




