var app = angular.module('Mutual').config(function ($interpolateProvider) { });
import { generarTabla } from './tabla';
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('modificarServicio', function ($scope, $http, $compile, $sce, $window, NgTableParams, $filter, UserSrv) {

    $scope.ActualDate = moment().format('YYYY-MM-DD');


    $scope.traerServicios = function () {

        return $http({
            url: "ventas/all",
            method: "get",
        }).then((response) => {
            console.log(response.data)
            $scope.servicios = response.data;
            $scope.paramsServicios = generarTabla($scope.servicios)
        }, (error) => {
            UserSrv.MostrarError(error)
        });
    }

    $scope.traerServicios();
});
