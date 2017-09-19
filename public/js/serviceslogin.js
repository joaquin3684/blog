angular.module('Login.services', [])

.factory('myHttpInterceptor', function($q) {
  return {
    // optional method
    'request': function(config) {
      // do something on success
      var div = '#mensajito';
      $('#LoadingGlobal').show(10);
      return config;
    },
    // optional method
   'requestError': function(rejection) {
        // Muestro el mensaje de Error
        $('#LoadingGlobal').hide(1);
        var data = rejection.data;
        var div = '#mensajito';
        $('#ContenedorMensaje').html('<div id="mensajito" class="alert alert-danger" role="alert"><button type="button" onclick="$(ContenedorMensaje).hide(500); "class="close">&times;</button><strong style="font-size: 20pt;">'+data.title+'</strong></br> <font style="font-size: 15pt;">'+data.detail+'</font></div>');
        $('#ContenedorMensaje').show(500);
    },
    // optional method
    'response': function(response) {
      // do something on success
      $('#LoadingGlobal').hide(1);
      var data = response.data;
        var div = '#mensajito';
        $('#ContenedorMensaje').html('<div id="mensajito" class="alert alert-success" role="alert"><button type="button" onclick="$(ContenedorMensaje).hide(500); "class="close">&times;</button><strong style="font-size: 20pt;">'+data.title+'</strong></br> <font style="font-size: 15pt;">'+data.detail+'</font></div>');
        $('#ContenedorMensaje').show(100);
        $window.location.href = 'asociados';
      return response;
    },
    // optional method
   'responseError': function(rejection) {
        // Muestro el mensaje de Error
        $('#LoadingGlobal').hide(1);
        var data = rejection.data;
        var div = '#mensajito';
        $('#ContenedorMensaje').html('<div id="mensajito" class="alert alert-danger" role="alert"><button type="button" onclick="$(ContenedorMensaje).hide(500); "class="close">&times;</button><strong style="font-size: 20pt;">'+data.title+'</strong></br> <font style="font-size: 15pt;">'+data.detail+'</font></div>');
        $('#ContenedorMensaje').show(500);
    }
  };
})

.config(['$httpProvider', function($httpProvider) {  
    $httpProvider.interceptors.push('myHttpInterceptor');
}]);