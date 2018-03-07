var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services');
app.controller('solicitudesPendientesDeCobro', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM) {

    $scope.borrarFormulario = function () {
        $('#formulario2')[0].reset();
  
    };


    var pull = function (url, scopeObj, params) {
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
            $scope.sumaTotalACobrar = $scope.solicitudes.map(el => el.montoACobrar).reduce((acum, monto) => acum + monto)
            $scope[params] = ServicioABM.createTable(returnedData)
        });
    }
    var pullElem = function (url, scopeObj, id) {
        ServicioABM.pull(url, id).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }

    
    pull('solicitudesPendientesDeCobro/solicitudes', 'solicitudes', 'paramsSolicitud');
    
});