var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable','Mutual.services', 'ngFileUpload']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('comercializador', function($scope, $http, $compile, $sce, NgTableParams, $filter,UserSrv, Upload) {

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

    $scope.onFileSelect = function($files) {
        console.log("Entro a la funcion");
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];
      $scope.upload = Upload.upload({
        url: 'pruebas', //upload.php script, node.js route, or servlet url
        data: {'imagen': $scope.myModelObj},
        file: file,
      }).progress(function(evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully
        console.log(data);
      });
    }
    };

    $scope.query = function(searchText, ruta)
    {
        return $http({
            url: 'comercializador/buscarSocios',
            method: 'post',
            data: {'nombre' : searchText,'id_organismo':$scope.organismocomplete}
            }).then(function successCallback(response)
                {
                    return response.data;
                    console.log(data);
                }, function errorCallback(data){
                    console.log(data);
                });
    }

    $scope.getFotos = function(idsolicitud)
    {
        return $http({
            url: 'comercializador/fotos',
            method: 'post',
            data: {'id' : idsolicitud}
            }).then(function successCallback(response)
                {
                    return response.data;
                    console.log(data);
                }, function errorCallback(data){
                    console.log(data);
                });
    }

    $scope.Comprobante = function (){

        archivo = $scope.comprobantevisualizar;
        
        document.getElementById('previsualizacion').src = "images/"+archivo+".png";

    }

    $scope.IDPropuesta = function(id,importe,monto,cantcuotas) {
        $scope.idpropuestae = id;
        $scope.importe = importe;
        $scope.monto_por_cuota = monto;
        $scope.cuotas = cantcuotas;
    }

    $scope.getOrganismos = function (){
        $http({
            url: 'organismos/traerElementos',
            method: 'get'
        }).then(function successCallback(response)
        {
          
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                $scope.organismos = response.data;
                console.log(response);
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
    }

    $scope.ImprimirFormulario = function() {
        alert('Se imprime el formulario..');
    }

    $scope.EnviarFormulario = function(id) {
        $http({
            url: 'comercializador/modificarPropuesta',
            method: 'post',
            data: {'id':id,'estado':'Formulario Enviado'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","El formulario fue enviado correctamente.","OK","mensaje");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

        });
    } 

    $scope.DatosModal = function (documento,recibo,cbu,domicilio,endeudamiento){

        $scope.DatosModalActual = [
        {'comprobante':'Documento','archivo':documento},
        {'comprobante':'Recibo','archivo':recibo},
        {'comprobante':'CBU','archivo':cbu},
        {'comprobante':'Domicilio','archivo':domicilio},
        {'comprobante':'Endeudamiento','archivo':endeudamiento}
        ];

    }



    $scope.AceptarPropuesta = function () {

        $http({
            url: 'comercializador/aceptarPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'estado':'Aceptada por Comercializador'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","La propuesta fue aceptada correctamente.","OK","mensajemodal","ContraPropuesta");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal");

        });

    }

    $scope.PropuestaModificada = function () {

        $http({
            url: 'comercializador/modificarPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'total':$scope.importe,'cuotas':$scope.cuotas,'monto_por_cuota':$scope.monto_por_cuota,'estado':'Modificada por Comercializador'}
        }).then(function successCallback(response)
        {
            
                UserSrv.MostrarMensaje("OK","La contra propuesta fue enviada correctamente.","OK","mensajemodal","ContraPropuesta");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensajemodal");

        });

    }

    $scope.ModificarPropuesta = function (valor) {
        $scope.modificandopropuesta = valor;
    }

    $scope.AltaComercializador = function (Dato){

        console.log(moment($scope.fecha_nacimiento).format('YYYY-MM-DD'));
    if($scope.socio != null) {
        $scope.Dato = {
        'nombre':$scope.nombre,//$scope.nombre,
        'apellido':$scope.apellido,
        'cuit':$scope.cuit,
        'domicilio':$scope.domicilio,
        'fecha_nacimiento':moment($scope.fecha_nacimiento).format('YYYY-MM-DD'),
        'codigo_postal':$scope.codigo_postal,
        'telefono':$scope.telefono,
        'doc_documento':$scope.doc_documento,
        'doc_cbu':$scope.doc_cbu,
        'doc_endeudamiento':$scope.doc_endeudamiento,
        'doc_recibo':$scope.doc_recibo,
        'doc_domicilio':$scope.doc_domicilio,
        'filtro':'',
        'id_organismo':$scope.organismocomplete,
        'dni':$scope.dni,
        'localidad':$scope.localidad,
        'legajo':$scope.legajo,
        'id_socio':$scope.socio.id
        };
    } else {
        $scope.Dato = {
        'nombre':$scope.nombre,//$scope.nombre,
        'apellido':$scope.apellido,
        'cuit':$scope.cuit,
        'domicilio':$scope.domicilio,
            'fecha_nacimiento':moment($scope.fecha_nacimiento).format('YYYY-MM-DD'),
        'codigo_postal':$scope.codigo_postal,
        'telefono':$scope.telefono,
        'doc_documento':$scope.doc_documento,
        'doc_cbu':$scope.doc_cbu,
        'doc_endeudamiento':$scope.doc_endeudamiento,
        'doc_recibo':$scope.doc_recibo,
        'doc_domicilio':$scope.doc_domicilio,
        'filtro':'',
        'id_organismo':$scope.organismocomplete,
        'dni':$scope.dni,
        'localidad':$scope.localidad,
        'legajo':$scope.legajo
        };
    }
    console.log($scope.Dato);
    // 'nombre', 'comercializador', 'cuit', 'domicilio', 'apellido', 'codigo_postal', 'telefono', 'doc_documento', 'doc_recibo', 'doc_domicilio', 'doc_cbu', 'doc_endeudamiento', 'agente_financiero', 'estado', 'total', 'monto_por_cuota', 'cuotas', 'organismo'];

        $http({
            url: 'comercializador/altaSolicitud',
            method: 'post',
            data: $scope.Dato
        }).then(function successCallback(response)
        {
            
        
                
                UserSrv.MostrarMensaje("OK","La solicitud fue dada de alta correctamente.","OK","mensaje");
                $scope.pullComercializadores();
                
                
           

        }, function errorCallback(data)
        {
            UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");
        });



    }

    var self = this;
    $scope.pullComercializadores();
    $scope.getOrganismos();
    

});

