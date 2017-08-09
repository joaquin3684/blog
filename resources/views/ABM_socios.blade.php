@extends('welcome')

@section('contenido')
  {!! Html::script('js/controladores/ABMprueba.js') !!}

  <!-- CSS TABLAS -->
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
  
<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >


    <div class="main_container" ng-init="traerRelaciones([{tabla:'organismos',select:'#forro'}])">

      <input type="hidden" id="tipo_tabla" value="asociados">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>
@if(Sentinel::check()->hasAccess('socios.crear'))
          <div class="row" >
          <div id="mensaje"></div>
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de socios <small>Dar de alta un socio</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')" id="formulario" >
                   {{ csrf_field() }}
                   
                    <span class="section">Datos de socio</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del Socio" type="text">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de nacimiento <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control col-md-7 col-xs-12" >{[{errores.fecha_nacimiento[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Cuit">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">DNI <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="dni" name="dni" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el DNI">{[{errores.dni[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Domicilio">{[{errores.domicilio[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="localidad">Localidad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="localidad" name="localidad" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la Localidad">{[{errores.localidad[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo_postal">Codigo Postal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="codigo_postal" name="codigo_postal" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Código Postal">{[{errores.codigo_postal[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Teléfono">{[{errores.telefono[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legajo">Legajo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="legajo" name="legajo" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Legajo">{[{errores.legajo[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_ingreso">Fecha de ingreso <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la fecha de ingreso">{[{errores.fecha_ingreso[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grupo_familiar">Grupo Familiar <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="grupo_familiar" name="grupo_familiar" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Grupo Familiar">{[{errores.grupo_familiar[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Organismo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="forro" name="id_organismo" class="form-control col-md-7 col-xs-12" ></select>
                      </div>

                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="puto()" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

       @endif

       @if(Sentinel::check()->hasAccess('socios.visualizar'))

      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Socios <small>Todos los socios disponibles</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Settings 1</a>
                              </li>
                              <li><a href="#">Settings 2</a>
                              </li>
                            </ul>
                          </li>
                          <li><a href="#"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
<!--                       <div class="x_content">
                       
                        <table id="datatable-responsive" cellspacing="0" class="table table-striped table-bordered dt-responsive nowrap order-colum compact" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Fecha Nacimiento</th>
                              <th>Cuit</th>
                              <th>Dni</th>
                              <th>Domicilio</th>
                              <th>Localidad</th>
                              <th>Codigo Postal</th>
                              <th>Telefono</th>
                              <th>Legajo</th>
                              <th>Fecha Ingreso</th>
                              <th>Grupo Familiar</th>
                              <th>Organismo</th>
                              <th></th>
                            </tr>
                          </thead>
                          
                          <tbody>
                            @foreach ($registros as $registro)
                              <tr>
                                <td>{{ $registro->nombre }}</td>
                                <td>{{ $registro->fecha_nacimiento }}</td>
                                <td>{{ $registro->cuit }}</td>
                                <td>{{ $registro->dni }}</td>
                                <td>{{ $registro->domicilio }}</td>
                                <td>{{ $registro->localidad }}</td>
                                <td>{{ $registro->codigo_postal }}</td>
                                <td>{{ $registro->telefono }}</td>
                                <td>{{ $registro->legajo }}</td>
                                <td>{{ $registro->fecha_ingreso }}</td>
                                <td>{{ $registro->grupo_familiar }}</td>
                                <td>{{ $registro->organismo->nombre }}</td>
                                

                                <td>@if(Sentinel::check()->hasAccess('socios.editar'))<button type="button" data-toggle="modal" data-target="#editar" onclick="enviarFormulario('Mostrar', {{$registro->id}})" class="btn btn-primary" ><span class="glyphicon glyphicon-pencil"></span></button>@endif
                               @if(Sentinel::check()->hasAccess('socios.borrar')) <button type="button" class="btn btn-danger" onclick="enviarFormulario('Borrar', {{$registro->id}})"><span class="glyphicon glyphicon-remove"></span></button>
                               @endif
                                </td>
                               

                              </tr>
                            @endforeach
                          </tbody>
                        </table>

                      </div> -->

                                            <div class="x_content">
                                             <center>
                     <button id="exportButton1" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div>
                                        <table ng-table="paramsABMS" class="table table-hover table-bordered">
                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" sortable="'nombre'">
                                                    {[{abm.nombre}]}
                                                </td>
                                                <td title="'Fecha de Nacimiento'" sortable="'fecha_nacimiento'">
                                                    {[{abm.fecha_nacimiento}]}
                                                </td>
                                                <td title="'Cuit'" sortable="'cuit'">
                                                    {[{abm.cuit}]}
                                                </td>
                                                <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- END TABLE -->
                                </div>
                            </div>

                        </div>
                    </div>
                   
                  </div>
                  @endif
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

 <!-- Modal -->
<div id="editar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar" >

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre del organismo" type="text">{[{errores.nombre[0]}]}
                      </div>
                    </div>
                    
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de nacimiento <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control col-md-7 col-xs-12" >{[{errores.fecha_nacimiento[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el cuit">{[{errores.cuit[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">DNI <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="dni" name="dni" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.dni[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.domicilio[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="localidad">Localidad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="localidad" name="localidad" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.localidad[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo_postal">Codigo Postal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="codigo_postal" name="codigo_postal" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.codigo_postal[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.telefono[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="legajo">Legajo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="legajo" name="legajo" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.legajo[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_ingreso">Fecha de ingreso <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.fecha_ingreso[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grupo_familiar">Grupo Familiar <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="grupo_familiar" name="grupo_familiar" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{[{errores.grupo_familiar[0]}]}
                      </div>
                      </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Organismo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="forro_Editar" name="id_organismo" class="form-control col-md-7 col-xs-12" ></select>{[{errores.dni[0]}]}
                      </div>

                    </div>
                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>
                      </div>
                    </div>
                  </form>
      </div>
      
    </div>

  </div>
</div>
<!-- Fin Modal -->
  <!-- bootstrap progress js -->


  <!-- icheck -->
  
  <!-- pace -->
 

  <!-- form validation -->
 
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.keyTable.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>




     
</div>


@endsection