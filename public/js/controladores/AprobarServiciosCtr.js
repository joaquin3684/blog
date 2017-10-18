var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('pago_proovedores', function($scope, $http, $compile, $sce, NgTableParams, UserSrv, $filter) {

$scope.ArrayAprobar = [];
    $scope.pullAprobar = function (){

        $http({
            url: 'aprobacion/datos',
            method: 'get'
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.aprobaciones = response.data;
                $scope.paramsAprobaciones = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.aprobaciones.length,
                    getData: function (params) {
                        $scope.aprobaciones = $filter('orderBy')($scope.aprobaciones, params.orderBy());
                        return $scope.aprobaciones.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    $scope.AprobarServicio = function (Dato){

        $http({
            url: 'aprobacion/aprobar',
            method: 'post',
            data: Dato
        }).then(function successCallback(response)
        {
                $scope.pullAprobar();
                UserSrv.MostrarMensaje("OK","Se ha aprobado el servicio.","OK","mensaje");
                $scope.ArrayAprobar = [];
                console.log('success');

        }, function errorCallback(data)
        {
            UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");
        });



    }

    var self = this;
    $scope.pullAprobar();


    $scope.Corroborar = function(serv,check){
    var esta = '';
    var i = 0;
        if(check == true){
            for(i == 0; i < $scope.ArrayAprobar.length; i++){
                if($scope.ArrayAprobar[i] == serv){ esta == 'si'; }
            }
            if(esta == 'si'){ }else{ $scope.ArrayAprobar.push(serv); }
        }
        if(check == false){
            for(i == 0; i < $scope.ArrayAprobar.length; i++){
                if($scope.ArrayAprobar[i] == serv){ $scope.ArrayAprobar.splice(i,1); }
            }
        }


    }

    $scope.Aprobar = function(tipo,id){
        if(tipo == 'ok'){

            $scope.Dato = [{'id':id,'estado':'APROBADO'}];
            $scope.AprobarServicio($scope.Dato);

        } else {
            $scope.Dato = [{'id':id,'estado':'RECHAZADO'}];
            $scope.AprobarServicio($scope.Dato);

        }

        //$scope.ArrayAprobar = ProcesoArray($scope.ArrayAprobar);
        //console.log($scope.ArrayAprobar);
        //$scope.PagarProveedores();

    }
    $scope.criterios = ['Criterio 1','Criterio 2','Criterio 3'];

});
