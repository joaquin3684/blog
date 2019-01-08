@extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABMimputaciones.js') !!}

<style>
  .wizard .nav-tabs>li {
    width: 16.66%;
  }
</style>

<div class="nav-md" ng-controller="ABMImputaciones">

  <div class="container body">

    <div class="main_container">

      <input type="hidden" id="tablon" ng-value="capitulo">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row">
            @if(Sentinel::check()->hasAccess('capitulos.crear'))
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Alta imputacion
                  </h2>

                  <ul class="nav navbar-right panel_toolbox">
                    <li>
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                    </li>
                    
                    <li>
                      <a class="close-link">
                        <i class="fa fa-close"></i>
                      </a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                 @verbatim

                    <form role="form" class="" style="text-align: right" style="text-align: right" ng-submit="enviarFormulario('imputacion','Alta')"
                              id="imputacionform">

                              <div class="row">
                                <div class="form-group col-md-2  col-md-offset-2">
                                  <label class="" for="id_subrubro">Subrubro *</label>
                                </div>
                                <div class="form-group col-md-4">
                                  <select id="id_subrubro" class="form-control col-md-7" ng-model="subrubro">
                                    <option ng-value="{{x}}" ng-repeat="x in selectsubrubros">
                                      {{x.nombre}}
                                    </option>
                                  </select>
                                  <input type="hidden" value="{{subrubro.id}}" name="id_subrubro">
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="codigo">Código
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">{{subrubro.codigo}}</span>
                                    <input id="codigo" class="form-control col-md-7 col-xs-12" ng-model="codigoImp" placeholder="11" type="number" max="99">{{errores.nombre[0]}}
                                    <input type="hidden" id="tipo_tabla" value="{{subrubro.codigo}}{{codigoImp}}" name="codigo">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-2 col-sm-2 col-xs-12 col-md-offset-2">
                                  <label class="" for="nombre">Nombre
                                    <span class="required">*</span>
                                  </label>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                  <input id="nombre" class="form-control col-md-7 col-xs-12" name="nombre" placeholder="Cuotas Sociales" type="text">{{errores.nombre[0]}}
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-2 col-md-offset-6">
                                    <button id="send" type="submit" style="width: 100%;" class="btn btn-success">
                                      <i class="fa fa-plus"></i> Alta</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                            @endverbatim
                  

                </div>
                <!-- End SmartWizard Content -->





              </div>
            </div>
            @endif
          </div>
        </div>
      </div>



    </div>
    <!-- aca va la tabla de editar -->
    @if(Sentinel::check()->hasAccess('capitulos.visualizar'))

    
      <div class="x_panel">
        <div class="x_title">
                  <h2>Editar imputacion
                  </h2>

                  <ul class="nav navbar-right panel_toolbox">
                    <li>
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                    </li>
                    
                    <li>
                      <a class="close-link">
                        <i class="fa fa-close"></i>
                      </a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
        <div class="x_content">
          <center>
            <button id="exportButton1" class="btn btn-danger clearfix">
              <span class="fa fa-file-pdf-o"></span> PDF
            </button>
            <button id="exportButton2" ng-click="$Servicio.Excel()" class="btn btn-success clearfix">
              <span class="fa fa-file-excel-o"></span> EXCEL</button>
            <button id="exportButton3" ng-click="Impresion()" class="btn btn-primary clearfix">
              <span class="fa fa-print"></span> IMPRIMIR</button>
          </center>
          <div id="pruebaExpandir">
            <div class="span12 row-fluid">
              <!-- START TABLE -->
              <!-- Mostrar Capitulos -->
              <div>

                <div class="table-responsive">
                  @verbatim
                  <table id="tablita" ng-table="paramsABMS" class="table table-hover table-bordered">
                    <tbody data-ng-repeat="abm in $data" data-ng-switch on="dayDataCollapse[$index]">
                      <tr class="clickableRow" title="Datos" ng-cloak>
                        <td title="'Codigo'" filter="{ codigo: 'text'}" sortable="'codigo'">
                          {{abm.codigo}}
                        </td>
                        <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                          {{abm.nombre}}
                        </td>

                        <td id="botones">
                          @endverbatim @if(Sentinel::check()->hasAccess('capitulos.editar'))
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="enviarFormulario('imputacion','Mostrar',abm.id)">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </button>
                          @endif @verbatim


                        </td>
                      </tr>
                    </tbody>
                  </table>
                  @endverbatim
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>
      <!-- aca va la tabla de editar -->



      <!-- /page content -->
  
    @endif

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
          <form class="form-horizontal form-label-left" ng-submit="enviarFormulario('imputacion','Editar')" id="formularioEditar">


            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" name="nombre" ng-model="abmConsultado.nombre">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo">Codigo
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name="codigo" class="form-control col-md-7 col-xs-12" type="text" maxlength="{{cantMaxima()}}">
              </div>
            </div>
            <input type="hidden" name="id">
            <input type="hidden" name="id_subrubro">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button id="send" type="submit" class="btn btn-success" >Enviar</button>

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