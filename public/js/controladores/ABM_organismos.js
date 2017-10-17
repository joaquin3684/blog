
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});
app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv,clonarHtmlService) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function(){
    $('#formulario')[0].reset();
  };

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
      'cuit': $scope.cuit,
      'cuota_social': $scope.cuentaCorriente,
    };

    return $http({
      url: 'abm_organismos',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.traerElementos();
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function() {

    return $http({
      url: "abm_organismos/organismos",
      method: "get",
    }).then(function successCallback(response) {
        if (typeof response.data === 'string') {
          return [];
        } else {
            console.log(response.data);
            $scope.datosabm = response.data;
            $scope.paramsABMS = new NgTableParams({
              page: 1,
              count: 10
            }, {
              total: $scope.datosabm.length,
              getData: function(params) {
                var filterObj = params.filter();
                filteredData = $filter('filter')($scope.datosabm, filterObj);
                var sortObj = params.orderBy();
                orderedData = $filter('orderBy')(filteredData, sortObj);
                $scope.datosabmfiltrados = orderedData;
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
      url: 'abm_organismos/'+ id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      $scope.abmConsultado = response.data;
    }, function errorCallback(response) {

    });
  }

  $scope.editarFormulario = function (id) {

    var data = {
      'nombre': $scope.abmConsultado.nombre,
      'cuit': $scope.abmConsultado.cuit,
      'cuota_social': $scope.abmConsultado.cuentaCorriente,
    };
    return $http({
      url: 'abm_organismos/'+ id,
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
      url: 'abm_organismos/'+ id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al eliminar");
    }, function errorCallback(response) {

    });
  }

  $scope.cuentaCorriente = []
  var cantComponentes = 1
    $scope.agregarHtml = function() {
    var htmlClonado = clonarHtmlService.clonarHtml("#aClonar");
    htmlClonado.find('#categoria').html('<input type="number" class="form-control col-md-2 col-xs-12" placeholder="Categoria" ng-model="cuentaCorriente['+cantComponentes+'].categoria">{{errores.cuota_social[0]}}');
    htmlClonado.find('#valor').html('<input type="number" step="0.01" class="form-control col-md-2 col-xs-12" placeholder="Valor" ng-model="cuentaCorriente['+cantComponentes+'].valor">{{errores.cuota_social[0]}}');
    var compilado = $compile(htmlClonado.html())($scope);
    $('#loadhtml').append(compilado);

    cantComponentes +=1;

  }
});
