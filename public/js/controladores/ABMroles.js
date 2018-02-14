var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'ServicioABM', 'Mutual.services']).config(function ($interpolateProvider) {});
app.controller('ABM_roles', function ($scope, $http, $compile, $sce, NgTableParams, $filter, ServicioABM, UserSrv) {

  $scope.borrarFormulario = function () {
    $('#formulario2')[0].reset();
  };

  $scope.create = function () {

    var metodo = 'post';
    var form = $("#formulario").serializeArray();
    var url = 'roles'
    $http({
      url: url,
      method: metodo,
      data: $.param(form),
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    }).then(function successCallback(response) {

      $scope.mensaje = response;
      $('#formulario')[0].reset();
     
      UserSrv.MostrarMensaje("OK", "Operación ejecutada correctamente.", "OK", "mensaje");

      $scope.errores = '';
      console.log(response.data);
      pull('roles/traerRoles', 'roles', 'paramsABMS');
    }, function errorCallback(data) {
      console.log(data);
      $scope.errores = data.data;
    });



  }

  $scope.editarRol = function (id) {
    var data = {
      'nombre': $scope.bancoSeleccionado.nombre,
      'direccion': $scope.bancoSeleccionado.direccion,
      'sucursal': $scope.bancoSeleccionado.sucursal,
      'nro_cuenta': $scope.bancoSeleccionado.nro_cuenta
    }
    ServicioABM.push(data, 'bancos', id)
    $("#editar").modal('toggle')
    pull('bancos/traerElementos', 'bancos', 'paramsABMS');
  }
  $scope.traerRol = function (id) {
    pullElem('roles', 'rolSeleccionado', id);
  }

  var generarPermisos = function (rol) {
    var permisos = []
    keys = Object.keys(rol.permissions)
    valores = Object.values(rol.permissions)
    var pantalla = {}
    var nombrePantalla = ''
    for (let i = 0; i < keys.length; i++) {
      var nombre = keys[i].substring(0, keys[i].indexOf('.'))
      var permiso = keys[i].substring(keys[i].indexOf('.') + 1, keys[i].lenght)
      if (nombre != nombrePantalla) {
        if (nombrePantalla != '') {
          permisos.push(pantalla)
          var pantalla = new Object
        }

        pantalla.nombre = nombre
        pantalla[permiso] = valores[i]
      } else {
        pantalla[permiso] = valores[i]
      }
      nombrePantalla = nombre
    }
    return permisos
  }
  var pull = function (url, scopeObj, params) {
    ServicioABM.pull(url).then(function (returnedData) {
      var roles = []
      returnedData.forEach(rol =>
        roles.push({
          'nombre': rol.name,
          'pantallas': generarPermisos(rol)
        })
      )
      $scope[scopeObj] = roles
      $scope[params] = ServicioABM.createTable(roles)
      console.log(roles)
    });


  }

  $scope.seleccionarRol = function () {
    $scope.rolSeleccionado = this.abm
  }
  $scope.agregarPantalla = function () {

    var codigo = '';
    var array = [];
    for (var i = 0; $scope.numeroDePantallas > i; i++) {

      codigo += '<div class="item form-group" >' +
        '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni" ng-click="console.log(' + 'anda' + ')">Pantalla <span class="required">*</span></label>' +
        '<div class="col-md-6 col-sm-6 col-xs-12">' +
        '<select id="pantallas' + i + '" name="pantalla' + i + '" class="form-control col-md-7 col-xs-12" ></select>     </div>      </div>' +
        '<div style=" margin-bottom:20px;"><label class="checkbox-inline col-sm-offset-4 col-xs-offset-2"  ><input type="checkbox" value="crear" name="valor' + i + '[]">Crear</label> <label class="checkbox-inline"><input type="checkbox" value="editar" name="valor' + i + '[]">Editar</label> <label class="checkbox-inline"><input type="checkbox" value="borrar" name="valor' + i + '[]">Borrar</label> <label class="checkbox-inline"><input type="checkbox" name="valor' + i + '[]" value="visualizar">Visualizar</label> </div>';

    }
    //$scope.agregarCodigo = $sce.trustAsHtml(codigo);
    $('#agregarCodigo').html(codigo);

    var url = 'roles/traerRelacionroles';
    $http({
      url: url,
      method: 'get',
    }).then(function successCallback(response) {

      console.log(response);
      $.each(response.data, function (val, text) {

        for (var j = 0; $scope.numeroDePantallas > j; j++) {

          $('#pantallas' + j).append($("<option />").val(text.nombre).text(text.nombre));


        }

      });
    }, function errorCallback(data) {
      console.log(data);
    });
  }

  pull('roles/traerRoles', 'roles', 'paramsABMS');
});