
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});
app.directive('exportToCsv',function(){
    return {
        restrict: 'A',
      
        link: function (scope, element, attrs) {
        function stringify(str){
          return '"' +str.replace(/^\s\s*/, '').replace(/\s*\s$/,                       '').replace(/"/g, '""') +'"';
        }
            var el = element[0];
            element.bind('click', function(e){
                var table = e.target.nextElementSibling;
                var csvString = '';
                for(var i=3; i<table.rows.length;i++){
            var rowData = table.rows[i].cells;
            for(var j=0; j<rowData.length;j++){
              if(rowData[j].innerHTML.indexOf('<a href')>-1){
                  var ele = angular.element(rowData[j]);
                  for(var k=0; k<ele[0].childNodes.length;k++){
                    if(ele[0].childNodes[k].tagName == 'A'){
                      csvString = csvString + stringify(ele[0].childNodes[k].innerText) + ",";
                    }
                 }
              }else if(rowData[j].innerHTML.indexOf('<em')>-1 || rowData[j].innerHTML.indexOf('<strong>')>-1){
                  var ele = angular.element(rowData[j]);
                  csvString = csvString + stringify(ele[0].textContent) + ",";
              }else{
                 csvString = csvString + stringify(rowData[j].innerHTML) + ",";
              }
            }
                csvString = csvString.substring(0,csvString.length - 1);
                csvString = csvString + "\n";
                }
          console.log(csvString);
                csvString = csvString.substring(0, csvString.length - 1);
                // alert(csvString);
                var a = $('<a/>', {
                style:'display:none',
                href:'data:application/csv;base64,'+btoa(csvString),
                download:'emailStatistics.csv'
                }).appendTo('body')
                a[0].click()
                a.remove();
            });
        }
    }
    });

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
      'cuota_social': $scope.cuotas,
    };

    return $http({
      url: 'organismos',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      $scope.traerElementos();
      $scope.borrarFormulario();
      $scope.cuotas = [{
        'categoria': '',
        'valor': ''
      }]
    }, function errorCallback(response) {
      $scope.errores = response.data;
    });

  }

  $scope.traerElementos = function() {

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
              total: $scope.datosabm.length,
              getData: function(params) {
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

      });
  }

  $scope.traerElementos();

  $scope.traerElemento = function(id) {

    return $http({
      url: 'organismos/'+ id,
      method: 'get',
      // data: data,
    }).then(function successCallback(response) {
      $scope.abmConsultado = response.data;
      $scope.nombreedi = response.data.nombre;
        $scope.variablepepe = "pepe";
      console.log($scope.abmConsultado);
      console.log($scope.nombreedi);
    }, function errorCallback(response) {

    });
  }

  $scope.editarFormulario = function (id) {

    var data = {
      'nombre': $scope.abmConsultado.nombre,
      'cuit': $scope.abmConsultado.cuit,
      'cuota_social': $scope.abmConsultado.cuotas,
      'id': $scope.abmConsultado.id,
    };
    return $http({
      url: 'organismos/'+ id,
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
      url: 'organismos/'+ id,
      method: 'delete',
    }).then(function successCallback(response) {
      $scope.traerElementos();
      console.log("Exito al eliminar");
    }, function errorCallback(response) {

    });
  }


  $scope.cuotas = [{
    'categoria': '',
    'valor': ''
  }]
  var cantComponentes = 1
    $scope.agregarHtml = function(destino) {

      destino.push({
        'categoria': '',
        'valor' : ''
      })

  }

  $scope.eliminarHtml = function (clon, array){

    var algo = $(clon);

  algo[$(clon).length -1].remove();
  array.pop();
};


});
