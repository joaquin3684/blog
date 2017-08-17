var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});
app.controller('correr_vto_servicios', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {


// en view llamarla correr_vto_servicios, cuando toca correr vencimiento mostrar pop confirm, libreria moment para menejar las fechas

  $scope.traerElementos = function() {

    return $http({
      url: 'correrVto/servicios',
      method: 'get',
    }).then(function successCallback(response) {
        console.log(response.data);
        if (typeof response.data === 'string') {
          return [];
        } else {
            console.log(response.data);
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

  $scope.traerElementos();

  // $scope.traerElemento = function(id) {
  //
  //   return $http({
  //     url: 'abm_comercializador/'+ id,
  //     method: 'get',
  //     // data: data,
  //   }).then(function successCallback(response) {
  //     $scope.abmConsultado = response.data;
  //   }, function errorCallback(response) {
  //
  //   });
  // }
  //
  // $scope.editarFormulario = function (id) {
  //
  //   var data = {
  //     'nombre': $scope.abmConsultado.nombre,
  //     'apellido': $scope.abmConsultado.apellido,
  //     'dni': $scope.abmConsultado.documento,
  //     'cuit': $scope.abmConsultado.cuit,
  //     'domicilio': $scope.abmConsultado.domicilio,
  //     'telefono': $scope.abmConsultado.telefono,
  //     'usuario': $scope.abmConsultado.usuario,
  //     'email': $scope.abmConsultado.email
  //   };
  //
  //   return $http({
  //     url: 'abm_comercializador/'+ id,
  //     method: 'put',
  //     data: data,
  //   }).then(function successCallback(response) {
  //     $scope.traerElementos();
  //     console.log("Exito al editar");
  //     $('#editar').modal('toggle');
  //   }, function errorCallback(response) {
  //
  //   });
  //
  // }
  //
  // $scope.borrarElemento = function (id) {
  //
  //   return $http({
  //     url: 'abm_comercializador/'+ id,
  //     method: 'delete',
  //   }).then(function successCallback(response) {
  //     $scope.traerElementos();
  //     console.log("Exito al eliminar");
  //   }, function errorCallback(response) {
  //
  //   });
  // }


});
