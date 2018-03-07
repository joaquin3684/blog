
var app = angular.module('Mutual').config(function($interpolateProvider) {});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services');

app.controller('cobrar_contablemente', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
    $scope.bancos =[];
    $scope.deudores = [];
    $scope.formaCobro = '';
    $scope.tipo = ''
  };


  $scope.submit = function() {

    if($scope.formaCobro == 'caja'){
      var idBanco = '';
      var codigoBanco = '';
    }else{
      var idBanco = $scope.bancoSeleccionado.id;
      var codigoBanco = $scope.bancoSeleccionado.codigo;
    }
    if($scope.tipo == 'cuotas_sociales'){
      var idDeudor = '';
      var codigoDeudor = '';
    }else{
      var idDeudor = $scope.deudorSeleccionado.id;
      var codigoDeudor = $scope.deudorSeleccionado.codigo;
    }

    var data = {
      'idBanco': idBanco,
      'codigoBanco': codigoBanco,
      'formaCobro': $scope.formaCobro,
      'valor': $scope.importe,
      'codigoDeudor': codigoDeudor,
      'idDeudor': idDeudor,
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
      UserSrv.MostrarError(response)
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
        UserSrv.MostrarError(response)
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
        UserSrv.MostrarError(response)
      });
  }

$scope.traerElementos = function (){
  $scope.traerDeudores();
  $scope.traerBancos();
}
  $scope.traerElementos();



});
