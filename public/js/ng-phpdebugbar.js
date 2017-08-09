.factory('httpInterceptor', function($q) {

        var handle_phpdebugbar_response = function(response) {
             if (phpdebugbar && phpdebugbar.ajaxHandler) {

         var headers = response && response.headers && response.headers();
                if (!headers) {
                     return;
                 }

        var headerName = phpdebugbar.ajaxHandler.headerName + '-id';
               var debugBarID = headers[headerName];
               if (debugBarID) {                           
                     phpdebugbar.loadDataSet(debugBarID, ('ajax'));
                 }
             }
       };

            return {
                request: function(config) {

                    return config || $q.when(config);

                },
                response: function(response) {

                    if (response || $q.when(response)) {

                        handle_phpdebugbar_response(response);
                        return response || $q.when(response);
                    }


                },
                responseError: function(response) {

                    handle_phpdebugbar_response(rejection);
                    return $q.reject(response);
                }
            };
        })

     .config(function($httpProvider) {

            $httpProvider.interceptors.push('httpInterceptor');

     })
