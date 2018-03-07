var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ejercicio');

app.controller('ejercicio', function ($scope, $http, $compile, $sce) {
    $scope.abrirEjercicio = function (){
        console.log($scope.fecha)
    }
    $scope.cerrarEjercicio = function () {
        console.log($scope.fecha)
    }
})