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

    return $http({
      url: 'abm_comercializador',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.traerElementos();
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function() {

    return $http({
      url: "abm_comercializador/comercializadores",
      method: "get",
    }).then(function successCallback(response) {
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

  $scope.traerElemento = function(id) {

    return $http({
      url: 'abm_comercializador/'+ id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      $scope.abmConsultado = response.data;
    }, function errorCallback(response) {

    });
  }

  $scope.editarFormulario = function (id) {

    var data = {
      'nombre': $scope.abmConsultado.nombre,
      'apellido': $scope.abmConsultado.apellido,
      'dni': $scope.abmConsultado.documento,
      'cuit': $scope.abmConsultado.cuit,
      'domicilio': $scope.abmConsultado.domicilio,
      'telefono': $scope.abmConsultado.telefono,
      'usuario': $scope.abmConsultado.usuario,
      'email': $scope.abmConsultado.email
    };

    return $http({
      url: 'abm_comercializador/'+ id,
      method: 'put',
      data: data,
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al editar");
      $('#editar').modal('toggle');
    }, function errorCallback(response) {

    });

  }

  $scope.borrarElemento = function (id) {

    return $http({
      url: 'abm_comercializador/'+ id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al eliminar");
    }, function errorCallback(response) {

    });
  }


});
