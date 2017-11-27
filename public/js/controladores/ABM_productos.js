
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});
app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv,clonarHtmlService) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
  };

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
             $scope.proovedores = response.data;
             console.log("Relaciones:")
            console.log(response);
              // $.each(response.data, function(val, text) {
              //    console.log(relaciones[x].select);
              //    $(relaciones[x].select).append($("<option />").val(text.id).text(text.nombre));
              //    $(relaciones[x].select+'_Editar').append($("<option />").val(text.id).text(text.nombre));
              // });
           }, function errorCallback(data)
           {
              console.log(data);
           });
        }
     }

    $scope.$Servicio = UserSrv;
     $scope.ExportarPDF = function(pantalla) {UserSrv.ExportPDF(pantalla);}
     $scope.Impresion = function() {
       var divToPrint=document.getElementById('exportTable');
       var tabla=document.getElementById('tablita').innerHTML;
       var newWin=window.open('','sexportTable');

       newWin.document.open();
       var code = '<html><link rel="stylesheet" href="js/angular-material/angular-material.min.css"><link rel="stylesheet" href="css/bootstrap.min.css"<link rel="stylesheet" href="fonts/css/font-awesome.min.css"><link rel="stylesheet" href="ss/animate.min.css"><link rel="stylesheet" href="css/custom.css"><link rel="stylesheet" href="css/icheck/flat/green.css"><link rel="stylesheet" href="css/barrow.css"><link rel="stylesheet" href="css/floatexamples.css"><link rel="stylesheet" href="css/ng-table.min.css"><link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css"><body onload="window.print()"><table ng-table="paramsABMS" class="table table-hover table-bordered">'+tabla+'</table></body></html>';
       newWin.document.write(code);
       newWin.document.getElementById('botones').innerHTML = '';

       newWin.document.close();
     };

  $scope.submit = function() {

    var data = {
      'nombre': $scope.nombre,
      'descripcion': $scope.descripcion,
      'ganancia': $scope.ganancia,
      'id_proovedor': $scope.id_proovedor,
      'tasa': $scope.tasa,
      'tipo': $scope.tipo,
      'porcentajes': $scope.porcentajes,
    };

    return $http({
      url: 'productos',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
      $scope.traerElementos();
      $scope.borrarFormulario();
      $scope.porcentajes = [{
         'desde': '',
        'hasta': '',
         'porcentaje' : '',
      }];
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function() {

    return $http({
      url: "productos/traerElementos",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
          console.log("Productos:");
            console.log(response.data);
            $scope.datosabm = response.data;
            $scope.paramsABMS = new NgTableParams({
              page: 1,
              count: 10
            }, {
              getData: function(params) {
                var filterObj = params.filter();
                filteredData = $filter('filter')($scope.datosabm, filterObj);
                var sortObj = params.orderBy();
                orderedData = $filter('orderBy')(filteredData, sortObj);
                $scope.datosabmfiltrados = orderedData;
                $scope.paramsABMS.total(orderedData.length);
                return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
              }
            });
          }


      }, function errorCallback(response) {

      });
  }

  $scope.traerElementos();

  $scope.traerElemento = function(id) {

    return $http({
      url: 'productos/'+ id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      $scope.abmConsultado = response.data;
      console.log("Producto");
      console.log(response);
    }, function errorCallback(response) {

    });
  }

  $scope.editarFormulario = function (id) {

    var data = {
      'nombre': $scope.abmConsultado.nombre,
      'descripcion': $scope.abmConsultado.descripcion,
      'ganancia': $scope.abmConsultado.ganancia,
      'tasa': $scope.abmConsultado.tasa,
      'id_proovedor': $scope.abmConsultado.id_proovedor,
      'tipo': $scope.abmConsultado.tipo,
      'porcentajes': $scope.abmConsultado.porcentajes,
    };
    return $http({
      url: 'productos/'+ id,
      method: 'put',
      data: data,
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al editar");
      $('#editar').modal('toggle');
    }, function errorCallback(response) {

    });

  }

  $scope.borrarElemento = function (id) {

    return $http({
      url: 'productos/'+ id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      $scope.borrarFormulario();
      console.log("Exito al eliminar");
    }, function errorCallback(response) {

    });
  }

  $scope.asignarDesde = function(indice, primero, destino){
    if(!primero){
      destino[indice].desde = destino[indice-1].hasta;
    }
  };

  $scope.porcentajes = [{
     'desde': '',
    'hasta': '',
     'porcentaje' : '',
  }];

  $scope.eliminarHtml = function (clon, array){

    var algo = $(clon);

  algo[$(clon).length -1].remove();
  array.pop();
  };

  $scope.agregarHtml = function (destino){

    destino.push({
      'desde': '',
      'hasta' : '',
      'porcentaje' : '',
    })
  };

  // var cantComponentes = 1;
  //   $scope.agregarHtml = function(id) {
  //   var htmlClonado = clonarHtmlService.clonarHtml("#aClonar");
  //   htmlClonado.find('#desde').html('<input type="number"   ng-model="porcentajes['+cantComponentes+'].desde" ng-init="porcentajes['+cantComponentes+'].desde = porcentajes['+(cantComponentes-1)+'].hasta" class="form-control col-md-2 col-xs-12" disabled placeholder="Desde">');
  //   htmlClonado.find('#hasta').html('<input type="number"   ng-model="porcentajes['+cantComponentes+'].hasta" class="form-control col-md-2 col-xs-12" placeholder="Hasta">');
  //   htmlClonado.find('#porc').html('<input type="number" step="0.01" ng-model="porcentajes['+cantComponentes+'].porcentaje" class="form-control col-md-2 col-xs-12" placeholder="Porcentaje">');
  //   var compilado = $compile(htmlClonado.html())($scope);
  //   $('#'+id+'').append(compilado);
  //
  //
  //   cantComponentes +=1;
  //
  // }
});
