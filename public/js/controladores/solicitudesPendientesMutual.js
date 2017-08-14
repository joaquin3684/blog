var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('solicitudesPendientesMutual', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv) {

    $scope.pullSolicitudes = function (){

        $http({
            url: 'agente_financiero/solicitudes',
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

    $scope.ReservarCapital = function(id) {
        $http({
                url: 'agente_financiero/reservarCapital',
                method: 'post',
                data: {'id':id,'estado':'Capital Reservado'}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","El capital fue reservado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

            });
    }

    $scope.OtorgarCapital = function(id) {
        
        $http({
            url: 'agente_financiero/otorgarCapital',
            method: 'post',
            data: {'id':id,'estado':'Capital Otorgado'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","El capital fue otorgado correctamente.","OK","mensaje");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

        });
    
    }

    $scope.EnviarPropuesta = function () {
        
        if(($scope.monto_por_cuota * $scope.cuotas) == $scope.importe){

            $http({
                url: 'agente_financiero/enviarPropuesta',
                method: 'post',
                data: {'id':$scope.idpropuestae,'total':$scope.importe,'cuotas':$scope.cuotas,'monto_por_cuota':$scope.monto_por_cuota,'estado':'Esperando Respuesta Comercializador'}
            }).then(function successCallback(response)
            {
                
                    UserSrv.MostrarMensaje("OK","La propuesta fue enviada correctamente.","OK","mensajemodal","ContraPropuesta");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal");

            });

        } else {
            UserSrv.MostrarMensaje("Error","El monto por cuota y las cuotas son incongruentes con el importe total.","Error","mensajemodal");
        }
    }



    var self = this;
    $scope.pullSolicitudes();
    

});

