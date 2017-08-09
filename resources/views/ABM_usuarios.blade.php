@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/ABMusuarios.js') !!}
  <!-- CSS TABLAS -->
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >
  
    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="usuarios">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>

          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Forrmulario de usuarios <small>Dar de alta un usuario</small></h2>
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
                    
                    <span class="section">Datos de usuario</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="usuario" class="form-control col-md-7 col-xs-12" name="usuario" placeholder="Ingrese usuario" type="text">{[{errores.usuario[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Ingrese email del usuario" type="text">{[{errores.email[0]}]}
                      </div>
                    </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="password" name="password" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la contraseña">{[{errores.password[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numeroDeRoles">Cantidad de roles <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="numeroDeRoles" name="numeroDeRoles" ng-model="numeroDeRoles" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cantidad de roles">{[{errores.password[0]}]}
                      </div><button type="button" ng-click="agregarPantalla()" class="btn btn-primary">Añadir Roles</button>
                    </div>

                     <div id="agregarCodigo">                     
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                       
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

       

      </div>
<!-- 
            <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Proovedores <small>Todos los proovedores disponibles</small></h2>
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
                                                <td title="'Descripcion'" sortable="'descripcion'">
                                                    {[{abm.descripcion}]}
                                                </td>
                                                <td title="'Prioridad'" sortable="'prioridad.nombre'">
                                                    <span ng-if="abm.id_prioridad == 1">Alta</span>
                                                    <span ng-if="abm.id_prioridad == 2">Baja</span>
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
                  </div> -->
      
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
                   {{ csrf_field() }}
                    <p>For alternative validation library <code>parsleyJS</code> check out in the <a href="form.html">form page</a>
                    </p>
                    <span class="section">Personal Info</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="usuario" class="form-control col-md-7 col-xs-12" name="usuario" placeholder="Ingrese usuario del organismo" type="text">{[{errores.usuario[0]}]}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Ingrese email del organismo" type="text">{[{errores.email[0]}]}
                      </div>
                    </div>
                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="password" name="password" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el password">{[{errores.password[0]}]}
                      </div>
                    </div>
                    
                   
                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
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




         <script>
          
        </script>
        <script type="text/javascript">
          $(document).ready(function() {


            $("#datatable-responsive").DataTable({
              select: true,
              fixedHeader: true,
               language: {
                info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
                lengthMenu: "Mostrar _MENU_ registros",
                paginate: {
                  next: "Siguiente",
                  previous: "Anterior"
                },
                search: "Buscar:"


               },
              dom: 'Blfrtip',
              buttons: [
        'copy', 'excel', 'pdf'
               ],
               lengthChange: true,

          });
          });
        </script>
</div>


@endsection