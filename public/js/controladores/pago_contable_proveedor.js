
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});

app.controller('pago_contable_proveedor', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
    $scope.bancos =[];
    $scope.proveedores = [];
    $scope.formaCobro = '';

  };


  $scope.submit = function() {
    var data;
if($scope.formaCobro == 'caja'){
   data = {
    'proveedor': $scope.proveedorSeleccionado.razon_social,
    'totalAPagar': $scope.proveedorSeleccionado.totalAPagar,
    'comision': $scope.proveedorSeleccionado.comision,
    'formaCobro': $scope.formaCobro,
    'idBanco': null,
    'codigoBanco': null
  };
}else{
   data = {
    'proveedor': $scope.proveedorSeleccionado.razon_social,
    'totalAPagar': $scope.proveedorSeleccionado.totalAPagar,
    'comision': $scope.proveedorSeleccionado.comision,
    'formaCobro': $scope.formaCobro,
    'idBanco': $scope.bancoSeleccionado.id,
    'codigoBanco': $scope.bancoSeleccionado.codigo
  };
}


    return $http({
      url: 'pagoContableProveedor/pagar',
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

  $scope.traerProveedores = function() {

    return $http({
      url: "pagoContableProveedor/proveedores",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
          $scope.proveedores = response.data;
          }


      }, function errorCallback(response) {

      });
  }

$scope.traerElementos = function (){
  $scope.traerProveedores();
  $scope.traerBancos();
}
  $scope.traerElementos();



});
