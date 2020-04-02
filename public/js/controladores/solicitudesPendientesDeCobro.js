var app = angular.module('Mutual').config(function ($interpolateProvider) {});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services', 'angular-loading-bar');
app.controller('solicitudesPendientesDeCobro', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM) {

    $scope.borrarFormulario = function () {
        $('#formulario2')[0].reset();

    };


    var pull = function (url, scopeObj, params) {
        moment.locale('es');
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData.map(solicitud => solicitud.updated_at = moment(solicitud.updated_at).format('L'));
            $scope.sumaTotalACobrar = returnedData.map(el => Number(el.montoACobrar)).reduce((acum, monto) => acum + monto, 0);
            $scope[params] = ServicioABM.createTable(returnedData);
        });
    };
    var pullElem = function (url, scopeObj, id) {
        ServicioABM.pull(url, id).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    };


    pull('solicitudesPendientesDeCobro/solicitudes', 'solicitudes', 'paramsSolicitud');

});