var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});
app.controller('ABM_comercializador', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.submitComerc = function() {

    var data = {
      'nombre': $scope.nombreComerc,
      'apellido': $scope.apellidoComerc,
    'dni': $scope.documentoComerc,
      'cuit': $scope.cuitComerc,
      'domicilio': $scope.domicilioComerc,
      'telefono': $scope.telefonoComerc,
      'usuario': $scope.usuarioComerc,
      'password': $scope.contraseniaComerc,
      'email': $scope.emailComerc
    };
    console.log(data);
    return $http({
      url: 'abm_comercializador',
      method: 'post',
      data: {
        'nombre': $scope.nombreComerc,
        'apellido': $scope.apellidoComerc,
      'dni': $scope.documentoComerc,
        'cuit': $scope.cuitComerc,
        'domicilio': $scope.domicilioComerc,
        'telefono': $scope.telefonoComerc,
        'usuario': $scope.usuarioComerc,
        'password': $scope.contraseniaComerc,
        'email': $scope.emailComerc
      },

    }).then(function successCallback(response) {
      $scope.traerElementos();
    }, function errorCallback(response) {

    });
    console.log("Marta")

  }

  $scope.traerElementos = function() {

    return $http({
      url: "abm_comercializador/comercializadores",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
          console.log(response);
          $scope.datosabm = response.data;
          $scope.paramsABMS = new NgTableParams({
            page: 1,
            count: 10
          }, {
            total: $scope.datosabm.length,
            getData: function(params) {
              $scope.datosabm = $filter('orderBy')($scope.datosabm, params.orderBy());
              return $scope.datosabm.slice((params.page() - 1) * params.count(), params.page() * params.count());
            }
          });
        }


}, function errorCallback(response) {

});
}

  $scope.traerElemento = function() {
    console.log("algo");
  }

});
