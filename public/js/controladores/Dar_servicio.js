var app = angular.module('Mutual',  ['ngMaterial','Mutual.services']).config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('Dar_servicio', function($scope, $http, $compile, $q, UserSrv) {
  //moment.locale('es');

  $scope.vencimiento = new Date(moment().startOf('month').add(24, 'days').add(2, 'months').format('YYYY-MM-DD'));
  $scope.fechaActual = moment().format('YYYY-MM-DD');
  $scope.mostrar = false;
  
  $scope.getImporte = function(){
    $scope.importe = Number(($scope.montoPorCuota * $scope.nro_cuotas).toFixed(2));
  }
  // machea a los socios en base al searchText
  $scope.query = function(searchText, ruta) {
    return $http({
      url: 'dar_servicio/' + ruta,
      method: 'post',
      data: {
        'nombre': searchText
      }
    }).then(function successCallback(response) {
      console.log(response);
      return response.data;

    }, function errorCallback(data) {
      console.log(data);
    });
  }

  $scope.traerProductos = function(searchText) {
    console.log($scope.proovedor);
    return $http({
      url: 'productos/TraerProductos',
      method: 'post',
      data: {
        'nombre': searchText,
        'proovedor': $scope.proovedor.id
      }
    }).then(function successCallback(response) {
      console.log(response);
      return response.data;

    }, function errorCallback(data) {
      console.log(data);
    });
  }

  $scope.refrescarPantalla = function() {
    $scope.socio = '';
    $scope.proovedor = '';
    $scope.producto = '';
    $scope.importe = '';
    $scope.montoPorCuota = '';
    $scope.nro_cuotas = '';
    $scope.observacion = '';

  }


  $scope.crearMovimiento = function() {
    var vencimiento = moment($scope.vencimiento, "DD/MM/YYYY").format('YYYY-MM-DD');

    $http({
      url: 'ventas',
      method: 'post',
      data: {
        'id_asociado': $scope.socio.id,
        'id_producto': $scope.producto.id,
        'importe': $scope.importe,
        'nro_cuotas': $scope.nro_cuotas,
        'fecha_vencimiento': vencimiento,
        'plata_recibida': $scope.$parent.plata_recibida
      }
    }).then(function successCallback(response) {
      console.log(response);
      $scope.refrescarPantalla();
      UserSrv.MostrarMensaje("OK","Se ha otorgado el servicio correctamente.","OK","mensaje");
      return response.data;

    }, function errorCallback(data) {
      console.log(data);
    });
  }

  $scope.habilitacion = true;
  $scope.habilitar = function() {
    if ($scope.proovedor == null) {
      $scope.habilitacion = true;
      $scope.producto = '';
    } else {
      $scope.habilitacion = false;

    }
  }
  $scope.mostrarPlanDePago = function() {
    $scope.mostrar = true;
    var planDePago = [];
    var importe = $scope.importe / $scope.nro_cuotas;
    importe = importe.toFixed(2);
    moment.locale('es')
    var vto = moment($scope.vencimiento, "DD/MM/YYYY");
    console.log(vto);
    for (var i = 0; i < $scope.nro_cuotas; i++) {

      /*console.log($scope.vencimiento);
      planDePago.push($scope.vencimiento);
      console.log(planDePago);
      $scope.vencimiento.addDays(30);
      console.log($scope.vencimiento);*/

      var objeto = {
        'cuota': i + 1,
        'importe': importe,
        'fecha': vto.format('L')
      };
      planDePago.push(objeto);
      vto.add(1, 'months');
    }
    $scope.planDePago = planDePago;

  }

});
