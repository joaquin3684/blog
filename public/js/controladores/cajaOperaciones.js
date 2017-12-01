var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM','Mutual.services']).config(function ($interpolateProvider) { });
app.controller('cajaOperaciones', function ($scope, $http, $compile, $sce, $window, NgTableParams, $filter, ServicioABM, UserSrv) {

    $scope.ActualDate = moment().format('YYYY-MM-DD');


    $scope.cambiarFormato = function (fecha_vencimiento) {
        var fecha = moment(fecha_vencimiento, 'YYYY-MM-DD').format('DD/MM/YYYY');
        return fecha;
    }

    
    $scope.filtro = function () {

        data = {
            'fecha_desde': $scope.fecha_desde,
            'fecha_hasta': $scope.fecha_hasta,
        };
        
        var url = 'caja/elementosFiltrados';

        ServicioABM.pullFilteredByData(url, data).then(function (returnedData) {
            $scope.cajas = returnedData;
        });
        
        $scope.params = ServicioABM.createTable($scope.cajas);
    }


});
