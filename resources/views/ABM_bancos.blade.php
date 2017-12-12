@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/ABMprueba.js') !!}
<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >


    <div class="main_container" >

      <!-- page content -->
      <input type="hidden" id="tipo_tabla" value="bancos">
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
<div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de bancos</h2>
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
                  @verbatim
                  <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')" id="formulario" >
                   {{ csrf_field() }}

                    <span class="section">Datos del banco</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese el nombre" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>
                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sucursal">Sucursal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="sucursal" class="form-control col-md-7 col-xs-12" name="sucursal" placeholder="Ingrese la sucursal" type="text">
                      </div>
                    </div>
                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Direccion <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="direccion" class="form-control col-md-7 col-xs-12" name="direccion" placeholder="Ingrese la direccion" type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nro_cuenta">Nro cuenta <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nro_cuenta" class="form-control col-md-7 col-xs-12" name="nro_cuenta" placeholder="Ingrese el numero de cuenta" type="number">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button  type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

                </div>
              </div>
            </div>
          </div>
        </div>



      </div>



      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Bancos <small>Todos los bancos disponibles</small></h2>
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
                     <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">

                                    <div class="table-responsive">
                                      @verbatim
                                        <table ng-table="paramsABMS" class="table table-hover table-bordered">
                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{abm.nombre}}
                                                </td>
                                                <td title="'Sucursal'" filter="{ sucursal: 'text'}" sortable="'sucursal'">
                                                    {{abm.nro_cuenta}}
                                                </td>
                                                <td title="'Direccion'" filter="{ direccion: 'text'}" sortable="'direccion'">
                                                    {{abm.direccion}}
                                                </td>
                                                <td title="'Nro cuenta'" filter="{ nro_cuenta: 'text'}" sortable="'nro_cuenta'">
                                                    {{abm.nro_cuenta}}
                                                </td>
                                                <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#chequera" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                            </tr>
                                        </table>
                                        @endverbatim
                                    </div>
                                    <!-- END TABLE -->
                                </div>
                            </div>

                        </div>
                    </div>
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
        @verbatim
         <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('Editar')" id="formularioEditar" >
                   {{ csrf_field() }}


                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sucursal">Sucursal<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="sucursal" class="form-control col-md-7 col-xs-12" name="sucursal" type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Direccion<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="direccion" class="form-control col-md-7 col-xs-12" name="direccion" type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nro_cuenta">Nro cuenta<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nro_cuenta" class="form-control col-md-7 col-xs-12" name="nro_cuenta" type="text">
                      </div>
                    </div>


                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim
      </div>

    </div>

  </div>
</div>

 <!-- Modal -->
<div id="chequera" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Chequera</h4>
      </div>
      <div class="modal-body">
        @verbatim
        <ul class="nav nav-tabs" id="tabContent">
          <li role="presentation" class="active" ><a href="#altaChequera" data-toggle="tab">Alta</a></li>
          <li role="presentation"><a href="#verChequera" data-toggle="tab">Visualizacion</a></li>
        </ul>
        <br>

        <div class="tab-content">
          <div id="altaChequera" class="tab-pane fade in active">
         <form  id="altaChequera" class="form-horizontal form-label-left" ng-submit="enviarFormulario('Alta')" id="formularioEditar" >
                   {{ csrf_field() }}


                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>
          
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>
                      </div>
                    </div>
                  </form>
          </div>
          <div id="verChequera" class="tab-pane fade">   
          <div class="table-responsive">
                              
             <table ng-table="paramsABMS" class="table table-hover table-bordered">
                <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                   <tr class="clickableRow" title="Datos">
                      <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                        {{abm.nombre}}
                      </td>
                                     
                    </tr>
              </table>
                               
           </div>      
          </div>
        </div>


         
       
                  @endverbatim
      </div>

    </div>

  </div>
</div>




</div>


@endsection
