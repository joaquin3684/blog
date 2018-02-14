var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'ngFileUpload']).config(function ($interpolateProvider, $compileProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|file|blob):|data:image\//);
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

        //ESTOY ARMANDO UN SERVICE INTEGRAL -- NO TOCAR
        //$scope.paramssolicitudes = UserSrv.RequestTable('comercializador/solicitudes','get');



    }

    $scope.submit = function() {
        console.log("el ng click funciona");
        $scope.upload($scope.file);

    };

   
    // upload on file select or drop
    $scope.upload = function (file) {
        Upload.upload({
            url: 'pruebas',
            method: 'post',
            data: {'imagen': file, 'comprobante2': file}
        }).then(function (resp) {
            console.log('Success ' + 'uploaded. Response: ' + resp.data);
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ');
        });
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
                    UserSrv.MensajeError(data.data);
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
                var img = new Image();
                img.onload = function () {
                    
                    document.getElementById('endeudamientodiv').style.display = 'none';
                    document.getElementById('previsualizaciondiv').style.display = 'block';
                    document.getElementById('previsualizacion').src = archivo;
                    $scope.heightImg = img.height;
                    $scope.widthImg = img.width;
                    $scope.$apply();
                }
                img.src = archivo;
            }
        }

    }
    $scope.expandirImg = function(){
        // Get the image and insert it inside the modal
        var img = document.getElementById('previsualizacion');
        var modalImg = document.getElementById("imgExpandida");
       
        modalImg.src = img.src;
        $scope.imageSrc = img.src;
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
            url: 'comercializador/enviarFormulario',
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

                UserSrv.MostrarMensaje("OK","La propuesta fue aceptada correctamente.","OK","mensaje");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

        });

    }

    $scope.PropuestaModificada = function () {

        $http({
            url: 'comercializador/modificarPropuesta',
            method: 'post',
            data: {'id':$scope.idpropuestae,'total':$scope.importe,'cuotas':$scope.cuotas,'monto_por_cuota':$scope.monto_por_cuota,'estado':'Modificada por Comercializador'}
        }).then(function successCallback(response)
        {

                UserSrv.MostrarMensaje("OK","La contra propuesta fue enviada correctamente.","OK","mensaje");
                $scope.pullComercializadores();

        }, function errorCallback(data)
        {

                UserSrv.MostrarMensaje("Error","Ocurrió algún error inesperado. Intente nuevamente.","Error","mensaje");

        });

    }

    $scope.ModificarPropuesta = function (valor) {
        $scope.modificandopropuesta = valor;
    }

    $scope.AltaComercializador = function (Dato){

        console.log(moment($scope.fecha_nacimiento).format('YYYY-MM-DD'));
        if($scope.doc_endeudamiento == ''){
            $scope.doc_endeudamiento = null;
        }
    if($scope.socio != null) {
        $scope.Dato = {
        'nombre':$scope.nombre,//$scope.nombre,
        'apellido':$scope.apellido,
        'cuit':$scope.cuit,
        'domicilio':$scope.domicilio,
        'fecha_nacimiento':moment($scope.fecha_nacimiento).format('YYYY-MM-DD'),
        'sexo':$scope.sexo,
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
        'sexo':$scope.sexo,
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
        /*$http({
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
        });*/

        Upload.upload({
            url: 'comercializador/altaSolicitud',
            method: 'post',
            data: $scope.Dato
        }).then(function (resp) {
            console.log('Success ' + 'uploaded. Response: ' + resp.data);
            $scope.pullComercializadores();
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ');
        });


    }

    var self = this;
    $scope.pullComercializadores();
    $scope.getOrganismos();


});
