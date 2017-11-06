
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});

app.controller('fechaContable', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm



  $scope.submit = function(fechaContable) {

    var data = {
      'fecha': fechaContable,
    };

    return $http({
      url: 'fechaContable',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
    }, function errorCallback(response) {
      console.log("Error")
    });

  }



});