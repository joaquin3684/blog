var app = angular.module('Mutual', [])
    app.config(function ($provide, $httpProvider) {

        // Intercept http calls.
        $provide.factory('MyHttpInterceptor', function ($q) {
            return {
                // On request success
                request: function (config) {
                    $('#LoadingGlobal').show(10);
                    // console.log(config); // Contains the data about the request before it is sent.

                    // Return the config or wrap it in a promise if blank.
                    return config || $q.when(config);
                },

                // On request failure
                requestError: function (rejection) {
                    // console.log(rejection); // Contains the data about the error on the request.
                   // $('#LoadingGlobal').hide(1);
                    // Return the promise rejection.
                    $('#LoadingGlobal').hide(1);
                    return $q.reject(rejection);
                },

                // On response success
                response: function (response) {
                    // console.log(response); // Contains the data from the response.
                    $('#LoadingGlobal').hide(1);
                    // Return the response or promise.
                    return response || $q.when(response);
                },

                // On response failture
                responseError: function (rejection) {
                    // console.log(rejection); // Contains the data about the error.
                    //$('#LoadingGlobal').hide(1);
                    // Return the promise rejection.
                    $('#LoadingGlobal').hide(1);
                    return $q.reject(rejection);
                }
            };
        });

        // Add the interceptor to the $httpProvider.
        $httpProvider.interceptors.push('MyHttpInterceptor');

    });