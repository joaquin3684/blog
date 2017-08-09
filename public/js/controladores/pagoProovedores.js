var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('pago_proovedores', function($scope, $http, $compile, $sce, NgTableParams, $filter) {


$scope.ArrayPago = [];
    $scope.pullProveedores = function (){

        $http({
            url: 'pago_proovedores/datos',
            method: 'post'
        }).then(function successCallback(response)
        {
            console.log(response.data.ventas);
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.proveedores = response.data;
                $scope.paramsProveedores = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.proveedores.length,
                    getData: function (params) {
                        $scope.proveedores = $filter('orderBy')($scope.proveedores, params.orderBy());
                        return $scope.proveedores.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    $scope.PagarProveedores = function (){

        $http({
            url: 'pago_proovedores/pagarCuotas',
            method: 'post',
            data: {'proveedores': $scope.ArrayPago}
        }).then(function successCallback(response)
        {
            console.log(response.data.ventas);
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                $scope.pullProveedores();
                $scope.ArrayPago = [];
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    var self = this;
    $scope.pullProveedores();
    

    $scope.Corroborar = function(prov,check){
    var esta = '';
    var i = 0;
        if(check == true){
            for(i == 0; i < $scope.ArrayPago.length; i++){
                if($scope.ArrayPago[i] == prov){ esta == 'si'; }
            }
            if(esta == 'si'){ }else{ $scope.ArrayPago.push(prov); }
        }
        if(check == false){
            for(i == 0; i < $scope.ArrayPago.length; i++){
                if($scope.ArrayPago[i] == prov){ $scope.ArrayPago.splice(i,1); }
            }
        }


    }

    $scope.pagar = function(){

        $scope.ArrayPago = ProcesoArray($scope.ArrayPago);
        $scope.PagarProveedores();

    }

});

