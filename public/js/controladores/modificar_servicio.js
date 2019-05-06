var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('modificarServicio', function ($scope, NgTableParams, $filter, $http, UserSrv) {

    $scope.servicioSelec = { importe_otorgado: 0 }
    $scope.ActualDate = moment().format('YYYY-MM-DD');
    $scope.traerServicios = function () {

        return $http({
            url: "ventas/all",
            method: "get",
        }).then((response) => {
            console.log(response.data)
            $scope.servicios = response.data;

            $scope.paramsServicios = new NgTableParams({
                page: 1,
                count: 10
            }, {
                    getData: function (params) {
                        var filterObj = params.filter();
                        filteredData = $filter('filter')($scope.servicios, filterObj);
                        var sortObj = params.orderBy();
                        orderedData = $filter('orderBy')(filteredData, sortObj)
                        return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
        }, (error) => {
            UserSrv.MostrarError(error)
        });
    }

    $scope.seleccionarServicio = (servicio) => {
        $scope.servicioSelec = { ...servicio }
        console.log($scope.servicioSelec)
    }

    $scope.editarServicio = () => {
        const servicio = $scope.servicioSelec
        const servicioModificar = {
            descripcion: servicio.descripcion,
            fecha_vencimiento: servicio.fecha_vencimiento,
            id_asociado: servicio.id_asociado,
            id_producto: servicio.id_producto,
            importe_cuota: servicio.importe_cuota,
            importe_otorgado: servicio.importe_otorgado,
            importe_total: servicio.importe_total,
            nro_cuotas: servicio.nro_cuotas,
            id: servicio.id
        }

        return $http({
            url: 'ventas/modificar',
            method: 'post',
            data: servicioModificar,
        }).then((response) => {
            $scope.traerServicios();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
        }, (response) => {
            UserSrv.MostrarError(response)
        });
    }

    $scope.traerServicios();
});
