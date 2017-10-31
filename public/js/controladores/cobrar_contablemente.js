
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});

app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
    $scope.bancos =[];
    $scope.deudores = [];
    $scope.formaCobro = '';
    $scope.tipo = ''
  };


  $scope.submit = function() {

    var data = {
      'idBanco': $scope.bancoSeleccionado,
      'formaCobro': $scope.formaCobro,
      'valor': $scope.importe,
      'codigoDeudor': $scope.deudorSeleccionado.codigo,
      'idDeudor': $scope.deudorSeleccionado.id,
      'tipo': $scope.tipo
    };

    return $http({
      url: 'cobrar_contablemente/cobrar',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
        $scope.borrarFormulario();
      $scope.traerElementos();
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerBancos = function() {

    return $http({
      url: "cobrar_contablemente/traerBancos",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
          $scope.bancos = response.data;
          }


      }, function errorCallback(response) {

      });
  }

  $scope.traerDeudores = function() {

    return $http({
      url: "cobrar_contablemente/traerProveedores",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
          $scope.deudores = response.data;
          }


      }, function errorCallback(response) {

      });
  }

$scope.traerElementos = function (){
  $scope.traerDeudores();
  $scope.traerBancos();
}
  $scope.traerElementos();



});
