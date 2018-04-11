@extends('welcome') @section('contenido') {!! Html::script('js/controladores/caja.js') !!}


<div class="nav-md" ng-controller="caja">

  <div class="container body">


    <div class="main_container">
      <!-- page content -->
      <div class="left-col" role="main">

        <div class="">

          <div class="clearfix"></div>
          <div id="mensaje"></div>
          <div class="row">
            @if(Sentinel::check()->hasAccess('cajas.crear'))
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Caja</h2>
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
                  <h2>Generar operacion</h2>
                  @verbatim
                  <form class="form-horizontal form-label-left" ng-submit="create()" id="formulario">
                    <div ng-cloak>{{ csrf_field() }}</div>

                    <span class="section"></span>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" ng-model="tipo" required>
                          <option value="caja">Caja</option>
                          <option value="banco">Banco</option>
                        </select>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Operacion
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <md-autocomplete md-input-name="idoperacion" md-item-text="item.nombre" md-items="item in query(searchText, 'operaciones/autocomplete')"
                          md-search-text="searchText" md-selected-item="operacionSeleccionada" md-min-length="0" placeholder="Buscar operacion..."
                          required>
                          <span md-highlight-text="searchText" ng-cloak>
                            {{item.nombre}}
                          </span>
                        </md-autocomplete>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Valor
                        <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" type="number" step="0.01" required ng-model="valor" placeholder="123">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Observacion</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" type="text" ng-model="observacion" placeholder="Ingrese una observacion">
                      </div>
                    </div>

                    <div ng-show="tipo == 'banco'" ng-cloak>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Banco
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" ng-model="bancoSeleccionado" required>
                            <option ng-value="banco.id" ng-repeat="banco in bancos">{{banco.nombre}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo operacion
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" ng-model="tipoTransaccion" required ng-disabled="bancoSeleccionado == undefined" ng-click="traerChequeras()">
                            <option value="cheque">Cheque</option>
                            <option value="transferencia">Transferencia</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div ng-show="tipoTransaccion == 'cheque' && tipo =='banco'" ng-cloak>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Chequera
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" ng-model="chequeraSeleccionada" required>
                            <option ng-value="chequera.id" ng-repeat="chequera in chequeras">{{chequera.nro_chequera}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nro cheque
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" type="number" step="1" required ng-model="nro_cheque" placeholder="Ingrese un nro de cheque">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control" type="date" step="1" required ng-model="fecha">
                        </div>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-3">
                        <button type="button" ng-click="borrarFormulario()" class="btn btn-primary">Cancel</button>
                        <button id="send" type="submit" ng-click="create()" class="btn btn-success">Generar</button>
                      </div>
                    </div>
                  </form>
                  @endverbatim

                </div>
              </div>
            </div>
            @endif
          </div>
        </div>

      </div>


      <!-- /page content -->
    </div>

  </div>






  @endsection