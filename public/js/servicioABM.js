angular.module('ServicioABM', ['ngTable', 'Mutual.services'])

    .service('ServicioABM', function ($http, NgTableParams, $filter, UserSrv) {

        //$("#editar").modal('toggle')

        this.borrarFormulario = function () {
            $('#formulario')[0].reset();
        };

        this.create = function (data, url) {
            return $http({
                url: url,
                method: 'post',
                data: data,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function successCallback(response) {
                UserSrv.MostrarMensaje("OK", "Elemento dado de alta correctamente.", undefined, 'mensaje', undefined);
            }, function errorCallback(response) {
                console.log('Error al realizar el alta!');
            });
        };



        this.pull = function (url, id) {

            if (id != undefined) {
                url = url + '/' + id;
            }

            var promise = $http({
                url: url,
                method: "get",
            }).then(function successCallback(response) {
                if (typeof response.data === 'string') {
                    return [];
                } else {
                    console.log(response.data);
                    return response.data;
                }
            }, function errorCallback(response) {
                console.log('Error al traer elementos!');
            });

            return promise;
        };

        this.pullFilteredByData = function (url, data) {

            var promise = $http({
                url: url,
                method: "post",
                data: data,
            }).then(function successCallback(response) {
                if (typeof response.data === 'string') {
                    return [];
                } else {
                    console.log(response.data);
                    return response.data;
                }
            }, function errorCallback(response) {
                console.log('Error al traer elementos!');
            });

            return promise;
        };

        this.createTable = function (data) {
            var paramsABMS = new NgTableParams({
                page: 1,
                count: 10
            }, {
                getData: function (params) {
                    var filterObj = params.filter();
                    filteredData = $filter('filter')(data, filterObj);
                    var sortObj = params.orderBy();
                    orderedData = $filter('orderBy')(filteredData, sortObj);
                    paramsABMS.total(orderedData.length);
                    return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                },
            });
            return paramsABMS;
        }


        this.push = function (data, url, id) {
            return $http({
                url: url + '/' + id,
                method: 'put',
                data: data,
            }).then(function successCallback(response) {
                UserSrv.MostrarMensaje("OK", "Elemento editado correctamente.", undefined, 'mensaje', undefined);

            }, function errorCallback(response) {
                console.log('Error al editar un elemento!');
            });

        }

        this.delete = function (url, id) {

            return $http({
                url: url + '/' + id,
                method: 'delete',
            }).then(function successCallback(response) {
                UserSrv.MostrarMensaje("OK", "Elemento eliminado correctamente.", undefined, 'mensaje', undefined);
            }, function errorCallback(response) {
                console.log('Error al borrar un elemento!');
            });
        }
    });