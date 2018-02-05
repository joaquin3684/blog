@extends('welcome') @section('contenido') {!! Html::script('js/controladores/ABM_bancos.js') !!}
<div class="nav-md" ng-controller="ABM_bancos">

  <div class="container body">


    <div class="main_container">

      <!-- page content -->
      <input type="hidden" id="tipo_tabla" value="bancos">
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          @if(Sentinel::check()->hasAccess('bancos.crear'))
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Formulario de bancos</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li>
                      <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                      </a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-wrench"></i>
                      </a>
                      <ul class="dropdown-menu" role="menu">
                        <li>
                          <a href="#">Settings 1</a>
                        </li>
                        <li>
                          <a href="#">Settings 2</a>
                        </li>
                      </ul>
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
                  <form class="form-horizontal form-label-left" ng-submit="create()" id="formulario1">
                    {{ csrf_field() }}

                    <span class="section">Datos del banco</span>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nombre" class="form-control col-md-7 col-xs-12" ng-model="nombre" placeholder="Ingrese el nombre" type="text">{{errores.nombre[0]}}
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sucursal">Sucursal
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="sucursal" class="form-control col-md-7 col-xs-12" ng-model="sucursal" placeholder="Ingrese la sucursal"
                          type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Direccion
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="direccion" class="form-control col-md-7 col-xs-12" ng-model="direccion" placeholder="Ingrese la direccion"
                          type="text">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nro_cuenta">Nro cuenta
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required id="nro_cuenta" class="form-control col-md-7 col-xs-12" ng-model="nro_cuenta" placeholder="Ingrese el numero de cuenta"
                          type="number">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancel</button>
                        <button type="submit" ng-model="enviar" class="btn btn-success">Alta</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

                </div>
              </div>
            </div>
          </div>
        </div>
        @endif


      </div>


      @if(Sentinel::check()->hasAccess('bancos.visualizar'))
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Bancos
              <small>Todos los bancos disponibles</small>
            </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="#">Settings 1</a>
                  </li>
                  <li>
                    <a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#">
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
                          @endverbatim @if(Sentinel::check()->hasAccess('bancos.editar')) @verbatim

                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar" ng-click="traerBanco(abm.id)">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </button>
                          @endverbatim @endif @if(Sentinel::check()->hasAccess('bancos.borrar')) @verbatim

                          <button type="button" class="btn btn-danger" ng-click="delete(abm.id)">
                            <span class="glyphicon glyphicon-remove"></span>
                          </button>
                          @endverbatim @endif @verbatim

                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#chequera" ng-click="asignarBanco(abm.id)">
                            <span class="glyphicon glyphicon-plus"></span>
                          </button>
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
          @verbatim
          <form class="form-horizontal form-label-left" ng-submit="editarBanco(bancoSeleccionado.id)" id="formulario2">
            {{ csrf_field() }}


            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required class="form-control col-md-7 col-xs-12" ng-model="bancoSeleccionado.nombre" type="text">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sucursal">Sucursal
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required class="form-control col-md-7 col-xs-12" ng-model="bancoSeleccionado.sucursal" type="text">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="direccion">Direccion
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required class="form-control col-md-7 col-xs-12" ng-model="bancoSeleccionado.direccion" type="text">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nro_cuenta">Nro cuenta
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input required class="form-control col-md-7 col-xs-12" ng-model="bancoSeleccionado.nro_cuenta" type="text">
              </div>
            </div>


            <input type="hidden" ng-model="id">
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>

                <button type="submit" class="btn btn-success">Enviar</button>
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
            <li role="presentation" class="active">
              <a href="#altaChequera" data-toggle="tab">Alta</a>
            </li>
            <li role="presentation">
              <a href="#verChequera" data-toggle="tab">Visualizacion</a>
            </li>
          </ul>
          <br>

          <div class="tab-content">
            <div id="altaChequera" class="tab-pane fade in active">
              <form id="altaChequera" class="form-horizontal form-label-left" ng-submit="createChequera()" id="formulario3">
                {{ csrf_field() }}


                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro chequera
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input required class="form-control col-md-7 col-xs-12" ng-model="nro_chequera" type="number">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro inicio
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input required class="form-control col-md-7 col-xs-12" ng-model="nro_inicio" type="number">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro fin
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input required class="form-control col-md-7 col-xs-12" ng-model="nro_fin" type="text">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Estado
                    <span class="required">*</span>
                  </label>

                  <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="radio">
                      <label>
                        <input type="radio" ng-model="estado" value="activo">Activo</label>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="radio">
                      <label>
                        <input type="radio" ng-model="estado" value="inactivo">Inactivo</label>
                    </div>
                  </div>

                </div>


                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">

                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="borrarFormulario()">Cancelar</button>
                    <button type="submit" class="btn btn-success">Enviar</button>
                  </div>
                </div>
              </form>
            </div>
            <div id="verChequera" class="tab-pane fade">
              <div class="table-responsive">

                <table ng-table="paramsChequera" class="table table-hover table-bordered">
                  <tbody data-ng-repeat="chequera in $data" data-ng-switch on="dayDataCollapse[$index]">
                    <tr class="clickableRow" title="Datos">
                      <td title="'Nro chequera'" filter="{ nro_chequera: 'text'}" sortable="'nro_chequera'">
                        {{chequera.nro_chequera}}
                      </td>
                      <td title="'Nro inicio'" filter="{ nro_inicio: 'text'}" sortable="'nro_inicio'">
                        {{chequera.nro_inicio}}
                      </td>
                      <td title="'Nro fin'" filter="{ nro_fin: 'text'}" sortable="'nro_fin'">
                        {{chequera.nro_fin}}
                      </td>
                      <td title="'Estado'" filter="{ estado: 'text'}" sortable="'estado'">
                        {{chequera.estado}}
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