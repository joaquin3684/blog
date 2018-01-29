var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services','ServicioABM']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('solicitudesPendientesMutual', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv, ServicioABM) {

    $scope.expandirImg = function () {
        // Get the image and insert it inside the modal
        var img = document.getElementById('previsualizacion');
        var modalImg = document.getElementById("imgExpandida");

        modalImg.src = img.src;
    }
    
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
                    getData: function (params) {
                        $scope.solicitudes = $filter('orderBy')($scope.solicitudes, params.orderBy());
                        $scope.paramssolicitudes.total($scope.solicitudes.length);
                        return $scope.solicitudes.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });

    }
   
    $scope.pullProductos = function () {
        var url= 'proveedores/productos';
        var data = {
            'id': Number($scope.agente)
        }
        ServicioABM.pullFilteredByData(url, data).then(function (returnedData) {
            $scope.productos = returnedData;
        });
    }

        $scope.pullSolicitudes2 = function (){

        $http({
            url: 'solicitudesPendientesMutual/conCapitalOtrogado',
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
                $scope.solicitudes2 = response.data;
                $scope.paramssolicitudes2 = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    getData: function (params) {
                        $scope.solicitudes2 = $filter('orderBy')($scope.solicitudes2, params.orderBy());
                        $scope.paramssolicitudes2.total($scope.solicitudes2.length);
                        return $scope.solicitudes2.slice((params.page() - 1) * params.count(), params.page() * params.count());
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
        $scope.getAgentes();
    }

    $scope.AsignarAF = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {
                    'id':$scope.idpropuestae,
                    'agente_financiero':$scope.agente,
                    'id_producto': $scope.productoSeleccionado
                }
            }).then(function successCallback(response)
            {

                    console.log(response);
                    UserSrv.MostrarMensaje("OK","El agente financiero fué asignado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

            });

            $('#AgenteFinanciero').modal('hide');
    }

    $scope.AprobarSolicitud = function(id) {
        $http({
                url: 'solicitudesPendientesMutual/aprobarSolicitud',
                method: 'post',
                data: {'id':id,'estado':'Solicitud Aprobada'}
            }).then(function successCallback(response)
            {
                    UserSrv.MostrarMensaje("OK","El agente financiero fué asignado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes2();
            }, function errorCallback(data)
            {
                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");
            });
    }

    $scope.AsignarEndeudamiento = function() {
        $http({
                url: 'solicitudesPendientesMutual/actualizar',
                method: 'post',
                data: {'id':$scope.idpropuestae,'doc_endeudamiento':$scope.endeudamiento}
            }).then(function successCallback(response)
            {
                    console.log(response);
                    UserSrv.MostrarMensaje("OK","El endeudamiento fué asignado correctamente.","OK","mensaje");
                    $scope.pullSolicitudes();

            }, function errorCallback(data)
            {

                    UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

            });
            $('#Endeudamiento').modal('hide');
    }

    $scope.getAgentes = function (){
        $http({
            url: 'solicitudesPendientesMutual/proveedores',
            method: 'post',
            data: {'id':$scope.idpropuestae}
        }).then(function successCallback(response)
        {
          
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                $scope.agentesasignar = response.data;
                
                console.log(response);
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
    }

    $scope.getFotos = function(idsolicitud)
    {
        document.getElementById('endeudamientodiv').style.display = 'none';
        document.getElementById('previsualizaciondiv').style.display = 'block';
        document.getElementById('previsualizacion').src = 'images/preload.png';
        $scope.idpropuestae = idsolicitud;
        return $http({
            url: 'comercializador/fotos',
            method: 'post',
            data: {'id' : idsolicitud}
            }).then(function successCallback(response)
                {
                    $scope.DatosModalActual = response.data;
                    console.log(response.data);
                }, function errorCallback(data){
                    console.log(data);
                });
    }

    $scope.Comprobante = function (){
 
        archivo = $scope.comprobantevisualizar;
        if(!isNaN(archivo) && archivo != null){
            document.getElementById('previsualizaciondiv').style.display = 'none';
            document.getElementById('endeudamientodiv').style.display = 'block';
            document.getElementById('endeud').innerHTML = archivo;
        } else {
            if(archivo != null){
                document.getElementById('endeudamientodiv').style.display = 'none';    
                document.getElementById('previsualizaciondiv').style.display = 'block';
                document.getElementById('previsualizacion').src = archivo;
            }
        }
        
    }


    var self = this;
    $scope.pullSolicitudes();
    $scope.pullSolicitudes2();
    
    

});

