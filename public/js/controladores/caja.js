var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services']).config(function ($interpolateProvider) { });
app.controller('caja', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM, UserSrv) {

    $scope.fecha = new Date();
    //moment().format('YYYY-MM-DD');

    $scope.query = function (searchText, url, scopeObj) {
        var data = {
            'nombre': serchText
        }
        ServicioABM.pullFilteredByData(url, data).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }

    $scope.borrarFormulario = function () {
        $('#formulario')[0].reset();
        $scope.operacionSeleccionada = '';
    };
    $scope.create = function () {
        var data = {
            'id_operacion': $scope.operacionSeleccionada,
            'valor': $scope.valor
        }
        var url = 'caja';
        ServicioABM.create(data, url);
        $scope.borrarFormulario();
    }
    var pull = function (url, scopeObj) {
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }
    pull('operaciones/traerElementos','operaciones');
    pull('bancos/traerElementos', 'bancos');
});