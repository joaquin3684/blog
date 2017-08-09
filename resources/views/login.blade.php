<!DOCTYPE html>
<html lang="en" ng-app="Login">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
    {!! Html::script('js/angular.min.js') !!}
	{!! Html::script('js/controladores/login.js') !!}
	{!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('fonts/css/font-awesome.min.css') !!}
    {!! Html::script('js/jquery.min.js') !!}
</head>
<body ng-controller="loguear">
	<div class="container">
		<div class="panel-group">
    		<div class="panel panel-default">
      			<div class="panel-heading">Login</div>
      			<div class="panel-body">
      				<form class="form-horizontal" id="formulario" ng-submit="enviarFormulario()">
      				{{ csrf_field() }}
      					<div class="item form-group">
                      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                      		</label>
                      		<div class="col-md-6 col-sm-6 col-xs-12">
                        		<input id="usuario" class="form-control col-md-7 col-xs-12" name="usuario" placeholder="Ingrese usuario del organismo" type="text">{[{errores.usuario[0]}]}
                      		</div>
                    	</div>
                    
                     	 <div class="item form-group">
                      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
                      		</label>
                      		<div class="col-md-6 col-sm-6 col-xs-12">
                        		<input type="text" id="password" name="password" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el password">{[{errores.password[0]}]}
                      		</div>
                    	</div>
                    	 <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button id="send" type="submit" class="btn btn-success">Ingresar</button>
                      </div>
                    </div>
      				</form>
      			</div>
    		</div>
		</div>
	</div>
</body>
</html>