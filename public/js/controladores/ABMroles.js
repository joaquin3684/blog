var app = angular.module('Mutual').config(function ($interpolateProvider) {});
app.requires.push('ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services', 'ServicioABM', 'angular-loading-bar');
app.controller('ABM_roles', function ($scope, $http, $compile, $sce, NgTableParams, $filter, $timeout, ServicioABM, UserSrv) {

  $scope.borrarFormulario = function () {
    $('#formulario')[0].reset();
    $scope.permisos = [];
  };

  $scope.create = function () {
    var metodo = 'post';
    var form = $("#formulario").serializeArray();
    var url = 'roles';
    var data = $.param(form);
    $http({
      url: url,
      method: metodo,
      data: data,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    }).then(function successCallback(response) {

      $scope.mensaje = response;
      $('#formulario')[0].reset();

      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");

      $scope.errores = '';
      console.log(response.data);
      $scope.permisos = [];
      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");
      pull('roles/traerRoles', 'roles', 'paramsABMS');
    }, function errorCallback(data) {
      UserSrv.MostrarError(data);
      console.log(data);
      $scope.errores = data.data;
    });



  };

  var generarPermisos = function (rol) {
    var permisos = [];
    keys = Object.keys(rol.permissions);
    valores = Object.values(rol.permissions);
    var pantalla = {};
    var nombrePantalla = '';
    var largo = keys.length;
    for (var index = 0; index < largo; index++) {
      console.log(keys[index]);
      console.log(keys.length);
      console.log(index);
      var nombre = keys[index].substring(0, keys[index].indexOf('.'));
      var permiso = keys[index].substring(keys[index].indexOf('.') + 1, keys[index].lenght);
      if (nombre != nombrePantalla) {
        if (nombrePantalla != '') {
          permisos.push(pantalla);
          var pantalla = new Object;
        }
        pantalla.nombre = nombre;
        pantalla[permiso] = valores[index];

      } else {
        pantalla[permiso] = valores[index];
      }
      nombrePantalla = nombre;
    }
    permisos.push(pantalla);
    return permisos;
  };
  var mapearRol = function (rol, roles) {
    permisos = generarPermisos(rol);
    roles.push({
      'nombre': rol.name,
      'pantallas': permisos,
      'cantPantallas': permisos.length
    });
  };
  var pull = function (url, scopeObj, params) {
    ServicioABM.pull(url).then(function (returnedData) {
      var roles = [];
      var permisos = [];

      returnedData.forEach(rol =>
        mapearRol(rol, roles)
      );
      $scope[scopeObj] = roles;
      $scope[params] = ServicioABM.createTable(roles);
      console.log(roles);
    });
  };

  $scope.seleccionarRol = function () {
    $scope.rolSeleccionado = this.abm;
  };
  $scope.permisos = [];
  $scope.agregarPantalla = function () {
    $scope.permisos = [];
    for (let index = 0; index < $scope.numeroDePantallas; index++) {
      $scope.permisos.push([]);
    }
  };

  pull('roles/traerRoles', 'roles', 'paramsABMS');
  $http({
    url: 'roles/traerRelacionroles',
    method: 'get',
  }).then(function successCallback(response) {
    $scope.pantallas = response.data;
  });
});