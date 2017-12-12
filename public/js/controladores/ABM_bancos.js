var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services']).config(function ($interpolateProvider) {});
app.controller('ABM_bancos', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM, UserSrv) {

    $scope.borrarFormulario = function () {
        $('#formulario2')[0].reset();
        $scope.nro_chequera = undefined
        $scope.nro_inicio = undefined
        $scope.nro_fin = undefined
        $scope.estado = undefined
    };
    $scope.asignarBanco = function (idBanco) {
        $scope.idBanco = idBanco
        $scope.traerChequeras()
    }
    $scope.create = function () {
        var data = {
            'nombre': $scope.nombre,
            'direccion': $scope.direccion,
            'sucursal': $scope.sucursal,
            'nro_cuenta': $scope.nro_cuenta
        }
        var url = 'bancos';
        ServicioABM.create(data, url).then(function () {
            pull('bancos/traerElementos', 'bancos', 'paramsABMS');
        });
        $scope.borrarFormulario();
    }
    $scope.createChequera = function () {
        var data = {
            'nro_chequera': $scope.nro_chequera,
            'nro_inicio': $scope.nro_inicio,
            'nro_fin': $scope.nro_fin,
            'estado': $scope.estado,
            'id_banco': $scope.idBanco
        }
        var url = 'chequera';
        ServicioABM.create(data, url).then(function () {
            $scope.traerChequeras();

        });
        $scope.borrarFormulario();
    }
    $scope.editarBanco = function (id) {
        var data = {
            'nombre': $scope.bancoSeleccionado.nombre,
            'direccion': $scope.bancoSeleccionado.direccion,
            'sucursal': $scope.bancoSeleccionado.sucursal,
            'nro_cuenta': $scope.bancoSeleccionado.nro_cuenta
        }
        ServicioABM.push(data, 'bancos', id)
        $("#editar").modal('toggle')
        pull('bancos/traerElementos', 'bancos', 'paramsABMS');
    }
    $scope.traerBanco = function (id) {
        pullElem('bancos', 'bancoSeleccionado', id);
    }
    $scope.traerChequeras = function () {
        var data = {
            'id_banco': $scope.idBanco
        }
        ServicioABM.pullFilteredByData('chequera/traerElementos', data).then(function (returnedData) {
            $scope.chequeras = returnedData
            $scope.paramsChequera = ServicioABM.createTable(returnedData)
        })
    }
    var pull = function (url, scopeObj, params) {
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
            $scope[params] = ServicioABM.createTable(returnedData)
        });
    }
    var pullElem = function (url, scopeObj, id) {
        ServicioABM.pull(url, id).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }
    $scope.delete = function (id) {
        ServicioABM.delete('bancos', id).then(function(){
            pull('bancos/traerElementos', 'bancos', 'paramsABMS');

        })
    }
    pull('bancos/traerElementos', 'bancos', 'paramsABMS');
});