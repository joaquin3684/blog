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
  {!! Html::script('js/angular.min.js') !!}
 
    {!! Html::script('js/jquery.min.js') !!}

   {!! Html::script('js/jquery-ui-1.12.1/jquery-ui.min.js') !!}
   {!! Html::style('js/jquery-ui-1.12.1/jquery-ui.min.css') !!}
     {!! Html::script('js/controladores/Mutual.js')!!} 
  <!-- Bootstrap core CSS -->
{!! Html::style('js/angular-material/angular-material.min.css') !!}
  {!! Html::style('css/bootstrap.min.css') !!}
  {!! Html::style('fonts/css/font-awesome.min.css') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=PT+Sans+Caption') !!}

  {!! Html::style('css/animate.min.css') !!}
{!! Html::script('js/moment/moment.min.js') !!}
{!! Html::style('js/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') !!}
  <!-- Custom styling plus plugins -->

  {!! Html::style('css/custom.css') !!}
  {!! Html::style('css/expandirImagen.css') !!}
  {!! Html::style('css/icheck/flat/green.css') !!}
  {!! Html::style('css/barrow.css') !!}
  {!! Html::style('css/floatexamples.css') !!}
  {!! Html::style('css/ng-table.min.css') !!}
  {!! Html::style('css/bootstrap-notifications-master/dist/stylesheets/bootstrap-notifications.min.css') !!}



    
    {!! Html::script('js/nprogress.js') !!}
  {!! Html::script('js/misFunciones.js') !!}
  {!! Html::script('js/angular-animate/angular-animate.min.js') !!}
  {!! Html::script('js/ng-table.min.js') !!}

  {!! Html::script('js/angular-aria/angular-aria.min.js') !!}
{!! Html::script('js/angular-messages/angular-messages.min.js') !!}
{!! Html::script('js/angular-material/angular-material.min.js') !!}

{!! Html::script('js/angular-sanitize/angular-sanitize.min.js') !!}
{!! Html::script('js/services.js') !!}
{!! Html::script('js/servicioABM.js') !!}
{!! Html::script('js/ManejoExcell.js') !!}
{!! Html::script('js/vue-resource/dist/vue-resource.min.js') !!}
{!! Html::script('js/alasql.min.js') !!}
{!! Html::script('js/xlsx.full.min.js') !!}
{!! Html::script('js/FileSaver.min.js') !!}

{!! Html::script('js/controladores/ejercicioController.js')!!}
{!! Html::script('js/controladores/ejercicio.js')!!}




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

<!-- Modal -->
<div ng-controller="fechaContable">
  @verbatim
 <div class="modal fade" id="fechaContable"  role="dialog"  data-backdrop="false">
   <div class="modal-dialog" role="document">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Fecha contable </h4>
       </div>
       <div class="modal-body">

         <form class="form-horizontal form-label-left">
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input class="form-control col-md-7 col-xs-12" ng-model="fechaContable" type="date" max="{{fechaACtual}}">
            </div>
          </div>
         <div class="ln_solid"></div>
         <div class="form-group">
           <div class="col-md-6 col-md-offset-3">
             <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
             <button type="button" class="btn btn-success" ng-click="submit(fechaContable)">Guardar</button>
           </div>
         </div>
       </form>

       </div>

     </div>
   </div>
 </div>
 @endverbatim
</div>


<body class="nav-md" >

  <div class="container body">


    <div class="main_container" >
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
      <div class="col-md-3 left_col menu_fixed" >
        <div class="left_col scroll-view" >

          <div class="navbar nav_title" style="border: 0;">
            <a href="" class="site_title"><i class="fa fa-briefcase"></i> <span>Mutual</span></a>
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
          <!-- <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="max-height: -webkit-fill-available; overflow-y: scroll;"> -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section" >
              <h3>General</h3>
              <ul class="nav side-menu" >
       
              @if(Sentinel::check()->hasAnyAccess(['socios.*', 'organismos.*', 'proveedores.*', 'organismos.*', 'proovedores.*', 'productos.*', 'usuarios.*', 'roles.*', 'comercializadores.*', 'bancos.*']))
                <li><a><i class="fa fa-edit"></i> ABM <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      @if(Sentinel::check()->hasAccess('socios.*')) 
                      <li><a href="asociados">Socios</a>
                      </li>
                      @endif
                      @if(Sentinel::check()->hasAccess('organismos.*'))
                      <li><a href="organismos">Organismos</a>
                      </li>
                      @endif
                      @if(Sentinel::check()->hasAccess('proovedores.*'))
                      <li><a href="proovedores">Proovedores</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('productos.*'))
                      <li><a href="productos">Productos</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('usuarios.*'))
                      <li><a href="usuarios">Usuarios</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('roles.*'))
                      <li><a href="roles">Roles</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('comercializadores.*'))
                      <li><a href="abm_comercializador">Comercializador</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('bancos.*'))
                      <li><a href="bancos">Bancos</a></li>
                      @endif

                  </ul>
                </li>
              @endif
               @if(Sentinel::check()->hasAnyAccess(['ventas.*', 'ccCuotasSociales.*']))
                  <li><a><i class="fa fa-bank"></i> Cuentas Corrientes <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  @if(Sentinel::check()->hasAccess('ventas.*'))
                    <li><a href="ventas">CC Servicios/Prestamos</a>
                    </li>
                    @endif
                    @if(Sentinel::check()->hasAccess('ccCuotasSociales.*'))
                    <li><a href="cc_cuotasSociales">CC Cuotas Sociales</a>
                    </li>
                    @endif
                  </ul>
                </li>
                @endif
                @if(Sentinel::check()->hasAnyAccess(['cobrar.*', 'cobroCuotasSociales.*']))
                  <li><a><i class="fa fa-dollar"></i> Cobros <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  @if(Sentinel::check()->hasAccess('cobrar.*'))
                    <li><a href="cobrar">Cobrar Servicios/Prestamos</a>
                    </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('cobroCuotasSociales.*'))
                    <li><a href="cobroCuotasSociales">Cobrar Cuotas Sociales</a>
                    </li>
                  @endif
                  </ul>
                </li>
                @endif
                @if(Sentinel::check()->hasAnyAccess(['darServicios.*', 'aprobacionServicios.*', 'novedades.*']))
                <li><a><i class="fa fa-gears"></i> Gestion de cobranza <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  @if(Sentinel::check()->hasAccess('darServicios.*'))
                    <li><a href="dar_servicio">Alta Gestion Servicio/Prestamo</a>
                    </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('aprobacionServicios.*'))
                    <li><a href="aprobacion">Aprobacion Servicio/Prestamo</a>
                    </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('novedades.*'))
                    <li><a href="novedades">Novedades</a>
                    </li>
                    @endif
                  </ul>
                </li>
                @endif
                @if(Sentinel::check()->hasAnyAccess(['agentesFinancieros.*', 'CCProveedor.*']))
                 <li><a><i class="fa fa-briefcase"></i> Agente Financiero <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  @if(Sentinel::check()->hasAccess('agentesFinancieros.*'))
                    <li><a href="agente_financiero">Solicitudes</a>
                    </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('CCProveedor.*'))
                      <li><a href="proveedorCC">Cuenta Corriente</a>
                      </li>
                      @endif
                  </ul>
                </li>
                @endif
                @if(Sentinel::check()->hasAnyAccess(['capitulos.*', 'asientosManuales.*', 'mayorContable.*', 'pagoContableProveedores.*', 'balances.*']))
                <li><a><i class="fa fa-area-chart"></i> Contabilidad <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  @if(Sentinel::check()->hasAccess('capitulos.*'))
                      <li><a href="capitulo">Plan de cuentas</a>
                      @endif
                      @if(Sentinel::check()->hasAccess('asientosManuales.*'))
                      <li><a href="asientos">Asientos Contables Manuales</a>
                      </li>
                      @endif

                      <!--<li><a href="cobrar_contablemente">Cobrar contablemente</a></li> -->
                      @if(Sentinel::check()->hasAccess('mayorContable.*'))
                      <li><a href="mayorContable">Mayor contable</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('pagoContableProveedores.*'))
                      <li><a href="pagoContableProveedor">Pago contable Proveedor</a></li>
                      @endif
                      @if(Sentinel::check()->hasAccess('balances.*'))
                      <li><a href="balance">Balance</a></li>
                      @endif
                      <!-- <li><a href="rubro">Rubros</a>
                      </li>
                      <li><a href="moneda">Monedas</a></li>
                      <li><a href="departamento">Departamentos</a></li>
                      <li><a href="subRubro">SubRubros</a></li>
                      <li><a href="imputacion">Imputaciones</a></li> -->

                  </ul>
                </li>
                @endif
                @if(Sentinel::check()->hasAnyAccess(['cajas.*', 'operaciones.*', 'cajaOperaciones.*']))
                <li><a><i class="fa fa-shopping-bag"></i> Caja <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                     @if(Sentinel::check()->hasAccess('cajas.*'))
                      <li><a href="caja">Caja</a>
                      @endif
                      @if(Sentinel::check()->hasAccess('operaciones.*'))
                      <li><a href="operaciones">ABM operaciones</a>
                      @endif
                      @if(Sentinel::check()->hasAccess('cajaOperaciones.*'))
                      <li><a href="cajaOperaciones">Reporte caja</a>
                      @endif
                  </ul>
                </li>
                @endif

                  </li>
                  @if(Sentinel::check()->hasAccess('comercializador.*'))
                  <li><a href="comercializador"><i class="fa fa-pencil"></i>Generar Solicitud</a>
                  @endif
                  </li>
                  @if(Sentinel::check()->hasAccess('solicitudesPendientes.*'))
                  <li><a href="solicitudesPendientesMutual"><i class="fa fa-clock-o"></i>Solicitudes Pendientes</a>
                  </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('correrVtoServicios.*'))
                  <li><a href="correrVto"><i class="fa fa-calendar"></i>Correr Vto Servicio/Prestamo</a>
                  </li>
                  @endif
                  @if(Sentinel::check()->hasAccess('pagoProveedores.*'))
                  <li><a href="pago_proovedores"><i class="fa fa-money" ></i> Pago proveedores</a></li>
                  @endif
                  @if(Sentinel::check()->hasAccess('fechaContable.*'))
                  <li><a type="button" data-toggle="modal" data-target="#fechaContable"><i class="fa fa-calendar-check-o" ></i> Fecha contable</a></li>
                  @endif
                  @if(Sentinel::check()->hasAccess('cerrarFecha.*'))
                  <li ng-controller="cerrarFecha"><a ng-click="cerrarFecha()"><i class="fa fa-calendar-times-o" ></i> Cerrar fecha</a></li>
                  @endif
                  <li><a type="button" data-toggle="modal" data-target="#ejercicio"><i class="fa fa-calendar-o" ></i> Abrir/Cerrar ejercicio</a></li> 
                  <div ng-controller="ejercicio">  
                  
                    <ejercicio></ejercicio>
                  </div>
                  
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

