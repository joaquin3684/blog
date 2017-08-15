var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('solicitudesPendientesMutual', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv) {

    $scope.pullSolicitudes = function (){

        $http({
            url: 'solicitudesPendientesMutual/solicitudes',
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
                $scope.solicitudes = response.data;
                $scope.paramssolicitudes = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.solicitudes.length,
                    getData: function (params) {
                        $scope.solicitudes = $filter('orderBy')($scope.solicitudes, params.orderBy());
                        return $scope.solicitudes.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    $scope.IDModal = function(id) {
        $scope.idpropuestae = id;
    }

    $scope.AsignarAF = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {'id':$scope.idpropuestae,'agente_financiero':$scope.agente,'estado':'Inversionista Asignado'}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El agente financiero fué asignado correctamente.","OK","mensajemodal","AgenteFinanciero");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal","AgenteFinanciero");

            });
    }

    $scope.AsignarEndeudamiento = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {'id':$scope.idpropuestae,'doc_endeudamiento':$scope.endeudamiento}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El endeudamiento fué asignado correctamente.","OK","mensajemodal2","Endeudamiento");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal","Endeudamiento");

            });
    }



    var self = this;
    $scope.pullSolicitudes();
    

});

