<!DOCTYPE html>
<html lang="en" ng-app="Login">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        {!! Html::script('js/angular.min.js') !!}
    	{!! Html::script('js/controladores/login.js') !!}
    	{!! Html::style('css/bootstrap.min.css') !!}
      {!! Html::style('fonts/css/font-awesome.min.css') !!}
        {!! Html::script('js/jquery.min.js') !!}
        {!! Html::style('http://fonts.googleapis.com/css?family=Roboto:400,100,300,500') !!}
        {!! Html::style('css/loginCss/form-elements.css') !!}
        {!! Html::style('css/loginCss/style.css') !!}
        {!! Html::script('js/loginJs/scripts.js') !!}
        {!! Html::script('js/loginJs/jquery.backstretch.min.js') !!}
        {!! Html::script('js/loginJs/jquery-1.11.1.min.js') !!}
        {!! Html::script('js/serviceslogin.js') !!}

        <!-- CSS -->
        <!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css"> -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body ng-controller="loguear">
    <center>
<div id="ContenedorMensaje" style="color: white; margin-left: 25%; margin-top: 20px; width: 50%; height: 150px; z-index: 1000000; position: fixed;" hidden>
      ACA VA EL MENSAJE
</div>
<!--<div id="LoadingGlobal" style="background-color: rgba(255, 255, 255, 0.9); position: fixed; width: 100%; height: 100%;" hidden>-->
  <div id="LoadingGlobal" style="background-color: rgba(255, 255, 255, 0.7); width: 100%; height: 100%; z-index: 10000000000; position: fixed;" hidden>
  <div style="margin-top: 20%; color: black;">
       <span style="font-size: 30pt; color: black;">CARGANDO</span></br></br>
          <i style="font-size: 40pt;" class="fa fa-spinner fa-pulse fa-fw"></i>
  </div>
  </div>
<!--</div>-->
</center>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>
                              <i class="fa fa-briefcase" aria-hidden="true"></i>
                              <strong>Mutual</strong>system
                            </h1>

                            <div class="description">
                            	<p>
	                            	Sistema integral de informacion
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                Ingresar a la aplicacion</h3>
                            		<p>Ingresá tu usuario y contraseña para entrar:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
                              @verbatim
			                    <form role="form" class="login-form" id="formulario" ng-submit="enviarFormulario()">

                            {{ csrf_field() }}
			                    	<div class="form-group">
			                    		<label class="sr-only" for="email">Email</label>
			                        	<input id="email" type="text" name="email" placeholder="Email..." class="form-username form-control" >{{errores.email[0]}}
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="password">Contraseña</label>
			                        	<input id="password" type="password" name="password" placeholder="Contraseña..." class="form-password form-control" >{{errores.password[0]}}
			                        </div>
			                        <button  id="send"  type="submit" class="btn btn-primary" style="background: #1479B8">Ingresar!</button>

			                    </form>
                          @endverbatim
		                    </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<h3>...or login with:</h3>
                        	<div class="social-login-buttons">
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-facebook"></i> Facebook
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-twitter"></i> Twitter
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-google-plus"></i> Google Plus
	                        	</a>
                        	</div>
                        </div>
                    </div> -->
                </div>
            </div>

        </div>


        <!-- Javascript -->
        <script src="js/loginJs/jquery-1.11.1.min.js"></script>
        <script src="css/bootstrap.min.css"></script>
        <script src="js/loginJs/jquery.backstretch.min.js"></script>
        <script src="js/loginJs/scripts.js"></script>

        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
