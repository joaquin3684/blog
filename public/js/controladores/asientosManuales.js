
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});

app.controller('asientosManuales', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
    $scope.asientos = [{
      'id_imputacion': null,
      'debe': null,
      'haber': null,
    }]
  };

$scope.fecha = new Date();

  $scope.submit = function() {

    var fechaFormateada = moment($scope.fecha).format("YYYY-MM-DD");
    var data = {
      'asientos': $scope.asientos,
      'fecha_valor': fechaFormateada
    };

    return $http({
      url: 'asientos',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.borrarFormulario();

      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
      $scope.traerElementos();
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function() {

    return $http({
      url: "imputacion/traerElementos",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
            console.log(response.data);
            $scope.idDisponibles = response.data;
          }


      }, function errorCallback(response) {

      });
  }

  $scope.traerElementos();

$scope.sumarTotales = function (){
  $scope.sumaDebe = 0;
  $scope.sumaHaber = 0;
  $scope.asientos.forEach(function(entry) {
    $scope.sumaDebe += entry.debe;
    $scope.sumaHaber += entry.haber;
  });
};
$scope.verificarIgualdad = function(){

  if($scope.sumaHaber == $scope.sumaDebe){
    $scope.submit();
  }
  else{
    UserSrv.MostrarMensaje("Error","La suma de los haber debe ser igual a la de los deber","Error","mensaje");
  }
};


  $scope.asientos = [{
    'id_imputacion': null,
    'debe': null,
    'haber': null,
  }]
  var cantComponentes = 1
    $scope.agregarHtml = function(destino) {

      destino.push({
        'id_imputacion': null,
        'debe': null,
        'haber': null,
      })

  }

  $scope.eliminarHtml = function (clon, array, indice){

    if(array.length >1){
      $(clon).remove();
      array.splice(indice, 1);

    }
};


});
