@extends('welcome')

@section('contenido')

{!! Html::script('js/controladores/cajaOperaciones.js') !!}



<div class="nav-md" ng-controller="cajaOperaciones">
    <div class="container body">
        <div class="main_container">
            <input id="tipo_tabla" name="tipo_tabla" type="hidden" value="proovedores">
            <input type="hidden" id="token" value="{{ csrf_token() }}">
                <!-- page content -->
                <div class="left-col" role="main">
                    <div class="">
                        <div class="clearfix">
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>
                                        Filtro

                                    </h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up">
                                                </i>
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                                <i class="fa fa-wrench">
                                                </i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="#">
                                                        Settings 1
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Settings 2
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="close-link">
                                                <i class="fa fa-close">
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix">
                                    </div>
                                </div>
                                <!-- ARRANCAN LOS FILTROS -->
                                <div class="x_content" >
                                    <div class="container">

                                      @verbatim

                                      <form class="form-horizontal form-label-left" ng-submit="filtro()">


                                        <div class="row">

                                          <div class="item form-group" >
                                              <label class="control-label col-md-3 col-sm-3 col-xs-8" for="categoria">Fecha</label>
                                              <div class="col-md-4 col-sm-4 col-xs-8" >
                                                <input type="text"  ng-model="fecha_desde" class="form-control col-md-2 col-xs-12" onfocus="(this.type='date')" placeholder="Desde">
                                              </div>
                                              <div class="col-md-4 col-sm-4 col-xs-8" >
                                                <input type="text" ng-model="fecha_hasta"  class="form-control col-md-2 col-xs-12" onfocus="(this.type='date')" placeholder="Hasta">
                                              </div>
                                          </div>


                                          </div>
                                        </div>
                                        <input type="submit" ng-click="filtro()" class="btn btn-success" value="Filtrar">
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
                            <h2>
                                Balances
                                
                            </h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up">
                                        </i>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                                        <i class="fa fa-wrench">
                                        </i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#">
                                                Settings 1
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Settings 2
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-close">
                                        </i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix">
                            </div>
                        </div>
                        <div class="x_content" id="impr">




                            <div id="pruebaExpandir" >
                                <div class="span12 row-fluid">
                                    <!-- START $scope.[model] updates -->
                                    <!-- END $scope.[model] updates -->
                                    <!-- START TABLE -->
                                    <div>
                                      @verbatim
                                      <table ng-table="params" class="table table-hover table-bordered">
                                          <tbody data-ng-repeat="operacion in $data" data-ng-switch on="dayDataCollapse[$index]">
                                          <tr class="clickableRow" title="Datos">
                                              <td title="'Codigo'" filter="{ codigo: 'text'}" sortable="'codigo'">
                                                  {{operacion.codigo}}
                                              </td>
                                              <td title="'Nombre'" filter="{ nombre: 'text'}" sortable="'nombre'">
                                                  {{operacion.nombre}}
                                              </td>
                                              <td title="'Saldo anterior'" filter="{ saldo_anterior: 'text'}" sortable="'saldo_anterior'">
                                                  {{operacion.saldoAnterior}}
                                              </td>
                                              <td title="'Total mov. debe'" filter="{ total_debe: 'text'}" sortable="'total_debe'">
                                                  {{operacion.totalDebe}}
                                              </td>
                                              <td title="'Total mov. haber'" filter="{ total_haber: 'text'}" sortable="'total_haber'">
                                                  {{operacion.totalHaber}}
                                              </td>
                                              <td title="'Saldo'" filter="{ saldo: 'text'}" sortable="'saldo'">
                                                  {{operacion.saldo}}
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
            </input>
        </div>
    </div>
    <div class="custom-notifications dsp_none" id="custom_notifications">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix">
        </div>
        <div class="tabbed_notifications" id="notif-group">
        </div>
    </div>


</div>
@endsection
