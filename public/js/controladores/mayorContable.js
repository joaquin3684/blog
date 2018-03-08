var app = angular.module('Mutual').config(function($interpolateProvider){});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('mayorContable', function($scope, $http, $compile, $sce, $window, NgTableParams, $filter, UserSrv) {

$scope.ActualDate = moment().format('YYYY-MM-DD');


$scope.traerImputaciones = function() {

  return $http({
    url: "imputacion/traerElementos",
    method: "get",
  }).then(function successCallback(response) {
      if (typeof response.data === 'string') {
        return [];
      } else {
          console.log(response.data);
          $scope.imputaciones = response.data;

        }


    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
}

$scope.cambiarFormato = function (fecha_vencimiento){
  var fecha= moment(fecha_vencimiento, 'YYYY-MM-DD').format('DD/MM/YYYY');
  return fecha;
}

$scope.filtro = function (){
  return $http({
    data:{
      "fecha_desde": $scope.fecha_desde,
      "fecha_hasta": $scope.fecha_hasta,
      "codigo_desde": $scope.codigo_desde,
      "codigo_hasta": $scope.codigo_hasta
    },
    url: "mayorContable",
    method: "post",
  }).then(function successCallback(response) {
      if (typeof response.data === 'string') {
        return [];
      } else {
          console.log(response.data);
          $scope.reporteMayorContable = [];

          response.data.forEach(function(entry) {
            var totalDebe = 0;
            var totalHaber = 0;
            var totalSaldo = 0;
            var arr = $.map(entry.asientos, function(el) { return el });

            arr.forEach(function(asiento) {
                totalDebe += asiento.debe;
                totalHaber += asiento.haber;
            });
            totalSaldo = entry.saldo+ totalDebe - totalHaber;
            $scope.reporteMayorContable.push({
              'codigo': entry.codigo,
              'saldo': entry.saldo,
              'nombre': entry.nombre,
              'asientos': arr,
              'totalDebe': totalDebe.toFixed(2),
              'totalHaber': totalHaber.toFixed(2),
              'totalSaldo': totalSaldo.toFixed(2)
            });

          });

          $scope.paramsReporte= new NgTableParams({
               page: 1,
               count: 10
           }, {
               getData: function (params) {
                 var filterObj = params.filter();
                 filteredData = $filter('filter')($scope.reporteMayorContable, filterObj);
                 var sortObj = params.orderBy();
                   orderedData = $filter('orderBy')(filteredData, sortObj);
                 $scope.paramsReporte.total(orderedData.length);
                   return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
               }
           });
        }


    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
}

$scope.propertyName = 'fechaContable';
$scope.reverse = true;
$scope.sortBy = function(propertyName) {
    $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
    $scope.propertyName = propertyName;
  };

$scope.traerImputaciones();
});
