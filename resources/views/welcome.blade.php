<!DOCTYPE html>
<html lang="en" ng-app="Mutual">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title> Mutual </title>
  <!-- Bootstrap core CSS -->
{!! Html::style('js/angular-material/angular-material.min.css') !!}
  {!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('fonts/css/font-awesome.min.css') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=PT+Sans+Caption') !!}

  {!! Html::style('css/animate.min.css') !!}
{!! Html::script('js/moment/moment.min.js') !!}
  <!-- Custom styling plus plugins -->

  {!! Html::style('css/custom.css') !!}
  {!! Html::style('css/icheck/flat/green.css') !!}
  {!! Html::style('css/barrow.css') !!}
  {!! Html::style('css/floatexamples.css') !!}
  {!! Html::style('css/ng-table.min.css') !!}
  {!! Html::style('css/bootstrap-notifications-master/dist/stylesheets/bootstrap-notifications.min.css') !!}

  {!! Html::script('js/jquery.min.js') !!}

   {!! Html::script('js/jquery-ui-1.12.1/jquery-ui.min.js') !!}
   {!! Html::style('js/jquery-ui-1.12.1/jquery-ui.min.css') !!}

    {!! Html::script('js/angular.min.js') !!}
    {!! Html::script('js/nprogress.js') !!}
  {!! Html::script('js/misFunciones.js') !!}
  {!! Html::script('js/angular-animate/angular-animate.min.js') !!}
  {!! Html::script('js/ng-table.min.js') !!}

  {!! Html::script('js/angular-aria/angular-aria.min.js') !!}
{!! Html::script('js/angular-messages/angular-messages.min.js') !!}
{!! Html::script('js/angular-material/angular-material.min.js') !!}

{!! Html::script('js/angular-sanitize/angular-sanitize.min.js') !!}
{!! Html::script('js/services.js') !!}
{!! Html::script('js/vue-resource/dist/vue-resource.min.js') !!}
{!! Html::script('js/alasql.min.js') !!}
{!! Html::script('js/xlsx.core.min.js') !!}





  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
</script>
</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">
<center>

<div id="ContenedorMensaje" style="margin-left: 25%; margin-top: 20px; width: 50%; height: 150px; z-index: 1000000; position: fixed;" hidden>
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
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Mutual</span></a>
          </div>
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido, {{Sentinel::check()->usuario}} {{\App\Repositories\Eloquent\ControlFechaContable::getFecha() }}</span>
              <h2></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">

                <li><a><i class="fa fa-edit"></i> ABM <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="asociados">Socios</a>
                      </li>
                      <li><a href="organismos">Organismos</a>
                      </li>
                      <li><a href="proovedores">Proovedores</a></li>
                      <li><a href="productos">Productos</a></li>
                      <li><a href="usuarios">Usuarios</a></li>
                      <li><a href="roles">Roles</a></li>
                      <li><a href="abm_comercializador">Comercializador</a></li>
                      <li><a href="bancos">Bancos</a></li>

                  </ul>
                </li>
                  <li><a><i class="fa fa-bank"></i> Cuentas Corrientes <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="ventas">CC Servicios/Prestamos</a>
                    </li>
                    <li><a href="cc_cuotasSociales">CC Cuotas Sociales</a>
                    </li>
                  </ul>
                </li>
                  <li><a><i class="fa fa-dollar"></i> Cobros <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="cobrar">Cobrar Servicios/Prestamos</a>
                    </li>
                    <li><a href="cobroCuotasSociales">Cobrar Cuotas Sociales</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-gears"></i> Gestion de cobranza <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="dar_servicio">Alta Gestion Servicio/Prestamo</a>
                    </li>
                    <li><a href="aprobacion">Aprobacion Servicio/Prestamo</a>
                    </li>
                  </ul>
                </li>
                 <li><a><i class="fa fa-briefcase"></i> Agente Financiero <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="agente_financiero">Solicitudes</a>
                    </li>


                      <li><a href="proveedorCC">Cuenta Corriente</a>
                      </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-area-chart"></i> Contabilidad <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="capitulo">Plan de cuentas</a>
                      <li><a href="asientos">Asientos Contables Manuales</a>
                      </li>
                      <li><a href="cobrar_contablemente">Cobrar contablemente</a></li>
                      <!-- <li><a href="rubro">Rubros</a>
                      </li>
                      <li><a href="moneda">Monedas</a></li>
                      <li><a href="departamento">Departamentos</a></li>
                      <li><a href="subRubro">SubRubros</a></li>
                      <li><a href="imputacion">Imputaciones</a></li> -->

                  </ul>
                </li>

                  </li>
                  <li><a href="comercializador"><i class="fa fa-pencil"></i>Generar Solicitud</a>
                  </li>

                  <li><a href="solicitudesPendientesMutual"><i class="fa fa-clock-o"></i>Solicitudes Pendientes</a>
                  </li>
                  <li><a href="correrVto"><i class="fa fa-calendar"></i>Correr Vto Servicio/Prestamo</a>
                  </li>
                  <li><a href="pago_proovedores"><i class="fa fa-money" ></i> Pago proveedores</a>
                  <!-- <li><a type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-calendar-check-o" ></i> Fecha contable</a> -->
                    <li><a><i class="fa fa-calendar-times-o" ></i> Cerrar fecha</a>
              </ul>
            </div>



          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer " style="background-color: #0f5ead;">
            <a data-toggle="tooltip" data-placement="top" title="Settings"  style="background-color: #106cc8; color:#e4e5e7;">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen" style="background-color: #106cc8; color:#e4e5e7;">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock" style="background-color: #106cc8; color:#e4e5e7;">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" href="logout" data-placement="top" title="Salir" style="background-color: #106cc8; color:#e4e5e7;">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu" style="border:none;">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle" style="color:#0f5ead; "><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/img.jpg" alt="">
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="javascript:;">  Profile</a>
                  </li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:;">Help</a>
                  </li>
                  <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>



              <div id="app">

                    <example id_usuario="11"></example>
                  </div>


            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main" >
        <div id="app">

<example></example>
        </div>
        @yield('contenido')
      </div>
      <!-- /page content -->

    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>





  <!-- bootstrap progress js -->
  {!! Html::script('js/progressbar/bootstrap-progressbar.min.js') !!}
{!! Html::script('js/wizard/jquery.smartWizard.js') !!}

  <!-- chart js -->
 {!! Html::script('js/custom.js') !!}
 {!! Html::script('js/app.js') !!}


 <!-- Modal -->
<div >
  <div class="modal fade" id="myModal"  role="dialog"  data-backdrop="false">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Fecha contable</h4>
        </div>
        <div class="modal-body">

          <form class="form-horizontal form-label-left">
            <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha</label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <input class="form-control col-md-7 col-xs-12" ng-model="fechaContable" type="date">
             </div>
           </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-success" ng-click="guardarFechaContable(fechaContable)">Guardar</button>
            </div>
          </div>
        </form>

        </div>

      </div>
    </div>
  </div>
</div>

<!-- <script type="text/javascript">
var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable', 'Mutual.services']).config(function($interpolateProvider) {});

app.controller('fechaContable', function($scope, $http, $compile, $sce, NgTableParams, $filter, UserSrv) {

  // manda las solicitud http necesarias para manejar los requerimientos de un abm



  $scope.submit = function(fechaContable) {

    var data = {
      'fecha': fechaContable,
    };

    return $http({
      url: 'fechaContable',
      method: 'post',
      data: data,

    }).then(function successCallback(response) {
      UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
    }, function errorCallback(response) {
      console.log("Error")
    });

  }

});

</script> -->

  <script>
    NProgress.done();
  </script>
  <!-- /datepicker -->
  <!-- /footer content -->

  <div ng-controller="Serviced">
    <div id="prompted" class="modal fade" role="dialog" >
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Descargar como Excel</h4>
        </div>
        <div class="modal-body">
        <form ng-submit="$Servicio.Excel2(nombreexcel)">
          <div class="input-group" style="width: 80%;">

            <input type="password" class="form-control" id="pass" name="pass" placeholder="Nombre del archivo.." aria-describedby="basic-addon1" ng-model="nombreexcel">
            <span class="input-group-btn"><button class="btn btn-primary" type="submit" style="" ><span class="fa fa-file-excel-o"></span> DESCARGAR</button></span>
          </div>

        </div>
      </div>
      </form>
    </div>
  </div>


  </div>



</body>

</html>
