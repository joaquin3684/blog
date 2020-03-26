var app = angular.module('Mutual').config(function ($interpolateProvider) {
});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'verificarBaja', 'angular-loading-bar');
app.controller('ABM_comercializador', function ($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

    // manda las solicitud http necesarias para manejar los requerimientos de un abm

    $scope.borrarFormulario = function () {
        $('#formulario')[0].reset();
    };

    $scope.submitComerc = function () {

        var data = {
            'nombre': $scope.nombreComerc,
            'apellido': $scope.apellidoComerc,
            'dni': $scope.documentoComerc,
            'cuit': $scope.cuitComerc,
            'domicilio': $scope.domicilioComerc,
            'provincia': $scope.provinciaComerc,
            'telefono': $scope.telefonoComerc,
            'password': $scope.contraseniaComerc,
            'email': $scope.emailComerc,
            'estado_civil': $scope.estadoCivilComerc,
            'porcentaje_colocacion': $scope.porcentaje_colocacionComerc

        };

        return $http({
            url: 'abm_comercializador',
            method: 'post',
            data: data,

        }).then(function successCallback(response) {
            $scope.traerElementos();
            $scope.borrarFormulario();
            $scope.errores = {};
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
        }, function errorCallback(response) {
            UserSrv.MostrarError(response);
            $scope.errores = response.data;
        });

    };


    $scope.traerElementos = function () {

        return $http({
            url: "abm_comercializador/comercializadores",
            method: "get",
        }).then(function successCallback(response) {
            if (typeof response.data === 'string') {
                return [];
            } else {
                console.log(response.data);
                $scope.datosabm = response.data;
                $scope.paramsABMS = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    getData: function (params) {
                        var filterObj = params.filter();
                        filteredData = $filter('filter')($scope.datosabm, filterObj);
                        var sortObj = params.orderBy();
                        orderedData = $filter('orderBy')(filteredData, sortObj);
                        $scope.paramsABMS.total(orderedData.length);
                        return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    },

                });

            }


        }, function errorCallback(response) {
            UserSrv.MostrarError(response);
        });
    };

    $scope.traerElementos();

    $scope.traerElemento = function (id) {

        return $http({
            url: 'abm_comercializador/' + id,
            method: 'get',
            // data: data,
        }).then(function successCallback(response) {
            $scope.errores = {};
            $scope.abmConsultado = response.data;
        }, function errorCallback(response) {
            UserSrv.MostrarError(response);
        });
    };

    $scope.editarFormulario = function (id) {

        var data = {
            'nombre': $scope.abmConsultado.nombre,
            'apellido': $scope.abmConsultado.apellido,
            'dni': $scope.abmConsultado.dni,
            'cuit': $scope.abmConsultado.cuit,
            'domicilio': $scope.abmConsultado.domicilio,
            'telefono': $scope.abmConsultado.telefono,
            'provincia': $scope.abmConsultado.provincia,
            'estado_civil': $scope.abmConsultado.estado_civil,
            'porcentaje_colocacion': $scope.abmConsultado.porcentaje_colocacion
        };

        return $http({
            url: 'abm_comercializador/' + id,
            method: 'put',
            data: data,
        }).then(function successCallback(response) {
            $scope.traerElementos();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
            console.log("Exito al editar");
            $scope.errores = {};
            $('#editar').modal('toggle');
        }, function errorCallback(response) {
            $scope.errores = response.data;
            UserSrv.MostrarError(response);
        });

    };

    $scope.guardarDatosBaja = function () {
        $scope.elemABorrar = this.abm;
    };
    $scope.delete = function (id) {
        $scope.borrarElemento(id);
    };
    $scope.borrarElemento = function (id) {

        return $http({
            url: 'abm_comercializador/' + id,
            method: 'delete',
        }).then(function successCallback(response) {
            $scope.traerElementos();
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
            console.log("Exito al eliminar");
        }, function errorCallback(response) {
            UserSrv.MostrarError(response);
        });
    };


});
