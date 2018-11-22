var app = angular.module('Mutual').config(function ($interpolateProvider) {});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'verificarBaja', 'angular-loading-bar');

app.controller('ABM', function ($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv, clonarHtmlService) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm

  $scope.borrarFormulario = function () {
    $('#formulario')[0].reset();
  };

  $scope.$Servicio = UserSrv;
  $scope.ExportarPDF = function (pantalla) {
    UserSrv.ExportPDF(pantalla);
  }
  $scope.Impresion = function () {
    var divToPrint = document.getElementById('exportTable');
    var tabla = document.getElementById('tablita').innerHTML;
    var newWin = window.open('', 'sexportTable');

    newWin.document.open();
    var code = '<html><link rel="stylesheet" href="js/angular-material/angular-material.min.css"><link rel="stylesheet" href="css/bootstrap.min.css"<link rel="stylesheet" href="fonts/css/font-awesome.min.css"><link rel="stylesheet" href="ss/animate.min.css"><link rel="stylesheet" href="css/custom.css"><link rel="stylesheet" href="css/icheck/flat/green.css"><link rel="stylesheet" href="css/barrow.css"><link rel="stylesheet" href="css/floatexamples.css"><link rel="stylesheet" href="css/ng-table.min.css"><link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.min.css"><body onload="window.print()"><table ng-table="paramsABMS" class="table table-hover table-bordered">' + tabla + '</table></body></html>';
    newWin.document.write(code);
    newWin.document.getElementById('botones').innerHTML = '';

    newWin.document.close();
  };

  $scope.submit = function () {

    var data = {
      'nombre': $scope.nombre,
      'cuit': $scope.cuit,
      'domicilio': $scope.domicilio,
      'localidad': $scope.localidad,
      'cuota_social': $scope.cuotas,
      'gasto_cobranza': $scope.gasto_cobranza,
      'comision': $scope.comision
    };

    return $http({
      url: 'organismos',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.traerElementos();
      $scope.borrarFormulario();
      $scope.cuotas = [{
        //'categoria': '',
        'valor': ''
      }];
      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function () {

    return $http({
      url: "organismos/traerElementos",
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
          getData: function (params) {
            var filterObj = params.filter();
            filteredData = $filter('filter')($scope.datosabm, filterObj);
            var sortObj = params.orderBy();
            orderedData = $filter('orderBy')(filteredData, sortObj);
            $scope.datosabmfiltrados = orderedData;
            $scope.datatoexcel = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
            return orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());
          }
        });
      }


    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
  }

  $scope.traerElementos();

  $scope.traerElemento = function (id) {

    return $http({
      url: 'organismos/' + id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      $scope.abmConsultado = response.data;
      console.log($scope.abmConsultado);
      console.log($scope.nombreedi);
    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
  }

  $scope.editarFormulario = function (id) {

    var data = {
      'nombre': $scope.abmConsultado.nombre,
      'cuit': $scope.abmConsultado.cuit,
      'domicilio': $scope.abmConsultado.domicilio,
      'localidad': $scope.abmConsultado.localidad,
      'comision': $scope.abmConsultado.comision,
      'cuota_social': $scope.abmConsultado.cuotas,
      'gasto_cobranza': $scope.abmConsultado.gasto_cobranza,
      'id': $scope.abmConsultado.id,
    };
    return $http({
      url: 'organismos/' + id,
      method: 'put',
      data: data,
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al editar");
      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
      $('#editar').modal('toggle');
    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });

  }

  $scope.guardarDatosBaja = function () {
    $scope.elemABorrar = this.abm
  }
  $scope.delete = function (id) {
    $scope.borrarElemento(id)
  }
  $scope.borrarElemento = function (id) {

    return $http({
      url: 'organismos/' + id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
      console.log("Exito al eliminar");
    }, function errorCallback(response) {
      UserSrv.MostrarError(response)
    });
  }


  $scope.cuotas = [{
    'nombre': '',
    'valor': ''
  }]
  var cantComponentes = 1
  $scope.agregarHtml = function (destino) {

    destino.push({
      'nombre': '',
      'valor': ''
    })

  }

  $scope.eliminarHtml = (index) => $scope.cuotas.splice(index)



});