<!-- scroller -->
 {!! Html::script('js/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') !!}
<script>
  $(document).ready(function() {
    
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            
            mouseWheel:{ 
              
              scrollAmount: 800, }
        });
    
  });
	</script>
 <script>


 app.controller('fechaContable', function($scope, $http, UserSrv) {
   $scope.fechaACtual = moment().format('YYYY-MM-DD');
   $scope.submit = function(fechaContable) {

     var fechaContable = moment(fechaContable).format('YYYY-MM-DD');

     var data = {
       'fecha': fechaContable,
     };

     return $http({
       url: 'fechaContable',
       method: 'post',
       data: data,

     }).then(function successCallback(response) {
       UserSrv.MostrarMensaje("OK","Operación ejecutada correctamente.","OK","mensaje");
       window.location.reload();
     }, function errorCallback(response) {
       console.log("Error")
     });
   }
 });

 app.controller('cerrarFecha', function($scope, $http, UserSrv) {
   $scope.cerrarFecha = function() {
     return $http({
       url: 'fechaContable/borrar',
       method: 'get',

     }).then(function successCallback(response) {
       UserSrv.MostrarMensaje("OK","Fecha cerrada","OK","mensaje");
       window.location.reload();
     }, function errorCallback(response) {
       console.log("Error")
     });
   }

 });

 </script>



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
