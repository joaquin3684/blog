var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'ServicioABM', 'angular-loading-bar');
app.controller('cajaOperaciones', function ($scope, $http, $compile, $sce, $window, NgTableParams, $filter, ServicioABM, UserSrv) {

    $scope.ActualDate = moment().format('YYYY-MM-DD');

    $scope.totales = [];
    $scope.calcularTotales = function(caja){
        var totalEntrada = 0;
        var totalSalida =0 ; 
        caja.forEach(element => {
            totalEntrada += element.entrada;  
            totalSalida += element.salida;  
        });
        $scope.totales.push({
            'entrada': totalEntrada.toFixed(2),
            'salida': totalSalida.toFixed(2)
        })
    }

    $scope.cambiarFormato = function (fecha_vencimiento) {
        var fecha = moment(fecha_vencimiento, 'YYYY-MM-DD').format('DD/MM/YYYY');
        return fecha;
    }

    
    $scope.filtro = function () {

        if($scope.tipoFiltro == 'caja'){
            data = {
                'banco': 0,
                'caja': 1,
                'fecha_desde': $scope.fecha_desde,
                'fecha_hasta': $scope.fecha_hasta,
            };

        }else{
            data = {
                'banco': 1,
                'caja': 0,
                'fecha_desde': $scope.fecha_desde,
                'fecha_hasta': $scope.fecha_hasta,
            };
        }
        
        var url = 'caja/elementosFiltrados';
        var fechas = [];
        ServicioABM.pullFilteredByData(url, data).then(function (returnedData) {
            /*$scope.cajas = [];
            returnedData.forEach(element => {
                fechas.push({'fecha':element.fecha});
                $scope.cajas.push(element.cajaOperacion)
                });
            console.log('cajas ', $scope.cajas);*/
            $scope.paramsCaja = ServicioABM.createTable(returnedData)
        });     
    }

    $scope.propertyName = 'nombre';
    $scope.reverse = true;
    $scope.sortBy = function (propertyName) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };
});
