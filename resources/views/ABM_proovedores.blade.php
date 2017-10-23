@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/ABMprueba.js') !!}


<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >


    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" name="tipo_tabla" value="proovedores" ng-init="traerRelaciones([{tabla:'prioridades',select:'#prioridad'}])">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >

          <div class="clearfix"></div>
<div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de proovedores <small>Dar de alta un proovedor</small></h2>
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

                    <span class="section">Datos de proovedor</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="razonSocial">Razon social <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="razonSocial" class="form-control col-md-7 col-xs-12" name="razon_social" placeholder="Ingrese la Razon social" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripcion
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="descripcion" name="descripcion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la Descripcion">{{errores.descripcion[0]}}
                      </div>
                    </div>

                    <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input required type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Domicilio">{{errores.domicilio[0]}}
                    </div>
                  </div>

                  <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input required type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Cuit">{{errores.cuit[0]}}
                  </div>
                </div>

                <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input required type="text" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Telefono">{{errores.telefono[0]}}
                </div>
              </div>

              <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Email<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Email">{{errores.email[0]}}
              </div>
            </div>

              <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Usuario<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required type="text" id="cuit" name="usuario" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el Usuario">{{errores.usuario[0]}}
              </div>
            </div>

            <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Contraseña<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input required type="text" id="cuit" name="password" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la Contraseña">{{errores.password[0]}}
            </div>
          </div>
<!--                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retencion">Porcentaje de Ganancia <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="porcentaje_retencion" name="porcentaje_retencion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese % Ganancia">{{errores.porcentaje_retencion[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_gastos_administrativos">Porcentaje de Gastos administrtivos <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="porcentaje_gastos_administrativos" name="porcentaje_gastos_administrativos" class="form-control col-md-7 col-xs-12" placeholder="Ingrese % G.A.">{{errores.porcentaje_gastos_administrativos[0]}}
                      </div>
                    </div> -->
                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Prioridad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select required id="prioridad" name="id_prioridad" class="form-control col-md-7 col-xs-12" ></select>
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
<!--                       <div class="x_content">

                        <table id="datatable-responsive" cellspacing="0" class="table table-striped table-bordered dt-responsive nowrap order-colum compact" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Descripcion</th>
                              <th>% de Ganancia</th>
                              <th>% Gastos Administrativos </th>
                                <th>Prioridad</th>
                              <th></th>

                            </tr>
                          </thead>
                        <tbody>
                        @foreach ($registros as $registro)
                            <tr>
                                <td>{{ $registro->nombre }}</td>
                                <td>{{ $registro->descripcion }}</td>
                                <td>{{ $registro->porcentaje_retencion }}</td>
                                <td>{{ $registro->porcentaje_gastos_administrativos }}</td>
                                <td>{{$registro->prioridad->nombre}}</td>
                                <td>@if(Sentinel::check()->hasAccess('organismos.editar'))<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', {{$registro->id}})"><span class="glyphicon glyphicon-pencil"></span></button>@endif
                                    @if(Sentinel::check()->hasAccess('organismos.borrar'))  <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', {{$registro->id}})"><span class="glyphicon glyphicon-remove"></span></button>@endif
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
                     <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div class="table-responsive">
                                      @verbatim
                                        <table ng-table="paramsABMS" class="table table-hover table-bordered">
                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Razon social'" filter="{ razon_social: 'text'}" sortable="'razonSocial'">
                                                    {{abm.razon_social}}
                                                </td>
                                                <td title="'Descripcion'" filter="{ descripcion: 'text'}" sortable="'descripcion'">
                                                    {{abm.descripcion}}
                                                </td>
                                                <td title="'Domicilio'" filter="{ domicilio: 'text'}" sortable="'domicilio'">
                                                    {{abm.domicilio}}
                                                </td>
                                                <td title="'Cuit'" filter="{ cuit: 'text'}" sortable="'cuit'">
                                                    {{abm.cuit}}
                                                </td>
                                                <td title="'Telefono'" filter="{ telefono: 'text'}" sortable="'telefono'">
                                                    {{abm.telefono}}
                                                </td>
                                                <td title="'Usuario'" filter="{ usuario: 'text'}" sortable="'usuario'">
                                                    {{abm.usuario}}
                                                </td>
<!--                                                 <td title="'$ de Ganancia'" sortable="'porcentaje_retencion'">
                                                    {{abm.porcentaje_retencion}}
                                                </td>

                                                <td title="'$ Gastos Administrativos'" sortable="'porcentaje_gastos_administrativos'">
                                                    {{abm.porcentaje_gastos_administrativos}}
                                                </td> -->
                                                <td title="'Prioridad'" filter="{ id_prioridad: 'text'}" sortable="'id_prioridad'">
                                                    <span ng-if="abm.id_prioridad == 1">Alta</span>
                                                    <span ng-if="abm.id_prioridad == 2">Baja</span>
                                                </td>

                                                <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
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
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="razon_social">Razon social<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="razon_social" class="form-control col-md-7 col-xs-12" name="razon_social" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripcion <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="descripcion" name="descripcion" class="form-control col-md-7 col-xs-12" >{{errores.descripcion[0]}}
                      </div>
                    </div>

                    <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="domicilio">Domicilio<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="domicilio" name="domicilio" class="form-control col-md-7 col-xs-12" >{{errores.descripcion[0]}}
                    </div>
                  </div>

                  <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="cuit" name="cuit" class="form-control col-md-7 col-xs-12" >{{errores.descripcion[0]}}
                  </div>
                </div>

                  <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefono">Telefono<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="telefono" name="telefono" class="form-control col-md-7 col-xs-12" >{{errores.descripcion[0]}}
                  </div>
                </div>

                <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="usuario" name="usuario" class="form-control col-md-7 col-xs-12" >{{errores.descripcion[0]}}
                </div>
              </div>
<!--                     <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retencion">Porcentaje de Ganancia <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="porcentaje_retencion" name="porcentaje_retencion" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{{errores.porcentaje_retencion[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_gastos_administrativos">Porcentaje de Gastos administrtivos <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" id="porcentaje_gastos_administrativos" name="porcentaje_gastos_administrativos" class="form-control col-md-7 col-xs-12" placeholder="Ingrese la cuota social">{{errores.porcentaje_gastos_administrativos[0]}}
                      </div>
                    </div> -->
                   <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">Prioridad <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="prioridad_Editar" name="id_prioridad" class="form-control col-md-7 col-xs-12" ></select>
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


</div>


@endsection
