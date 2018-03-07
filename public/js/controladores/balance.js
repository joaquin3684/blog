var app = angular.module('Mutual').config(function($interpolateProvider){});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services');
app.controller('balance', function($scope, $http, $compile, $sce, $window, NgTableParams, $filter, UserSrv) {

$scope.ActualDate = moment().format('YYYY-MM-DD');


$scope.cambiarFormato = function (fecha_vencimiento){
  var fecha= moment(fecha_vencimiento, 'YYYY-MM-DD').format('DD/MM/YYYY');
  return fecha;
}

$scope.filtro = function (){
  return $http({
    data:{
      "fecha_desde": $scope.fecha_desde,
      "fecha_hasta": $scope.fecha_hasta,
    },
    url: "balance",
    method: "post",
  }).then(function successCallback(response) {
      if (typeof response.data === 'string') {
        return [];
      } else {
          console.log(response.data);

          $scope.balances = response.data;

          $scope.paramsBalances= new NgTableParams({
               page: 1,
               count: $scope.balances.length
           }, {
              counts: [],
               getData: function (params) {
                 var filterObj = params.filter();
                 filteredData = $filter('filter')($scope.balances, filterObj);
                 var sortObj = params.orderBy();
                   orderedData = $filter('orderBy')(filteredData, sortObj);
                 $scope.paramsBalances.total(orderedData.length);
                   return orderedData;
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


});
