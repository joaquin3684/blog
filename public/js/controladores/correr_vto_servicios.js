var app = angular.module('Mutual').config(function($interpolateProvider) {});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services');
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
              getData: function(params) {
                $scope.datosabm = $filter('orderBy')($scope.datosabm, params.orderBy());
                $scope.paramsABMS.total($scope.datosabm.length);
                return $scope.datosabm.slice((params.page() - 1) * params.count(), params.page() * params.count());
              }
            });
          }


      }, function errorCallback(response) {
        UserSrv.MostrarError(response)
      });
  }

  $scope.traerElementos();

 $scope.confirmarCambios = function (fecha_vencimiento, cantDias, id){
   cantDias = Number(cantDias);
   console.log(fecha_vencimiento);
   moment.locale('es');
   var fecha= moment(fecha_vencimiento, 'YYYY-MM-DD').add(cantDias, 'days');

   var fechaActual = moment();
   if(fechaActual.isAfter(fecha, 'day')){
     cantDias = fechaActual.diff(fecha.subtract(cantDias, 'days'), 'days');
     fecha = fechaActual;
   }
   if(confirm("La fecha de vencimiendo se cambiara al "+ fecha.format('L'))){
     $scope.actualizarFecha(cantDias, id)
   }
 }


  $scope.actualizarFecha = function(cantDias, id) {

    var data = {
    'dias': cantDias,
    'id': id,
    };

    return $http({
      url: 'correrVto/correrServicio',
      method: 'post',
      data: data,
    }).then(function successCallback(response) {
      $scope.traerElementos();
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
  }

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
