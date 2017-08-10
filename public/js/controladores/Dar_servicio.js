var app = angular.module('Mutual', ['ngMaterial']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('Dar_servicio', function($scope, $http, $compile, $q) {
$scope.vencimiento = moment().add(1, 'month').calendar();
$scope.vencimiento = moment().format('L');
	$scope.mostrar = false;
	// machea a los socios en base al searchText
	$scope.query = function(searchText, ruta)
	{
		return $http({
			url: 'dar_servicio/'+ruta,
			method: 'post',
			data: {'nombre' : searchText}
			}).then(function successCallback(response)
				{
					return response.data;
				}, function errorCallback(data){
					console.log(data);
				});
	}

 	$scope.traerProductos = function(searchText)
 	{
 		console.log($scope.proovedor);
 		return $http({
			url: 'productos/TraerProductos',
			method: 'post',
			data: {'nombre': searchText, 'proovedor': $scope.proovedor.id}
			}).then(function successCallback(response)
				{
					console.log(response);
					return response.data;

				}, function errorCallback(data){
					console.log(data);
				});
 	}

 	$scope.crearMovimiento = function()
 	{
 		console.log($('#vencimiento').val());
 		var vencimiento = $('#vencimiento').val();
 		$http({
			url: 'ventas',
			method: 'post',
			data: {'id_asociado': $scope.socio.id, 'id_producto': $scope.producto.id, 'importe': $scope.importe, 'nro_cuotas': $scope.nro_cuotas, 'tipo':$scope.tipo_servicio, 'fecha_vencimiento':vencimiento, 'plata_recibida':$scope.$parent.plata_recibida}
			}).then(function successCallback(response)
				{
					console.log(response);
					return response.data;

				}, function errorCallback(data){
					console.log(data);
				});
 	}
 	$scope.habilitacion = true;
 	$scope.habilitar = function()
 	{	
 		
 		if($scope.proovedor == null)
 		{
 			$scope.habilitacion = true;
 		} else {
 			$scope.habilitacion = false;
 			$scope.producto = '';
 		}
 	}
 	$scope.mostrarPlanDePago = function()
 	{
 		$scope.mostrar = true;
 		var planDePago = [];
 		var importe = $scope.importe / $scope.nro_cuotas;
 		var vto = moment($scope.vencimiento);
 		console.log(vto);
 		for(var i=0; i < $scope.nro_cuotas; i++){
 			
 			/*console.log($scope.vencimiento);
 			planDePago.push($scope.vencimiento);
 			console.log(planDePago);
 			$scope.vencimiento.addDays(30);
 			console.log($scope.vencimiento);*/
 		var j = vto.format("DD/MM/YYYY");
 			 			
 			var objeto = {'cuota': i+1, 'importe': importe, 'fecha': j};
 			planDePago.push(objeto);
 			vto.add(30, 'd');
 		}
 		$scope.planDePago = planDePago;
 		
 	}
	
});