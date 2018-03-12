var app = angular.module('Mutual').config(function ($interpolateProvider) { });
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('caja', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM, UserSrv) {

    $scope.fecha = new Date();
    //moment().format('YYYY-MM-DD');

    $scope.query = function (searchText, url) {
        var data = {
            'nombre': searchText
        }
        return ServicioABM.pullFilteredByData(url, data)
    }

    $scope.borrarFormulario = function () {
        $('#formulario')[0].reset();
        $scope.operacionSeleccionada = '';
        $scope.bancoSeleccionado = '';
        $scope.chequeraSeleccionada = '';
        $scope.tipoTransaccion = '';
        $scope.tipoOperacion ='';
        $scope.tipo = ''
    };
    $scope.create = function (object) {

       var data = getData();
        var url = 'caja';
        ServicioABM.create(data, url);
        $scope.borrarFormulario();
    }
    var pull = function (url, scopeObj) {
        ServicioABM.pull(url).then(function (returnedData) {
            $scope[scopeObj] = returnedData;
        });
    }
    $scope.traerChequeras = function () {
        if($scope.tipoTransaccion == 'cheque'){

            var data = {
                'id_banco': $scope.bancoSeleccionado
            }
            ServicioABM.pullFilteredByData('chequera/traerElementos', data).then(function (returnedData) {
                $scope.chequeras = returnedData
                $scope.paramsChequera = ServicioABM.createTable(returnedData)
            })
        }
    }
    pull('operaciones/traerElementos','operaciones');
    pull('bancos/traerElementos', 'bancos');

    var getData = function(){
        var caja = {
             'data' : {
                'tipoOperacion': $scope.tipo,
                'id_operacion': $scope.operacionSeleccionada.id,
                'valor': $scope.valor,
                'observacion': $scope.observacion
            }
        }
        var banco = {
            'data': {
                'tipoOperacion': $scope.tipo,
                'id_operacion': $scope.operacionSeleccionada.id,
                'valor': $scope.valor,
                'observacion': $scope.observacion,
                'id_banco': $scope.bancoSeleccionado,
                'transferencia': 1
            }
        }
        var bancoConCheque = {
            'data': {
                'tipoOperacion': $scope.tipo,
                'id_operacion': $scope.operacionSeleccionada.id,
                'valor': $scope.valor,
                'observacion': $scope.observacion,
                'id_banco': $scope.bancoSeleccionado,
                'id_chequera': $scope.chequeraSeleccionada,
                'nro_cheque': $scope.nro_cheque,
                'fecha': moment($scope.fecha).format('YYYY-MM-DD'),
                'transferencia': 0
            }
        }
        if($scope.tipo == 'caja'){ return caja.data }
        else if($scope.tipoTransaccion == 'transferencia'){ return banco.data }
        else{ return bancoConCheque.data}
        
    }
});