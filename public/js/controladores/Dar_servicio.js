var app = angular.module('Mutual').config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.requires.push('ngMaterial', 'Mutual.services', 'angular-loading-bar');
app.controller('Dar_servicio', function ($scope, $http, $compile, $q, UserSrv) {
    //moment.locale('es');

    $scope.vencimiento = moment(moment().format('YYYY') + '-' + moment().add(2, 'months').format('MM') + '-20').toDate();
    $scope.fechaActual = moment().format('YYYY-MM-DD');
    $scope.mostrar = false;

    $scope.anioHoy = moment().format('YYYY');
    $scope.mesHoy = moment().locale('es').format('MMMM');
    $scope.diaHoy = moment().format('DD');

    $scope.getImporte = function () {
        $scope.importe = Number(($scope.montoPorCuota * $scope.nro_cuotas).toFixed(2));
    }
    // machea a los socios en base al searchText
    $scope.query = function (searchText, ruta) {
        return $http({
            url: 'dar_servicio/' + ruta,
            method: 'post',
            data: {
                'nombre': searchText
            }
        }).then(function successCallback(response) {
            console.log(response);
            return response.data;

        }, function errorCallback(data) {
            UserSrv.MostrarError(data)
            console.log(data);
        });
    }
    $scope.calcularVencimiento = function () {
        $scope.vencimiento = moment(moment().format('YYYY') + '-' + moment().format('MM') + '-20').toDate();
        $scope.vencimiento = moment($scope.vencimiento).add(($scope.nro_cuotas + 1 || 0), 'months').toDate();
    }
    $scope.traerProductos = function (searchText) {
        console.log($scope.proovedor);
        return $http({
            url: 'productos/TraerProductos',
            method: 'post',
            data: {
                'nombre': searchText,
                'proovedor': $scope.proovedor.id
            }
        }).then(function successCallback(response) {
            console.log(response);
            return response.data;

        }, function errorCallback(data) {
            UserSrv.MostrarError(data)
            console.log(data);
        });
    }

    $scope.numberToString = function (number) {
        return writtenNumber(Math.trunc(number), { lang: 'es' });
    }
    $scope.decimalToString = function (number) {
        number = Math.ceil((number % 1).toFixed(2) * 100)
        return $scope.numberToString(number)
    }

    $scope.refrescarPantalla = function () {
        $scope.socio = '';
        $scope.proovedor = '';
        $scope.producto = '';
        $scope.importe = '';
        $scope.montoPorCuota = '';
        $scope.nro_cuotas = '';
        $scope.observacion = '';
        $scope.importe_otorgado = ''
    }


    $scope.crearMovimiento = function () {

        try {
            $scope.generarArchivo()
            var vencimiento = moment($scope.vencimiento, "DD/MM/YYYY").format('YYYY-MM-DD');

            $http({
                url: 'ventas',
                method: 'post',
                data: {
                    'id_asociado': $scope.socio.id,
                    'id_producto': $scope.producto.id,
                    'importe_total': $scope.importe,
                    'importe_cuota': $scope.montoPorCuota,
                    'nro_cuotas': $scope.nro_cuotas,
                    'descripcion': $scope.observacion,
                    'fecha_vencimiento': vencimiento,
                    'plata_recibida': $scope.$parent.plata_recibida,
                    'importe_otorgado': $scope.importe_otorgado
                }
            }).then(function successCallback(response) {
                console.log(response);
                $scope.refrescarPantalla();
                UserSrv.MostrarMensaje("OK", "Se ha otorgado el servicio correctamente.", "OK", "mensaje");
                return response.data;

            }, function errorCallback(data) {
                UserSrv.MostrarError(data)
                console.log(data);
            });
        } catch (e) {
            console.log(e)
        }

    }

    $scope.habilitacion = true;
    $scope.habilitar = function () {
        if ($scope.proovedor == null) {
            $scope.habilitacion = true;
            $scope.producto = '';
        } else {
            $scope.habilitacion = false;

        }
    }

    $scope.generarArchivo = function () {
        w = window.open();
        w.document.write(document.getElementById('archivoImprimir').outerHTML);
        w.print();
        w.close();
    }

    $scope.mostrarPlanDePago = function () {
        $scope.mostrar = true;
        var planDePago = [];
        var importe = $scope.importe / $scope.nro_cuotas;
        importe = importe.toFixed(2);
        moment.locale('es')
        var vto = moment($scope.vencimiento, "DD/MM/YYYY");
        console.log(vto);
        for (var i = 0; i < $scope.nro_cuotas; i++) {

            /*console.log($scope.vencimiento);
            planDePago.push($scope.vencimiento);
            console.log(planDePago);
            $scope.vencimiento.addDays(30);
            console.log($scope.vencimiento);*/

            var objeto = {
                'cuota': i + 1,
                'importe': importe,
                'fecha': vto.format('L')
            };
            planDePago.push(objeto);
            vto.add(1, 'months');
        }
        $scope.planDePago = planDePago;

    }

});