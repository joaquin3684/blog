var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {
   
  // manda las solicitud http necesarias para manejar los requerimientos de un abm


$scope.traerRelaciones = function(relaciones)
   {  
      for(x in relaciones)
      {
       
         var url = relaciones[x].tabla + '/traerRelacion'+relaciones[x].tabla;
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {
          
          console.log(response);
            $.each(response.data, function(val, text) {
               console.log(relaciones[x].select);
               $(relaciones[x].select).append($("<option />").val(text.id).text(text.nombre));
               $(relaciones[x].select+'_Editar').append($("<option />").val(text.id).text(text.nombre));
            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
      }
   }


   $scope.ExportarPDF = function(pantalla) {UserSrv.ExportPDF(pantalla);}


   $scope.enviarFormulario = function(tipoSolicitud, id = '')
   {
         var form = '';
         var abm = $("#tipo_tabla").val();
         console.log('el id es: ' + id);
         switch(tipoSolicitud)
         {
            case 'Editar':
               var metodo = 'put';
               var form = $("#formularioEditar").serializeArray();
               var id = $('input[name=id]').val();
               break;
            case 'Alta':
               var metodo = 'post';
               var form = $("#formulario").serializeArray();
               break;
            case 'Borrar':
               var metodo = 'delete';
               break;
            case 'Mostrar':
               var metodo = 'get';
               break;
            default:
               console.log("el tipo de solicitud no existe");
               break;
         }
         
         var url = id == '' ? abm : abm+'/'+id;
         console.log(url);
         $http({
            url: url,
            method: metodo,
            data: $.param(form),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response)
            {
               if(tipoSolicitud == 'Mostrar')
                  {

                     console.log(response);
                     llenarFormulario('formularioEditar',response.data);
                  } 
               $scope.mensaje = response;
               $('#formulario')[0].reset();
               if(tipoSolicitud != 'Mostrar'){UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK"); $('#editar').modal('hide');}
               $scope.errores = '';
               console.log(response.data);
               $scope.traerElementos();
            }, function errorCallback(data)
            {
               console.log(data);
               $scope.errores = data.data;
            });
        
   }

   $scope.traerElementos = function(relaciones)
   {  
      var metodito = 'get';
      var abm = $("#tipo_tabla").val();
      var urlabm = abm + "/traerElementos";
      
      $http({
            url: urlabm,
            method: metodito
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.datosabm = response.data;
                $scope.paramsABMS = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.datosabm.length,
                    getData: function (params) {
                        $scope.datosabm = $filter('orderBy')($scope.datosabm, params.orderBy());
                        return $scope.datosabm.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
   }

   $scope.agregarPantalla = function()
   {
     
      var codigo = '';
      var array = [];
      for(var i = 0; $scope.numeroDePantallas > i; i++){

      codigo += '<div class="item form-group" >' +
           '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni" ng-click="console.log('+'anda'+')">Pantalla <span class="required">*</span></label>'+
         '<div class="col-md-6 col-sm-6 col-xs-12">'+
       '<select id="pantallas'+i+'" name="pantalla'+i+'" class="form-control col-md-7 col-xs-12" ></select>     </div>      </div>'+
         '<div style=" margin-bottom:20px;"><label class="checkbox-inline col-sm-offset-4 col-xs-offset-2"  ><input type="checkbox" value="crear" name="valor'+i+'[]">Crear</label> <label class="checkbox-inline"><input type="checkbox" value="editar" name="valor'+i+'[]">Editar</label> <label class="checkbox-inline"><input type="checkbox" value="borrar" name="valor'+i+'[]">Borrar</label> <label class="checkbox-inline"><input type="checkbox" name="valor'+i+'[]" value="visualizar">Visualizar</label> </div>';

      }
      //$scope.agregarCodigo = $sce.trustAsHtml(codigo);
      $('#agregarCodigo').html(codigo);

         var url = 'roles/traerRelacionroles';
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {
          
          console.log(response);
            $.each(response.data, function(val, text) {
              
               for(var j = 0; $scope.numeroDePantallas > j; j++){
                
               $('#pantallas'+j).append($("<option />").val(text.nombre).text(text.nombre));
              
                 
               }
               
            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
   }
   $scope.Impresion = function() {


        var divToPrint=document.getElementById('exportTable');
        var tabla=document.getElementById('tablita').innerHTML;
  var newWin=window.open('','sexportTable');

  newWin.document.open();
  var code = '<html><link rel="stylesheet" href="js/angular-material/angular-material.min.css"><link rel="stylesheet" href="css/bootstrap.min.css"<link rel="stylesheet" href="fonts/css/font-awesome.min.css"><link rel="stylesheet" href="ss/animate.min.css"><link rel="stylesheet" href="css/custom.css"><link rel="stylesheet" href="css/icheck/flat/green.css"><link rel="stylesheet" href="css/barrow.css"><link rel="stylesheet" href="css/floatexamples.css"><link rel="stylesheet" href="css/ng-table.min.css"><link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css"><body onload="window.print()"><table ng-table="paramsABMS" class="table table-hover table-bordered">'+tabla+'</table></body></html>';
  newWin.document.write(code);
  newWin.document.getElementById('botones').innerHTML = '';

  newWin.document.close();




   }

   $scope.Excel = function() {


    var divToPrint=document.getElementById('exportTable');
    var tabla=document.getElementById('tablita').innerHTML;
    var newWin=window.open('','sexportTable');

    newWin.document.open();
    var code = '<html><link rel="stylesheet" href="js/angular-material/angular-material.min.css"><link rel="stylesheet" href="css/bootstrap.min.css"<link rel="stylesheet" href="fonts/css/font-awesome.min.css"><link rel="stylesheet" href="ss/animate.min.css"><link rel="stylesheet" href="css/custom.css"><link rel="stylesheet" href="css/icheck/flat/green.css"><link rel="stylesheet" href="css/barrow.css"><link rel="stylesheet" href="css/floatexamples.css"><link rel="stylesheet" href="css/ng-table.min.css"><link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css"><body onload="window.print()"><div id="juan"><table ng-table="paramsABMS" class="table table-hover table-bordered">'+tabla+'</table></div></body></html>';
    newWin.document.write(code);
    newWin.document.getElementById('botones').innerHTML = '';

    var data_type = 'data:application/vnd.ms-excel';
    var table_html = newWin.document.getElementById('juan').outerHTML.replace(/ /g, '%20');

    var a = newWin.document.createElement('a');
    a.href = data_type + ', ' + table_html;
    a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
    a.click();

   }
   $scope.traerElementos();

   
});

