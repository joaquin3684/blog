var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services');
app.controller('solicitudesPendientesDeCobro', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM) {

    $scope.borrarFormulario = function () {
        $('#formulario2')[0].reset();
  
    };


    var pull = function (url, scopeObj, params) {
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
            $scope[params] = ServicioABM.createTable(returnedData)
        });
    }
    var pullElem = function (url, scopeObj, id) {
        ServicioABM.pull(url, id).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }

    $scope.solicitudes = [{
        nombre: 'Lucas',
        apellido: 'Blanco',
        legajo:'1567433',
        montoACobrar: 2150
    }];
    $scope.paramsSolicitud = ServicioABM.createTable($scope.solicitudes)
   
    //pull('agente_financiero/solicitudes', 'solicitudes', 'paramsSolicitud');
});