var app = angular.module('Mutual').config(function($interpolateProvider){});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'angular-loading-bar');
app.controller('ABMWizard', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

$scope.borrarFormulario = function(){
  $('#formulario')[0].reset();
};

$scope.fechadehoy = moment().format('YYYY-MM-DD');


$scope.$Servicio = UserSrv;
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

   $scope.cantMaxima= function(){
     if($scope.pantallaActual =='rubro' || $scope.pantallaActual=='capitulo' || $scope.pantallaActual=='moneda'){
      return 1;
     }
     return 2;
   }
   $scope.enviarFormulario = function(abm,tipoSolicitud, id = '')
   {
         var form = '';
         var formu = abm + 'form';
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
               var form = $("#"+formu).serializeArray();
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
                     $scope.id_anterior = response.data.id_anterior;
                  }
               $scope.mensaje = response;
               $('#'+formu)[0].reset();
               if(tipoSolicitud != 'Mostrar'){
                 UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
                 $('#editar').modal('hide');
                 $('#editar_'+$scope.pantallaActual).modal('hide');
               }
               $scope.errores = '';
               console.log(response.data);
               $scope.traerElementos($scope.pantallaActual);
            }, function errorCallback(data)
            {
                UserSrv.MostrarError(data)
               console.log(data);
               $scope.errores = data.data;
            });

   }

   $scope.cambiarFecha = function(dato){
      moment.locale('es');
      fechaNacimiento= dato.fecha_nacimiento;
      fechaIngreso= dato.fecha_ingreso;
      var fechaNacimiento= moment(fechaNacimiento, 'YYYY-MM-DD').format('L');
      var fechaIngreso= moment(fechaIngreso, 'YYYY-MM-DD').format('L');
      dato.fecha_nacimiento= fechaNacimiento;
      dato.fecha_ingreso= fechaIngreso;
      return dato;
    }



  $scope.generarTabla = function(url, tipoSelect){

    $http({
            url: url,
            method: 'get'
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
              switch($scope.pantallaActual){
                case 'capitulo':
                  $scope.selectcapitulos = response.data
                   break;
                case 'rubro':
                  $scope.selectrubros= response.data;
                   break;
                case 'moneda':
                   $scope.selectmonedas = response.data;
                   break;
                case 'departamento':
                   $scope.selectdepartamentos= response.data;
                   break;
                case 'subRubro':
                   $scope.selectsubrubros= response.data;
                   break;
                case 'imputacion':
                   $scope.selectimputaciones= response.data;
                   break;
              }
              $scope.paramsABMS = new NgTableParams({
                page: 1,
                count: 10
              }, {
                getData: function (params) {
                  var filterObj = params.filter();
                  filteredData = $filter('filter')(response.data, filterObj);
                  var sortObj = params.orderBy();
                  orderedData = $filter('orderBy')(filteredData, sortObj);
                    $scope.paramsABMS.total(orderedData.length);
                  $scope.datatoexcel = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                  return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
                }
              });
            }

        }, function errorCallback(data)
        {
            UserSrv.MostrarError(data)
            console.log(data.data);
        });


    //tablaDestino = tabla;
  }


  $scope.asignarPantallaActual = function (pantalla){
    $scope.pantallaActual = pantalla;
    $scope.traerElementos(pantalla);
  }

   $scope.traerElementos = function(pantalla){

     switch(pantalla){
       case 'capitulo':
          $scope.generarTabla('capitulo/traerElementos');
          break;
       case 'rubro':
          $scope.generarTabla('rubro/traerElementos');
          break;
       case 'moneda':
          $scope.generarTabla('moneda/traerElementos');
          break;
       case 'departamento':
          $scope.generarTabla('departamento/traerElementos');
          break;
       case 'subRubro':
          $scope.generarTabla('subRubro/traerElementos');
          break;
       case 'imputacion':
          $scope.generarTabla('imputacion/traerElementos');
          break;
     }



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
             UserSrv.MostrarError(data)
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

   $scope.pantallaActual = 'capitulo';
   $scope.traerElementos('capitulo');


   //EMPIEZA EL CODIGO DEL EXPANDIR
   $scope.tableRowExpanded = false;
   $scope.tableRowIndexExpandedCurr = "";
   $scope.tableRowIndexExpandedPrev = "";
   $scope.storeIdExpanded = "";

   $scope.dayDataCollapseFn = function () {
       $scope.dayDataCollapse = [];
       for (var i = 0; i < $scope.storeDataModel.storedata.length; i += 1) {
           $scope.dayDataCollapse.push(false);
       }
   };


   $scope.selectTableRow = function (index, storeId) {
       if (typeof $scope.dayDataCollapse === 'undefined') {
           $scope.dayDataCollapseFn();
       }

       if ($scope.tableRowExpanded === false && $scope.tableRowIndexExpandedCurr === "" && $scope.storeIdExpanded === "") {
           $scope.tableRowIndexExpandedPrev = "";
           $scope.tableRowExpanded = true;
           $scope.tableRowIndexExpandedCurr = index;
           $scope.storeIdExpanded = storeId;
           $scope.dayDataCollapse[index] = true;
       } else if ($scope.tableRowExpanded === true) {
           if ($scope.tableRowIndexExpandedCurr === index && $scope.storeIdExpanded === storeId) {
               $scope.tableRowExpanded = false;
               $scope.tableRowIndexExpandedCurr = "";
               $scope.storeIdExpanded = "";
               $scope.dayDataCollapse[index] = false;
           } else {
               $scope.tableRowIndexExpandedPrev = $scope.tableRowIndexExpandedCurr;
               $scope.tableRowIndexExpandedCurr = index;
               $scope.storeIdExpanded = storeId;
               $scope.dayDataCollapse[$scope.tableRowIndexExpandedPrev] = false;
               $scope.dayDataCollapse[$scope.tableRowIndexExpandedCurr] = true;
           }
       }

   };

   $scope.storeDataModel = {
       "metadata": {
           "storesInTotal": "25",
           "storesInRepresentation": "6"
       },
       "storedata": [{
           "store": {
               "storeId": "1000",
               "storeName": "Store 1",
               "storePhone": "+46 31 1234567",
               "storeAddress": "Avenyn 1",
               "storeCity": "Gothenburg"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "100000",
               "salesTotal": "150000",
               "revenueTotal": "50000",
               "averageEmployees": "3.5",
               "averageEmployeesHours": "26.5",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "50000",
                   "sales": "71000",
                   "revenue": "21000",
                   "employees": "3",
                   "employeesHoursSum": "24"
               }, {
                   "date": "2013-07-02",
                   "cost": "50000",
                   "sales": "79000",
                   "revenue": "29000",
                   "employees": "4",
                   "employeesHoursSum": "29"
               }]
           }
       }, {
           "store": {
               "storeId": "2000",
               "storeName": "Store 2",
               "storePhone": "+46 8 9876543",
               "storeAddress": "Drottninggatan 100",
               "storeCity": "Stockholm"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "170000",
               "salesTotal": "250000",
               "revenueTotal": "80000",
               "averageEmployees": "4.5",
               "averageEmployeesHours": "35",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "85000",
                   "sales": "120000",
                   "revenue": "35000",
                   "employees": "5",
                   "employeesHoursSum": "38"
               }, {
                   "date": "2013-07-02",
                   "cost": "85000",
                   "sales": "130000",
                   "revenue": "45000",
                   "employees": "4",
                   "employeesHoursSum": "32"
               }]
           }
       }, {
           "store": {
               "storeId": "3000",
               "storeName": "Store 3",
               "storePhone": "+1 99 555-1234567",
               "storeAddress": "Elm Street",
               "storeCity": "New York"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "2400000",
               "salesTotal": "3800000",
               "revenueTotal": "1400000",
               "averageEmployees": "25.5",
               "averageEmployeesHours": "42",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "1200000",
                   "sales": "1600000",
                   "revenue": "400000",
                   "employees": "23",
                   "employeesHoursSum": "41"
               }, {
                   "date": "2013-07-02",
                   "cost": "1200000",
                   "sales": "2200000",
                   "revenue": "1000000",
                   "employees": "28",
                   "employeesHoursSum": "43"
               }]
           }
       }, {
           "store": {
               "storeId": "4000",
               "storeName": "Store 4",
               "storePhone": "0044 34 123-45678",
               "storeAddress": "Churchill avenue",
               "storeCity": "London"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "1700000",
               "salesTotal": "2300000",
               "revenueTotal": "600000",
               "averageEmployees": "13.0",
               "averageEmployeesHours": "39",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "850000",
                   "sales": "1170000",
                   "revenue": "320000",
                   "employees": "14",
                   "employeesHoursSum": "39"
               }, {
                   "date": "2013-07-02",
                   "cost": "850000",
                   "sales": "1130000",
                   "revenue": "280000",
                   "employees": "12",
                   "employeesHoursSum": "39"
               }]
           }
       }, {
           "store": {
               "storeId": "5000",
               "storeName": "Store 5",
               "storePhone": "+33 78 432-98765",
               "storeAddress": "Le Big Mac Rue",
               "storeCity": "Paris"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "1900000",
               "salesTotal": "2500000",
               "revenueTotal": "600000",
               "averageEmployees": "16.0",
               "averageEmployeesHours": "37",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "950000",
                   "sales": "1280000",
                   "revenue": "330000",
                   "employees": "16",
                   "employeesHoursSum": "37"
               }, {
                   "date": "2013-07-02",
                   "cost": "950000",
                   "sales": "1220000",
                   "revenue": "270000",
                   "employees": "16",
                   "employeesHoursSum": "37"
               }]
           }
       }, {
           "store": {
               "storeId": "6000",
               "storeName": "Store 6",
               "storePhone": "+49 54 7624214",
               "storeAddress": "Bier strasse",
               "storeCity": "Berlin"
           },
           "data": {
               "startDate": "2013-07-01",
               "endDate": "2013-07-02",
               "costTotal": "1800000",
               "salesTotal": "2200000",
               "revenueTotal": "400000",
               "averageEmployees": "11.0",
               "averageEmployeesHours": "39",
               "dayData": [{
                   "date": "2013-07-01",
                   "cost": "900000",
                   "sales": "1100000",
                   "revenue": "200000",
                   "employees": "12",
                   "employeesHoursSum": "39"
               }, {
                   "date": "2013-07-02",
                   "cost": "900000",
                   "sales": "1100000",
                   "revenue": "200000",
                   "employees": "10",
                   "employeesHoursSum": "39"
               }]
           }
       }],
       "_links": {
           "self": {
               "href": "/storedata/between/2013-07-01/2013-07-02"
           }
       }
   };

});
