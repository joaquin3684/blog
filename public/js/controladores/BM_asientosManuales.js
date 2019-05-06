
var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');

app.controller('BMasientosManuales', function ($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

    // manda las solicitud http necesarias para manejar los requerimientos de un abm

    $scope.nroAsiento = null
    $scope.asiento = { fecha_valor: null, registros: [], fecha_valor: null, observacion: null, nro_asiento: null }
    $scope.fechaActual = moment().format("YYYY-MM-DD");

    $scope.buscar = function () {
        return $http({
            url: `asientos/${$scope.nroAsiento}`,
            method: 'get',

        }).then((response) => {
            console.log(response)
            const { nro_asiento, fecha_valor, observacion } = response.data[0]
            $scope.asiento = {
                nro_asiento,
                fecha_valor,
                observacion,
                registros: response.data.map(({ id_imputacion, debe, codigo, haber }) => ({
                    id_imputacion,
                    debe: debe === 0 ? null : debe,
                    codigo,
                    haber: haber === 0 ? null : haber
                }

                ))
            }
        }, function errorCallback(response) {
            UserSrv.MostrarError(response)
        });
    }

    $scope.editar = function () {
        if ($scope.sumaHaber != $scope.sumaDebe) {
            UserSrv.MostrarMensaje("Error", "La suma de los haber debe ser igual a la de los debe", "Error", "mensaje");
            return
        }
        var data = {
            asientos: $scope.asiento.registros.map(r => ({
                cuenta: $scope.cuentas.find(c => c.id === r.id_imputacion).codigo,
                ...r
            })),
            fecha_valor: moment($scope.asiento.fecha).format("YYYY-MM-DD"),
            observacion: $scope.asiento.observacion,
            nro_asiento: $scope.asiento.nro_asiento
        };

        return $http({
            url: 'asientos/editar',
            method: 'post',
            data: data,

        }).then(function successCallback(response) {
            $scope.borrarFormulario();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
        }, function errorCallback(response) {
            UserSrv.MostrarError(response)
        });
    }

    $scope.borrar = () => {
        return $http({
            url: 'asientos/borrar',
            method: 'post',
            data: { nro_asiento: $scope.nroAsiento },
        }).then(function successCallback(response) {
            $scope.borrarFormulario();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
        }, function errorCallback(response) {
            UserSrv.MostrarError(response)
        });
    }

    $scope.reenumerar = () => {
        return $http({
            url: 'asientos/renumerar',
            method: 'post',
            data: { fecha: moment($scope.fechaReenumeracion).format("YYYY-MM-DD") },
        }).then(function successCallback(response) {
            $scope.borrarFormulario();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
        }, function errorCallback(response) {
            UserSrv.MostrarError(response)
        });
    }

    $scope.borrarFormulario = function () {
        $scope.asiento = { fecha_valor: null, registros: [], fecha_valor: null, observacion: null, nro_asiento: null }
    };


    $scope.traerCuentas = function () {
        return $http({
            url: "imputacion/traerElementos",
            method: "get",
        }).then(function successCallback(response) {
            if (typeof response.data === 'string') {
                return [];
            } else {
                console.log(response.data);
                $scope.cuentas = response.data;
            }
        }, function errorCallback(response) {
            UserSrv.MostrarError(response)
        });
    }

    $scope.traerCuentas();

    $scope.sumarTotales = function () {
        $scope.sumaDebe = 0;
        $scope.sumaHaber = 0;
        $scope.asiento.registros.forEach((entry) => {
            $scope.sumaDebe += entry.debe;
            $scope.sumaHaber += entry.haber;
        });
    };


    $scope.agregarAsiento = function () {
        $scope.asiento.registros.push({
            'id_imputacion': null,
            'debe': null,
            'haber': null,
        })
    }
    $scope.eliminarAsiento = (i) => {
        $scope.asiento.registros = $scope.asiento.registros.filter((_, index) => index !== i)
    }

});
