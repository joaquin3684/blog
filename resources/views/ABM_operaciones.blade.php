@extends('welcome')

@section('contenido')


{!! Html::script('js/controladores/ABM_operaciones.js') !!}


<div class="nav-md" ng-controller="ABM_operaciones" >

  <div class="container body">

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
                  <h2>Formulario de operaciones de caja </h2>
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
                  <form class="form-horizontal form-label-left" id="formulario" ng-submit="submit()">
                   {{ csrf_field() }}

                    <span class="section">Datos de la operacion</span>

                  <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre" >Nombre <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Ingrese nombre de la operacion" type="text" ng-model="nombre">{{errores.nombre[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Tipo<span class="required">*</span>
                        </label>
                       <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="entrada" ng-click="modificar('salida')" ng-value="1">Ingreso</label>
                            </div>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="salida" ng-click="modificar('entrada')" ng-value="1">Egreso</label>
                            </div>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Asiento<span class="required">*</span>
                      </label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <select class="form-control" ng-model="cuenta1Seleccionada" >
                            <option ng-value="cuenta1.id" ng-repeat="cuenta1 in cuentas">{{cuenta1.nombre}}</option>
                        </select>
                      </div>
                      <div class="col-md-1 col-sm-1 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="cuenta1Debe" ng-click="modificar('cuenta1Haber')" ng-value="1">Debe</label>
                            </div>
                      </div>
                      <div class="col-md-1 col-sm-1 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="cuenta1Haber" ng-click="modificar('cuenta1Debe')" ng-value="1">Haber</label>
                            </div>
                      </div>
                    </div>
                    
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Asiento<span class="required">*</span>
                      </label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <select class="form-control" ng-model="cuenta2Seleccionada">
                            <option ng-value="cuenta2.id" ng-repeat="cuenta2 in cuentas">{{cuenta2.nombre}}</option>
                        </select>
                      </div>
                      <div class="col-md-1 col-sm-1 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-checked="cuenta1Haber == 1" disabled>Debe</label>
                            </div>
                      </div>
                      <div class="col-md-1 col-sm-1 col-xs-6">
                            <div class="radio">
                            <label><input type="radio"  ng-checked="cuenta1Debe == 1" disabled>Haber</label>
                            </div>
                      </div>
                    </div>  


                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancelar</button>
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
                        <h2>Operaciones de caja <small>Todas las operaciones disponibles</small></h2>
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

                     <button id="exportButton1" ng-click="ExportarPDF('organismos')" class="btn btn-danger clearfix"><span class="fa fa-file-pdf-o"></span> PDF
                     </button>
                     <button id="exportButton2"  data-toggle="modal" data-target="#prompted" class="btn btn-success clearfix" ><span class="fa fa-file-excel-o"></span> EXCEL</button>

                     <button id="exportButton3" ng-click="$Servicio.Impresion()" class="btn btn-primary clearfix"><span class="fa fa-print"></span> IMPRIMIR</button>
                     </center>

                     <div id="estatablaseexporta" style="display: none;">
                      @verbatim
                      <table id="tablaexported">
                          <thead>

                            <td>NOMBRE</td><td>CUIT</td>

                          </thead>
                          <tbody>
                            <tr ng-repeat="abm in datatoexcel">
                              <td>{{abm.nombre}}</td><td>{{abm.cuit}}</td>
                            </tr>
                          </tbody>
                      </table>
                      @endverbatim
                     </div>
                            <div id="pruebaExpandir">
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div  class="table-responsive">
                                      @verbatim
                                        <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">

                                            <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]" >
                                            <tr class="clickableRow" title="Datos">
                                                <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                    {{abm.nombre}}
                                                </td>
                                                 <td title="'Tipo'" filter="{ tipo: 'text'}" sortable="'tipo'">
                                                    {{abm.tipo}}
                                                </td>
                                                

                                                <td id="botones">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="traerElemento(abm.id)"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button type="button" class="btn btn-danger" ng-click="borrarElemento(abm.id)"><span class="glyphicon glyphicon-remove"></span></button>
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
    @verbatim
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal form-label-left" ng-submit="editarFormulario(abmConsultado.id)" id="formularioEditar" >
           <div class="item form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nombre <span class="required">*</span>
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <input  type="text" class="form-control col-md-7 col-xs-12" ng-model="abmConsultado.nombre" required>{{errores.nombre[0]}}
             </div>
           </div>
           <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="abmConsultado.entrada" ng-checked="abmConsultado.entrada == 1" ng-click="modificar2('abmConsultado','salida')" ng-value="1">Ingreso</label>
                            </div>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-model="abmConsultado.salida" ng-checked="abmConsultado.salida == 1" ng-click="modificar2('abmConsultado','entrada')" ng-value="1">Egreso</label>
                            </div>
                      </div>
                </div>
            </div>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cuit" >Asiento<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <select class="form-control" ng-model="abmConsultado.imputacion1" >
                        <option ng-value="cuenta1.id" ng-repeat="cuenta1 in cuentas" ng-selected="cuenta1.id == abmConsultado.imputacion1">{{cuenta1.nombre}}</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="radio">
                        <label><input type="radio" ng-model="abmConsultado.debe1" ng-click="modificar2('abmConsultado','haber1')" ng-value="1">Debe</label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="radio">
                        <label><input type="radio" ng-model="abmConsultado.haber1" ng-click="modificar2('abmConsultado','debe1')" ng-value="1">Haber</label>
                    </div>
                    </div>
             </div>

              <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Asiento<span class="required">*</span>
                      </label>
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <select class="form-control" ng-model="abmConsultado.imputacion2">
                            <option ng-value="cuenta2.id" ng-repeat="cuenta2 in cuentas" ng-selected="cuenta2.id == abmConsultado.imputacion2">{{cuenta2.nombre}}</option>
                        </select>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="radio">
                            <label><input type="radio" ng-checked="abmConsultado.haber1 == 1" disabled>Debe</label>
                            </div>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="radio">
                            <label><input type="radio"  ng-checked="abmConsultado.debe1 == 1" disabled>Haber</label>
                            </div>
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
      </div>

    </div>
    @endverbatim

  </div>
</div>

</div>


@endsection
