var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services');
app.controller('cuentaCorrienteComercializador', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM) {

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
        //pull('comercializadores/trearElementos', 'socios', 'paramsSocios');
        pull('cuentaCorrienteComercializador/ventasComer/'+idComercializador, 'socios', 'paramsSocios');
        $scope.comercializadoractual= nombreComercializador
        $scope.setVista('Socios')
    }
    $scope.PullComercializador = function (idComercializador) {
        pull('cuentaCorrienteComercializador/comercializadores', 'comercializadores', 'paramsComercializador');
        $scope.setVista('Comercializador')
    }
    $scope.PullComercializador()


});