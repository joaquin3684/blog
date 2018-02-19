var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'ServicioABM', 'verificarBaja']).config(function($interpolateProvider) {});
app.controller('ABM_operaciones', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv, ServicioABM) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm
  $scope.query = function (searchText, url, scopeObj) {
    var data = {
      'nombre': searchText
    }
    return ServicioABM.pullFilteredByData(url, data)
  }

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
    $scope.cuenta1Debe = 0;
    $scope.cuenta1Haber =0
  };
  $scope.modificar = function (elem){
    $scope[elem] = 0;
  }
  $scope.modificar2 = function (elem, elem2) {
    $scope[elem][elem2] = 0;
  }
  $scope.cuenta1Debe = 0;
  $scope.cuenta1Haber = 0;
  $scope.entrada = 0;
  $scope.salida = 0;
  $scope.cuenta1Seleccionada = '';
  $scope.cuenta2Seleccionada = '';

  $scope.submit = function() {
    var data = {
      'nombre': $scope.nombre,
      'imputacion1': $scope.cuenta1Seleccionada.id,
      'imputacion2': $scope.cuenta2Seleccionada.id,
      'debe1': $scope.cuenta1Debe,
      'haber1': $scope.cuenta1Haber,
      'debe2': $scope.cuenta1Haber,
      'haber2': $scope.cuenta1Debe,
      'entrada': $scope.entrada,
      'salida': $scope.salida
    };

    return $http({
      url: 'operaciones',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.traerElementos();
      $scope.borrarFormulario();
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  traerImputaciones = function (){
    return $http({
      url: "imputacion/traerElementos",
      method: "get",
    }).then(function successCallback(response) {
      
        console.log(response.data);
        $scope.cuentas = response.data;
    }, function errorCallback(response) {

    });
  }
  $scope.traerElementos = function() {

    return $http({
      url: "operaciones/traerElementos",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
            console.log(response.data);
            $scope.datosabm = [];
            response.data.forEach(operacion => {
              if(operacion.entrada == 1){
                var tipo = 'Ingreso'
              }else{
                var tipo = 'Egreso'
              }
              $scope.datosabm.push({
                'nombre': operacion.nombre,
                'id': operacion.id,
                'tipo': tipo
              })
            });
            $scope.paramsABMS = new NgTableParams({
              page: 1,
              count: 10
            }, {
              getData: function(params) {
                var filterObj = params.filter();
                filteredData = $filter('filter')($scope.datosabm, filterObj);
                var sortObj = params.orderBy();
                orderedData = $filter('orderBy')(filteredData, sortObj);
                $scope.paramsABMS.total(orderedData.length);
                return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
              },
                
            });
         
          }


      }, function errorCallback(response) {

      });
  }

  $scope.traerElementos();
  traerImputaciones();
  $scope.traerElemento = function(id) {
    return $http({
      url: 'operaciones/'+ id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      
      $scope.abmConsultado = {
        'id': response.data.id,
        'nombre': response.data.nombre,
        'imputacion1': response.data.imputaciones[0].id,
        'imputacion2': response.data.imputaciones[1].id,
        'debe1': response.data.imputaciones[0].pivot.debe,
        'haber1': response.data.imputaciones[0].pivot.haber,
        'debe2': response.data.imputaciones[1].pivot.debe,
        'haber2': response.data.imputaciones[1].pivot.haber,
        'entrada': response.data.entrada,
        'salida': response.data.salida
      };
    }, function errorCallback(response) {

    });
  }

  $scope.editarFormulario = function (id) {
    $scope.abmConsultado.debe2 = $scope.abmConsultado.haber1;
    $scope.abmConsultado.haber2 = $scope.abmConsultado.debe1;
    return $http({
      url: 'operaciones/'+ id,
      method: 'put',
      
      data: $scope.abmConsultado,
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al editar");
      $('#editar').modal('toggle');
    }, function errorCallback(response) {

    });

  }

  $scope.delete = function (id){
    $scope.borrarElemento(id)
  }
  $scope.borrarElemento = function (id) {

    return $http({
      url: 'operaciones/'+ id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al eliminar");
    }, function errorCallback(response) {

    });
  }


});
