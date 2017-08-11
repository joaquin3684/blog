var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('comercializador', function($scope, $http, $compile, $sce, NgTableParams, $filter) {

    $scope.pullComercializadores = function (){

        $http({
            url: 'comercializador/solicitudes',
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


    $scope.AltaComercializador = function (Dato){
        
    $scope.Dato = [{'nombre':$scope.nombre,'apellido':$scope.apellido,'cuit':$scope.cuit,'domicilio':$scope.domicilio,'codigo_postal':$scope.codigo_postal,'telefono':$scope.telefono,'doc_documento':'archivos/documento.png','doc_cbu':'archivos/cbu.png','doc_endeudamiento':'archivos/endeudamiento.png','doc_recibo':'archivos/recibo.png','doc_domicilio':'archivos/domicilio.png'}];
    // 'nombre', 'comercializador', 'cuit', 'domicilio', 'apellido', 'codigo_postal', 'telefono', 'doc_documento', 'doc_recibo', 'doc_domicilio', 'doc_cbu', 'doc_endeudamiento', 'agente_financiero', 'estado', 'total', 'monto_por_cuota', 'cuotas', 'organismo'];

        $http({
            url: 'comercializador/altaSolicitud',
            method: 'post',
            data: $scope.Dato
        }).then(function successCallback(response)
        {
            console.log(response.data.ventas);
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                $scope.pullComercializadores();
                console.log('Di el alta');
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    var self = this;
    $scope.pullComercializadores();
    
/*
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

            var observacion = document.getElementById('observacion'+id).value;
            $scope.Dato = [{'id':id,'estado':'APROBADO','observacion':observacion}];
            $scope.AprobarServicio($scope.Dato);

        } else {

            var observacion = document.getElementById('observacion'+id).value;
            $scope.Dato = [{'id':id,'estado':'RECHAZADO','observacion':observacion}];
            $scope.AprobarServicio($scope.Dato);

        }

        //$scope.ArrayAprobar = ProcesoArray($scope.ArrayAprobar);
        //console.log($scope.ArrayAprobar);
        //$scope.PagarProveedores();

    }
    $scope.criterios = ['Criterio 1','Criterio 2','Criterio 3'];
*/
});

