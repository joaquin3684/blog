var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services', 'angular-loading-bar');
app.controller('cuentaCorrienteComercializador', function ($scope, $http, $compile, $sce, NgTableParams, ServicioABM) {

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

    $scope.setVista = function (pantalla){
        $scope.vistaactual = pantalla
    }
   

    $scope.PullSocios= function(idComercializador, nombreComercializador){
       // pull('cuentaCorrienteComercializador/ventasComer/'+idComercializador, 'socios', 'paramsSocios');
       moment.locale('es')
        ServicioABM.pull('cuentaCorrienteComercializador/ventasComer/' + idComercializador).then(function (returnedData) {
            $scope.socios = returnedData.map(socio => socio.updated_at = moment(socio.updated_at).format('L'))
            $scope.paramsSocios = ServicioABM.createTable(returnedData)
        });
        $scope.comercializadoractual= nombreComercializador
        $scope.setVista('Socios')
    }
    $scope.PullComercializador = function (idComercializador) {
        pull('cuentaCorrienteComercializador/comercializadores', 'comercializadores', 'paramsComercializador');
        $scope.setVista('Comercializador')
    }
    $scope.PullComercializador()


});