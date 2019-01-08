var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('ABMImputaciones', function ($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

    // manda las solicitud http necesarias para manejar los requerimientos de un abm

    $scope.borrarFormulario = function () {
        $('#formulario')[0].reset();
    };

    $scope.cantMaxima = function () {
        if ($scope.pantallaActual == 'rubro' || $scope.pantallaActual == 'capitulo' || $scope.pantallaActual == 'moneda') {
            return 1;
        }
        return 2;
    }
    $scope.enviarFormulario = function (abm, tipoSolicitud, id = '') {
        var form = '';
        var formu = abm + 'form';
        console.log('el id es: ' + id);
        switch (tipoSolicitud) {
            case 'Editar':
                var metodo = 'put';
                var form = $("#formularioEditar").serializeArray();
                console.log('formulario', form)
                var id = $('input[name=id]').val();
                break;
            case 'Alta':
                var metodo = 'post';
                var form = $("#" + formu).serializeArray();
                break;
            case 'Borrar':
                var metodo = 'delete';
                break;
            case 'Mostrar':
                var metodo = 'get';
                break;
            default:
                console.log("el tipo de solicitud no existe");
                break;
        }

        var url = id == '' ? abm : abm + '/' + id;
        console.log(url);
        $http({
            url: url,
            method: metodo,
            data: $.param(form),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function successCallback(response) {
            if (tipoSolicitud == 'Mostrar') {
                console.log(response);
                llenarFormulario('formularioEditar', response.data);
                $scope.abm_consultado = response.data
            }
            $scope.mensaje = response;
            $('#' + formu)[0].reset();
            if (tipoSolicitud != 'Mostrar') {
                UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
                $('#editar').modal('hide');
                $('#editar_' + $scope.pantallaActual).modal('hide');
            }
            $scope.errores = '';
            console.log(response.data);
            $scope.traerElementos($scope.pantallaActual);
        }, function errorCallback(data) {
            UserSrv.MostrarError(data)
            console.log(data);
            $scope.errores = data.data;
        });

    }



    $scope.editar = () => {
        let { id, codigo, prefijo, nombre, id_subrubro } = $scope.abm_consultado
        $http({
            url: 'imputacion/' + id,
            method: 'put',
            data: $.param({ nombre, id_subrubro, id, codigo: prefijo + codigo }),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function successCallback(response) {
            UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
            $scope.traerElementos($scope.pantallaActual);
        }, function errorCallback(data) {
            UserSrv.MostrarError(data)
            $scope.errores = data.data;
        });
    };
    $scope.generarTabla = function (url, tipoSelect) {

        $http({
            url: url,
            method: 'get'
        }).then(function successCallback(response) {
            if (typeof response.data === 'string') {
                return [];
            }
            else {
                $scope.selectimputaciones = response.data;

                $scope.paramsABMS = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                        getData: function (params) {
                            var filterObj = params.filter();
                            filteredData = $filter('filter')(response.data, filterObj);
                            var sortObj = params.orderBy();
                            orderedData = $filter('orderBy')(filteredData, sortObj);
                            $scope.paramsABMS.total(orderedData.length);
                            $scope.datatoexcel = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                            return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                        }
                    });
            }

        }, function errorCallback(data) {
            UserSrv.MostrarError(data)
            console.log(data.data);
        });
    }

    $scope.getSubrubros = () => {
        $http({ url: 'subRubro/traerElementos', method: 'get' }).then(
            response => $scope.selectsubrubros = response.data
        )
    }


    $scope.traerElementos = function (pantalla) {
        $scope.generarTabla('imputacion/traerElementos');
        $scope.getSubrubros()
    }


    $scope.traerElementos();


});
