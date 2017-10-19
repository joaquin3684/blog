@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/ABM_organismos.js') !!}


<div class="nav-md" ng-controller="ABM" >

  <div class="container body" >

    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="organismos">
      <!-- page content -->
      <div class="left-col" role="main" >

          <div class="" >

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Formulario de organismos <small>Dar de alta un organismo</small></h2>
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
                  <form class="form-horizontal form-label-left" ng-submit="submit()" id="formulario" >
                   {{ csrf_field() }}

                    <span class="section">Datos del organismo</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" ng-model="nombre" placeholder="Ingrese nombre del organismo" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" ng-model="cuit" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el cuit">{{errores.cuit[0]}}
                      </div>
                    </div>


                      <div id="aClonar" ng-repeat="cuota in cuotas">
                        <div class="item form-group clonado">

                            <label class="control-label col-md-3 col-sm-3 col-xs-4" for="categoria">Cuota social<span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-6" id="categoria">
                              <input type="number" class="form-control col-md-2 col-xs-12" placeholder="Categoria"  ng-model="cuota.categoria" >{{errores.cuota_social[0]}}
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6" id="valor">
                              <input type="number" step="0.01" class="form-control col-md-2 col-xs-12" placeholder="Valor" ng-model="cuota.valor">{{errores.cuota_social[0]}}
                            </div>
                      </div>
                      </div>



                      <button id="sumahtml" type="button" class="btn btn-danger"  style="float: right;position: relative;bottom: 45px;" ng-click="eliminarHtml('.clonado', cuotas)">
                        <span class="glyphicon glyphicon-minus" aria-hidden="true" ></span>
                      </button>
                    <button id="sumahtml" type="button" class="btn btn-primary"  style="float: right;position: relative;bottom: 45px;" ng-click="agregarHtml(cuotas)">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
                    </button>




                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
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
                        <h2>Organismos <small>Todos los organismos disponibles</small></h2>
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
                              <th>Cuit</th>
                              <th>Cuota Social</th>
                              <th></th>

                            </tr>
                          </thead>

                          <tbody>
                            @foreach ($registros as $registro)
                              <tr>
                                <td>{{ $registro->nombre }}</td>
                                <td>{{ $registro->cuit }}</td>
                                <td>{{ $registro->cuota_social }}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('Mostrar', {{$registro->id}})"><span class="glyphicon glyphicon-pencil"></span></button>
                               <button type="button" class="btn btn-danger" ng-click="enviarFormulario('Borrar', {{$registro->id}})"><span class="glyphicon glyphicon-remove"></span></button>
                                </td>


                              </tr>
                            @endforeach
                          </tbody>
                        </table>

                      </div> -->
                      <div class="x_content">
                     <center>
                     <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix"><span class="fa fa-file-excel-o"></span> EXCEL</button>
                     <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix"><span class="fa fa-print"></span> IMPRIMIR</button>
                     </center>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div class="table-responsive">
                                      @verbatim
                                      <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
                                          <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]" >
                                          <tr class="clickableRow" title="Datos" data-ng-click="selectTableRow($index,socio.id)"  ng-class="socio.id">
                                              <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                  {{abm.nombre}}
                                              </td>
                                              <td title="'Cuit'" filter="{ cuit: 'text'}" sortable="'cuit'">
                                                  {{abm.cuit}}
                                              </td>


                                              <td id="botones">
                                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="traerElemento(abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                              <button type="button" class="btn btn-danger" ng-click="borrarElemento(abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
                                              </td>

                                          </tr>

                                        </tbody>
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
@verbatim
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar</h4>
      </div>
      <div class="modal-body">


         <form class="form-horizontal form-label-left" ng-submit="editarFormulario(abmConsultado.id)" id="formularioEditar" >

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12" placeholder="Ingrese nombre del organismo" type="text" ng-model="nombreedi" >{{errores.nombre[0]}}

                      </div>
                    </div>

                      <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit">Cuit <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="cuit" ng-model="abmConsultado.cuit" class="form-control col-md-7 col-xs-12">{{errores.cuit[0]}}
                      </div>
                    </div>
                    <div ng-repeat="cuota in abmConsultado.cuotas">
                      <div class="item form-group clonado1" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-4" for="categoria">Cuota social<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6" id="categoria">
                          <input type="number" class="form-control col-md-2 col-xs-12" placeholder="Categoria"  ng-model="cuota.categoria">{{errores.cuota_social[0]}}
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6" id="valor">
                          <input type="number" step="0.01" class="form-control col-md-2 col-xs-12" placeholder="Valor" ng-model="cuota.valor">{{errores.cuota_social[0]}}
                        </div>
                      </div>
                    </div>


                    <button id="sumahtml" type="button" class="btn btn-danger"  style="float: right;position: relative;bottom: 45px;" ng-click="eliminarHtml('.clonado1', abmConsultado.cuotas)">
                      <span class="glyphicon glyphicon-minus" aria-hidden="true" ></span>
                    </button>
                  <button id="sumahtml" type="button" class="btn btn-primary"  style="float: right;position: relative;bottom: 45px;" ng-click="agregarHtml(abmConsultado.cuotas)">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true" ></span>
                  </button>

                    <input type="hidden" name="id">
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        <button id="send" type="submit" class="btn btn-success">Enviar</button>

                      </div>
                    </div>
                  </form>

      </div>

    </div>
@endverbatim
  </div>
</div>


</div>


@endsection
